<?php

namespace App\Http\Controllers;

use App\Services\AppticaTopAppsService;
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

    public function getAppTopCategoryByDate(\Date $date)
    {
        return $this->topAppsService->getData(new \DateTime('now'));
    }
}
