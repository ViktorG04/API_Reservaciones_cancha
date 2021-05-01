<?php

    include_once 'conexion.php';

    class TipoCancha extends ConexionDB
    {
        //consulta para listar todos los datos
        function obtenerTipoCancha()
        {
            $id=0;
            $accion = "listar";
            $var = "null";
          
            $query = $this->connect()->prepare('Call getAllTipoCancha(:id, :accion, :var)');
            $query->execute(['id'=>$id, 'accion'=>$accion, 'var'=>$var]);
            return $query;
        }

        //se realiza la consulta en base al id solicitado
        function obtenerTipoCanchas($tipo)
        {

            $query = $this->connect()->prepare('Call getAllTipoCancha(:id, :accion, :var)');
            $query->execute(['id'=>$tipo['id'], 'accion'=>$tipo['accion'], 'var'=>$tipo['var']]);

            return $query;
        }

        //$tipo es array de objetos que traera los datos a insertar
        function nuevoTipoCancha($tipo)
        {

            $query = $this->connect()->prepare('Call getAllTipoCancha(:id, :accion, :tipo)');
            $query->execute(['id'=>$tipo['id'], 'accion'=>$tipo['accion'], 'tipo'=>$tipo['tipo']]);

            return $query;
        }

        //consulta update
        function actualizarTipoCancha($tipo)
         {

            $query = $this->connect()->prepare('Call getAllTipoCancha(:id, :accion, :tipo)');
            $query->execute(['id'=>$tipo['id'], 'accion'=>$tipo['accion'], 'tipo'=>$tipo['tipo']]);

             return $query;
         }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarTipoCancha($id)
         {
            
            $query = $this->connect()->prepare('SELECT count(tipo_cancha.idTipoCancha) AS cantidad FROM cancha INNER JOIN tipo_cancha
                                                ON tipo_cancha.idTipoCancha = cancha.idTipoCancha
                                                WHERE tipo_cancha.idTipoCancha = :id');
            $query->execute(['id' =>$id]);
            
            return $query;
 
         }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarTipoCancha($tipo)
         {
            $query = $this->connect()->prepare('Call getAllTipoCancha(:id, :accion, :var)');
            $query->execute(['id'=>$tipo['id'], 'accion'=>$tipo['accion'], 'var'=>$tipo['var']]);

             return $query;
    
         }

        
    }


?>