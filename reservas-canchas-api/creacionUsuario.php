<?php

    include_once 'DBUsuario.php';

    class CrearUsuario
    {
        public $usuario;
        public $nombre;
        public $apellido;

        //Funcion que generar el primer usuario por defecto
        function generarUsuario($nombreCompleto)
        {   
            $arrayUsuario = explode(" ", $nombreCompleto);
            $tamanio = count($arrayUsuario);

            $nombre = $arrayUsuario[0];
            $this->nombre = $nombre;

            if($tamanio == 1)
            {
                $usuario = $arrayUsuario[0];
            }
            else
            {
                $usuario = $nombre[0];
                if($tamanio == 2)
                {
                    $apellido = $arrayUsuario[1];
                    $usuario .= $apellido;
                    $this->apellido = $apellido;
                }
                else if($tamanio == 3 or $tamanio == 4)
                {
                    $apellido = $arrayUsuario[2];
                    $usuario .= $apellido;
                    $this->apellido = $apellido;
                }
                else if($tamanio == 5 or $tamanio == 6)
                {
                    for($i=2; $i < $tamanio-1; $i++)
                    {
                        if(strlen($arrayUsuario[$i]) > 2)
                        {
                           $apellido = $arrayUsuario[$i];
                        }
                    }
                    $usuario .= $apellido;
                    $this->apellido = $apellido;
                }

            }
            $this->usuario = $usuario;
        }

        //hacemos una consulta para obtener el total de los usuarios que tengan el mismo nombre
        function totalNombreRegistrado()
        {
            $nombre = $this->nombre;
            $nombre =$nombre.'%';
            $dbusuario = new Usuario();

            $res = $dbusuario->contarUsuarioNombre($nombre);
            $row = $res->fetch();
            $total = $row['cantidad'];
            return $this->total = $total;
        }

       //segunda funcion que genera al usuario despues que lo retorna compara los caractes repetidos y toma uno nuevo
        function generarUsuario2($usuario)
        {
            $nombre = $this->nombre;
            $apellido = $this->apellido;

            if($nombre == $usuario)
            {
                $nombre .=1;
                $usuario = $nombre;
            }
            else
            {
                for($e=0; $e<strlen($nombre); $e++)
                    {
                        if($nombre[$e] == $usuario[$e])
                        {
                            $posicion++;
                        }
                    }

                    $posicion +=1;
                    $usuario="";

                    for($a=0; $a<$posicion; $a++)
                    {
                        $usuario .= $nombre[$a];
                    }
                    $usuario .=$apellido;
            }
            return $this->usuario = $usuario;
        }

        //La funcion que convina las 3 primeras para generar dinamicamente a partir de una consulta a la DB el usuario
        function registrarUsuario()
        {
            $dbusuario = new Usuario();

            $contador = $this->totalNombreRegistrado();

            $usuario = $this->usuario;

           if($contador == 0)
           {
              $usuario;
           }
           else
           {
               do{
                   $res = $dbusuario->validarUsuario($usuario);
                   $row = $res->fetch();
       
                   if($row['usuario'] == $usuario)
                   {
                     $this->generarUsuario2($usuario);
                    $usuario =  $this->usuario;
                   }
                   $contador--;  
           
               }while($contador>0);
       
           }
           return $this->usuario = $usuario;
        }
    }
?>