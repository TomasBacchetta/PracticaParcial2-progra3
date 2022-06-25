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
require_once "./Models/Usuario.php";

class VentaCripto {
    public $id;
    public $criptomoneda_id;
    public $usuario_id;
    public $fecha;
    public $cantidad;
    public $total;
    public $foto;
    public $fecha_de_baja;
   

    public function crearVenta(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("INSERT INTO ventascripto (criptomoneda_id, usuario_id, fecha, cantidad, total, foto) 
        VALUES (:criptomoneda_id, :usuario_id, :fecha, :cantidad, :total, :foto)");
        $consulta->bindValue(':criptomoneda_id', $this->criptomoneda_id, PDO::PARAM_INT);
        $consulta->bindValue(':usuario_id', $this->usuario_id, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':total', $this->total, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
  
        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from ventascripto WHERE fecha_de_baja IS NULL");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'VentaCripto');
    }

    public static function obtenerPorNacionalidadEntreDosFechas($nacionalidad, $desde, $hasta){
        $objectoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objectoAccesoDatos->prepararConsulta(
            "SELECT ventascripto.id, criptomoneda_id, usuario_id, fecha, cantidad, total, ventascripto.foto, ventascripto.fecha_de_baja from ventascripto INNER JOIN criptomonedas ON 
            criptomonedas.nacionalidad = :nacionalidad && criptomonedas.id = ventascripto.criptomoneda_id 
            WHERE fecha BETWEEN :desde AND :hasta");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        $consulta->bindValue(':desde', $desde, PDO::PARAM_STR);
        $consulta->bindValue(':hasta', $hasta, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'VentaCripto');
    }

    public static function obtenerTodosEnPDF(){
        $ventas = self::obtenerTodos();
        $texto = "<h1>Listado de Ventas al " . date("d-m-y") .  "</h1> <br> 
        <table>
        <tr>
            <th>Id</th>
            <th>Cripto</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>";
        foreach($ventas as $eVenta){
            $texto .= "
            <tr>
                <th>". $eVenta->id . "</th>
                <th>". CriptoMoneda::obtenerCriptoMoneda($eVenta->criptomoneda_id)->nombre . "</th>
                <th>". Usuario::obtenerUsuario($eVenta->usuario_id)->mail . "</th>
                <th>". $eVenta->fecha . "</th>
                <th>". $eVenta->cantidad . "</th>
                <th>$". $eVenta->total . "</th>
                
            </tr>";

        }
        $texto .= "</table>";

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false, true);
       
        $pdf->addPage();
        
        $pdf->writeHTML($texto, true, false, true, false, '');

        
        ob_end_clean();

        return $pdf;

    }

    public static function obtenerVenta($id){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from ventascripto WHERE id = :id && fecha_de_baja IS NULL");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'VentaCripto');

        return $consulta->fetch();
    }

    public function GuardarFoto(){
        if (!file_exists('FotosCripto/')) {
            mkdir('FotosCripto/', 0777, true);
        }
        $destino = "FotosCripto/" . CriptoMoneda::obtenerCriptoMoneda($this->criptomoneda_id)->nombre . "-" . Usuario::obtenerUsuario($this->usuario_id)->mail . "-" . $this->fecha .  ".jpg";
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

        return $destino;
    }


   
}



?>