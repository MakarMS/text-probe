<details open>
<summary><strong>Probe Index</strong></summary>

- [Extensibility](#extensibility)
- [Contact & Identity](#contact--identity)
  - [Vehicle](#-vehicle)
  - [Passports (MRZ)](#-passports-mrz)
  - [Tax Numbers](#-tax-numbers)
  - [Medical Policy](#-medical-policy)
  - [Driver Licenses](#-driver-licenses)
  - [Company Registration](#-company-registration)
- [Security & Auth](#-security--auth)
- [Date & Time](#-date--time)
- [Finance](#-finance)
  - [Currency](#-currency)
  - [Crypto Transaction IDs](#-crypto-transaction-ids)
  - [Invoices & Payment References](#-invoices--payment-references)
  - [VAT Numbers](#-vat-numbers)
  - [SWIFT References](#-swift-references)
  - [PayPal](#-paypal)
  - [Stripe Object IDs](#-stripe-object-ids)
  - [Prices](#-prices)
  - [Bank Account](#-bank-account)
  - [Bank Cards](#-bank-cards)
  - [Card Security & Expiration](#-card-security--expiration)
  - [Crypto](#-crypto)
- [Logistics](#-logistics)
  - [Tracking Numbers](#-tracking-numbers)
- [Barcodes](#-barcodes)
- [Geolocation](#-geolocation)
- [Social & Tags](#-social--tags)
- [Text](#-text)
- [UUID & Identifiers](#-uuid--identifiers)
- [Versioning](#-versioning)
- [Web & Network](#-web--network)
- [System & DevOps](#-system--devops)
- [Docker](#-docker)

</details>

### 🔌 Extensibility

TextProbe is designed to be extensible. You can implement your own probes by creating classes that implement the `IProbe` interface. Each probe also supports custom validation by passing an `IValidator` instance to the probe's constructor.

Built-in probes ship with sensible default validators, but these can be replaced to enforce stricter or domain-specific rules. For example, `BankCardNumberProbe` uses a Luhn-based validator by default which you can override to restrict allowed card issuers or formats.

### 🧑‍💻 Contact & Identity

- `DiscordNewUsernameProbe` — extracts Discord usernames in the new format (e.g., `@username`), enforcing Discord’s
  updated naming rules (length, characters, no consecutive dots).

- `DiscordOldUsernameProbe` — extracts classic Discord usernames in the format `username#1234`, ensuring proper
  structure and valid discriminator.

- `EmailProbe` — extracts email addresses.

- `RussianPassportNumberProbe` — extracts Russian internal passport numbers (series and six-digit number), supporting
  spaces or dashes between parts with basic structure validation.

- `PhoneProbe` — extracts phone numbers (supports various formats).

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

#### 🚗 Vehicle

- `CarVinProbe` — extracts vehicle identification numbers (VINs), enforcing allowed characters and validating the
  checksum digit.

#### 🛂 Passports (MRZ)

- `MrzTd1Probe` — extracts MRZ TD1 blocks (3 lines × 30 chars).

- `MrzTd2Probe` — extracts MRZ TD2 blocks (2 lines × 36 chars).

- `MrzTd3Probe` — extracts MRZ TD3 blocks (2 lines × 44 chars).

- `InternationalPassportProbe` — extracts MRZ passport blocks across TD1/TD2/TD3 formats.

#### 🧾 Tax Numbers

- `DeSteuerIdProbe` — extracts German Steuer-ID numbers.

- `DeSteuernummerProbe` — extracts German Steuernummer identifiers.

- `FrNumeroFiscalReferenceProbe` — extracts French numero fiscal reference numbers.

- `ItCodiceFiscaleProbe` — extracts Italian Codice Fiscale identifiers.

- `EsNifProbe` — extracts Spanish NIF identifiers.

- `NlBsnProbe` — extracts Dutch BSN numbers.

- `PlPeselProbe` — extracts Polish PESEL numbers.

- `PlNipProbe` — extracts Polish NIP numbers.

- `SePersonnummerProbe` — extracts Swedish personnummer identifiers.

- `NoFoedselsnummerProbe` — extracts Norwegian fødselsnummer identifiers.

- `ChAhvNummerProbe` — extracts Swiss AHV numbers.

- `GbUtrProbe` — extracts UK Unique Taxpayer Reference (UTR) numbers.

- `RuInnProbe` — extracts Russian tax identification numbers (INN).

- `UsEinProbe` — extracts US EIN numbers.

- `TaxNumberProbe` — extracts tax numbers across supported regions.

#### 🏥 Medical Policy

- `DeKrankenversichertennummerProbe` — extracts German Krankenversichertennummer numbers.

- `FrNirProbe` — extracts French NIR numbers.

- `ItTesseraSanitariaProbe` — extracts Italian tessera sanitaria identifiers.

- `EsSipNumberProbe` — extracts Spanish SIP numbers.

- `NlBsnMedicalProbe` — extracts Dutch BSN medical identifiers.

- `PlPeselMedicalProbe` — extracts Polish PESEL medical identifiers.

- `SePersonnummerMedicalProbe` — extracts Swedish personnummer medical identifiers.

- `NoFoedselsnummerMedicalProbe` — extracts Norwegian fødselsnummer medical identifiers.

- `ChAhvMedicalProbe` — extracts Swiss AHV medical identifiers.

- `GbNhsNumberProbe` — extracts UK NHS numbers.

- `RuOmsEnp16Probe` — extracts Russian OMS ENP16 numbers.

- `UsMemberIdProbe` — extracts US member identifiers.

- `MedicalPolicyNumberProbe` — extracts medical policy numbers across supported regions.

#### 🪪 Driver Licenses

- `UkDrivingLicenceNumberProbe` — extracts UK driving licence numbers.

- `DeFuehrerscheinnummerProbe` — extracts German driving licence numbers.

- `FrNumeroPermisDeConduireProbe` — extracts French driving licence numbers.

- `ItNumeroPatenteProbe` — extracts Italian driving licence numbers.

- `EsNumeroPermisoConducirProbe` — extracts Spanish driving licence numbers.

- `NlRijbewijsNummerProbe` — extracts Dutch driving licence numbers.

- `PlNumerPrawaJazdyProbe` — extracts Polish driving licence numbers.

- `SeKoerkortsnummerProbe` — extracts Swedish driving licence numbers.

- `NoFoererkortnummerProbe` — extracts Norwegian driving licence numbers.

- `ChFuehrerausweisNummerProbe` — extracts Swiss driving licence numbers.

- `RuVoditelskoeUdostoverenieProbe` — extracts Russian driving licence numbers.

- `UsDriverLicenseNumberProbe` — extracts US driving licence numbers.

- `DriverLicenseProbe` — extracts driver licence numbers across supported regions.

#### 🏢 Company Registration

- `DeHandelsregisternummerProbe` — extracts German Handelsregister numbers.

- `FrSirenProbe` — extracts French SIREN numbers.

- `FrSiretProbe` — extracts French SIRET numbers.

- `ItCodiceReaProbe` — extracts Italian codice REA numbers.

- `EsCifProbe` — extracts Spanish CIF numbers.

- `NlKvKNummerProbe` — extracts Dutch KvK numbers.

- `PlKrsProbe` — extracts Polish KRS numbers.

- `SeOrganisationsnummerProbe` — extracts Swedish organisation numbers.

- `NoOrganisasjonsnummerProbe` — extracts Norwegian organisation numbers.

- `ChUidiProbe` — extracts Swiss UIDI numbers.

- `UkCompanyNumberProbe` — extracts UK company registration numbers.

- `RuOgrnProbe` — extracts Russian OGRN numbers.

- `UsCompanyRegistrationNumberProbe` — extracts US company registration numbers.

- `CompanyRegistrationNumberProbe` — extracts company registration numbers across supported regions.

### 🔐 Security & Auth

- `ApiKeyProbe` — extracts API keys from common provider prefixes (Stripe, GitHub, Google, AWS).

- `StripeSecretKeyProbe` — extracts Stripe secret keys (e.g., `sk_live_...`).

- `StripePublishableKeyProbe` — extracts Stripe publishable keys (e.g., `pk_test_...`).

- `GitHubClassicTokenProbe` — extracts GitHub classic personal access tokens (`ghp_...`).

- `GitHubFineGrainedTokenProbe` — extracts GitHub fine-grained personal access tokens (`github_pat_...`).

- `GoogleApiKeyProbe` — extracts Google API keys starting with `AIza`.

- `AwsAccessKeyIdProbe` — extracts AWS access key IDs (`AKIA`/`ASIA` + 16 chars).

- `BearerTokenProbe` — extracts bearer token strings (JWT or opaque).

- `OpaqueTokenProbe` — extracts opaque token strings (base64url-ish).

- `BasicAuthProbe` — extracts HTTP Basic auth base64 blobs.

- `BasicAuthBase64Probe` — extracts base64 blobs suitable for Basic auth.

- `OAuthAccessTokenProbe` — extracts OAuth access tokens in JWT or opaque form.

- `OAuthAccessTokenJwtProbe` — extracts OAuth access tokens in JWT form.

- `OAuthAccessTokenOpaqueProbe` — extracts opaque OAuth access tokens.

- `OAuthRefreshTokenProbe` — extracts OAuth refresh tokens in JWT or opaque form.

- `OAuthRefreshTokenJwtProbe` — extracts OAuth refresh tokens in JWT form.

- `OAuthRefreshTokenOpaqueProbe` — extracts opaque OAuth refresh tokens.

- `CsrfTokenProbe` — extracts CSRF tokens in hex, base64url, or UUID form.

- `CsrfTokenHexProbe` — extracts 32–128 character hexadecimal CSRF tokens.

- `CsrfTokenBase64UrlProbe` — extracts base64url-style CSRF tokens.

- `CsrfTokenUuidProbe` — extracts UUID-shaped CSRF tokens.

- `PasswordHashProbe` — extracts bcrypt and Argon2 password hashes.

- `BcryptHashProbe` — extracts bcrypt hashes with supported cost factors.

- `Argon2idHashProbe` — extracts Argon2id hashes with non-zero parameters.

- `Argon2iHashProbe` — extracts Argon2i hashes with non-zero parameters.

- `PrivateKeyProbe` — extracts PEM/OpenSSH private key blocks.

- `PemRsaPrivateKeyProbe` — extracts PEM-encoded RSA private key blocks.

- `PemPkcs8PrivateKeyProbe` — extracts PEM-encoded PKCS#8 private key blocks.

- `OpenSshPrivateKeyProbe` — extracts OpenSSH private key blocks.

- `PublicKeyProbe` — extracts PEM public keys and certificates.

- `PemPublicKeyProbe` — extracts PEM public key blocks.

- `PemCertificateProbe` — extracts PEM certificate blocks.

- `SshPublicKeyProbe` — extracts OpenSSH public key lines.

- `SshRsaPublicKeyProbe` — extracts ssh-rsa public keys.

- `SshEd25519PublicKeyProbe` — extracts ssh-ed25519 public keys.

- `SshEcdsaPublicKeyProbe` — extracts ECDSA OpenSSH public keys.

### 📅 Date & Time

- `DateProbe` — extracts dates in various formats (e.g., `YYYY-MM-DD`, `DD/MM/YYYY`, `2nd Jan 2023`).

- `DateTimeProbe` — extracts combined date and time in multiple common formats.

- `TimeProbe` — extracts times (e.g., `14:30`, `14:30:15`, optional AM/PM).

### 💰 Finance

#### 💱 Currency

- `CurrencyCodeProbe` — extracts ISO-4217 currency codes (e.g., `USD`, `EUR`) using a whitelist validator.

#### 🔗 Crypto transaction IDs

- `BitcoinTxIdProbe` — extracts Bitcoin transaction IDs (64 hex characters).

- `EthereumTxHashProbe` — extracts Ethereum transaction hashes (`0x` + 64 hex characters).

- `LitecoinTxIdProbe` — extracts Litecoin transaction IDs (64 hex characters).

- `RippleTxIdProbe` — extracts Ripple transaction IDs (64 uppercase hex characters).

- `SolanaTxSignatureProbe` — extracts Solana transaction signatures (87–88 base58 characters).

- `TronTxIdProbe` — extracts Tron transaction IDs (64 hex characters).

- `UsdcAlgorandTxIdProbe` — extracts USDC Algorand transaction IDs (52 base32 characters).

- `UsdcErc20TxHashProbe` — extracts USDC ERC-20 transaction hashes (`0x` + 64 hex characters).

- `UsdcSolanaTxSignatureProbe` — extracts USDC Solana transaction signatures (87–88 base58 characters).

- `UsdtErc20TxHashProbe` — extracts USDT ERC-20 transaction hashes (`0x` + 64 hex characters).

- `UsdtOmniTxIdProbe` — extracts USDT Omni transaction IDs (64 hex characters).

- `UsdtTrc20TxIdProbe` — extracts USDT TRC-20 transaction IDs (64 hex characters).

- `CryptoTransactionIdProbe` — extracts transaction IDs across supported crypto networks.

#### 🧾 Invoices & payment references

- `InvoiceNumericIdProbe` — extracts numeric invoice identifiers (6+ digits).

- `InvoiceAlnumIdProbe` — extracts alphanumeric invoice identifiers (uppercase letters, digits, `-` and `/`).

- `InvoiceNumberProbe` — extracts invoice identifiers in numeric or alphanumeric form.

- `SepaRfReferenceProbe` — extracts SEPA RF references and validates Mod-97 checksums.

- `PaymentReferenceProbe` — extracts SEPA RF references or invoice identifiers.

#### 🏛 VAT numbers

- `AtUidProbe` — extracts Austria VAT numbers (`ATU########`).

- `BeVatNumberProbe` — extracts Belgium VAT numbers (`BE0#########`).

- `BgVatNumberProbe` — extracts Bulgaria VAT numbers (`BG#########` or `BG##########`).

- `CyVatNumberProbe` — extracts Cyprus VAT numbers (`CY########X`).

- `CzDicProbe` — extracts Czech VAT numbers (`CZ########`–`CZ##########`).

- `DeUstIdNrProbe` — extracts Germany VAT numbers (`DE#########`).

- `DkCvrProbe` — extracts Denmark VAT numbers (`DK########`).

- `EeKmkrProbe` — extracts Estonia VAT numbers (`EE#########`).

- `EsNifIvaProbe` — extracts Spain VAT numbers (`ES#########`).

- `FiAlvNumeroProbe` — extracts Finland VAT numbers (`FI########`).

- `FrNumeroTvaIntracommunautaireProbe` — extracts France VAT numbers (`FR**#########`).

- `GrAfmVatProbe` — extracts Greece VAT numbers (`EL#########`).

- `HrOibVatProbe` — extracts Croatia VAT numbers (`HR###########`).

- `HuAdoazonositoJelVatProbe` — extracts Hungary VAT numbers (`HU########`).

- `IeVatNumberProbe` — extracts Ireland VAT numbers (legacy and new formats).

- `ItPartitaIvaProbe` — extracts Italy VAT numbers (`IT###########`).

- `LtPvmMoketojoKodasProbe` — extracts Lithuania VAT numbers (`LT#########` or `LT############`).

- `LuNumeroTvaProbe` — extracts Luxembourg VAT numbers (`LU########`).

- `LvPvnRegNrProbe` — extracts Latvia VAT numbers (`LV###########`).

- `MtVatNumberProbe` — extracts Malta VAT numbers (`MT########`).

- `NlBtwNummerProbe` — extracts Netherlands VAT numbers (`NL#########B##`).

- `PlNipVatProbe` — extracts Poland VAT numbers (`PL##########`).

- `PtNifIvaProbe` — extracts Portugal VAT numbers (`PT#########`).

- `RoCuiVatProbe` — extracts Romania VAT numbers (`RO##`–`RO##########`).

- `SeVatNummerProbe` — extracts Sweden VAT numbers (`SE##########01`).

- `SiDavcnaStevilkaVatProbe` — extracts Slovenia VAT numbers (`SI########`).

- `SkDicVatProbe` — extracts Slovakia VAT numbers (`SK##########`).

- `GbVatNumberProbe` — extracts Great Britain VAT numbers (`GB#########`).

- `XiVatNumberProbe` — extracts Northern Ireland VAT numbers (`XI#########`).

- `ChUidMwstProbe` — extracts Switzerland VAT numbers (`CHE#########MWST|TVA|IVA`).

- `NoOrgnrMvaProbe` — extracts Norway VAT numbers (`NO#########MVA`).

- `VatNumberProbe` — extracts VAT numbers across supported regions.

#### 🏦 SWIFT references

- `UetrProbe` — extracts SWIFT UETR identifiers (UUID-like with constrained version/variant).

- `SwiftField20ReferenceProbe` — extracts SWIFT field 20 references (6–16 chars: A–Z, 0–9, `/` or `-`).

- `SwiftReferenceProbe` — extracts SWIFT references (UETR or field 20 reference).

#### 💸 PayPal

- `PaypalTransactionIdProbe` — extracts PayPal transaction IDs (17 uppercase alphanumeric characters).

#### 💳 Stripe object IDs

- `StripePaymentIntentIdProbe` — extracts Stripe payment intent IDs (`pi_...`).

- `StripeChargeIdProbe` — extracts Stripe charge IDs (`ch_...`).

- `StripeCustomerIdProbe` — extracts Stripe customer IDs (`cus_...`).

- `StripeInvoiceIdProbe` — extracts Stripe invoice IDs (`in_...`).

- `StripeSubscriptionIdProbe` — extracts Stripe subscription IDs (`sub_...`).

- `StripePaymentMethodIdProbe` — extracts Stripe payment method IDs (`pm_...`).

- `StripeEventIdProbe` — extracts Stripe event IDs (`evt_...`).

- `StripeObjectIdProbe` — extracts Stripe object IDs across supported types.

#### 🧾 Prices

- `PriceProbe` — extracts price expressions combining numeric amounts with currency symbols (e.g., `$199`, `1 500₽`) or
  ISO currency codes, including slash-separated pairs (e.g., `100 USD`, `99 EUR/UAH`). Supports spaces or commas as
  thousand separators and dots or commas for decimal fractions.

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

### 📦 Logistics

#### 📦 Tracking numbers

- `Ups1ZTrackingProbe` — extracts UPS 1Z tracking numbers.

- `Fedex12Probe` — extracts FedEx 12-digit tracking numbers.

- `Fedex15Probe` — extracts FedEx 15-digit tracking numbers.

- `Fedex20Probe` — extracts FedEx 20-digit tracking numbers.

- `UspsNumeric20Probe` — extracts USPS 20-digit tracking numbers.

- `UspsNumeric22Probe` — extracts USPS 22-digit tracking numbers.

- `UspsIntlS10Probe` — extracts USPS S10-format tracking numbers.

- `DhlExpress10Probe` — extracts DHL Express 10-digit tracking numbers.

- `DpdTrackingProbe` — extracts DPD 14-digit tracking numbers.

- `GlsTrackingProbe` — extracts GLS tracking numbers (11–14 digits).

- `HermesEvriTrackingProbe` — extracts Hermes/Evri tracking numbers.

- `RoyalMailS10Probe` — extracts Royal Mail S10 tracking numbers.

- `LaPosteColissimoS10Probe` — extracts La Poste/Colissimo S10 tracking numbers.

- `CorreosS10Probe` — extracts Correos S10 tracking numbers.

- `PostnlTrackingProbe` — extracts PostNL tracking numbers.

- `BpostS10Probe` — extracts bpost S10 tracking numbers.

- `DeutschePostS10Probe` — extracts Deutsche Post S10 tracking numbers.

- `SwissPostS10Probe` — extracts Swiss Post S10 tracking numbers.

- `PosteItalianeS10Probe` — extracts Poste Italiane S10 tracking numbers.

- `PocztaPolskaS10Probe` — extracts Poczta Polska S10 tracking numbers.

- `PostNordS10Probe` — extracts PostNord S10 tracking numbers.

- `RussiaPostS10Probe` — extracts Russia Post S10 tracking numbers.

- `TrackingNumberProbe` — extracts tracking numbers across supported carriers.

### 🏷 Barcodes

- `Ean13Probe` — extracts EAN-13 barcodes.

- `UpcAProbe` — extracts UPC-A barcodes.

- `BarcodeValueProbe` — extracts barcode values across supported formats.

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

- `HexHashProbe` — extracts common hexadecimal hash strings such as MD5, SHA-1,
  SHA-224, SHA-256, SHA-384, and SHA-512, matching 32–128 hex characters while
  avoiding partial matches inside longer strings.

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

### ⚙️ Versioning

- `SemanticVersionProbe` — extracts semantic version numbers in `MAJOR.MINOR.PATCH` format with optional pre-release
  identifiers and build metadata, ensuring numeric identifiers avoid leading zeros while supporting dot-separated
  alphanumeric segments.

- `ComposerConstraintProbe` — extracts Composer constraint strings with operators, ranges, and wildcard segments.

- `SemverRangeProbe` — extracts semantic version ranges, including Composer-style constraints.

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

- `HtmlTagProbe` — extracts HTML tags, returning full paired segments with their content or standalone/self-closing
  tags.

- `HexColorProbe` — extracts CSS-style hexadecimal color codes (`#fff`, `#ffffff`), ensuring only 3- or 6-digit values
  are matched while ignoring longer hexadecimal tokens.

- `RgbRgbaColorProbe` — extracts RGB/RGBA color strings (e.g., `rgb(255,0,0)`, `rgba(255,0,0,0.5)`, `255,0,0`).

- `MacAddressProbe` — extracts MAC addresses in standard formats using colons or hyphens (e.g., `00:1A:2B:3C:4D:5E` or
  `00-1A-2B-3C-4D-5E`), accurately detecting valid addresses while excluding invalid patterns.

- `JwtTokenProbe` — extracts JSON Web Tokens (JWT) in compact format (`xxxxx.yyyyy.zzzzz`), supporting Base64url
  segments
  with optional padding.

- `UserAgentProbe` — extracts User-Agent strings from text, supporting complex structures like multiple product tokens,
  OS information, and browser identifiers.

- `FilePathProbe` — extracts absolute file paths in Linux (e.g., `/etc/passwd`) and Windows (e.g.,
  `C:\\Windows\\System32`)
  formats.

- `HttpStatusLineProbe` — extracts HTTP status lines like `HTTP/1.1 200` with valid status ranges.

- `HttpStatusCodeProbe` — extracts HTTP status codes from status lines or standalone numeric codes.

- `AbsoluteHttpUrlProbe` — extracts absolute HTTP/HTTPS URLs with optional ports and paths.

- `AbsolutePathProbe` — extracts absolute paths that start with `/`.

- `RestEndpointProbe` — extracts REST endpoints from absolute URLs or absolute paths.

- `QueryParamPairProbe` — extracts query parameter key/value pairs.

- `QueryStringProbe` — extracts full query strings starting with `?` and containing key/value pairs.

- `QueryParameterProbe` — extracts query parameters or query strings.

- `JsonQuotedKeyProbe` — extracts quoted JSON keys (e.g., `"name"`).

- `JsonKeyProbe` — extracts unquoted JSON-like keys (e.g., `name`).

- `JsonStringValueProbe` — extracts JSON string values.

- `JsonNumberValueProbe` — extracts JSON numeric values.

- `JsonBooleanValueProbe` — extracts JSON boolean values.

- `JsonNullValueProbe` — extracts JSON null values.

- `JsonValueProbe` — extracts JSON primitive values (string, number, boolean, null).

- `GraphqlOperationKeywordProbe` — extracts GraphQL operation keywords (`query`, `mutation`, `subscription`).

- `GraphqlSelectionSetProbe` — extracts GraphQL selection sets with balanced braces.

- `GraphqlQueryProbe` — extracts GraphQL query components (operation keywords or selection sets).

- `WsUrlProbe` — extracts `ws://` WebSocket URLs.

- `WssUrlProbe` — extracts `wss://` WebSocket URLs.

- `WebsocketUrlProbe` — extracts WebSocket URLs across `ws://` and `wss://` schemes.

- `CorsAllowOriginProbe` — extracts `Access-Control-Allow-Origin` headers.

- `CorsAllowMethodsProbe` — extracts `Access-Control-Allow-Methods` headers.

- `CorsAllowHeadersProbe` — extracts `Access-Control-Allow-Headers` headers.

- `CorsAllowCredentialsProbe` — extracts `Access-Control-Allow-Credentials` headers.

- `CorsExposeHeadersProbe` — extracts `Access-Control-Expose-Headers` headers.

- `CorsMaxAgeProbe` — extracts `Access-Control-Max-Age` headers.

- `CorsHeaderProbe` — extracts CORS headers across supported variants.

### ⚙️ System & DevOps

- `K8sDnsLabelProbe` — extracts Kubernetes DNS labels (RFC1123 label format).

- `K8sDnsSubdomainProbe` — extracts Kubernetes DNS subdomains (RFC1123 subdomain format).

- `KubernetesResourceNameProbe` — extracts Kubernetes resource names.

- `KubernetesNamespaceStrictProbe` — extracts Kubernetes namespaces using DNS label rules.

- `KubernetesNamespaceProbe` — extracts Kubernetes namespaces using DNS subdomain rules.

- `HelmSemverProbe` — extracts Helm semantic versions.

- `HelmChartVersionProbe` — extracts Helm chart versions.

- `EnvAssignmentProbe` — extracts environment variable assignments like `KEY=value`.

- `EnvVariableProbe` — extracts environment variable names.

- `GithubActionsRunIdUrlProbe` — extracts GitHub Actions run URLs.

- `GitlabPipelineIdUrlProbe` — extracts GitLab pipeline URLs.

- `CircleciWorkflowUuidProbe` — extracts CircleCI workflow UUIDs.

- `CiPipelineIdProbe` — extracts CI pipeline IDs.

- `GitFullShaProbe` — extracts 40-character Git commit SHAs.

- `GitShortShaProbe` — extracts short Git commit SHAs.

- `GitCommitHashProbe` — extracts Git commit hashes (short or full).

- `GitRefHeadsProbe` — extracts `refs/heads/*` Git references.

- `GitBranchNameProbe` — extracts Git branch names.

- `GitRefTagsProbe` — extracts `refs/tags/*` Git references.

- `GitTagProbe` — extracts Git tag names.

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