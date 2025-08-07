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
}
