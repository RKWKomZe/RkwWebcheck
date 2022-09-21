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
 * Class WebcheckRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class WebcheckRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * get all checks
     * sorted by name
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllOrderByName()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings(array('name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));

        return $query->execute();
        //===
    }

    /**
     * find check by included question
     *
     * @param integer $questionId (the id of the included question)
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByQuestion(int $questionId = 0)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->statement(
            'SELECT tx_rkwwebcheck_domain_model_webcheck.*
            FROM tx_rkwwebcheck_domain_model_webcheck
            INNER JOIN tx_rkwwebcheck_topic_question_mm ON tx_rkwwebcheck_topic_question_mm.uid_foreign = ' . $questionId . '
            INNER JOIN tx_rkwwebcheck_check_topic_mm
            WHERE tx_rkwwebcheck_check_topic_mm.uid_foreign = tx_rkwwebcheck_topic_question_mm.uid_local
            AND tx_rkwwebcheck_domain_model_webcheck.uid = tx_rkwwebcheck_check_topic_mm.uid_local
            GROUP BY tx_rkwwebcheck_domain_model_webcheck.uid'
        );

        return $query->execute();
        //===

    }
}
