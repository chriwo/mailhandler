<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Service;

use ChriWo\Mailhandler\Utility\StringUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

trait MailServiceTrait
{
    /**
     * Add the email receiver.
     *
     * @param array $email
     * @param string $receiver
     * @param string $overwriteReceiver
     * @return void
     */
    protected function addEmailReceiver(array &$email, $receiver, $overwriteReceiver = '')
    {
        $mailReceiver = GeneralUtility::trimExplode('|', $receiver, true);
        $email['receiverEmail'] = $mailReceiver[1];
        $email['receiverName'] = $mailReceiver[0];

        if (!empty($overwriteReceiver)) {
            $mailReceiver = GeneralUtility::trimExplode('|', $overwriteReceiver, true);
            $email['receiverEmail'] = $mailReceiver[1];
            $email['receiverName'] = $mailReceiver[0];
        }
    }

    /**
     * Add the sender email address and sender name.
     *
     * @param array $email
     * @param string $sender
     * @throws \Exception
     * @return void
     */
    protected function addEmailSender(array &$email, $sender)
    {
        $mailSender = GeneralUtility::trimExplode('|', $sender, true);
        $email['senderName'] = $mailSender[0];
        $email['senderEmail'] = $mailSender[1];
    }

    /**
     * Add mail body html.
     *
     * @param array $email
     * @return string
     */
    protected function getHtmlBody(array $email): string
    {
        return StringUtility::fluidParseString($email['rteBody'], $email['variables']);
    }

    /**
     * Add mail body plain.
     *
     * @param array $email
     * @return string
     */
    protected function getPlainBody(array $email): string
    {
        $bodyText = StringUtility::fluidParseString(
            nl2br(nl2br($email['rteBody'])),
            $email['variables']
        );
        return StringUtility::makePlain($bodyText);
    }
}
