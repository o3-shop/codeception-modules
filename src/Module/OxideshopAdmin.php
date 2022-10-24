<?php
/**
 * This file is part of O3-Shop.
 *
 * O3-Shop is free software: you can redistribute it and/or modify  
 * it under the terms of the GNU General Public License as published by  
 * the Free Software Foundation, version 3.
 *
 * O3-Shop is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
 * General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with O3-Shop.  If not, see <http://www.gnu.org/licenses/>
 *
 * @copyright  Copyright (c) 2022 OXID eSales AG (https://www.oxid-esales.com)
 * @copyright  Copyright (c) 2022 O3-Shop (https://www.o3-shop.com)
 * @license    https://www.gnu.org/licenses/gpl-3.0  GNU General Public License 3 (GPLv3)
 */

namespace OxidEsales\Codeception\Module;

require_once __DIR__.'/../../../../oxid-esales/testing-library/base.php';

use Codeception\Lib\Interfaces\DependsOnModule;

/**
 * Class OxideshopAdmin
 * @package OxidEsales\Codeception\Module
 */
class OxideshopAdmin extends \Codeception\Module implements DependsOnModule
{
    /**
     * Admin interface frame IDs
     */
    private const FRAME_LIST = 'list';
    private const FRAME_NAVIGATION = 'navigation';
    private const FRAME_BASE = 'basefrm';
    private const FRAME_EDIT = 'edit';
    private const FRAME_HEADER = 'header';
    private const FRAME_ADMINNAV = 'adminnav';

    /**
     * Admin interface frame dependency structure. One level supported.
     *
     * Frame -> Parent frame
     *
     * @var array
     */
    private $frameParents = [
        self::FRAME_ADMINNAV => self::FRAME_NAVIGATION,
        self::FRAME_LIST => self::FRAME_BASE,
        self::FRAME_EDIT => self::FRAME_BASE
    ];

    /**
     * Dependency on Oxideshop module
     *
     * @var Oxideshop
     */
    private $oxideshop;

    /**
     * Dependency on Webdriver module
     *
     * @var \Codeception\Module\WebDriver
     */
    private $webdriver;

    /**
     * @return array
     */
    public function _depends()
    {
        return [
            \Codeception\Module\WebDriver::class => 'Codeception\Module\WebDriver is required',
            Oxideshop::class => 'Codeception\Module\Oxideshop is required'
        ];
    }

    /**
     * @param \Codeception\Module\WebDriver $webDriver
     * @param Oxideshop $oxideshop
     */
    public function _inject(\Codeception\Module\WebDriver $webDriver, Oxideshop $oxideshop)
    {
        $this->webdriver = $webDriver;
        $this->oxideshop = $oxideshop;
    }

    /**
     * Select Header frame in Admin panel to be active now
     */
    public function selectHeaderFrame()
    {
        $this->selectFrameInAdmin(self::FRAME_HEADER);
    }


    /**
     * Select Base frame in Admin panel to be active now
     */
    public function selectBaseFrame()
    {
        $this->selectFrameInAdmin(self::FRAME_BASE);
    }

    /**
     * Select Edit frame in Admin panel to be active now
     */
    public function selectEditFrame()
    {
        $this->selectFrameInAdmin(self::FRAME_EDIT);
    }

    /**
     * Select Navigation frame in Admin panel to be active now
     */
    public function selectNavigationFrame()
    {
        $this->selectFrameInAdmin(self::FRAME_ADMINNAV);
    }

    /**
     * Select List frame in Admin panel to be active now
     */
    public function selectListFrame()
    {
        $this->selectFrameInAdmin(self::FRAME_LIST);
    }

    /**
     * Selects the frame by current O3-Shop admin frame dependency structure
     *
     * @param string $desiredFrame
     */
    private function selectFrameInAdmin($desiredFrame)
    {
        $desiredParent = $this->frameParents[$desiredFrame] ?? '';

        $this->webdriver->switchToFrame();

        if ($desiredParent) {
            $this->webdriver->waitForElement("#{$desiredParent}", 5);
            $this->webdriver->switchToFrame($desiredParent);
            $this->oxideshop->waitForDocumentReadyState();
        }

        $this->webdriver->waitForElement("#{$desiredFrame}", 5);
        $this->webdriver->switchToFrame($desiredFrame);
        $this->oxideshop->waitForDocumentReadyState();
    }
}
