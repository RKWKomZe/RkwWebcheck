<?php

namespace RKW\RkwWebcheck\ViewHelpers;

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

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
 * GlossaryViewViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GlossaryViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * Format the numeric value as a number with grouped thousands, decimal point and
     * precision.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $glossaryList
     * @param string $cssClass
     * @return string
     */
    public function render(\TYPO3\CMS\Extbase\Persistence\QueryResultInterface $glossaryList, $cssClass = '')
    {
        return static::renderStatic(
            [
                'glossaryList' => $glossaryList,
                'cssClass'     => $cssClass,
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $glossaryList = $arguments['glossaryList'];
        $cssClass = $arguments['cssClass'] ? $arguments['cssClass'] : 'careercheck__glossary';
        $string = $renderChildrenClosure();

        if ($glossaryList instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface) {

            $replacementArray = array();
            $cnt = 0;
            foreach ($glossaryList as $glossary) {
                if ($glossary instanceof \RKW\RkwWebcheck\Domain\Model\Glossary) {
                    $string = preg_replace('/\b(' . $glossary->getName() . ')\b/i', '<!-- REPLACEMENT-START-' . $cnt . ' -->' . strip_tags("$1") . '<!-- REPLACEMENT-END-' . $cnt . ' -->', $string);
                    $replacementArray['<!-- REPLACEMENT-START-' . $cnt . ' -->'] = '<span class="' . $cssClass . '" title="' . addslashes($glossary->getDescription()) . '">';
                    $replacementArray['<!-- REPLACEMENT-END-' . $cnt . ' -->'] = '</span>';
                    $cnt++;
                }
            }

            // now do final replacement - this way we are able to prevent replacing in the span-elements!
            $string = str_replace(array_keys($replacementArray), array_values($replacementArray), $string);

        }

        return $string;
        //===
    }


}