<?php

namespace RKW\RkwWebcheck\Helper;

use RKW\RkwWebcheck\Domain\Model\Webcheck;

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
 * Backend
 * Due to the large commonalities, the QueueMail-Model is derived and the other propertys for
 * QueueRecipient specially created
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Backend implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * is calculating benchmarks for a webcheck
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @param array $checkResultList
     * @return array
     */
    public function getCheckBenchmark
    (
        Webcheck $webcheck,
        $checkResultList
    )
    {
        $checksum = 0;
        $counter = 0;

        foreach ($checkResultList as $checkResult) {
            $checksum = $checksum + $checkResult['sum'];
            $counter++;
        }

        $maxSum = 0;

        /** @var \RKW\RkwWebcheck\Domain\Model\Topic $topic */
        foreach ($webcheck->getTopics() as $topic) {

            $questionSum = count($topic->getQuestions());
            $maxSum = $maxSum + (($questionSum * 2) * $topic->getWeight());
        }

        $sumAllMaximum = ($maxSum * $counter);
        $percent = round((($checksum / $sumAllMaximum) * 100), 2);

        $benchmark = array(
            'percent'       => $percent,
            'numChecks'     => $counter,
            'averageSum'    => $checksum / $counter,
            'maxSum'        => $maxSum,
            'sumAllMaximum' => $sumAllMaximum,
        );

        return ($benchmark);
        //===
    }
}