<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
require_once "./Models/Usuario.php";



class UsuarioController extends Usuario{


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $mail = $param["mail"];
        $tipo = $param["tipo"];
        $clave = $param["clave"];
        
        

        $usuarioNuevo = new Usuario();
        $usuarioNuevo->mail = $mail;
        $usuarioNuevo->tipo = $tipo;
        $usuarioNuevo->clave = $clave;
        
        
        $usuarioNuevo->crearUsuario();

        $payload = json_encode(array("mensaje" => $tipo . " creado con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $usuario = Usuario::obtenerUsuario($id);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $usuarios = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $usuarios));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerTodosPorNombreCripto($request, $response, $args){
        $nombreCripto = $args["nombrecripto"];
        $usuarios = Usuario::obtenerUsuariosQueCompraronDerminadaCripto($nombreCripto);
        $payload = json_encode(array("listaUsuario" => $usuarios));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $id = $args["id"];
        $mail = $param["mail"];
        $tipo = $param["tipo"];
        $clave = $param["clave"];

        $usuarioModificado = new Usuario();
        $usuarioModificado->id = $id;
        $usuarioModificado->mail = $mail;
        $usuarioModificado->tipo = $tipo;
        $usuarioModificado->clave = $clave;
        

        $usuarioModificado->modificarUsuario();

        $payload = json_encode(array("mensaje" => "Usuario " . $id . " modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id = $args["id"];

        $usuarioABorrar = Usuario::obtenerUsuario($id);
        $usuarioABorrar->BorrarUsuario();

        $payload = json_encode(array("mensaje"=> "Usuario" . $id . " eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

}



?>