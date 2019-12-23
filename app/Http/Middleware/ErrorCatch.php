<?php

namespace App\Http\Middleware;

use App\Services\Error\ErrorService;
use Closure;

class ErrorCatch
{

    /**
     * @var ErrorService
     */
    private $errorService;

    /**
     * ErrorCatch constructor.
     * @param ErrorService $errorService
     */
    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!empty($response->exception)) {
            $response = $this->errorService->push($request);
        }

        return $response;
    }
}
