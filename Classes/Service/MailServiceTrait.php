<?php

declare(strict_types=1);

namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Utility\StringUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

trait MailServiceTrait
{
    /**
     * Add the email receiver.
     */
    protected function addEmailReceiver(array &$email, string $receiver, string $overrideReceiver = '')
    {
        $mailReceiver = GeneralUtility::trimExplode('|', $receiver, true);
        $email['receiverEmail'] = $mailReceiver[1];
        $email['receiverName'] = $mailReceiver[0];

        if (!empty($overrideReceiver)) {
            $mailReceiver = GeneralUtility::trimExplode('|', $overrideReceiver, true);
            $email['receiverEmail'] = $mailReceiver[1];
            $email['receiverName'] = $mailReceiver[0];
        }
    }

    /**
     * Add the sender email address and sender name.
     *
     * @throws \Exception
     */
    protected function addEmailSender(array &$email, string $sender)
    {
        $mailSender = GeneralUtility::trimExplode('|', $sender, true);
        $email['senderName'] = $mailSender[0];
        $email['senderEmail'] = $mailSender[1];
    }

    /**
     * Add mail body html.
     */
    protected function getHtmlBody(array $email): string
    {
        return StringUtility::fluidParseString($email['rteBody'], $email['variables']);
    }

    /**
     * Add mail body plain.
     */
    protected function getPlainBody(array $email): string
    {
        return StringUtility::makePlain($this->getHtmlBody($email));
    }
}
