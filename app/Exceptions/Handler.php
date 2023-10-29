<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => false,
                'mensaje' => __("La ruta no existe"),
                'errors' => $e->getMessage(),
            ], 404);
            //
        });
        $this->renderable(function(\Spatie\Permission\Exceptions\UnauthorizedException $e, $request){
            return response()->json([
                "mensaje"=>"No tienes permiso para ver el contenido de esta página",
                "status"=>false,
                "tienePermiso"=>false
            ],403);
        });
    }

    public function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'mensaje' => __("Los datos proporcionados no son validos"),
            'errors' => $exception->errors(),
        ], $exception->status);
    }
}
