<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationStatisticResource;
use App\Interfaces\ExternalStatisticInterface;
use App\Jobs\ProcessStatisticsSave;
use App\Models\ApplicationStatistic;
use App\Services\AppticaTopAppsService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationStatisticController extends Controller
{
    private ExternalStatisticInterface $externalStatistic;

    public function __construct(AppticaTopAppsService $externalStatistic)
    {
        $this->externalStatistic = $externalStatistic;
    }


    /**
     * @throws RequestException
     */
    public function getAppTopByDate(string $date)
    {
        $date = new \DateTime($date);

        $applicationStatistics = ApplicationStatistic::whereActualDate($date)->get();

        if ($applicationStatistics->isEmpty()) {
            $applicationStatistics = $this->externalStatistic->getStatistic($date);
            ProcessStatisticsSave::dispatch($applicationStatistics);
        }

        return new JsonResponse([
            'selected_date' => $date->format('Y-m-d'),
            'statistic' => ApplicationStatisticResource::collection($applicationStatistics)
        ]);
    }
}
