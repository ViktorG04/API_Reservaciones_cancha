<?php

    include_once 'conexion.php';

    class horarioReservacion extends ConexionDB
    {
        //consulta para listar todos los datos
        function obtenerHorarios()
        {
            $id=0;
            $accion = "listar";
            
            $query = $this->connect()->prepare('Call getAllHorarioReservacion(:id, :accion)');
            $query->execute(['id'=>$id, 'accion'=>$accion]);
            return $query;
        }

        //se realiza la consulta en base al id solicitado
        function obtenerHorario($id)
        {
            $accion = "buscar";
           
            $query = $this->connect()->prepare('Call getAllHorarioReservacion(:id, :accion)');
            $query->execute(['id'=>$id, 'accion'=>$accion]);

            return $query;
        }

        //$horario es array de objetos que traera los datos a insertar
        function nuevoHorario($horario)
        {
 
            $query = $this->connect()->prepare('Call InsertHorarioReservacion(:horaInicio, :horaFin)');
            $query->execute(['horaInicio'=>$horario['horaInicio'], 'horaFin'=>$horario['horaFin']]);

            return $query;
        }

        //consulta update
        function actualizarHorario($horario)
         {
  
            $query = $this->connect()->prepare('Call UpdateHorarioReservacion(:id, :horaInicio, :horaFin)');
            $query->execute(['id'=>$horario['id'], 
                             'horaInicio'=>$horario['horaInicio'], 
                             'horaFin'=>$horario['horaFin']]);

             return $query;
         }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarHorarioID($id)
         {
            
            $query = $this->connect()->prepare('SELECT count(idReservacion) AS cantidad FROM reservacion INNER JOIN horario_reservacion
                                                ON reservacion.idHorarioReservacion = horario_reservacion.idHorarioReservacion
                                                WHERE horario_reservacion.idHorarioReservacion = :id');
            $query->execute(['id' =>$id]);
            
            return $query;
 
         }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarHorario($id)
         {
            $accion = "eliminar";

            $query = $this->connect()->prepare('Call getAllHorarioReservacion(:id, :accion)');
            $query->execute(['id' =>$id, 'accion' =>$accion]);

             return $query;
    
         }
        
    }

?>