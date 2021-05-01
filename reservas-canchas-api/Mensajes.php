<?php
    class Mensajes_JSON
    {
        function printJSON($array)
        {
            echo  json_encode($array) ;
        }

        function error($mensaje)
        {
            echo  json_encode(array('mensaje' => $mensaje)) ;
        }

        function exito($mensaje)
        {
            echo json_encode(array('mensaje' => $mensaje));
        }

        function obtenerJSON()
        {   
           $decode = json_decode(file_get_contents('php://input'), true);
           if(empty($decode))
           {
               $decode = $_REQUEST;
           }
            return $this->decode = $decode;
        }

        //modificar el formato de la fecha recibida
        function formatFecha($fecha)
        {
            if(strpos($fecha, '/') !==  false)
            {
                $fecha = date_create_from_format('d/m/Y', $fecha);
                $date =  date_format($fecha, 'Y-m-d');
            }
            else
            {
                $date = $fecha;    
            }
            return $this->date =$date;
        }
 
    }
?>