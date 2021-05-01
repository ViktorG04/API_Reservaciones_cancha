<?php
    include_once 'DBEdificio.php';
    include_once 'Mensajes.php';

    class ApiEdificios                        
    {
        function listarActivos()
        {
            $mensaje = new Mensajes_JSON();
            
            $edificio = new edificio();
            $edificios = array();

            $res = $edificio->obtenerEdificios();
            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    if($row['idEstado']==1)
                    {
                        $item = array(
                            'id'            =>$row['idEdificio'],
                            'nombre'        =>$row['nombre'],
                            'direccion'     =>$row['direccion'],
                            'idEstado'      =>$row['idEstado'],
                            'estado'        =>$row['estado'],
                            'descripcion'   =>$row['descripcion']                        
                        );
                        array_push($edificios, $item);
                    }
                }
                $mensaje->printJSON($edificios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            $edificio = new edificio();
            $edificios = array();

            $res = $edificio->obtenerEdificios();
            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'            =>$row['idEdificio'],
                        'nombre'        =>$row['nombre'],
                        'direccion'     =>$row['direccion'],
                        'idEstado'      =>$row['idEstado'],
                        'estado'        =>$row['estado'],
                        'descripcion'   =>$row['descripcion'],
                        'imagen'        =>$row['imagen']
                    );
                    array_push($edificios, $item);
                }
                $mensaje->printJSON($edificios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            $mensaje = new Mensajes_JSON();

            $edificio = new edificio();
            $item = ['id'=>$id, 'accion'=>'buscar'];
            $res = $edificio->obtenerEdificio($item);
            $edificios = array();
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'            =>$row['idEdificio'],
                    'nombre'        =>$row['nombre'],
                    'direccion'     =>$row['direccion'],
                    'idEstado'      =>$row['idEstado'],
                    'estado'        =>$row['estado'],
                    'descripcion'   =>$row['descripcion'],
                    'imagen'        =>$row['imagen'],
                );
                array_push($edificios, $item);
 
                $mensaje->printJSON($edificios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }
        
        //registrar
        function add($item)
        {
            $mensaje = new Mensajes_JSON();
            $edificio = new edificio();

            $item['estado'] = 2;
            
            $res = $edificio->nuevoEdificio($item);

            $mensaje->exito('Datos registrados');
        }

        //actualizar
        function update($item)
        {  
            $mensaje = new Mensajes_JSON();
            $edificio = new edificio();

            $res = $edificio->getvalidarEstado($id = $item['id']);
            $row = $res->fetch();
            $estadoActual = $row['estado'];

            if($item['estado'] == 2 && $estadoActual == 1)
            {
	           $array = ['id' => $item['id'], 'accion'=>'validar'];
               $res = $edificio->validarEdificioID($array);
               $row = $res->fetch();

                if($row['var'] == 0)
                {
                    $res = $edificio->actualizarEdificio($item);
                    $mensaje->exito('Datos actualizados');
                }
                else
                {
                    $mensaje->error('no se puede cambiar el estado ya que hay reservaciones aprobadas');
                }
            }
            else if($estadoActual == 2 && ($item['estado'] == 1 or $item['estado'] == 2))
            {
                $res = $edificio->actualizarEdificio($item);
                $mensaje->exito('Datos actualizados');
            }
            else if($estadoActual == 1 && $item['estado'] == 1)
            {
                $res = $edificio->actualizarEdificio($item);
                $mensaje->exito('Datos actualizados');
            }
            else
            {
                $mensaje->error('No se puede actualizar el estado');
            }
        }

         //eliminar
         function delete($id)
         {
             $mensaje = new Mensajes_JSON();
             $edificio = new edificio();
             //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
             $item = ['id'=>$id, 'accion'=>'eliminar'];

             $res = $edificio->validarEdificioID($item);
             
             $row = $res->fetch();
             //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
             if($row['var'] == 0)
             {
                
                $res = $edificio->eliminarEdificio($item);
                $mensaje->exito('Datos eliminados con exito');

             }
             else
             {
                 $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
             }
             
         }

    }

?>