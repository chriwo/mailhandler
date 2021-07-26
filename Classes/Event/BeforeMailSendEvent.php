<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Event;

use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Class BeforeMailSendEvent
 */
class BeforeMailSendEvent
{
    protected MailMessage $message;

    protected array $mail;

    public function __construct(MailMessage $mailMessage, array $mail)
    {
        $this->message = $mailMessage;
        $this->mail = $mail;
    }

    public function getMessageData(): MailMessage
    {
        return $this->message;
    }

    public function setMessageData(MailMessage $message): void
    {
        $this->message = $message;
    }

    public function getMailData(): array
    {
        return $this->mail;
    }
}
