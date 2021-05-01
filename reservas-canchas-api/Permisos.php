<?php

include_once 'conexion.php';

class permisos extends ConexionDB
{
    
    function getRolUsuario($id)
    {
        
        $query = $this->connect()->prepare('SELECT idRol AS var FROM  usuario WHERE idUsuario = :id');
        $query->execute(['id'=>$id]);

        return $query;
    }

    function validarFechaRol($item)
    {
        $query = $this->connect()->prepare('Call getValidarHorario(:usuario, :fecha)');
        $query->execute(['usuario'=>$item['usuario'], 'fecha'=>$item['fecha'] ]);

        return $query;
    }

    function getIdUsuario($usu)
    {
        $query = $this->connect()->prepare('SELECT idUsuario AS id FROM usuario WHERE dui = :dui');
        $query->execute(['dui'=>$usu]);
        return $query;
    }

    function bloquearUsuario($id)
    {
        $estado = 2;
        $query = $this->connect()->prepare('UPDATE usuario SET idEstado = :estado WHERE idUsuario = :id');
        $query->execute(['id'=>$id, 'estado'=>$estado]);

        return $query;
    }

    function getEstadoUsuario($id)
    {
        $query = $this->connect()->prepare('SELECT idEstado AS estado FROM  usuario WHERE idUsuario = :id');
        $query->execute(['id'=>$id]);

        return $query;
    }

    
}