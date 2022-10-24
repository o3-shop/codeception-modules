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

namespace OxidEsales\Codeception\Module\Translation;

/**
 * Class TranslationsModule
 * @package OxidEsales\Codeception\Module\Translation
 */
class TranslationsModule extends \Codeception\Module
{
    /**
     * @var array
     */
    private $paths = ['Application/translations'];

    /**
     * @var string
     */
    private $currentLocale = 'en';

    /**
     * @var array
     */
    private $fileNamePatterns = ['*lang.php', '*options.php'];

    /**
     * @var array
     */
    protected $config = [
        'paths' => null,
        'locale' => null,
        'file_name_patterns' => null,
    ];

    /**
     * @var array
     */
    protected $requiredFields = ['shop_path'];

    /**
     * Initializes translator
     */
    public function _initialize()
    {
        parent::_initialize();

        Translator::initialize(
            $this->getCurrentLocale(),
            $this->getLanguageDirectoryPaths(),
            $this->getFileNamePatterns()
        );
    }

    /**
     * @return array
     */
    private function getLanguageDirectoryPaths(): array
    {
        $fullPaths = [];
        if ($this->config['paths']) {
            $customPaths = $this->normalizeCustomPaths($this->config['paths']);
            $this->paths = array_merge($this->paths, $customPaths);
        }
        foreach ($this->paths as $path) {
            $fullPaths[] = $this->config['shop_path'].'/'.trim($path, '/').'/';
        }
        return $fullPaths;
    }

    private function normalizeCustomPaths($paths): array
    {
        if (!is_array($paths)) {
            $paths = explode(',', $paths);
        }

        return $paths;
    }

    /**
     * @return string
     */
    private function getCurrentLocale(): string
    {
        if (isset($this->config['locale'])) {
            return $this->config['locale'];
        }
        return $this->currentLocale;
    }

    /**
     * @return array
     */
    private function getFileNamePatterns(): array
    {
        if (isset($this->config['file_name_patterns'])) {
            $this->fileNamePatterns = explode(',', $this->config['file_name_patterns']);
        }
        return $this->fileNamePatterns;
    }
}
