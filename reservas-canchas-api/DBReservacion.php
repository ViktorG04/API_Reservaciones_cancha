<?php

include_once 'conexion.php';

class reservacion extends ConexionDB
{
    //consultar horario a reservar
    function consultarDisponibilidad($reserva)
    {
        $query = $this->connect()->prepare('Call getDisponibilidadReserva(:fecha, :hora, :cancha)');
        $query->execute([ 'fecha'=>$reserva['fecha'], 'hora'=>$reserva['hora'], 'cancha'=>$reserva['cancha']  ]);

        return $query;
    }

    //para generar horarios disponibles por fecha
    function validarDisponibilidadActual($item)
    {
        $query = $this->connect()->prepare('Call getAllDisponibilidadHorarios(:cancha, :fecha)');
        $query->execute([ 'cancha'=>$item['cancha'], 'fecha'=>$item['fecha'] ]);
        return $query;
    }

    //insert reserva por llamada
    function registrarReserva($reserva)
    {
        
        $query = $this->connect()->prepare('Call InsertReservacionAdmin 
        (:fecha, :usuarioAd, :usuario, :hora, :cancha, :estado, :tipo)');

        $query->execute([   'fecha'         =>$reserva['fecha'], 
                            'usuarioAd'     =>$reserva['usuarioAd'],
                            'usuario'       =>$reserva['usuario'], 
                            'hora'          =>$reserva['hora'],
                            'cancha'        =>$reserva['cancha'], 
                            'estado'        =>$reserva['estado'], 
                            'tipo'          =>$reserva['tipo']
                        ]);
        return $query;
    }

    //insert usuario por app
    function nuevaReserva($reserva)
    {
        $query = $this->connect()->prepare('Call InsertReservacion(:fecha, :usuario, :hora, :cancha, :estado, :tipo)');

        $query->execute([   'fecha'         =>$reserva['fecha'],
                            'usuario'       =>$reserva['usuario'], 
                            'hora'          =>$reserva['hora'],
                            'cancha'        =>$reserva['cancha'], 
                            'estado'        =>$reserva['estado'], 
                            'tipo'          =>$reserva['tipo']
                        ]);
        return $query;
    }

    
    function validarEstado($reserva)
    {
        $query = $this->connect()->prepare('Call DatosReserva(:numReserva)');
        $query->execute(['numReserva'=>$reserva['numReserva']]);
        return $query;
    }

    function consultaCancelReserva($id)
    {
        $query = $this->connect()->prepare('Call getNumCancelaciones(:id)');
        $query->execute(['id'=>$id]);
        return $query;
    }
    

    function UpdateReserva($reserva)
    {

        $query = $this->connect()->prepare('Call UpdateReservacion(:id, :usuario, :estado, :comentario)');
        $query->execute([   'id'          =>$reserva['id'],  
                            'usuario'     =>$reserva['usuario'], 
                            'estado'      =>$reserva['estado'],
                            'comentario'  =>$reserva['comentario'],
                        ]);        

        return $query;
    }

    function ConsultarReservasRechazadas($reserva)
    {
        $query = $this->connect()->prepare('Call getAllReservasRechazadas(:fecha, :hora, :cancha)');
        $query->execute([   'fecha'         =>$reserva['fecha'], 
                            'hora'          =>$reserva['hora'],
                            'cancha'        =>$reserva['cancha']
                        ]);

        return $query;
    }

    function InsertHistorico($reserva)
    {
        $query = $this->connect()->prepare('Call InsertHistorico(:usuario, :reserva)');
        $query->execute([ 'usuario'=>$reserva['usuario'], 'reserva'=>$reserva['reserva'] ]);

        return $query;
    }

    function ObtenerReservasFecha($reserva)
    {
        $query = $this->connect()->prepare('Call getAllReservacionesFecha(:fecha)');
        $query->execute(['fecha' =>$reserva['fecha']]);

        return $query;
    }

    function ObtenerReservasCancha($id)
    {
        $query = $this->connect()->prepare('Call getAllReservacionesCancha(:cancha)');
        $query->execute([ 'cancha' =>$id ]);

        return $query;
    }

    function ObtenerReservasUsu($reserva)
    {
        $query = $this->connect()->prepare('Call getAllReservacionesUsuario(:usu, :rol)');
        $query->execute([   'usu'  =>$reserva['usuario'],
                            'rol'  =>$reserva['rol']
                        ]);
        return $query;
    }

    function SeguimientoRerserva($id)
    {
        $query = $this->connect()->prepare('Call getAllSeguimientoReserva(:num)');
        $query->execute([ 'num'=>$id]);

        return $query;
    }

    function Notificaciones($id)
    {
        $query = $this->connect()->prepare('Call getAllNotiResera(:num)');
        $query->execute([ 'num'=>$id]);

        return $query;
    }

}
?>