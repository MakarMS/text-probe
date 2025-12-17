# TextProbe

[![PHP Version Require](http://poser.pugx.org/makarms/text-probe/require/php)](https://packagist.org/packages/makarms/text-probe) [![Latest Stable Version](http://poser.pugx.org/makarms/text-probe/v)](https://packagist.org/packages/makarms/text-probe) [![PHP Tests](https://github.com/MakarMS/text-probe/actions/workflows/php-tests.yml/badge.svg?branch=main)](https://github.com/MakarMS/text-probe/actions/workflows/php-tests.yml) [![codecov](https://codecov.io/github/MakarMS/text-probe/graph/badge.svg?token=HFDSEGHGH4)](https://codecov.io/github/MakarMS/text-probe) [![License](http://poser.pugx.org/makarms/text-probe/license)](https://packagist.org/packages/makarms/text-probe)

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

- `DiscordNewUsernameProbe` — extracts Discord usernames in the new format (e.g., `@username`), enforcing Discord’s
  updated naming rules (length, characters, no consecutive dots).

- `DiscordOldUsernameProbe` — extracts classic Discord usernames in the format `username#1234`, ensuring proper
  structure and valid discriminator.

- `EmailProbe` — extracts email addresses.

- `RussianPassportNumberProbe` — extracts Russian internal passport numbers (series and six-digit number), supporting
  spaces or dashes between parts with basic structure validation.

- `PhoneProbe` — extracts phone numbers (supports various formats).

- `RussianInnProbe` — extracts Russian tax identification numbers (INN) for organizations (10 digits) and individuals (
  12 digits), validating checksums.

- `RussianSnilsProbe` — extracts Russian SNILS numbers (11 digits with checksum),
  supporting compact or dashed formats like `11223344595` or `112-233-445 95`.

- `SlackUsernameProbe` — extracts Slack usernames (e.g., `@username`), supporting Slack-specific username rules such as
  allowed characters, length limits, and no consecutive dots.

- `InstagramUsernameProbe` — extracts Instagram usernames (e.g., `@username`), allowing letters, digits, underscores,
  and dots while rejecting invalid boundaries or consecutive dots.

- `TelegramUserLinkProbe` — extracts `t.me` links pointing to Telegram users.

- `TelegramUsernameProbe` — extracts Telegram usernames (e.g., `@username`).

- `UsSocialSecurityNumberProbe` — extracts U.S. Social Security Numbers (SSN) in the `XXX-XX-XXXX` format while
  discarding structurally invalid area, group, or serial combinations.

### 📅 Date & Time

- `DateProbe` — extracts dates in various formats (e.g., `YYYY-MM-DD`, `DD/MM/YYYY`, `2nd Jan 2023`).

- `DateTimeProbe` — extracts combined date and time in multiple common formats.

- `TimeProbe` — extracts times (e.g., `14:30`, `14:30:15`, optional AM/PM).

### 💰 Finance

#### 🧾 Prices

- `PriceProbe` — extracts price expressions combining numeric amounts with currency symbols (e.g., `$199`, `1 500₽`) or
  ISO currency codes, including slash-separated pairs (e.g., `100 USD`, `99 EUR/UAH`). Supports spaces or commas as
  thousand separators and dots or commas for decimal fractions.

#### 🏢 Company Registration

- `RussianOgrnNumberProbe` — Extracts Russian OGRN numbers (13 digits) and validates the checksum.

#### 🏦 Bank Account

- `BankBicCodeProbe` — Extracts SWIFT/BIC codes (8–11 characters, e.g., `DEUTDEFF500`).

- `BankIbanNumberProbe` — Extracts IBAN numbers, supports spaces, validates using Mod-97.

- `BankRoutingNumberProbe` — Extracts US Routing Numbers (9 digits), validates the checksum.

#### 💳 Bank Cards

> Supported formats: plain digits (e.g., `4111111111111111`), digits separated by spaces (e.g., `4111 1111 1111 1111`)
> or
> dashes (e.g., `4111-1111-1111-1111`). Only Luhn-valid numbers by default.

- `BankCardNumberProbe` — extracts major card schemes like Visa, Mastercard, Amex, and all other supported schemes
  listed below.

- `BankAmexCardProbe` — American Express (prefixes: 34, 37), 15 digits.

- `BankDinersClubCardProbe` — Diners Club (prefixes: 30[0-5], 309, 36, 38, 39), 13–14 digits.

- `BankDiscoverCardProbe` — Discover (prefixes: 6011, 65, 644–649, 622126–622925), 16 digits.

- `BankJcbCardProbe` — JCB (prefixes: 3528–3589), 16 digits.

- `BankMaestroCardProbe` — Maestro (prefixes: 5018, 5020, 5038, 5612, 5893, 6304, 6759, 6761–6763), 16–19 digits.

- `BankMastercardCardProbe` — Mastercard (prefixes: 51–55, 2221–2720), 16 digits.

- `BankMirCardProbe` — MIR (prefixes: 2200–2204), 16 digits.

- `BankRupayCardProbe` — RuPay (prefixes: 508, 60, 65, 81, 82), 16 digits.

- `BankTroyCardProbe` — Troy (prefixes: 9792), 16 digits.

- `BankUnionpayCardProbe` — UnionPay (prefixes: 62), 16–19 digits.

- `BankVerveCardProbe` — Verve (prefixes: 5060, 5061, 6500–6509), 13–19 digits.

- `BankVisaCardProbe` — Visa (prefixes: 4), 13–19 digits.

#### 🔒 Card Security & Expiration

- `BankCardCvvCvcCodeProbe` — Extracts CVV/CVC codes (3–4 digits).

- `BankCardExpiryProbe` — Extracts card expiration dates (formats `MM/YY`, `MM/YYYY`, `MM-YY`, `MM-YYYY`, etc.).

#### 🔗 Crypto

- `BitcoinAddressProbe` — Extracts Bitcoin addresses (Base58 and Bech32 formats).

- `EthereumAddressProbe` — Extracts Ethereum addresses (0x-prefixed, 40 hex characters).

- `LitecoinAddressProbe` — Extracts Litecoin addresses (Base58 or Bech32).

- `RippleAddressProbe` — Extracts Ripple/XRP addresses (starts with 'r', Base58).

- `SolanaAddressProbe` — Extracts Solana addresses (Base58, 32–44 chars).

- `TronAddressProbe` — Extracts TRON addresses (Base58, starts with 'T', 34 chars).

- `UsdcAlgorandAddressProbe` — Extracts USDC addresses on Algorand (Base32, 58 chars).

- `UsdcErc20AddressProbe` — Extracts USDC ERC20 addresses (Ethereum-compatible, 0x-prefixed).

- `UsdcSolanaAddressProbe` — Extracts USDC addresses on Solana (same format as Solana addresses).

- `UsdtErc20AddressProbe` — Extracts USDT ERC20 addresses (Ethereum-compatible, 0x-prefixed).

- `UsdtOmniAddressProbe` — Extracts USDT Omni addresses (Bitcoin-based, starts with 1 or 3, 26–35 chars).

- `UsdtTrc20AddressProbe` — Extracts USDT TRC20 addresses (TRON-based, Base58, starts with 'T', 34 chars).

### 🗺 Geolocation

- `GeoCoordinatesProbe` — extracts geographic coordinates in various formats (`decimal` or `degrees/minutes/seconds`,
  `N/S/E/W`).

- `PostalCodeProbe` — extracts postal codes across multiple regions, including US ZIP (+4), Russian six-digit, UK,
  Canadian, and Dutch-style codes.

### 🏷 Social & Tags

- `HashtagProbe` — extracts hashtags from text (e.g., `#example`), supporting Unicode letters, numbers, and underscores,
  detecting hashtags in any position of the text.

### ✍️ Text

- `AllCapsSequenceProbe` — extracts sequences of two or more consecutive uppercase letters (Unicode-aware), making it
  easy to detect acronyms or emphasised ALL CAPS tokens in text.

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

- `CarVinProbe` — extracts vehicle identification numbers (VINs), enforcing allowed characters and validating the
  checksum digit.

### ⚙️ Versioning

- `SemanticVersionProbe` — extracts semantic version numbers in `MAJOR.MINOR.PATCH` format with optional pre-release
  identifiers and build metadata, ensuring numeric identifiers avoid leading zeros while supporting dot-separated
  alphanumeric segments.

### 🌐 Web & Network

- `DomainProbe` — extracts domain names, including internationalized (Unicode) domains.

- `IPv4Probe` — extracts IPv4 addresses, supporting standard formats and excluding reserved/bogus ranges if necessary.

- `PrivateIPv4Probe` — extracts private IPv4 addresses from the 10.0.0.0/8, 172.16.0.0/12, and 192.168.0.0/16 ranges.

- `IPv6Probe` — extracts IPv6 addresses, including compressed formats, IPv4-mapped addresses, and zone indexes (e.g.,
  `%eth0`).

- `LinkProbe` — extracts hyperlinks, including ones with IP addresses, ports, or without a protocol.

- `GithubRepositoryLinkProbe` — extracts GitHub repository links over HTTP/HTTPS, supporting optional `.git` suffixes,
  additional paths, and trimming trailing punctuation.

- `GoogleDocsLinkProbe` — extracts Google Docs, Sheets, Slides, and Forms links hosted on docs.google.com.

- `CookieProbe` — extracts HTTP cookie key/value pairs from `Set-Cookie` or `Cookie` headers, filtering out common
  attributes like `Path` or `Expires`.

- `MacAddressProbe` — extracts MAC addresses in standard formats using colons or hyphens (e.g., `00:1A:2B:3C:4D:5E` or
  `00-1A-2B-3C-4D-5E`), accurately detecting valid addresses while excluding invalid patterns.

- `JwtTokenProbe` — extracts JSON Web Tokens (JWT) in compact format (`xxxxx.yyyyy.zzzzz`), supporting Base64url
  segments
  with optional padding.

- `UserAgentProbe` — extracts User-Agent strings from text, supporting complex structures like multiple product tokens,
  OS information, and browser identifiers.

### 🐳 Docker

- `DockerImageProbe` — extracts Docker image names with tags only (e.g., `nginx:1.25.1`, `redis:latest`, `ghcr.io/app/api:
  v2`). Supports registries, multi-level namespaces, semantic and custom tags, while ignoring invalid or tagless image
  names (e.g., python, myapp/web).

- `DockerContainerIdProbe` — extracts Docker container IDs in short and full formats from logs and CLI output (e.g.,
  docker ps, docker logs, CI, orchestration traces). Detects lowercase hexadecimal IDs of 12 or 64 characters, ignoring
  strings of other lengths or with non-hex characters.

- `DockerLabelProbe` — extracts Docker label key/value pairs from Dockerfiles and CLI commands (e.g.,
  `LABEL version="1.0.0" description="API" vendor=acme`). Detects fragments in the form `key=value` and `key="value"`,
  including multiple labels in a single instruction, without fully parsing Dockerfile syntax.

- `DockerCliFlagProbe` — extracts Docker CLI flags from arbitrary text (e.g., `-p 8080:80`, `-v ./src:/app`,
  `--env KEY=VALUE`, `--name api`, `--rm`). Detects short and long options in both space and equals forms, with or
  without arguments, making it suitable for parsing docker run commands, CI scripts, and orchestration logs without
  full CLI parsing.

- `DockerfileInstructionProbe` — extracts Dockerfile instructions such as `FROM`, `RUN`, `COPY`, `ENV`, `HEALTHCHECK`,
  including multiline continuations with `\`. Matches instruction blocks regardless of indentation and supports
  case-insensitive detection of all core Dockerfile directives.

- `DockerImageDigestProbe` — extracts Docker image digests in the form `sha256:<64-hex>` from logs, Docker/registry
  output
  and SBOM metadata, including references like `image@sha256:<digest>`, while always returning only the digest value.

You can implement your own probes by creating classes that implement the `IProbe` interface.
Each probe also supports using a different validator for the returned values by passing an instance of a class
implementing the `IValidator` interface to the probe’s constructor. This allows you to override the default validation
logic.

For example, `BankCardNumberProbe` uses a default validator based on the Luhn algorithm, but you can provide your
own validator if you want to enforce additional rules, such as limiting to specific card issuers or formats.

## Usage Example

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
