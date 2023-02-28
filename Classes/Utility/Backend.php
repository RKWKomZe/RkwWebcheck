<?php
namespace RKW\RkwWebcheck\Utility;

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

use RKW\RkwWebcheck\Domain\Model\Webcheck;

/**
 * Backend
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Backend implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Calculates benchmarks for a webcheck
     *
     * @param \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck
     * @param array $checkResultList
     * @return array
     */
    public function getCheckBenchmark (
        Webcheck $webcheck,
        array $checkResultList
    ): array {

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
    }
}
