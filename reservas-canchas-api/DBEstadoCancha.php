<?php

    include_once 'conexion.php';

    class estadoCancha extends ConexionDB
    {
        //consulta para listar todos los datos
        function obtenerEstados()
        {
            $id=0;
            $accion = "listar";
            $var = "null";
          
            $query = $this->connect()->prepare('Call getAllEstadoCancha(:id, :accion, :var)');
            $query->execute(['id'=>$id, 'accion'=>$accion, 'var'=>$var]);
            return $query;
        }

        //se realiza la consulta en base al id solicitado
        function obtenerEstadobyId($estado)
        {
            $query = $this->connect()->prepare('Call getAllEstadoCancha(:id, :accion, :var)');
            $query->execute(['id'=>$estado['id'], 'accion'=>$estado['accion'], 'var'=>$estado['var']]);

            return $query;
        }

        //$estado es array de objetos que traera los datos a insertar
        function nuevoEstado($estado)
        {

            $query = $this->connect()->prepare('Call getAllEstadoCancha(:id, :accion, :estado)');
            $query->execute(['id'=>$estado['id'], 'accion'=>$estado['accion'], 'estado'=>$estado['estado']]);

            return $query;
        }

        //consulta update
        function actualizarEstado($estado)
         {

            $query = $this->connect()->prepare('Call getAllEstadoCancha(:id, :accion, :estado)');
            $query->execute(['id'=>$estado['id'], 'accion' =>$estado['accion'], 'estado'=>$estado['estado']]);

             return $query;
         }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarEstadoID($id)
         {
            $query = $this->connect()->prepare('SELECT count(estado_cancha.idEstado) AS cantidad FROM cancha INNER JOIN estado_cancha
                                                ON cancha.idEstado = estado_cancha.idEstado
                                                WHERE estado_cancha.idEstado = :id');
            $query->execute(['id' =>$id]);
            
            return $query;
         }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarEstado($estado)
         { 
            $query = $this->connect()->prepare('Call getAllEstadoCancha(:id, :accion, :var)');
            $query->execute(['id'=>$estado['id'], 'accion'=>$estado['accion'], 'var'=>$estado['var']]);

             return $query;
         }
   
    }
?>