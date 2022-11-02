<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStatisticsSave;
use App\Models\ApplicationStatistic;
use App\Services\AppticaTopAppsService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class ApplicationStatisticController extends Controller
{
    /**
     * @var AppticaTopAppsService
     */
    private $topAppsService;

    public function __construct(AppticaTopAppsService $topAppsService)
    {
        $this->topAppsService = $topAppsService;
    }


    /**
     * @throws RequestException
     */
    public function getAppTopByDate(string $date)
    {
        $date = new \DateTime($date);

        $applicationStatistics = ApplicationStatistic::whereActualDate($date)->get();

        if ($applicationStatistics->isEmpty()) {
            $applicationStatistics = $this->topAppsService->getStatistic($date);
            ProcessStatisticsSave::dispatch($applicationStatistics);
        }
    }
}
