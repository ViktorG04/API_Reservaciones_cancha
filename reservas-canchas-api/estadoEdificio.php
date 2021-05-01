<?php
    include_once 'apiEstadoEdificio.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiEstadosEdificios();

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
               if(isset($data['estado']) && is_string($data['estado']))
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
               if(isset($data['id']) && isset($data['estado']))
               {
                   $api->update($data);
               }
               else
               {
                   $mensaje->error('Datos Incorrectos');
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
           $mensaje->error('Error al llamar API');
       }
   }   
?>