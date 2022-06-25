<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
class Usuario {
    public $id;
    public $mail;
    public $tipo;
    public $clave;
    public $fecha_de_baja;
   

    public function crearUsuario(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("INSERT INTO usuarios (mail, tipo, clave) VALUES (:mail, :tipo, :clave)");
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_INT);
  
        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from usuarios WHERE fecha_de_baja IS NULL");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuariosQueCompraronDerminadaCripto($nombreCripto){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from usuarios 
        INNER JOIN ventascripto ON ventascripto.usuario_id = usuarios.id
        INNER JOIN criptomonedas ON criptomonedas.id = ventascripto.criptomoneda_id
        WHERE criptomonedas.nombre = :nombreCripto && usuarios.fecha_de_baja IS NULL");
        $consulta->bindValue(':nombreCripto', $nombreCripto, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($id){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from usuarios WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

        return $consulta->fetch();
    }

    public static function obtenerUsuarioPorMail($mail){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from usuarios WHERE mail = :mail && fecha_de_baja IS NULL");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

        return $consulta->fetch();
    }


    public function modificarUsuario(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE usuarios SET mail = :mail, tipo = :tipo, clave = :clave WHERE id = :id");
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_INT);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute(); 

    }
    
    public function borrarUsuario(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE usuarios SET fecha_de_baja = :fecha_de_baja WHERE id = :id");
        $consulta->bindValue(':fecha_de_baja',date("y-m-d") , PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);

        $consulta->execute();

    }

    public static function verificarUsuario($mail, $tipo, $clave){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE mail = :mail && clave = :clave && tipo = :tipo");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_INT);
        $consulta->execute();
        $existe = $consulta->fetchColumn();

        if ($existe > 0) {
            return true;
        }
        else {
            return false;
        }

        
    }

    public static function yaExisteMail($mail){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE mail = :mail");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
        $consulta->execute();
        $existe = $consulta->fetchColumn();

        if ($existe > 0) {
            return true;
        }
        else {
            return false;
        }

    }

   
}



?>