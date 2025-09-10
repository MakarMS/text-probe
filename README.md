[![PHP Version Require](http://poser.pugx.org/makarms/text-probe/require/php)](https://packagist.org/packages/makarms/text-probe) [![Latest Stable Version](http://poser.pugx.org/makarms/text-probe/v)](https://packagist.org/packages/makarms/text-probe) [![codecov](https://codecov.io/github/MakarMS/text-probe/graph/badge.svg?token=HFDSEGHGH4)](https://codecov.io/github/MakarMS/text-probe) [![License](http://poser.pugx.org/makarms/text-probe/license)](https://packagist.org/packages/makarms/text-probe)

# TextProbe

**TextProbe** is a simple and extensible PHP library for text analysis and pattern matching. It is designed to help
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

The library comes with several built-in probes to detect common patterns in text:

### 🧑‍💻 Contact & Identity

- `EmailProbe` — extracts email addresses

- `PhoneProbe` — extracts phone numbers (supports various formats)

- `TelegramUserLinkProbe` — extracts t.me links pointing to Telegram users

- `TelegramUsernameProbe` — extracts Telegram usernames (e.g., `@username`)

- `DiscordNewUsernameProbe` — extracts Discord usernames in the new format (e.g., `@username`), enforcing Discord’s
  updated naming rules (length, characters, no consecutive dots)

- `DiscordOldUsernameProbe` — extracts classic Discord usernames in the format `username#1234`, ensuring proper
  structure and valid discriminator

- `SlackUsernameProbe` — extracts Slack usernames (e.g., @username), supporting Slack-specific username rules such as
  allowed characters, length limits, and no consecutive dots

### 📅 Date & Time

- `DateProbe` — extracts dates in various formats (e.g., YYYY-MM-DD, DD/MM/YYYY, 2nd Jan 2023)

- `TimeProbe` — extracts times (e.g., 14:30, 14:30:15, optional AM/PM)

- `DateTimeProbe` — extracts combined date and time in multiple common formats

### 🌐 Web & Network

- `DomainProbe` — extracts domain names, including internationalized (Unicode) domains

- `LinkProbe` — extracts hyperlinks, including ones with IP addresses, ports, or without a protocol

- `IPv4Probe` — extracts IPv4 addresses, supporting standard formats and excluding reserved/bogus ranges if necessary

- `IPv6Probe` — extracts IPv6 addresses, including compressed formats, IPv4-mapped addresses, and zone indexes (e.g.,
  %eth0)

- `MacAddressProbe` — extracts MAC addresses in standard formats using colons or hyphens (e.g., 00:1A:2B:3C:4D:5E or
  00-1A-2B-3C-4D-5E), accurately detecting valid addresses while excluding invalid patterns.

- `UserAgentProbe` — extracts User-Agent strings from text, supporting complex structures like multiple product tokens,
  OS information, and browser identifiers.

### 🗺 Geolocation

- `GeoCoordinatesProbe` — extracts geographic coordinates in various formats (decimal or degrees/minutes/seconds,
  N/S/E/W)

### 🏷 Social & Tags

- `HashtagProbe` — extracts hashtags from text (e.g., #example), supporting Unicode letters, numbers, and underscores,
  detecting hashtags in any position of the text.

### 🆔 UUID & Identifiers

- `UUIDProbe` — extracts any valid UUID (v1–v6) without checking the specific version. Supports standard UUID formats
  with hyphens.

- `UUIDv1Probe` — extracts UUID version 1, matching the format `xxxxxxxx-xxxx-1xxx-xxxx-xxxxxxxxxxxx`, commonly used for
  time-based identifiers.

- `UUIDv2Probe` — extracts UUID version 2, matching the format `xxxxxxxx-xxxx-2xxx-xxxx-xxxxxxxxxxxx`, typically used in
  DCE Security contexts.

- `UUIDv3Probe` — extracts UUID version 3, matching the format `xxxxxxxx-xxxx-3xxx-xxxx-xxxxxxxxxxxx`, generated using
  MD5 hashing of names and namespaces.

- `UUIDv4Probe` — extracts UUID version 4, matching the format `xxxxxxxx-xxxx-4xxx-xxxx-xxxxxxxxxxxx`, randomly
  generated and commonly used for unique identifiers.

- `UUIDv5Probe` — extracts UUID version 5, matching the format `xxxxxxxx-xxxx-5xxx-xxxx-xxxxxxxxxxxx`, generated using
  SHA-1 hashing of names and namespaces.

- `UUIDv6Probe` — extracts UUID version 6, matching the format `xxxxxxxx-xxxx-6xxx-xxxx-xxxxxxxxxxxx`, an ordered
  version for better indexing and sorting.

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
