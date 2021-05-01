<?php

    include_once 'conexion.php';

    class edificio extends ConexionDB
    {
        //consulta para listar todos los datos
        function obtenerEdificios()
        {
            $id=0;
            $accion = "listar";
            
            $query = $this->connect()->prepare('Call getAllEdificio(:id, :accion)');
            $query->execute(['id'=>$id, 'accion'=>$accion]);
            return $query;
        }

        //se realiza la consulta en base al id solicitado
        function obtenerEdificio($edificio)
        {

            $query = $this->connect()->prepare('Call getAllEdificio(:id, :accion)');
            $query->execute([ 'id'=>$edificio['id'], 'accion'=>$edificio['accion'] ]);
            return $query;
        }

        //$edificio es array de objetos que traera los datos a insertar
        function nuevoEdificio($edificio)
        {

            $query = $this->connect()->prepare('Call InsertEdificio(:nombre, :direccion, :estado, :descripcion, :imagen)');

            $query->execute(['nombre'       =>$edificio['nombre'], 
                             'direccion'    =>$edificio['direccion'], 
                             'estado'       =>$edificio['estado'], 
                             'descripcion'  =>$edificio['descripcion'], 
                             'imagen'       =>$edificio['imagen']  
                            ]);
            return $query;
        }

        //consulta update
        function actualizarEdificio($edificio)
         {

            $query = $this->connect()->prepare('Call UpdateEdificio(:id, :nombre, :direccion, :estado, :descripcion, :imagen)');
            
            $query->execute(['id'           =>$edificio['id'],
                             'nombre'       =>$edificio['nombre'], 
                             'direccion'    =>$edificio['direccion'], 
                             'estado'       =>$edificio['estado'], 
                             'descripcion'  =>$edificio['descripcion'],
                             'imagen'       =>$edificio['imagen']   
                            ]);

             return $query;
         }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarEdificioID($edificio)
         {
            $query = $this->connect()->prepare('Call getValidarEdificio(:id, :accion)');
            $query->execute([ 'id'=>$edificio['id'], 'accion'=>$edificio['accion'] ]);
            
            return $query;
         }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarEdificio($edificio)
         {
            $query = $this->connect()->prepare('Call getAllEdificio(:id, :accion)');
            $query->execute([ 'id'=>$edificio['id'], 'accion'=>$edificio['accion'] ]);

             return $query;
         }

         function getvalidarEstado($id)
         {
            $query = $this->connect()->prepare('SELECT idEstado AS estado FROM edificio WHERE idEdificio = :id');
            $query->execute(['id'=>$id]);

            return $query;
         }
   
    }
?>