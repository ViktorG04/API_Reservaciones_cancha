<?php
    include_once 'DBTipoReservacion.php';
    include_once 'Mensajes.php';

    class ApiTiposReservacion                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase estadoUsuaario, donde esta la consulta
            $tipo = new tipoReservacion();
            $tipos = array();

            $res = $tipo->obtenerTipoReservas();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'            =>$row['idTipoReservacion'],
                        'tipo'          =>$row['tipo'],
                        'descripcion'   =>$row['descripcion']
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
            
            //creo un objeto de la clase estadoUsuaario, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $tipo = new tipoReservacion();
            $item = ['id'=>$id, 'accion'=>'buscar'];

            $tipos = array();

            $res = $tipo->obtenerTipoReserva($item);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'            =>$row['idTipoReservacion'],
                    'tipo'          =>$row['tipo'],
                    'descripcion'   =>$row['descripcion']
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

        //registrar nuevo estado
        function add($item)
        {
            $tipo = new tipoReservacion();
            $res = $tipo->nuevoTipoReserva($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
           
            $tipo = new tipoReservacion();
            $res = $tipo->actualizarTipoReserva($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $tipo = new tipoReservacion();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $tipo->validarTipoID($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['cantidad'] == 0)
            {
                $item = ['id'=>$id, 'accion'=>'eliminar'];
                $res = $tipo->eliminarTipoReserva($item);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }

?>