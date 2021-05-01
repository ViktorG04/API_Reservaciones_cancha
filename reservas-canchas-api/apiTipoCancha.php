<?php
    include_once 'DBTipoCancha.php';
    include_once 'Mensajes.php';

    class ApiTipoCanchas                       
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase tipoCancha, donde esta la consulta
            $tipo = new TipoCancha();
            $tipos 	= array();

            $res = $tipo->obtenerTipoCancha();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'              =>$row['idTipoCancha'],
                        'tipo'            =>$row['tipo']
                    );
                    array_push($tipos, $item);
                }
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($tipos);
            }
            else
            {

                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            
            //creo un objeto de la clase tipoCancha, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $tipo 	 = new TipoCancha();
            $tipos 	 = array();
            $item = ['id'=>$id, 'accion'=>'buscar', 'var'=>'null'];

            $res = $tipo->obtenerTipoCanchas($item);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'      =>$row['idTipoCancha'],
                    'tipo'    =>$row['tipo']
                );
                array_push($tipos, $item);
                
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($tipos);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //registrar nuevo tipoCancha
        function add($item)
        {
            $tipo = new TipoCancha();
            $item = ['id'=>0, 'accion'=>'insertar', 'tipo'=>$item['tipo']];
            $res  = $tipo->nuevoTipoCancha($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar tipoCancha
        function update($item)
        {
           
            $tipo = new TipoCancha();
            $item['accion'] = "update";

            $res  = $tipo->actualizarTipoCancha($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar tipoCancha
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $tipo = new TipoCancha();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $tipo->validarTipoCancha($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['cantidad'] == 0)
            {
                $item = ['id'=>$id, 'accion'=>'eliminar', 'var'=>'null'];
                $res = $tipo->eliminarTipoCancha($item);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }

?>