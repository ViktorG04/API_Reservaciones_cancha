<?php
    include_once 'DBRolUsuario.php';
    include_once 'Mensajes.php';

    class ApiRolUsuarios                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase rolUsuario, donde esta la consulta
            $rol = new rolUsuario();
            $roles = array();

            $res = $rol->obtenerRoles();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'    =>$row['idRolUsuario'],
                        'rol'   =>$row['rol']
                    );
                    array_push($roles, $item);
                }
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($roles);
            }
            else
            {

                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            
            //creo un objeto de la clase rolUsuario, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $rol = new rolUsuario();
            $item = ['id'=>$id, 'accion'=>'buscar', 'var'=>'null'];
            $roles = array();

            $res = $rol->obtenerRol($item);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'   =>$row['idRolUsuario'],
                    'rol'  =>$row['rol']
                );
                array_push($roles, $item);
                
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($roles);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //registrar nuevo estado
        function add($item)
        {
            $rol = new rolUsuario();
            $item = ['id'=>0, 'accion'=>'insertar', 'rol'=>$item['rol']];
            $res = $rol->nuevoRol($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
            $rol = new rolUsuario();
            $item['accion'] = "update";

            $res = $rol->actualizarRol($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $rol = new rolUsuario();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $rol->validarRolID($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['cantidad'] == 0)
            {
                $item = ['id'=>$id, 'accion'=>'eliminar', 'var'=>'null'];
                $res = $rol->eliminarRol($item);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }

?>