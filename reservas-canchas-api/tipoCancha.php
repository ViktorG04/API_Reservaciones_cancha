<?php
    include_once 'apiTipoCancha.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiTipoCanchas();

    //peticion get para listar todos los datos o solo el ID requerido
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['id']))
        {
            $id = $data['id'];

            //validar solo un id numerico
            if(is_numeric($id))
            {
                 $api->getById($id);
                exit;
            }
            else
            {
                $mensaje->error('Los parametros son incorrectos');          
            }
        }
        else
        {   
             //listar todos
            $api->getAll();
            exit;
        }
    
    }

    //insertar datos
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        if(empty($data))
        {
            $mensaje->error('ERROR al llamar API');
        }
        else
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
                if(isset($data['tipo']) && is_string($data['tipo']))
                {
                    $api->add($data);
                }
                else
                {   
                    $mensaje->error('Error al llamar la API insertar');
                }
            }
        }
    }

    //actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $data = $mensaje->obtenerJSON();

        if(empty($data))
        {
            $mensaje->error('ERROR al llamar API');
        }
        else
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
                $mensaje->error('Campos vacios no se puede actualizar');
            }
            else 
            {
                if(isset($data['id']) && isset($data['tipo']))
                {
                    $api->update($data);
                }
                else
                {
                    $mensaje->error('Error al llamar la API Actualizar');
                }
            }
        }
    }

    //eliminar
     if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['id']))
        {
             //validar solo un id numerico
             if(is_numeric($id))
             {
                $api->delete($id);
             }
             else
             {
                 $mensaje->error('Los parametros son incorrectos');          
             }
            
        }
        else
        {
            $mensaje->error('Error al llamar la API eliminar');
        }
    }   
?>