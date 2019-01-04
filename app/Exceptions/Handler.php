<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{

    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //Cualquier exception la manejamos aca enviandola a este metodo cd conver...
        if ($exception instanceof ValidationException){
            // Aqui validacion de las reglas de validacion 
          
            return $this->convertValidationExceptionToResponse($exception,$request);
        }

        if ($exception instanceof ModelNotFoundException){
          // Aqui cuando escriben algo que no corresponde no encontrado
            $model = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse('No existe ninguna instancia del '. $model .' especificado', 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception );
        }

          if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('No posee permiso para ejecutar esta accion', 403);
        }

         if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontro la URL especificada', 404);
        }
        // Excepcion del metodo no permitido para la url solicitada
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El metodo no es valida para la ruta especificada', 405);
        }
         if ($exception instanceof HttpException) {
    return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }


        if ($exception instanceof QueryException) {
            // nos muestra el contenido de la variable dd($exception);
            $codigo= $exception->errorInfo[1];
            if($codigo == 1451){

            return $this->errorResponse('El recurso a eliminar esta relacionado con otro, por lo que este no puede ser eliminado', 409);    
            }
        }
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }
        // Error con estado 500, error con algo malo en el servidor
        //Falla inesperada. Si estamos en modo desarrollo...
        if (config('app.debug')){
            return parent::render($request, $exception);
        }
         return $this->errorResponse('Falla inesperada, Intente Luego', 500);    
        

    }

  /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
       /* if ($this->isFrontend($request)) {
            return redirect()->guest('login');
        }*/

        return $this->errorResponse('No Autenticado',401);
    }


 /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
      protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

      /*  if ($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors,22) : 
            redirect()
            ->back()
            ->withInput($request->input())
            ->withErrors($errors);
        }
*/

        return $this->errorResponse($errors, 422);
    }

    private function isFrontend($request){

        return $request->acceptsHtml() && collect($request->route()->middleware())
                ->contains('web');

    }
}
