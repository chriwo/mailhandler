<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class MailRepository.
 */
class MailRepository extends Repository
{
    /**
     * Overload Find by UID to also get hidden records.
     *
     * @param int $uid mail template UID
     * @return object|\ChriWo\Mailhandler\Domain\Model\Mail
     */
    public function findByUid($uid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $and = [$query->equals('uid', $uid)];

        return $query->matching($query->logicalAnd($and))->execute()->getFirst();
    }
}
