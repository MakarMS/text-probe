<?php

namespace TextProbe\Enums;

enum ProbeType: int
{
    case EMAIL = 1;
    case PHONE = 2;
    case DOMAIN = 3;
    case LINK = 4;
    case TELEGRAM_USERNAME = 5;
    case TELEGRAM_USER_LINK = 6;
    case DISCORD_OLD_USERNAME = 7;
    case DISCORD_NEW_USERNAME = 8;
    case SLACK_USERNAME = 9;
    case IPV4 = 10;
    case IPV6 = 11;
    case MAC_ADDRESS = 12;
    case HASHTAG = 13;
    case UUID = 14;
    case UUID_V1 = 15;
    case UUID_V2 = 16;
    case UUID_V3 = 17;
    case UUID_V4 = 18;
    case UUID_V5 = 19;
    case UUID_V6 = 20;
    case GEO_COORDINATES = 21;
    case USER_AGENT = 22;
    case DATE = 23;
    case TIME = 24;
    case DATETIME = 25;
    case BANK_CARD_NUMBER = 26;
    case BANK_VISA_CARD_NUMBER = 27;
    case BANK_MASTERCARD_CARD_NUMBER = 28;
    case BANK_AMEX_CARD_NUMBER = 29;
    case BANK_DISCOVER_CARD_NUMBER = 30;
    case BANK_DINERS_CLUB_CARD_NUMBER = 31;
    case BANK_JBC_CARD_NUMBER = 32;
    case BANK_UNIONPAY_CARD_NUMBER = 33;
    case BANK_MAESTRO_CARD_NUMBER = 34;
    case BANK_MIR_CARD_NUMBER = 35;
    case BANK_RUPAY_CARD_NUMBER = 36;
    case BANK_TROY_CARD_NUMBER = 37;
    case BANK_VERVE_CARD_NUMBER = 38;
    case BANK_IBAN_NUMBER = 39;
    case BANK_BIC_CODE = 40;
    case BANK_ROUTING_NUMBER = 41;
    case BANK_CARD_EXPIRY_DATE = 42;
    case BANK_CARD_CVV_CVC_CODE = 43;
}
