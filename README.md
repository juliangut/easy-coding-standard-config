[![PHP version](https://img.shields.io/badge/PHP-%3E%3D8.1-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/juliangut/easy-coding-standard-config.svg?style=flat-square)](https://packagist.org/packages/juliangut/easy-coding-standard-config)
[![License](https://img.shields.io/github/license/juliangut/easy-coding-standard-config.svg?style=flat-square)](https://github.com/juliangut/easy-coding-standard-config/blob/master/LICENSE)

[![Total Downloads](https://img.shields.io/packagist/dt/juliangut/easy-coding-standard-config.svg?style=flat-square)](https://packagist.org/packages/juliangut/easy-coding-standard-config/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/juliangut/easy-coding-standard-config.svg?style=flat-square)](https://packagist.org/packages/juliangut/easy-coding-standard-config/stats)

# easy-coding-standard-config

Opinionated as can be configuration defaults for [Easy-Coding-Standard](https://github.com/symplify/easy-coding-standard/)

## Installation

### Composer

```
composer require --dev juliangut/easy-coding-standard-config
```

## Usage

Create `ecs.php` file at your project's root directory

```php
<?php

use Jgut\ECS\ConfigSet82;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$header = <<<'HEADER'
slim-routing (https://github.com/juliangut/slim-routing).
Slim framework routing.

@license BSD-3-Clause
@link https://github.com/juliangut/slim-routing
@author Julián Gutiérrez <juliangut@gmail.com>
HEADER;

return static function (ECSConfig $ecsConfig) use ($header): void {
    $ecsConfig->paths([
        __FILE__,
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    (new ConfigSet82())
        ->configure($ecsConfig);
};
```

Use one of the provided configurations depending on the PHP version you want to support:

* `Jgut\ECS\ConfigSet82`, PHP >= 8.2
* `Jgut\ECS\ConfigSet81`, PHP >= 8.1
* `Jgut\ECS\ConfigSet80`, PHP >= 8.0
* `Jgut\ECS\ConfigSet74`, PHP >= 7.4

### Configurations

#### Header

Provide a header string, it will be prepended to every file analysed by php-cs-fixer.

The string `{{year}}` will be replaced by the current year, and the string `{{package}}` will be replaced by your package name

```php
(new ConfigSet82())
    ->setHeader(<<<'HEADER'
    (c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    This file is part of package {{package}}
    HEADER);
```

```diff
--- Original
+++ New
 <?php

+/*
+ * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
+ *
+ * This file is part of package juliangut/php-cs-fixer-config
+ */
+
 declare(strict_types=1);

 namespace App;
```

If `{{year}}` is preceded by current year it will be combined into a single date

```php
// Assuming current year is 2023
(new ConfigSet82())
    ->setHeader(<<<'HEADER'
    (c) 2023-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    This file is part of package {{package}}
    HEADER);
```

```diff
--- Original
+++ New
 <?php

+/*
+ * (c) 2023 Julián Gutiérrez <juliangut@gmail.com>
+ *
+ * This file is part of package juliangut/php-cs-fixer-config
+ */
+
 declare(strict_types=1);

 namespace App;
```

#### PHPUnit

If you work with PHPUnit

```php
(new ConfigSet82())
    ->enablePhpUnitRules();
```

#### Doctrine

If you work with Doctrine

```php
(new ConfigSet82())
    ->enableDoctrineRules();
```

#### Type Inference

If you're in the middle of "type hinting everything", try enabling type inference rules and let php-cs-fixer migrate types from annotations into properties, parameters and return types

Be aware __these rules are experimental__ and will need human supervision after fixing, so you are advised NOT to permanently enable type inference

```php
(new ConfigSet82())
    ->enableTypeInferRules();
```

```diff
--- Original
+++ New
<?php

 declare(strict_types=1);

 namespace App;
 
 class Foo
 {
-    /**
-     * @var string|null
-     */
-    protected $foo
+    protected ?string $foo

-    /**
-     * @var Bar
-     */
-    protected $bar
+    protected Bar $bar

-    /**
-     * @var bool
-     */
-    protected $baz
+    protected bool $baz

     /**
      * Foo constructor.
-     *
-     * @param string|null $foo
-     * @param Bar         $bar
-     * @param bool        $baz
      */
-    public function __construct($foo, $bar, $baz = false)
+    public function __construct(?string $foo, Bar $bar, bool $baz = false)
     {
         $this->foo = $foo;
         $this->bar = $bar;
         $this->baz = $baz;
     }

-    /**
-     * @return bool
-     *
-    public function isBaz()
+    public function isBaz(): bool
     {
        return $this->baz;
     }
 }
```

#### Additional rules

If you need to add a few additional rules, this rules can be new or override rules already set, the easiest way is using `setAdditionalRules` method

It is preferred to identify fixers by their class name, anyway using fixer names will work as well

```php
(new ConfigSet82())
    ->setAdditionalRules([
        SingleLineThrowFixer::class => true,
    ]);
```

#### Custom config

If you need more control over applied rules or prefer a cleaner setup, you can easily create your custom fixer config instead of setting additional rules

```php
use Jgut\ECS\ConfigSet82;
use PhpCsFixer\Fixer\FunctionNotation\SingleLineThrowFixer;

class CustomConfigSet extends ConfigSet82
{
    protected function getRules(): array
    {
        // Return your custom rules, or add/remove rules from parent's getRules()
        return array_merge(
            parent::getRules(),
            [
                SingleLineThrowFixer::class => true,
            ]
        );
    }
}
```

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/juliangut/easy-coding-standard-config/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/juliangut/easy-coding-standard-config/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/juliangut/easy-coding-standard-config/blob/master/LICENSE) included with the source code for a copy of the license terms.
