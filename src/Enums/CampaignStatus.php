<?php

declare(strict_types=1);

namespace ActiveCampaign\Enums;

enum CampaignStatus: int
{
    case Draft = 0;
    case Scheduled = 1;
    case Sending = 3;
    case Paused = 4;
    case Sent = 5;
    case Disabled = 6;
}
