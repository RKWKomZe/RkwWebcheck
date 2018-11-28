<?php

namespace RKW\RkwWebcheck\Domain\Repository;

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
 * Class CheckResultRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CheckResultRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Set setRespectStorage on FALSE by default
     */
    public function initializeObject()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false); // ignore the storagePid
        $this->setDefaultQuerySettings($querySettings);
    }


    /**
     * get CheckResults that are completed by checkId and userId
     * sorted by tstamp
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @param \RKW\RkwWebcheck\Domain\Model\FrontendUser $feUser
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findCompletedByCheckAndFeUser($webcheck, $feUser)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals("webcheck", $webcheck),
                $query->equals("feUser", $feUser),
                $query->equals("completed", 1)
            )
        );

        $query->setOrderings(array("tstamp" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));

        return $query->execute();
        //===
    }


    /**
     * find checkResults for a specific user
     * sorted by tstamp
     *
     * @param \RKW\RkwWebcheck\Domain\Model\FrontendUser $feUser
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByFeUser($feUser)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $feUser)
        );
        $query->setOrderings(array("tstamp" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));

        return $query->execute();
        //===
    }


    /**
     * find checkResults for a specific check that is completed
     * sorted by tstamp
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByWebcheck($webcheck)
    {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->equals("webcheck", $webcheck),
                $query->equals("completed", 1)
            )
        );

        $query->setOrderings(array("tstamp" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));

        return $query->execute();
        //===
    }


    /**
     * find checkResults for a specific check that is completed
     * additional it has an condition to choose if it should return an object or an array
     * sorted by tstamp
     *
     * @param int $checkId
     * @param bool $array
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getCompletedByCheckId($checkId, $array)
    {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->equals("webcheck", $checkId),
                $query->equals("completed", 1)
            )
        );

        $query->setOrderings(array("tstamp" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));

        if ($array) {
            return $query->execute(true);
            //===
        }

        return $query->execute();
        //===
    }
}
