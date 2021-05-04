<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Mail.
 */
class Mail extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $mailSubject = '';

    /**
     * @var string
     */
    protected string $mailBody = '';

    /**
     * @var string
     */
    protected string $mailReceiver = '';

    /**
     * @var string
     */
    protected string $mailReceiverCc = '';

    /**
     * @var string
     */
    protected string $mailReceiverBcc = '';

    /**
     * @var string
     */
    protected string $mailSender = '';

    /**
     * @var string
     */
    protected string $mailReturnPath = '';

    /**
     * @var string
     */
    protected string $mailReplyTo = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $mailAttachment;

    /**
     * Returns the mail subject.
     *
     * @return string
     */
    public function getMailSubject(): string
    {
        return $this->mailSubject;
    }

    /**
     * Sets the mail subject.
     *
     * @param string $mailSubject
     * @return void
     */
    public function setMailSubject(string $mailSubject)
    {
        $this->mailSubject = $mailSubject;
    }

    /**
     * Returns the mail body text.
     *
     * @return string
     */
    public function getMailBody(): string
    {
        return $this->mailBody;
    }

    /**
     * Sets the mail body text.
     *
     * @param string $mailBody
     * @return void
     */
    public function setMailBody(string $mailBody)
    {
        $this->mailBody = $mailBody;
    }

    /**
     * Returns the mail receiver.
     *
     * @return string
     */
    public function getMailReceiver(): string
    {
        return $this->mailReceiver;
    }

    /**
     * Set the mail receiver.
     *
     * @param string $mailReceiver
     * @return void
     */
    public function setMailReceiver(string $mailReceiver)
    {
        $this->mailReceiver = $mailReceiver;
    }

    /**
     * Returns the mail cc receiver.
     *
     * @return string
     */
    public function getMailReceiverCc(): string
    {
        return $this->mailReceiverCc;
    }

    /**
     * Set the mail cc receiver.
     *
     * @param string $mailReceiverCc
     * @return void
     */
    public function setMailReceiverCc(string $mailReceiverCc)
    {
        $this->mailReceiverCc = $mailReceiverCc;
    }

    /**
     * Returns the mail bcc receiver.
     *
     * @return string
     */
    public function getMailReceiverBcc(): string
    {
        return $this->mailReceiverBcc;
    }

    /**
     * Set the mail bcc receiver.
     *
     * @param string $mailReceiverBcc
     * @return void
     */
    public function setMailReceiverBcc(string $mailReceiverBcc)
    {
        $this->mailReceiverBcc = $mailReceiverBcc;
    }

    /**
     * Returns the mail sender.
     *
     * @return string
     */
    public function getMailSender(): string
    {
        return $this->mailSender;
    }

    /**
     * Sets the mail sender.
     *
     * @param string $mailSender
     * @return void
     */
    public function setMailSender(string $mailSender)
    {
        $this->mailSender = $mailSender;
    }

    /**
     * Returns the mail return path.
     *
     * @return string
     */
    public function getMailReturnPath(): string
    {
        return $this->mailReturnPath;
    }

    /**
     * Set the mail return path.
     *
     * @param string $mailReturnPath
     * @return void
     */
    public function setMailReturnPath(string $mailReturnPath)
    {
        $this->mailReturnPath = $mailReturnPath;
    }

    /**
     * Returns the mail reply to.
     *
     * @return string
     */
    public function getMailReplyTo(): string
    {
        return $this->mailReplyTo;
    }

    /**
     * Set the mail reply to.
     *
     * @param string $mailReplyTo
     * @return void
     */
    public function setMailReplyTo(string $mailReplyTo)
    {
        $this->mailReplyTo = $mailReplyTo;
    }

    /**
     * Returns an object storage of file references.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getMailAttachment()
    {
        return $this->mailAttachment;
    }

    /**
     * Sets an object storage of file references.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $mailAttachment
     * @return void
     */
    public function setMailAttachment(ObjectStorage $mailAttachment)
    {
        $this->mailAttachment = $mailAttachment;
    }
}
