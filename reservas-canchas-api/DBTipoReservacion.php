<?php

    include_once 'conexion.php';

    class tipoReservacion extends ConexionDB
    {
        //consulta para listar todos los datos
        function obtenerTipoReservas()
        {
            $id=0;
            $accion = "listar";
            
            $query = $this->connect()->prepare('Call getAllTipoReservacion(:id, :accion)');
            $query->execute(['id'=>$id, 'accion'=>$accion]);
            return $query;
        }

        //se realiza la consulta en base al id solicitado
        function obtenerTipoReserva($tipo)
        {

            $query = $this->connect()->prepare('Call getAllTipoReservacion(:id, :accion)');
            $query->execute([ 'id'=>$tipo['id'], 'accion'=>$tipo['accion'] ]);

            return $query;
        }

        //$horario es array de objetos que traera los datos a insertar
        function nuevoTipoReserva($tipo)
        {
 
            $query = $this->connect()->prepare('Call InsertTipoReservacion(:tipo, :descripcion)');
            $query->execute(['tipo'=>$tipo['tipo'], 'descripcion'=>$tipo['descripcion']]);

            return $query;
        }

        //consulta update
        function actualizarTipoReserva($tipo)
         {
  
            $query = $this->connect()->prepare('Call UpdateTipoReservacion(:id, :tipo, :descripcion)');
            $query->execute(['id'=>$tipo['id'], 'tipo'=>$tipo['tipo'], 'descripcion'=>$tipo['descripcion']]);

             return $query;
         }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarTipoID($id)
         {
            
            $query = $this->connect()->prepare('SELECT count(idReservacion) AS cantidad FROM reservacion INNER JOIN tipo_reservacion
                                                ON reservacion.idTipoReservacion = tipo_reservacion.idTipoReservacion
                                                WHERE tipo_reservacion.idTipoReservacion = :id');
            $query->execute(['id' =>$id]);
            
            return $query;
 
         }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarTipoReserva($tipo)
         {
            $query = $this->connect()->prepare('Call getAllTipoReservacion(:id, :accion)');
            $query->execute([ 'id'=>$tipo['id'], 'accion'=>$tipo['accion'] ]);

             return $query;
    
         }
        
    }

?>