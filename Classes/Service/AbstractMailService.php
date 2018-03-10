<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Domain\Repository\MailRepository;
use ChriWo\Mailhandler\Utility\ObjectUtility;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AbstractMailService.
 */
abstract class AbstractMailService
{
    /**
     * @var \ChriWo\Mailhandler\Domain\Repository\MailRepository
     */
    protected $mailRepository;

    /**
     * @var \ChriWo\Mailhandler\Domain\Model\Mail
     */
    protected $mailTemplate;

    /**
     * @var \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected $mailMessage;

    /**
     * AbstractMailService constructor.
     */
    public function __construct()
    {
        $this->mailRepository = ObjectUtility::getObjectManager()->get(MailRepository::class);
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
