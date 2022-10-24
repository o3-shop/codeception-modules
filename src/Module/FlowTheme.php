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

declare(strict_types=1);

namespace OxidEsales\Codeception\Module;

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\TestInterface;

/**
 * Class FlowTheme
 * @package OxidEsales\Codeception\Module
 */
class FlowTheme extends \Codeception\Module implements DependsOnModule
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @return array
     */
    public function _depends(): array
    {
        return [
            Database::class => 'OxidEsales\Codeception\Module\Database is required'
        ];
    }

    /**
     * @param Database $database
     */
    public function _inject(Database $database): void
    {
        $this->database = $database;
    }

    /**
     * @param TestInterface $test
     */
    public function _before(TestInterface $test): void
    {
        $this->database->updateConfigInDatabase('stickyHeader', false, 'bool');
    }
}
