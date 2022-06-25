<?php

use GuzzleHttp\Psr7\Response;

//require_once "AutentificadorJWT.php";

class ValidadorParams
{
    public static function ValidarUsuarioUnico($request, $handler)
    {
        $params = $request->getParsedBody();
        $mail = $params["mail"];
        $response = new Response();

        if (Usuario::yaExisteMail($mail)){
            $response->getBody()->write("Ya existe ese usuario");
            return $response->withStatus(403);
        }
        
        
        
        $response = $handler->handle($request);

        return $response;

        
    }

    
}

?>