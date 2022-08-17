<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Service;

/**
 * Interface MailServiceInterface.
 */
interface MailServiceInterface
{
    /**
     * @param int $templateRecord
     * @param string $receiver
     * @param array $data
     * @param array $overrideOptions
     * @param array $additionalAttachment
     */
    public function process(
        int $templateRecord,
        string $receiver,
        array $data,
        array $overrideOptions,
        array $additionalAttachment): void;

    /**
     * Returns the submit status of an email
     * @return bool
     */
    public function isMailSend(): bool;
}
