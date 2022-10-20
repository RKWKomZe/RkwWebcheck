<?php

namespace RKW\RkwWebcheck\ViewHelpers;
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
 * RatingCssViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RatingCssViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('percentage', 'float', 'The percentage value.', false, 0.0);
    }


    /**
     * Returns the corresponding CSS-Class for the percentage value
     *
     * @return string
     */
    public function render(): string
    {
        /** @var float $percentage */
        $percentage = $this->arguments['percentage'];

        $rating = 'good';
        if ($percentage <= 34) {
            $rating = 'bad';
        } elseif ($percentage <= 64) {
            $rating = 'normal';
        }

        return $rating;
    }

}
