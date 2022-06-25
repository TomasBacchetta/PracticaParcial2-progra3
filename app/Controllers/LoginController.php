<?php

require_once "./Models/Usuario.php";


//use \App\Middleware\AutentificadorJWT as AutentificadorJWT;
use GuzzleHttp\Psr7\Stream;

class LoginController {

    public function VerificarUsuario($request, $response, $args){
        $parametros = $request->getParsedBody();

        $mail = $parametros['mail'];
        $tipo = $parametros['tipo'];
        $clave = $parametros['clave'];

        
        $existe = usuario::verificarUsuario($mail, $tipo, $clave);
        if ($existe){
            $usuario = Usuario::obtenerUsuarioPorMail($mail);
            $tokenNuevo = AutentificadorJWT::CrearToken(
            $tipo, 
            $usuario->id
          );


          $response->getBody()->write(json_encode(array("OK, " . $usuario->tipo . " Token:"=>$tokenNuevo)));

          return $response;
            
            
        }
        
        $response->getBody()->write("Datos erróneos");
        return $response->withStatus(403);
        
    }

    
}

?>