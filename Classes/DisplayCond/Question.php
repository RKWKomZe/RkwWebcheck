<?php

namespace RKW\RkwWebcheck\DisplayCond;

use RKW\RkwWebcheck\Domain\Repository\WebcheckRepository;

/**
 * This file is part of the "RkwWebcheck" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */


/**
 * Checks display conditions on TCA
 */
class Question
{

    /**
     * webcheckRepository
     *
     * @var \RKW\RkwWebcheck\Domain\Repository\WebcheckRepository
     * @inject
     */
    protected $webcheckRepository;

    /**
     * Question constructor
     * @return void
     */
    public function __construct()
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        if (!$this->webcheckRepository) {
            $this->webcheckRepository = $objectManager->get(WebcheckRepository::class);
        }
    }

    /**
     * @param array $array
     * @return bool
     */
    public function useHints(array $array): bool
    {
        /** @var \RKW\RkwWebcheck\Domain\Model\Webcheck $webcheck */
        $webcheck = $this->webcheckRepository->findByQuestion($array['record']['uid'])->getFirst();

        return $webcheck->getShowHints();
    }

}
