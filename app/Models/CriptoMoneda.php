<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
class CriptoMoneda {
    public $id;
    public $precio;
    public $nombre;
    public $foto;
    public $nacionalidad;
    public $fecha_de_baja;
   

    public function crearCriptoMoneda(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("INSERT INTO criptomonedas (precio, nombre, foto, nacionalidad) VALUES (:precio, :nombre, :foto, :nacionalidad)");
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
  
        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from criptomonedas WHERE fecha_de_baja IS NULL");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'CriptoMoneda');
    }

    public static function obtenerPorNacionalidad($nacionalidad){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from criptomonedas WHERE fecha_de_baja IS NULL && nacionalidad = :nacionalidad");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'CriptoMoneda');
    }

    public static function obtenerCriptoMoneda($id){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from criptomonedas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'CriptoMoneda');

        return $consulta->fetch();
    }

    public function modificarCriptoMoneda(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE criptomonedas SET precio = :precio, nombre = :nombre, foto = :foto , nacionalidad = :nacionalidad WHERE id = :id");
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute(); 

    }
    
    public function borrarCriptoMoneda(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE criptomonedas SET fecha_de_baja = :fecha_de_baja WHERE id = :id");
        $consulta->bindValue(':fecha_de_baja',date("y-m-d") , PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);

        $consulta->execute();

    }

    public static function verificarCriptoMoneda($id){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        
        return $consulta->execute();

        
    }

    public function GuardarFoto(){
        if (!file_exists('FotosMonedas/')) {
            mkdir('FotosMonedas/', 0777, true);
        }
        $destino = "FotosMonedas/" . $this->nombre . ".jpg";
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

        return $destino;
    }

    public function ActualizarFoto($destinoFotoAnterior){
        if (!file_exists('Backup/')) {
            mkdir('Backup/', 0777, true);
        }
        $nombreViejo = explode('/', $destinoFotoAnterior);
        rename($destinoFotoAnterior, 'Backup/' . end($nombreViejo ));
        $destino = "FotosMonedas/" . $this->nombre . ".jpg";
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

        return $destino;
    }
    
}



?>