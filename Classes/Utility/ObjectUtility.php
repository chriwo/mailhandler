<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class ObjectUtility.
 */
class ObjectUtility
{
    /**
     * @return object|\TYPO3\CMS\Extbase\Object\ObjectManager
     */
    public static function getObjectManager()
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }
}
