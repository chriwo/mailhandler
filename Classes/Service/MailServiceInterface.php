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
     * @return bool
     */
    public function process($templateRecord, $receiver, array $data, array $overrideOptions): bool;
}
