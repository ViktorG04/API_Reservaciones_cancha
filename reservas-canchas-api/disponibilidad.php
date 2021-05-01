<?php
    include_once 'apiHorarioReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiHorariosReservacion();

    //peticion get para listar los horarios disponibles
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
        
        if(!empty($data))
        {
            $datos = (array_values($data));
            for($a = 0; $a < count($datos); $a++)
            {
                if(empty($datos[$a])) 
                {
                    $vacio++;
                }
            }

            if($vacio != 0)
            {
                $mensaje->error('Campos vacios');
            }
            else 
            {
                if(isset($data['cancha']) && isset($data['fecha']))
                {
                    $api->GenerarDisponibilidad($data);
                }
                else
                {
                    $mensaje->error('Datos incorrectos');
                }
            }
        }
        else
        {
            $mensaje->error('ERROR al llamar API');
        }
    }
?>