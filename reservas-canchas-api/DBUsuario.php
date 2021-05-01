<?php

include_once 'conexion.php';

class usuario extends ConexionDB
{
    //consulta para listar todos los datos
    function obtenerUsuarios($usuario)
    {
        $query = $this->connect()->prepare('Call getAllUsuario(:id, :accion)');
        $query->execute(['id' =>$usuario['id'], 'accion' =>$usuario['accion']]);
        return $query;
    }


    //$estado es array de objetos que traera los datos a insertar
    function nuevoUsuario($usuario)
    {
        $query = $this->connect()->prepare('Call InsertUsuario(:usuario, :nombre, :dui, :carnet, :correo, :telefono, :password, :rol, :estado)');
        $query->execute([   'usuario'   =>$usuario['usuario'], 
                            'nombre'    =>$usuario['nombre'],
                            'dui'       =>$usuario['dui'], 
                            'carnet'    =>$usuario['carnet'], 
                            'correo'    =>$usuario['correo'], 
                            'telefono'  =>$usuario['telefono'], 
                            'password'  =>$usuario['password'],
                            'rol'       =>$usuario['rol'], 
                            'estado'    =>$usuario['estado']
                        ]);
        return $query;
    }

    function actualizarUsuario($usuario)
    {
        $query = $this->connect()->prepare('Call UpdateUsuario(:id, :nombre, :carnet, :dui, :correo, :telefono, :password, :rol, :estado)');
        $query->execute([   'id'        =>$usuario['id'], 
                            'nombre'    =>$usuario['nombre'], 
                            'carnet'    =>$usuario['carnet'],
                            'dui'       =>$usuario['dui'], 
                            'correo'    =>$usuario['correo'], 
                            'telefono'  =>$usuario['telefono'], 
                            'password'  =>$usuario['password'],
                            'rol'       =>$usuario['rol'], 
                            'estado'    =>$usuario['estado']
                        ]);
        return $query;
    }

    
    function modificarDatos($usuario)
    {
        $query = $this->connect()->prepare('UPDATE usuario SET telefono = :telefono, password = :pass WHERE idUsuario=:id');
        $query->execute([   'id'        =>$usuario['id'], 
                            'telefono'  =>$usuario['telefono'], 
                            'pass'      =>$usuario['password'],
                        ]);

        return $query;
    }

     //antes de elimininar un usuario se valida si este no a sido utilizado
     function validarUsuarioID($id)
     {
        
        $query = $this->connect()->prepare('SELECT count(idReservacion) as cantidad FROM reservacion 
        INNER JOIN usuario ON usuario.idUsuario = reservacion.idUsuario
        WHERE usuario.idUsuario = :id');
        $query->execute(['id' =>$id]);
        return $query;
 
     }

    //una vez se ha validado que no el ID no esta siendo utilizado
    function eliminarUsuario($id)
    {
       $accion = "eliminar";

       $query = $this->connect()->prepare('Call getAllUsuario(:id, :accion)');
       $query->execute(['id' =>$id, 'accion' =>$accion]);
       return $query;

    }

    //Contar usuarios creados con el mismo nombre
    function contarUsuarioNombre($usuario)
    {
        $query = $this->connect()->prepare('SELECT count(usuario) AS cantidad FROM usuario WHERE nombreCompleto LIKE :nombre');
        $query->execute(['nombre' =>$usuario]);

        return $query;
    }

    //buscar si existe usuario creado
    function validarUsuario($usuario)
    {
        $query = $this->connect()->prepare('SELECT usuario FROM usuario WHERE usuario = :usuario');
        $query->execute(['usuario' =>$usuario]);

        return $query;
    }

    function loginUsuario($usuario)
    {
        $query = $this->connect()->prepare('Call getAllLOGIN(:usuario, :password)');
        $query->execute(['usuario'=>$usuario['usuario'], 'password'=>$usuario['password']]);

        return $query;
    }

    function validarCarnet($usuario)
    {
        $query = $this->connect()->prepare('SELECT count(carnet) AS var FROM usuario WHERE carnet = :carnet');
        $query->execute(['carnet'=>$usuario['carnet']]);

        return $query;
    }

    //funcion validar dui
    function validarDUI($usuario)
    {
        $query = $this->connect()->prepare('SELECT count(dui) AS var FROM usuario WHERE dui = :dui');
        $query->execute(['dui'=>$usuario['dui']]);
        return $query;
    }

    function consultarDUI($id)
    {   
        $query = $this->connect()->prepare('Call getAllDUI(:i)');
        $query->execute(['i'=>$id]);
        return $query;
    }
}
?>