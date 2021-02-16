<?php

namespace RKW\RkwWebcheck\Utility;

use RKW\RkwWebcheck\Domain\Model\Webcheck;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Misc
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Misc implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected static $logger;



    /**
     * get pages UID from typolink (TCA "inputLink")
     *
     * @param string typolink
     * @return int|bool
     */
    public static function getUidFromTypolink($typolink)
    {
        // ### workaround start ###
        // just a little service-workaround for existing checks, which having a PID (int) as link
        // @toDo: this could be removed, after all checks have new links
        if (is_numeric($typolink)) {
            return (int) $typolink;
        }
        // ### workaround end ###

        // extract page UID from inputLink
        $result = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('=', $typolink);

        // check if trimExplode has a numeric entry as result
        if (is_numeric($result[1])) {
            return (int) $result[1];
        }

        self::getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, 'No valid PID for check given. Or something other went wrong while exploding the given link.');

        return false;
    }



    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected static function getLogger()
    {

        if (!self::$logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            self::$logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        }

        return self::$logger;
        //===
    }
}