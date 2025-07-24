# TextProbe

**TextProbe** is a simple and extensible PHP library for text analysis and pattern matching. It is designed to help developers probe, parse, and manipulate text efficiently using customizable rules and matchers.

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

The library comes with several built-in probes to detect common patterns in text:

- EmailProbe — extracts email addresses

- PhoneProbe — extracts phone numbers (supports various formats)

- DomainProbe — extracts domain names, including internationalized (Unicode) domains

You can also implement your own probes by creating classes that implement the `IProbe` interface.

## Usage Example

```php
require __DIR__ . '/vendor/autoload.php';

use TextProbe\TextProbe;
use TextProbe\Probes\EmailProbe;

$text = "Please contact us at info@example.com for more details.";

$probe = new TextProbe();
$probe->addProbe(new EmailProbe());

$results = $probe->analyze($text);

foreach ($results as $result) {
    echo sprintf(
        "[%s] %s (position %d-%d)\n",
        $result->getProbeEnum()->name,
        $result->getResult(),
        $result->getStart(),
        $result->getEnd()
    );
}
```

### Expected output:

```
[EMAIL] info@example.com (position 21-37)
```
