[![PHP Version Require](http://poser.pugx.org/makarms/text-probe/require/php)](https://packagist.org/packages/makarms/text-probe) [![Latest Stable Version](http://poser.pugx.org/makarms/text-probe/v)](https://packagist.org/packages/makarms/text-probe) [![codecov](https://codecov.io/github/MakarMS/text-probe/graph/badge.svg?token=HFDSEGHGH4)](https://codecov.io/github/MakarMS/text-probe) [![License](http://poser.pugx.org/makarms/text-probe/license)](https://packagist.org/packages/makarms/text-probe)
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

- `EmailProbe` — extracts email addresses

- `PhoneProbe` — extracts phone numbers (supports various formats)

- `DomainProbe` — extracts domain names, including internationalized (Unicode) domains

- `LinkProbe` — extracts hyperlinks, including ones with IP addresses, ports, or without a protocol

- `TelegramUserLinkProbe` — extracts t.me links pointing to Telegram users

- `TelegramUsernameProbe` — extracts Telegram usernames (e.g., `@username`)

- `DiscordNewUsernameProbe` — extracts Discord usernames in the new format (e.g., `@username`), enforcing Discord’s
  updated naming rules (length, characters, no consecutive dots)

- `DiscordOldUsernameProbe` — extracts classic Discord usernames in the format `username#1234`, ensuring proper
  structure and valid discriminator

- `SlackUsernameProbe` — extracts Slack usernames (e.g., @username), supporting Slack-specific username rules such as
  allowed characters, length limits, and no consecutive dots

- `IPv4Probe` — extracts IPv4 addresses, supporting standard formats and excluding reserved/bogus ranges if necessary

- `IPv6Probe` — extracts IPv6 addresses, including compressed formats, IPv4-mapped addresses, and zone indexes (e.g.,
  %eth0)

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
        $result->getProbeType()->name,
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
