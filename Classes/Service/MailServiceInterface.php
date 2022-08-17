<?php

declare(strict_types=1);

namespace ChriWo\Mailhandler\Service;

/**
 * Interface MailServiceInterface.
 */
interface MailServiceInterface
{
    public function process(
        int $templateRecord,
        string $receiver,
        array $data,
        array $overrideOptions,
        array $additionalAttachment): void;

    /**
     * Returns submit status of an email
     */
    public function isMailSend(): bool;
}
