<?php
declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2023 Atlas Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */
namespace BEdita\I18n\Deepl\Test\Core;

use BabyMarkt\DeepL\DeepL;
use BEdita\I18n\Deepl\Core\DeepLTranslator;
use Cake\TestSuite\TestCase;

/**
 * {@see \BEdita\I18n\Deepl\Core\DeepLTranslator} Test Case
 *
 * @covers \BEdita\I18n\Deepl\Core\DeepLTranslator
 */
class DeepLTranslatorTest extends TestCase
{
    /**
     * Test setup.
     *
     * @return void
     * @covers ::setup()
     */
    public function testSetup(): void
    {
        $translator = new class extends DeepLTranslator {
            public function getDeepLClient(): DeepL
            {
                return $this->deeplClient;
            }
        };
        $translator->setup(['auth_key' => 'test-auth-key']);
        static::assertNotEmpty($translator->getDeepLClient());
    }

    /**
     * Test translate.
     *
     * @return void
     * @covers ::translate()
     */
    public function testTranslate(): void
    {
        $translator = new class extends DeepLTranslator {
            public function setup(array $options = []): void
            {
                $this->deeplClient = new class ('fake-auth-key', 2) extends DeepL
                {
                    public function translate(
                        $text,
                        $sourceLang = '',
                        $targetLang = 'en',
                        $tagHandling = null,
                        array $ignoreTags = null,
                        $formality = 'default',
                        $splitSentences = null,
                        $preserveFormatting = null,
                        array $nonSplittingTags = null,
                        $outlineDetection = null,
                        array $splittingTags = null,
                        string $glossaryId = null
                    ): array {
                        return [
                            ['text' => 'translation of ' . json_encode($text) . ' from ' . $sourceLang . ' to ' . $targetLang],
                        ];
                    }
                };
            }
        };
        $translator->setup([]);
        $actual = $translator->translate(['Hello world!'], 'en', 'it');
        $expected = json_encode([
            'translation' => [
                'translation of ["Hello world!"] from en to it',
            ],
        ]);
        static::assertEquals($expected, $actual);
    }
}