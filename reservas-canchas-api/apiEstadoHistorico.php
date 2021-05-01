<?php
    include_once 'DBEstadoHistorico.php';
    include_once 'Mensajes.php';

    class ApiEstadosHistorico                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase estadoEdificio, donde esta la consulta
            $estado = new estadoHistorico();
            $estados = array();

            $res = $estado->obtenerEstados();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'              =>$row['idEstado'],
                        'estado'          =>$row['estado']
                    );
                    array_push($estados, $item);
                }
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($estados);
            }
            else
            {

                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            
            //creo un objeto de la clase estadoEdificio, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $estado = new estadoHistorico();

            $item = ['id'=>$id, 'accion'=>'buscar', 'var'=>'null'];
            $estados = array();

            $res = $estado->obtenerEstado($item);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'      =>$row['idEstado'],
                    'estado'  =>$row['estado']
                );
                array_push($estados, $item);
                
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($estados);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //registrar nuevo estado
        function add($item)
        {
            $estado = new estadoHistorico();
            $item = ['id'=>0, 'accion'=>'insertar', 'estado'=>$item['estado']];

            $res = $estado->nuevoEstado($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
           
            $estado = new estadoHistorico();
            $item['accion'] = "update";

            $res = $estado->actualizarEstado($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $estado = new estadoHistorico();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $estado->validarEstadoID($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['cantidad'] == 0)
            {
                $item = ['id'=>$id, 'accion'=>'eliminar', 'var'=>'null'];
                $res = $estado->eliminarEstado($item);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }

?>