<?php

declare(strict_types=1);

namespace ActiveCampaign\Enums;

enum Sentiment: string
{
    case Positive = 'POSITIVE';
    case Negative = 'NEGATIVE';
    case Neutral = 'NEUTRAL';
    case None = 'NONE';
}
