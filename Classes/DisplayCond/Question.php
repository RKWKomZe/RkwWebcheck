<?php
namespace RKW\RkwWebcheck\DisplayCond;

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
use RKW\RkwWebcheck\Domain\Repository\WebcheckRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class WebcheckController
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Philipp Grigoleit <p.grigoleit@agentur-fahrenheit.de>
 * @author Salih Özdemir <s.oezdemir@agentur-fahrenheit.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWebcheck
 */

class Question
{

    /**
     * @var \RKW\RkwWebcheck\Domain\Repository\WebcheckRepository|null
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ?WebcheckRepository $webcheckRepository = null;


    /**
     * @param \RKW\RkwWebcheck\Domain\Repository\WebcheckRepository $webcheckRepository
     */
    public function injectWebcheckRepository(WebcheckRepository $webcheckRepository)
    {
        $this->webcheckRepository = $webcheckRepository;
    }


    /**
     * Question constructor
     * @return void
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function __construct()
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
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
