<?php
namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Domain\Repository\MailRepository;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AbstractMailService
 */
abstract class AbstractMailService
{
    /**
     * @var \ChriWo\Mailhandler\Domain\Model\Mail
     */
    protected $mailTemplate;

    /**
     * @var \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected $mailMessage;

    /**
     * @var \ChriWo\Mailhandler\Domain\Repository\MailRepository
     */
    protected $mailRepository;

    /**
     * AbstractMailService constructor.
     */
    public function __construct()
    {
        $this->mailRepository = GeneralUtility::makeInstance(MailRepository::class);
        $this->mailMessage = GeneralUtility::makeInstance(MailMessage::class);
    }

    /**
     * @param int $record
     * @return void
     */
    protected function loadMailTemplateRecord($record)
    {
        $this->mailTemplate = $this->mailRepository->findByUid($record);
    }
}
