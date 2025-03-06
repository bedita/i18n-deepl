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

use BEdita\I18n\Deepl\Core\Translator;
use Cake\TestSuite\TestCase;
use DeepL\TextResult;
use DeepL\Translator as DeeplTranslator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

/**
 * {@see \BEdita\I18n\Deepl\Core\Translator} Test Case
 */
#[CoversClass(Translator::class)]
#[CoversMethod(Translator::class, 'setup')]
#[CoversMethod(Translator::class, 'translate')]
class TranslatorTest extends TestCase
{
    /**
     * Test setup.
     *
     * @return void
     */
    public function testSetup(): void
    {
        $translator = new class extends Translator {
            public function getDeepLClient(): DeeplTranslator
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
     */
    public function testTranslate(): void
    {
        $translator = new class extends Translator {
            public function setup(array $options = []): void
            {
                $this->deeplClient = new class ('fake-auth-key') extends DeeplTranslator
                {
                    /**
                     * @inheritDoc
                     */
                    public function translateText($texts, ?string $sourceLang, string $targetLang, array $options = [])
                    {
                        return [new TextResult(
                            'translation of ' . json_encode($texts) . ' from ' . $sourceLang . ' to ' . $targetLang,
                            'en'
                        )];
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
