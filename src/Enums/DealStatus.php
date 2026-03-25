<?php

declare(strict_types=1);

namespace ActiveCampaign\Enums;

enum DealStatus: int
{
    case Open = 0;
    case Won = 1;
    case Lost = 2;
}
