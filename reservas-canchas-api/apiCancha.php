<?php
    include_once 'DBCancha.php';
    include_once 'Mensajes.php';

    class ApiCanchas                       
    {
        function getById($item)
        {
            $mensaje = new Mensajes_JSON();
            
            if($item['cancha'])
            {
                $item = ['id'=>$item['cancha'], 'accion'=>'cancha'];
                $this->listarCanchas($item);
            }
            else if($item['edificio'])
            {
                $item = ['id'=>$item['edificio'], 'accion'=>'edificio'];
                $this->listarCanchas($item);
            }
            else if($item['tipo'])
            {
                $item = ['id'=>$item['tipo'], 'accion'=>'tipo'];
                $this->listarCanchas($item);
            }
            else
            {
                $this->listarCanchas($item); 
            }
            
        }

        //consulta solo el id solicitado
        function listarCanchas($item)
        {
            //creo un objeto de la clase estadoEdificio, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $cancha = new Cancha();
            $canchas = array();
            $res = $cancha->obtenerCanchas($item);
            $row = $res->fetch();

            if($res->rowCount())
            { 
                do 
                {
                    $item = array(
                        'cancha'                =>$row['cancha'],
                        'nombre' 				=>$row['nombre'],
                        'descripcion'           =>$row['descripcion'],
                        'telefonoContacto' 		=>$row['telefonoContacto'],
                        'horaInicio' 			=>$row['horaInicio'],	
                        'horaFin' 				=>$row['horaFin'],
                        'idEdificio'            =>$row['idEdificio'],
                        'edificio' 				=>$row['edificio'],						
                        'idTipoCancha' 			=>$row['idTipoCancha'],	
                        'tipo' 				    =>$row['tipo'],
                        'idEstado' 				=>$row['idEstado'],
                        'estado'                =>$row['estado'],
                        'imagen'                =>$row['imagen'],
                        'fechaCreacion'         =>$row['fechaCreacion']
                        );
                    array_push($canchas, $item);
                } 
                while ($row = $res->fetch(PDO::FETCH_ASSOC));
                $mensaje->printJSON($canchas);
            }
            else
            {
                $mensaje->error('No hay datos registrados');
            }
        }

        //registrar nuevo estado
        function add($item)
        {
            $cancha = new Cancha();
            $mensaje = new Mensajes_JSON();

            $item['estado'] = 2;
            $res = $cancha->nuevoCancha($item);

            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
            $mensaje = new Mensajes_JSON();
            $cancha = new Cancha();

            $res = $cancha->ConsultarEstadoCancha($id = $item['id']);
            $row = $res->fetch();
            
            $estadoActual = $row['var'];

            if($item['estado'] == 2 && $estadoActual == 1)
            {
                $array = ['id' => $item['id'], 'accion'=>'validar'];
                $res = $cancha->validarCanchaID($array);
                $row = $res->fetch();
                if($row['var'] == 0)
                {
                    $res = $cancha->actualizarCancha($item);
                    $mensaje->exito('Datos actualizados');
                }
                else
                {
                    $mensaje->error('no se puede cambiar el estado ya que hay reservaciones aprobadas');
                }
            }
            else if($estadoActual == 2 && ($item['estado'] == 1 or $item['estado'] == 2))
            {
                $res = $cancha->actualizarCancha($item);
                $mensaje->exito('Datos actualizados');
            }
            else if($estadoActual == 1 && $item['estado'] == 1)
            {
                $res = $cancha->actualizarCancha($item);
                $mensaje->exito('Datos actualizados');
            }
            else
            {
                $mensaje->error('ERROR no tiene permisos');
            }
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $cancha = new Cancha();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $item = ['id'=>$id, 'accion'=>'eliminar'];
            $res = $cancha->validarCanchaID($item);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['var'] == 0)
            {
                $res = $cancha->eliminarCancha($item);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }
?>