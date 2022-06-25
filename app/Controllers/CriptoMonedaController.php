<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
require_once "./Models/CriptoMoneda.php";



class CriptoMonedaController extends CriptoMoneda{


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $precio = $param["precio"];
        $nombre = $param["nombre"];
        $nacionalidad = $param["nacionalidad"];
        
        

        $criptoNueva = new CriptoMoneda();
        $criptoNueva->precio = $precio;
        $criptoNueva->nombre = $nombre;
        $criptoNueva->foto = $criptoNueva->GuardarFoto();
        $criptoNueva->nacionalidad = $nacionalidad;
        
        
        $criptoNueva->crearCriptoMoneda();

        $payload = json_encode(array("mensaje" =>"Cripto " . $nombre . " creada con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $cripto = CriptoMoneda::obtenerCriptoMoneda($id);
        $payload = json_encode($cripto);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $criptos = CriptoMoneda::obtenerTodos();
        $payload = json_encode(array("listaCriptos" => $criptos));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerTodosDeUnaNacionalidad($request, $response, $args){
        $nacionalidad = $args["nacionalidad"];
        $criptos = CriptoMoneda::obtenerPorNacionalidad($nacionalidad);
        $payload = json_encode(array("listaCriptos" => $criptos));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $id = $args["id"];
        $precio = $param["precio"];
        $nombre = $param["nombre"];
        $nacionalidad = $param["nacionalidad"];

        
        $criptoModificada = new CriptoMoneda();
        $criptoModificada->id = $id;
        $criptoModificada->precio = $precio;
        $criptoModificada->nombre = $nombre;
        $destinoFotoAnterior = CriptoMoneda::obtenerCriptoMoneda($id)->foto;
        $criptoModificada->foto = $criptoModificada->ActualizarFoto($destinoFotoAnterior);
        $criptoModificada->nacionalidad = $nacionalidad;
        

        $criptoModificada->modificarCriptoMoneda();

        $payload = json_encode(array("mensaje" => "Cripto " . $id . " modificada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id = $args["id"];

        $criptoABorrar = CriptoMoneda::obtenerCriptoMoneda($id);
        $criptoABorrar->borrarCriptoMoneda();

        $payload = json_encode(array("mensaje"=> "Cripto " . $id . " eliminada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

}



?>