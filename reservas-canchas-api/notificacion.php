<?php
    include_once 'apiReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiReservacion();

    //peticion get para listar los horarios disponibles
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
        
        if(!empty($data))
        {
            if(!empty($data['id']))
            {
                $id = $data['id'];

                //validar solo un id numerico
                if(is_numeric($id))
                {
                    $api->notificacionReserva($id);
                    exit;
                }
                else
                {
                    $mensaje->error('Los parametros son incorrectos');          
                }
                    
            }
            else
            {
                $mensaje->error('Campos vacios');
            }
        }
        else
        {
            $mensaje->error('ERROR al llamar API');
        }
    }
?>