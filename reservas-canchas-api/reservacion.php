<?php
    include_once 'apiReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiReservacion();

    if($_SERVER['REQUEST_METHOD'] == 'GET')
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
                if(isset($data['usuario']) or isset($data['numReservacion']) or isset($data['cancha']) or isset($data['fecha']))
                {
                    
                    $api->getById($data);
                    exit;
                }
                else
                {
                    $mensaje->error('Los parametros son incorrectos');
                }
            }            
        }
        else
        {
            $data = ['fecha' =>'2020-01-1'];
            $api->getById($data);
            exit;
        }
    }

    //insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        if(empty($data))
        {
            $mensaje->error('ERROR al llamar API');
        }
        else
        {
            $i = count($data);
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
                //reservacion administrativa
                if($i == 6)
                {
                    if(isset($data['fecha']) && isset($data['usuarioAd']) && isset($data['dui']) && isset($data['hora']) 
                    && isset($data['cancha']) && isset($data['tipo']))
                    { 
                       $usuario = $api->obtenerIdUsuario($data['dui']);
                       if(!empty($usuario))
                       {
                            $data['usuario'] = $usuario;
                            $api->add($data);
                       }
                       else
                       {
                            $mensaje->error('El numero de dui no esta registrado');
                       }
                       
                    }
                    else
                    {   
                        $mensaje->error('Los parametros son incorrectos');
                    }
                }
                //reservacion usuario final
                else if ($i == 5)
                {
                    if(isset($data['fecha']) && isset($data['usuario']) && isset($data['hora']) 
                    && isset($data['cancha']) && isset($data['tipo']))
                    {
                        $api->add($data);
                    }
                    else
                    {   
                        $mensaje->error('Los parametros son incorrectos');
                    }
                }
            }
        }
    }

    //actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['numReserva'])  && isset($data['usuario']) && isset($data['estado'])
            && isset($data['comentario']))
        {
            $api->update($data);
        }
        else
        {
            $mensaje->error('Error con datos JSON al Actualizar');
        }
    }

?>