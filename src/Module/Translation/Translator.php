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

use Symfony\Component\Translation\Translator as SymfonyTranslator;

/**
 * Class Translator
 * @package OxidEsales\Codeception\Module\Translation
 */
class Translator implements TranslatorInterface
{
    /**
     * @var SymfonyTranslator
     */
    private static $sfTranslator;

    /**
     * @param string $locale
     * @param array  $paths
     * @param array  $fileNamePatterns
     */
    public static function initialize(string $locale, array $paths, array $fileNamePatterns)
    {
        self::$sfTranslator = new SymfonyTranslator($locale);
        self::$sfTranslator->setFallbackLocales(['en', 'de']);
        self::$sfTranslator->addLoader('oxphp', new LanguageDirectoryReader($fileNamePatterns));

        $languageDirectory = self::getLanguageDirectories($paths, $locale);
        self::$sfTranslator->addResource('oxphp', $languageDirectory, $locale);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function translate(string $string)
    {
        return self::$sfTranslator->trans($string);
    }

    /**
     * Returns language map array
     *
     * @param array  $paths
     * @param string $language Language index
     *
     * @return array
     */
    private static function getLanguageDirectories(array $paths, string $language)
    {
        $languageDirectories = [];

        foreach ($paths as $path) {
            $languageDirectories[] = $path . $language;
        }

        return $languageDirectories;
    }
}
