<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
require_once "./Models/VentaCripto.php";



class VentaCriptoController extends VentaCripto{


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $criptomoneda_id = $param["criptomoneda_id"];
        $usuario_id = AutentificadorJWT::ObtenerId($token);
        $fecha = date("y-m-d");
        $cantidad = $param["cantidad"];
        $cripto = CriptoMoneda::obtenerCriptoMoneda($criptomoneda_id);
        $total = $cantidad * $cripto->precio;
       
        $ventaNueva = new VentaCripto();
        $ventaNueva->criptomoneda_id = $criptomoneda_id;
        $ventaNueva->usuario_id = $usuario_id;
        $ventaNueva->fecha = $fecha;
        $ventaNueva->cantidad = $cantidad;
        $ventaNueva->cripto = $cripto;
        $ventaNueva->total = $total;
        $ventaNueva->foto = $ventaNueva->GuardarFoto();
        
        $ventaNueva->crearVenta();

        $payload = json_encode(array("mensaje" => "Venta de " . $cripto->nombre . " registrada con exito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $usuario = VentaCripto::obtenerVenta($id);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $usuarios = VentaCripto::obtenerTodos();
        $payload = json_encode(array("listaVentas" => $usuarios));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerVentasPorNacionalidadEntreDosFechas($request, $response, $args){
        $params = $request->getQueryParams();

        $nacionalidad = $params["nacionalidad"];
        $desde = $params["desde"] . " 00:00:00";
        $hasta = $params["hasta"] . " 00:00:00";
        $ventas = VentaCripto::obtenerPorNacionalidadEntreDosFechas($nacionalidad, $desde, $hasta);

        $payload = json_encode(array("listaVentas" => $ventas));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }

    public function TraerTodosPDF($request, $response, $args){
        VentaCripto::obtenerTodosEnPDF()->Output(date("d-m-y") .'.pdf', 'I');
        return $response->withHeader("Content-Type", "application/pdf");

    }

    
    
    

}



?>