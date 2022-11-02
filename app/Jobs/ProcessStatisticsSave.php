<?php

namespace App\Jobs;

use App\Models\ApplicationStatistic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ProcessStatisticsSave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection|ApplicationStatistic[]
     */
    public $applicationStatisticCollection;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $applicationStatisticCollection)
    {
        $this->applicationStatisticCollection = $applicationStatisticCollection;
    }

    public function middleware()
    {
        return [new WithoutOverlapping($this->applicationStatisticCollection)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->applicationStatisticCollection->map(function (ApplicationStatistic $applicationStatistic) {
            $applicationStatistic->saveOrFail();
        });
    }
}
