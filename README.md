# BEdita I18n Deepl plugin for CakePHP

[![Github Actions](https://github.com/bedita/i18n-deepl/workflows/php/badge.svg)](https://github.com/bedita/i18n-deepl/actions?query=workflow%3Aphp)
[![codecov](https://codecov.io/gh/bedita/i18n-deepl/branch/master/graph/badge.svg)](https://codecov.io/gh/bedita/i18n-deepl)
[![phpstan](https://img.shields.io/badge/PHPStan-level%209-brightgreen.svg)](https://phpstan.org)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bedita/i18n-deepl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bedita/i18n-deepl?branch=master)
[![image](https://img.shields.io/packagist/v/bedita/i18n-deepl.svg?label=stable)](https://packagist.org/packages/bedita/i18n-deepl)
[![image](https://img.shields.io/github/license/bedita/i18n-deepl.svg)](https://github.com/bedita/i18n-deepl/blob/master/LICENSE.LGPL)

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require bedita/i18n-deepl
```

## DeepL Translator

This plugin uses [DeepL Translator](https://www.deepl.com/translator) to translate texts, via [deepl-php-lib](https://github.com/Baby-Markt/deepl-php-lib).

Usage example:
```php
use BEdita\I18n\Translator\DeepLTranslator;

$translator = new DeepLTranslator();
$translator->setup(['auth_key' => 'your-auth-key']);
$translation = $translator->translate(['Hello world!'], 'en', 'it');
```
