<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Domain\Model\Mail;
use ChriWo\Mailhandler\Utility\StringUtility;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MailService.
 */
class MailService extends AbstractMailService implements MailServiceInterface
{
    use MailServiceTrait;

    protected $attachments = [];

    /**
     * Send an email to insurer.
     *
     * @param int $templateRecord
     * @param string $receiver
     * @param array $data
     * @param array $overwriteOptions
     * @param array $additionalAttachment
     * @throws \Exception
     * @return bool
     */
    public function process(
        $templateRecord,
        $receiver,
        array $data = [],
        array $overwriteOptions = [],
        array $additionalAttachment = []
    ): bool {
        $submitResult = false;
        $this->attachments = $additionalAttachment;

        $this->loadMailTemplateRecord($templateRecord);
        if (!$this->mailTemplate instanceof Mail) {
            return $submitResult;
        }

        return $this->buildEmail($receiver, $data, $overwriteOptions);
    }

    /**
     * Create the basics for email shipping and submit the email.
     *
     * @param string $mailReceiver
     * @param array $data
     * @param array $overwriteOptions
     * @throws \Exception
     * @return bool
     */
    protected function buildEmail($mailReceiver, array $data = [], array $overwriteOptions = []): bool
    {
        $mail = [
            'subject' => $this->mailTemplate->getMailSubject(),
            'rteBody' => $this->mailTemplate->getMailBody(),
            'format' => 'plain',
            'variables' => $data,
        ];

        $this->addEmailReceiver($mail, $mailReceiver, $this->mailTemplate->getMailReceiver());
        $this->addEmailSender($mail, $this->mailTemplate->getMailSender());
        $mail = array_merge($mail, $overwriteOptions);

        if (!GeneralUtility::validEmail($mail['receiverEmail']) || !GeneralUtility::validEmail($mail['senderEmail'])) {
            return false;
        }

        return self::sendEmail($mail);
    }

    /**
     * Submit an email.
     *
     * @param array $email
     * @throws \Exception
     * @return bool
     */
    protected function sendEmail(array $email): bool
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
        $message = $this->addEmailBody($message, $email);
        $message = $this->addAttachments($message);

        $message->send();

        return $message->isSent();
    }

    /**
     * Add cc receiver.
     *
     * @param \TYPO3\CMS\Core\Mail\MailMessage $message
     * @return MailMessage
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
     * @param MailMessage $message
     * @throws \Exception
     * @return MailMessage
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
     *
     * @param MailMessage $message
     * @return MailMessage
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
     *
     * @param MailMessage $message
     * @return MailMessage
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
     * Add the email body in html or plain text.
     *
     * @param \TYPO3\CMS\Core\Mail\MailMessage $message
     * @param array $email
     * @return \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected function addEmailBody(MailMessage $message, array $email): MailMessage
    {
        if ('html' !== $email['format']) {
            $message->addPart($this->getHtmlBody($email), 'text/html');
        } else {
            $message->addPart($this->getPlainBody($email), 'text/plain');
        }

        return $message;
    }

    /**
     * Add documents as attachment.
     *
     * @param MailMessage $message
     * @return MailMessage
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
                    $message->attach(
                        \Swift_Attachment::fromPath($attachmentFilePath)
                    );
                }
            }
        }

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $message->attach(\Swift_Attachment::newInstance(
                    $attachment['fileContent'],
                    $attachment['fileName'],
                    $attachment['contentType']
                ));
            }
        }

        return $message;
    }
}
