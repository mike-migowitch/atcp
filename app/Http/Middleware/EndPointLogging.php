<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class EndPointLogging
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::channel('request_statistic');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->logger->info("Request:");
        $this->logger->info($request);

        return $next($request);
    }

    /**
     * Handle an outgoing response.
     * @param Request $request
     * @param JsonResponse $response
     * @return void
     */
    public function terminate(Request $request, JsonResponse $response)
    {
        $this->logger->info("Response:");
        $this->logger->info($response);
    }
}
