<?php

    include_once 'conexion.php';

    class Cancha extends ConexionDB
    {
        //se realiza la consulta en base a lo solicitado
        function obtenerCanchas($cancha)
        {
            $query = $this->connect()->prepare('Call getAllCancha(:id, :accion)');
            $query->execute(['id'=>$cancha['id'], 'accion'=>$cancha['accion']]);

            return $query;
        }

        //$estado es array de objetos que traera los datos a insertar
        function nuevoCancha($cancha)
        {
            $query = $this->connect()->prepare('Call InsertCancha(:nombre, :descripcion, :telefono, :horaIn, :horaEnd, :idEdi, :tipo, :estado, :imagen)');
            $query->execute(['nombre'       =>$cancha['nombre'], 
                            'descripcion'   =>$cancha['descripcion'], 
                            'telefono'      =>$cancha['telefono'], 
                            'horaIn'        =>$cancha['horaInicio'],  
                            'horaEnd'       =>$cancha['horaFin'], 
                            'idEdi'         =>$cancha['idEdificio'], 
                            'tipo'          =>$cancha['idTipoCancha'], 
                            'estado'        =>$cancha['estado'], 
                            'imagen'        =>$cancha['imagen']
                            ]);
            return $query;
        }

        //consulta update
        function actualizarCancha($cancha)
        {

            $query = $this->connect()->prepare('Call UpdateCancha(:id, :nombre, :descripcion, :telefono, :horaInicio, :horaFin, :idEdificio, :idTipoCancha, :idEstado, :imagen)');
            
            $query->execute([   'id'            =>$cancha['id'], 
                                'nombre'        =>$cancha['nombre'], 
                                'descripcion'   =>$cancha['descripcion'], 
                                'telefono'      =>$cancha['telefono'],
                                'horaInicio'    =>$cancha['horaInicio'],
                                'horaFin'       =>$cancha['horaFin'], 
                                'idEdificio'    =>$cancha['idEdificio'], 
                                'idTipoCancha'  =>$cancha['idTipoCancha'], 
                                'idEstado'      =>$cancha['estado'], 
                                'imagen'        =>$cancha['imagen']
                            ]);
             return $query;
        }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarCanchaID($cancha)
        {
            $query = $this->connect()->prepare('Call getValidarCancha(:id, :accion)');
            $query->execute([ 'id'=>$cancha['id'], 'accion'=>$cancha['accion'] ]);

            return $query;
 
        }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarCancha($cancha)
         {
            $query = $this->connect()->prepare('Call Cancha(:id, :accion)');
            $query->execute([ 'id'=>$cancha['id'], 'accion'=>$cancha['accion'] ]);

             return $query;
         }
        
         //consultar el estado actual de la cancha
        function ConsultarEstadoCancha($id)
        {
            $query = $this->connect()->prepare('Call getEstadoCancha(:id)');
            $query->execute(['id'=>$id]);

            return $query;
        }
        
    }
?>