<?php

use BitCraft\Core\Exceptions\ExceptApp;
use BitCraft\Core\Exceptions\ExceptModel;
use BitCraft\Core\Http\Middlewares\MdlFakeNow;
use BitCraft\Core\Http\Middlewares\MdlResponse;
use BitCraft\Core\Http\Middlewares\MdlTransaction;
use BitCraft\Core\Http\Responses\ResFailed;
use BitCraft\Core\Libraries\Stateful\Static\StfStaFactory;
use BitCraft\Core\Libraries\Stateful\Static\StfStaTransaction;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'mdl.transaction' => MdlTransaction::class,
            'mdl.response' => MdlResponse::class,
            'mdl.fake_now' => MdlFakeNow::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request): JsonResponse {

            // @note transaction rollback enable
            StfStaTransaction::enableRollback();

            $class = StfStaFactory::singleton(ResFailed::class);
            $class->setParams([
                'error_info' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ]);
            if ($e instanceof ExceptApp) {
                return $class->toResponse($request)
                    ->setStatusCode(422);
            }
            if ($e instanceof ExceptModel) {
                return $class->toResponse($request)
                    ->setStatusCode(404);
            }
            return $class->toResponse($request)
                ->setStatusCode(401);
        });
    })->create();
