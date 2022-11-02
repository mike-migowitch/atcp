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

    public function getAppTopCategoryByDate(\DateTimeInterface $date)
    {
        $this->topAppsService->sendRequest(new \DateTime('now'));
    }
}
