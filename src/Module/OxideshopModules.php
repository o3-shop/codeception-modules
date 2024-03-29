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

use Codeception\Lib\Interfaces\ConflictsWithModule;
use Codeception\Lib\ModuleContainer;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Exception\ModuleSetupException;
use OxidEsales\Facts\Facts;

/**
 * Class Oxideshop
 * @package OxidEsales\Codeception\Module
 */
class OxideshopModules extends \Codeception\Module implements ConflictsWithModule
{
    /** @var string */
    private $shopRootPath;

    /**
     * @var string
     */
    private $communityEditionRootPath;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        $this->shopRootPath = (new Facts())->getShopRootPath();
        $this->communityEditionRootPath = (new Facts())->getCommunityEditionRootPath();

        parent::__construct($moduleContainer, $config);
    }

    public function _conflicts()
    {
        return 'OxidEsales\Codeception\Module\Oxideshop';
    }

    /**
     * Reset context and activate modules before test
     */
    public function _beforeSuite($settings = [])
    {
        $this->activateModules();
    }

    /**
     * Activates modules
     */
    private function activateModules()
    {
        $testConfig = new \OxidEsales\TestingLibrary\TestConfig();
        $modulesToActivate = $testConfig->getModulesToActivate();

        if ($modulesToActivate) {
            $serviceCaller = new \OxidEsales\TestingLibrary\ServiceCaller();
            $serviceCaller->setParameter('modulestoactivate', $modulesToActivate);
            try {
                $serviceCaller->callService('ModuleInstaller', 1);
            } catch (ModuleSetupException $e) {
                // this may happen if the module is already active,
                // we can ignore this
            }
        }
    }

    public function getShopModulePath(string $modulePath): string
    {
        return $this->shopRootPath . '/source/modules' . substr($modulePath, strrpos($modulePath, '/'));
    }

    public function installModule($modulePath)
    {
        //first Copy
        exec('cp ' . $modulePath . ' ' . $this->shopRootPath . '/source/modules/ -R');
        //now activate
        exec(
            $this->communityEditionRootPath .
            '/bin/oe-console oe:module:install-configuration ' .
            $this->getShopModulePath($modulePath)
        );
    }

    public function uninstallModule($modulePath, $moduleId)
    {
        exec(
            $this->communityEditionRootPath .
            '/bin/oe-console oe:module:uninstall-configuration ' .
            $moduleId
        );
        $path = $this->getShopModulePath($modulePath);
        if (file_exists($path) && is_dir($path)) {
            exec('rm ' . $path . ' -R');
        }
    }

    public function activateModule($moduleId)
    {
        exec($this->communityEditionRootPath . '/bin/oe-console oe:module:activate ' . $moduleId);
    }

    public function deactivateModule($moduleId)
    {
        exec($this->communityEditionRootPath . '/bin/oe-console oe:module:deactivate ' . $moduleId);
    }
}
