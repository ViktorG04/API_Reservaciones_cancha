<?php
    include_once 'apiEdificio.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiEdificios();
    $vacio= 0;

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
        else if(isset($data['activos']))
        {
            $api->listarActivos();
            exit;
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
                if(isset($data['nombre']) && isset($data['direccion']) && isset($data['descripcion']) && isset($data['imagen']))
                {
                    $api->add($data);
                }
                else
                {   
                    $mensaje->error('Datos Incorrectos');
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
                if(isset($data['id']) && isset($data['nombre']) && isset($data['direccion'])
                    && isset($data['descripcion']) && isset($data['estado']) && isset($data['imagen']) )
                {
                    $api->update($data);
                }
                else
                {
                    $mensaje->error('Datos incorrectos');
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
            $id = $data['id'];

            //validar solo un id numerico
            if(is_numeric($id))
            {
                 $api->delete($id);
                exit;
            }
            else
            {
                $mensaje->error('Los parametros son incorrectos');          
            }
        }
        else
        {
            $mensaje->error('Error al llamar API eliminar');
        }
    }   

?>