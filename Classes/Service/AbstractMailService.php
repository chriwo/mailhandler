<?php

declare(strict_types=1);

namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Domain\Model\Mail;
use ChriWo\Mailhandler\Domain\Repository\MailRepository;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AbstractMailService.
 */
abstract class AbstractMailService
{
    protected EventDispatcher $eventDispatcher;

    protected ?MailRepository $mailRepository;

    protected ?Mail $mailTemplate;

    protected ?MailMessage $mailMessage;

    /**
     * AbstractMailService constructor.
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->mailRepository = GeneralUtility::makeInstance(MailRepository::class);
        $this->mailMessage = GeneralUtility::makeInstance(MailMessage::class);
    }

    protected function loadMailTemplateRecord(int $record)
    {
        $this->mailTemplate = $this->mailRepository->findByUid($record);
    }
}
