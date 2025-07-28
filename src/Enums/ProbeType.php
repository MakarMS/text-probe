<?php

namespace TextProbe\Enums;

enum ProbeType: int
{
    case EMAIL = 1;
    case PHONE = 2;
    case DOMAIN = 3;
    case LINK = 4;
}
