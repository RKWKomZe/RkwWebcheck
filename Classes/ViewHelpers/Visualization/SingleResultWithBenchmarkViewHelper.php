<?php

namespace RKW\RkwWebcheck\ViewHelpers\Visualization;

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
 * Class SingleResultWithBenchmarkViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SingleResultWithBenchmarkViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;


    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('benchmarkPercent', 'float', 'The percentage value for the benchmark result.', true);
        $this->registerArgument('resultPercent', 'float', 'The percentage value for the individual result', true);
    }


    /**
     * google virtualization single result
     *
     * @return string $string
     *  @todo remove combination of PHP and JS. This is no fucking WordPress. JS should be outsourced into a template, maybe combined with StandaloneView
     */
    public function render(): string
    {

        /** @var float $resultPercent */
        $resultPercent = $this->arguments['resultPercent'];

        /** @var float $benchmarkPercent */
        $benchmarkPercent = $this->arguments['benchmarkPercent'];

        return "
			<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
            <script type='text/javascript'>
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawVisualization);

				function drawVisualization() {
					var data = google.visualization.arrayToDataTable([
						[
							'" . LocalizationUtility::translate('partials_backend_visualization.check', 'rkw_webcheck') . "',
							'" . LocalizationUtility::translate('partials_backend_visualization.resultOfCheck', 'rkw_webcheck') . "',
							'" . LocalizationUtility::translate('partials_backend_visualization.benchmark', 'rkw_webcheck') . "'
						],
						[
						'" . LocalizationUtility::translate('partials_backend_visualization.check', 'rkw_webcheck') . "',
						" . floatval($resultPercent) . ",
						" . floatval($benchmarkPercent) . "
						]
					]);

					var options = {
						title : '',
						legend: {
							position: 'top',
							alignment: 'start'
						},
						vAxis: {
							title: '%',
							minValue: 0,
							maxValue: 100
						},
						hAxis: {
							title: ''
						},
						seriesType: 'bars',
						series: {
							0: {
								color: '#e64415'
							},
							1: {
								color: '#666'
							}
						}
					};

					var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
					chart.draw(data, options);
				}
			</script>
		";
    }
}
