<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ExternalStatisticInterface
{
    public function getStatistic(\DateTimeInterface $date): Collection;
}
