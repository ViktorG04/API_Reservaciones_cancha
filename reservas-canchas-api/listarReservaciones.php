<?php
    include_once 'DBReservacion.php';
    include_once 'Mensajes.php';

    class ListarReservaciones                       
    {
        //listar reservaciones por usuario
        function listarReservasUsu($item)
        {
            $reserva = new reservacion();
            $mensaje = new Mensajes_JSON();

            $reservaciones = array();
            $res = $reserva->ObtenerReservasUsu($item);

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {  
                    $item = array(
                        'numReservacion'    =>$row['numReservacion'],
                        'fechaReservacion'  =>$row['fechaReservacion'],
                        'Horario'           =>$row['idHorarioReservacion'],
                        'horaInicio'        =>$row['horaInicio'],
                        'horaFin'           =>$row['horaFin'],
                        'idCancha'          =>$row['idCancha'],
                        'cancha'            =>$row['cancha'],
                        'idEstado'          =>$row['idEstado'],
                        'estado'            =>$row['estado']
                    );
                    array_push($reservaciones, $item);
                }
                $mensaje->printJSON($reservaciones);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //listar una reservacion en especifico
        function ConsultarReservacion($id)
        {
            $reserva = new reservacion();
            $mensaje = new Mensajes_JSON();

            $reservaciones = array();
            $res = $reserva->SeguimientoRerserva($id);

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {   
                    $item = array(
                        'fechayHoraCreacion' =>$row['fechayHoraCreacion'],
                        'fechaReservacion'  =>$row['fechaReservacion'],
                        'numReservacion'    =>$row['numReservacion'],
                        'AdminUsuario'      =>$row['AdminUsuario'],
                        'UsuarioFinal'      =>$row['UsuarioFinal'],
                        'Horario'           =>$row['Horario'],
                        'idEstado'          =>$row['idEstado'],
                        'estado'            =>$row['estado'],
                        'comentarios'       =>$row['comentarios']
                    );
                    array_push($reservaciones, $item);
                }
                $mensaje->printJSON($reservaciones);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //listar reservar por cancha
        function ConsultarReservacionCancha($id)
        {
            $reserva = new reservacion();
            $mensaje = new Mensajes_JSON();

            $reservaciones = array();
            $res = $reserva->ObtenerReservasCancha($id);

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                { 
                    $item = array(
                        'fechayHoraCreacion' =>$row['fechayHoraCreacion'],
                        'numReservacion'    =>$row['numReservacion'],
                        'usuario'            =>$row['idUsuario'],
                        'nombre'            =>$row['nombreCompleto'],
                        'telefono'          =>$row['telefono'],
                        'fechaReservacion'  =>$row['fechaReservacion'],
                        'Horario'           =>$row['idHorarioReservacion'],
                        'horaInicio'        =>$row['horaInicio'],
                        'horaFin'           =>$row['horaFin'],
                        'idEstado'          =>$row['idEstado'],
                        'estado'            =>$row['estado']
                    );
                    array_push($reservaciones, $item);
                }
                $mensaje->printJSON($reservaciones);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //listar reservaciones por fecha
        function listarReservasFecha($item)
        {
            $reserva = new reservacion();
            $mensaje = new Mensajes_JSON();

            $reservaciones = array();
            $res = $reserva->ObtenerReservasFecha($item);

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                { 
                   $item = array(
                        'fechayHoraCreacion' =>$row['fechayHoraCreacion'],
                        'numReservacion'     =>$row['numReservacion'],
                        'usuario'            =>$row['idUsuario'],
                        'nombreCompleto'     =>$row['nombreCompleto'],
                        'telefono'           =>$row['telefono'],
                        'fechaReservacion'   =>$row['fechaReservacion'],
                        'Horario'            =>$row['idHorarioReservacion'],
                        'horaInicio'         =>$row['horaInicio'],
                        'horaFin'            =>$row['horaFin'],
                        'idCancha'           =>$row['idCancha'],
                        'cancha'             =>$row['cancha'],
                        'idEstado'           =>$row['idEstado'],
                        'estado'             =>$row['estado']
                    );
                    array_push($reservaciones, $item);
                }
                $mensaje->printJSON($reservaciones);
            }
            else
            {
                $mensaje->error('No existen reservaciones para esa fecha');
               
            }
        }
    }

?>