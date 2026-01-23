# TextProbe

[![PHP Version Require](http://poser.pugx.org/makarms/text-probe/require/php)](https://packagist.org/packages/makarms/text-probe) [![Latest Stable Version](http://poser.pugx.org/makarms/text-probe/v)](https://packagist.org/packages/makarms/text-probe) [![PHP Tests](https://github.com/MakarMS/text-probe/actions/workflows/php-tests.yml/badge.svg?branch=main)](https://github.com/MakarMS/text-probe/actions/workflows/php-tests.yml) [![codecov](https://codecov.io/github/MakarMS/text-probe/graph/badge.svg?token=HFDSEGHGH4)](https://codecov.io/github/MakarMS/text-probe) [![License](http://poser.pugx.org/makarms/text-probe/license)](https://packagist.org/packages/makarms/text-probe)

**TextProbe** is a simple and extensible PHP library for text analysis and pattern matching. Designed to help
developers probe, parse, and manipulate text efficiently using customizable rules and matchers.

## Features

- 🧠 Easy-to-use API for text matching and parsing
- 🔧 Extensible architecture — write your own matchers and rules
- 💡 Suitable for parsing logs, user input, or any structured text

## Installation

You can install the library via [Composer](https://getcomposer.org/):

```bash
composer require makarms/text-probe
```

## Available Probes

TextProbe includes a wide range of built-in probes. Probes are fully extensible and support custom validation via the `IProbe` and `IValidator` interfaces. 
See [docs/probes.md](docs/probes.md) for the full categorized list.

## Usage

```php
require __DIR__ . '/vendor/autoload.php';

use TextProbe\TextProbe;
use TextProbe\Probes\Contact\EmailProbe;

$text = "Please contact us at info@example.com for more details.";

$probe = new TextProbe();
$probe->addProbe(new EmailProbe());

$results = $probe->analyze($text);

foreach ($results as $result) {
    echo sprintf(
        "[%s] %s (position %d-%d)\n",
        $result->getProbeType()->name,
        $result->getResult(),
        $result->getStart(),
        $result->getEnd()
    );
}
```

### Expected output

```text
[EMAIL] info@example.com (position 21-37)
```
