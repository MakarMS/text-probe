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
}
