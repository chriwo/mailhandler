<?php

declare(strict_types=1);

namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Domain\Model\Mail;
use ChriWo\Mailhandler\Event\BeforeMailSendEvent;
use ChriWo\Mailhandler\Utility\StringUtility;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MailService.
 */
class MailService extends AbstractMailService implements MailServiceInterface
{
    use MailServiceTrait;

    protected array $attachments = [];

    protected bool $mailIsSend = false;

    /**
     * Send email to insurer.
     *
     * @throws \Exception
     */
    public function process(
        int $templateRecord,
        string $receiver,
        array $data = [],
        array $overrideOptions = [],
        array $additionalAttachment = []
    ): void {
        $this->attachments = $additionalAttachment;

        $this->loadMailTemplateRecord($templateRecord);
        if ($this->mailTemplate instanceof Mail) {
            $this->buildEmail($receiver, $data, $overrideOptions);
        }
    }

    /**
     * Returns submit status of an email
     */
    public function isMailSend(): bool
    {
        return $this->mailIsSend;
    }

    /**
     * Create the basics for email shipping and submit the email.
     *
     * @throws \Exception
     * @todo add an log entry if email validation failed
     */
    protected function buildEmail(string $mailReceiver, array $data = [], array $overrideOptions = []): void
    {
        $mail = [
            'subject' => $this->mailTemplate->getMailSubject(),
            'rteBody' => $this->mailTemplate->getMailBody(),
            'format' => 'plain',
            'variables' => $data,
        ];

        $this->addEmailReceiver($mail, $mailReceiver, $this->mailTemplate->getMailReceiver());
        $this->addEmailSender($mail, $this->mailTemplate->getMailSender());
        $mail = array_merge($mail, $overrideOptions);

        if (!GeneralUtility::validEmail($mail['receiverEmail']) || !GeneralUtility::validEmail($mail['senderEmail'])) {
            $this->mailIsSend = false;
        }

        self::sendEmail($mail);
    }

    /**
     * Submit an email.
     *
     * @throws \Exception
     */
    protected function sendEmail(array $email): void
    {
        /** @var MailMessage $message */
        $message = GeneralUtility::makeInstance(MailMessage::class);
        $message
            ->setTo([$email['receiverEmail'] => $email['receiverName']])
            ->setFrom([$email['senderEmail'] => $email['senderName']])
            ->setSubject(StringUtility::fluidParseString($email['subject'], $email['variables']))
        ;
        $message = $this->addCc($message);
        $message = $this->addBcc($message);
        $message = $this->addReplyTo($message);
        $message = $this->addReturnPath($message);
        $message = $this->addHtmlBody($message, $email);
        $message = $this->addPlainBody($message, $email);
        $message = $this->addAttachments($message);

        $message = $this->eventDispatcher->dispatch(new BeforeMailSendEvent($message, $email))->getMessageData();

        $message->send();
        $this->mailIsSend = $message->isSent();
    }

    /**
     * Add cc receiver.
     */
    protected function addCc(MailMessage $message): MailMessage
    {
        $ccReceiver = GeneralUtility::trimExplode(PHP_EOL, $this->mailTemplate->getMailReceiverCc(), true);
        if (count($ccReceiver)) {
            foreach ($ccReceiver as $receiverString) {
                $receiver = GeneralUtility::trimExplode('|', $receiverString, true);
                if (GeneralUtility::validEmail($receiver[1])) {
                    $message->addCc($receiver[1], !empty($receiver[0]) ? $receiver[0] : $receiver[1]);
                }
            }
        }

        return $message;
    }

    /**
     * Add bcc receiver from extension configuration.
     *
     * @throws \Exception
     */
    protected function addBcc(MailMessage $message): MailMessage
    {
        $bccReceiver = GeneralUtility::trimExplode(PHP_EOL, $this->mailTemplate->getMailReceiverBcc(), true);
        if (count($bccReceiver)) {
            foreach ($bccReceiver as $receiver) {
                $receiverSplit = GeneralUtility::trimExplode('|', $receiver, true);
                if (GeneralUtility::validEmail($receiverSplit[1])) {
                    $message->addBcc(
                        $receiverSplit[1],
                        !empty($receiverSplit[0]) ? $receiverSplit[0] : $receiverSplit[1]
                    );
                }
            }
        }

        return $message;
    }

    /**
     * Add ReplyTo receiver.
     */
    protected function addReplyTo(MailMessage $message): MailMessage
    {
        $replyToReceiver = GeneralUtility::trimExplode(PHP_EOL, $this->mailTemplate->getMailReplyTo(), true);
        if (count($replyToReceiver)) {
            foreach ($replyToReceiver as $receiver) {
                $receiverSplit = GeneralUtility::trimExplode('|', $receiver, true);
                if (GeneralUtility::validEmail($receiverSplit[1])) {
                    $message->addReplyTo(
                        $receiverSplit[1],
                        !empty($receiverSplit[0]) ? $receiverSplit[0] : $receiverSplit[1]
                    );
                }
            }
        }

        return $message;
    }

    /**
     * Add ReturnPath / error-receiver.
     */
    protected function addReturnPath(MailMessage $message): MailMessage
    {
        $returnPath = $this->mailTemplate->getMailReturnPath();
        if (GeneralUtility::validEmail($returnPath)) {
            $message->setReturnPath($returnPath);
        }

        return $message;
    }

    /**
     * Add the html email body.
     */
    protected function addHtmlBody(MailMessage $message, array $email): MailMessage
    {
        if ('plain' !== $email['format']) {
            $message->html($this->getHtmlBody($email), 'text/html');
        }

        return $message;
    }

    /**
     * Add the plaintext email body.
     */
    protected function addPlainBody(MailMessage $message, array $email): MailMessage
    {
        if ('html' !== $email['format']) {
            $message->text($this->getPlainBody($email), 'text/plain');
        }

        return $message;
    }

    /**
     * Add documents as attachment.
     */
    protected function addAttachments(MailMessage $message): MailMessage
    {
        $attachments = $this->mailTemplate->getMailAttachment();
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $attachmentFilePath = GeneralUtility::getFileAbsFileName(
                    $attachment->getOriginalResource()->getOriginalFile()->getPublicUrl()
                );

                if (file_exists($attachmentFilePath)) {
                    $message->attachFromPath($attachmentFilePath);
                }
            }
        }

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $message->embed(
                    $attachment['fileContent'],
                    $attachment['fileName'],
                    $attachment['contentType']
                );
            }
        }

        return $message;
    }
}
