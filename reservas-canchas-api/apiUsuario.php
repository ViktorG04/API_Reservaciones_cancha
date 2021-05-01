<?php
    include_once 'Permisos.php';
    include_once 'DBUsuario.php';
    include_once 'creacionUsuario.php';
    include_once 'Mensajes.php';

    class ApiUsuarios                        
    {
        function getAll($item)
        {
            $perm = new permisos();
            $mensaje = new Mensajes_JSON();

            $res = $perm->getRolUsuario($id = $item['id']);
            $row = $res->fetch(); 

            if($row['var'] == 1)
            {
                $this->listarDui($row['var']);
            }
            else if($row['var'] == 2)
            {
                $this->listarDui($row['var']);
            }
            else
            {
                $mensaje->error('No posee permisos');
            }
        }

        function listarDui($id)
        {
            $mensaje = new Mensajes_JSON();
            $usuario = new usuario();
            $usuarios = array(); 

            $res = $usuario->consultarDUI($id);
            $row = $res->fetch(); 
            if($res->rowCount())
            {
               do {
                $item = array(
                    'id'   =>$row['idUsuario'],
                    'dui'  =>$row['dui']
                );
               array_push($usuarios, $item);
               } 
               while ($row = $res->fetch(PDO::FETCH_ASSOC));
               $mensaje->printJSON($usuarios);
            }
            else
            {
               $mensaje->error('No hay elementos seleccionados');
            }
        }

        //consultar usuarios
        function getById($item)
        {
            $perm = new permisos();
            $mensaje = new Mensajes_JSON();

            $res = $perm->getRolUsuario($id = $item['id']);
            $row = $res->fetch(); 

            if($item['accion'] == 'listar')
            {
                if($row['var'] == 1)
                {
                    $item = ['id'=>0, 'accion' => 'listarA'];
                    $this->listarUsuarios($item);
                }
                else if($row['var'] == 2)
                {
                    $item['id'] = 0;
                    $this->listarUsuarios($item);
                }
                else
                {
                    $mensaje->error('No posee permisos');
                }
            }
            else
            {
                $this->listarUsuarios($item);
            }

        }

        //lista todos los datos
        function listarUsuarios($item)
        {
           //creo un objeto de la clase Usuario, donde esta la consulta
           $mensaje = new Mensajes_JSON();
           $usuario = new usuario();
           $usuarios = array();

           $res = $usuario->obtenerUsuarios($item);

           if($res->rowCount())
           {
               while($row = $res->fetch(PDO::FETCH_ASSOC))
               {  
                    $item = array(
                        'id'            =>$row['idUsuario'],
                        'nombre'        =>$row['nombreCompleto'],
                        'usuario'       =>$row['usuario'],
                        'dui'           =>$row['dui'],
                        'carnet'        =>$row['carnet'],
                        'correo'        =>$row['correo'],
                        'telefono'      =>$row['telefono'],
                        'password'      =>$row['password'],
                        'idRol'         =>$row['idRol'],
                        'rol'           =>$row['rol'],
                        'idEstado'      =>$row['idEstado'],
                        'estado'        =>$row['estado'],
                        'fechaCreacion' =>$row['fechaCreacion']
                    );
                   array_push($usuarios, $item);
               }
               $mensaje->printJSON($usuarios);
           }
           else
           {
               $mensaje->error('No hay elementos seleccionados');
           }
        }

       //registrar nuevo usuario
       function add($item)
       {
           $usuario = new usuario();
           $creacion = new CrearUsuario();
           $mensaje = new Mensajes_JSON();

           //validar el dui a registrar
           $res = $usuario->validarDUI($item);
           $row = $res->fetch();
           if($row['var'] != 0)
           {
                $mensaje->error('ERROR el DUI ya existe!');
           }
           else
           {    
               //validar el carnet a registrar
                $res = $usuario->validarCarnet($item);
                $row = $res->fetch();
                if($row['var'] != 0)
                {
                    $mensaje->error('ERROR el carnet ya existe!');
                }
                else
                {
                    //estado activo por defecto
                    $item['estado'] = 1;

                    //crear usuario apartir del nombre
                    $creacion->generarUsuario($item['nombre']);
                    $nuevousuario = $creacion->registrarUsuario();
                    $item['usuario'] = $nuevousuario;

                    //generar password
                    $this->generarPassword();
                    $item['password'] = $this->psswd;
                        
                    //registrar los datos en la base
                    $res = $usuario->nuevoUsuario($item);
                    $usuarios = array();
                        
                    //mostrar datos del usuario creado
                    if($res->rowCount() == 1)
                    {
                        $row = $res->fetch();
        
                        $item = array(
                            'usuario'       =>$row['usuario'],
                            'password'      =>$row['password'],
                            'fechaCreacion' =>$row['fechaCreacion']
                        );
                        array_push($usuarios, $item);
                        
                        $mensaje->printJSON($usuarios);
                    }
                }
           }
       }


         //actualizar datos usuario administrador
         function update($item)
         {
            $perm = new permisos();
            $usuario = new usuario();
            $mensaje = new Mensajes_JSON();

            $e = strlen($item['password']);
            if($e < 8 or $e > 12)
            {
                $mensaje->error('La longitud del password debe estar entre 8 y 12');
            }
            else
            {
                $i = count($item);
                if($i != 3)
                {   
                    $this->updateDUi($item);
                    $bandera = $this->i;
                    $this->updateCarnet($item);
                    $bandera2 = $this->e;
                    if($bandera !=1 && $bandera2 !=1)
                    {   
                        //rol del usuario a actualizar
                        $res = $perm->getRolUsuario($id = $item['id']);
                        $row = $res->fetch(); 
                        $RolU = $row['var'];

                        //rol del usuario que actualiza
                        $res = $perm->getRolUsuario($id = $item['usuloguedo']);
                        $row = $res->fetch(); 
                        $rolA = $row['var'];

                        if($RolU == 3 && ($rolA == 1 or $rolA == 2))
                        {
                            $res = $usuario->actualizarUsuario($item);
                            $mensaje->exito('Datos actualizados');
                            
                        }
                        else if ($RolU == 2 && $rolA == 1)
                        {
                            $res = $usuario->actualizarUsuario($item);
                            $mensaje->exito('Datos actualizados');
                            
                        }
                        else if ($RolU == 1 && $rolA == 1)
                        {
                            $res = $usuario->actualizarUsuario($item);
                            $mensaje->exito('Datos actualizados');
                            
                        }
                        else
                        {
                            $mensaje->error('No tiene permisos de edicion');
                        }
                    }
                }
                else
                {   
                    $res = $usuario->modificarDatos($item);
                    $mensaje->exito('Datos actualizados');
                }
            } 
         }
         

         //eliminar usuario
         function delete($id)
         {
             $mensaje = new Mensajes_JSON();
             $usuario = new usuario();
             //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
             $res = $usuario->validarUsuarioID($id);
             
             $row = $res->fetch();
             //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
             if($row['cantidad'] == 0)
             {
                 $res = $usuario->eliminarUsuario($id);
                 $mensaje->exito('Datos eliminados con exito');
             }
             else
             {
                 $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
             }
             
         }

         //funcion login
         function getAllUser($item)
         {
             //creo un objeto de la clase Usuario, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $usuario = new usuario();

            $usuarios = array();
            $res = $usuario->loginUsuario($item);
            
            if($res->rowCount() != 0)
            {
                $row = $res->fetch();

                if($row['idEstado'] == 1)
                {
                    $item = array(
                        'id'            =>$row['idUsuario'],
                        'nombre'        =>$row['nombreCompleto'],
                        'usuario'       =>$row['usuario'],
                        'dui'           =>$row['dui'],
                        'carnet'        =>$row['carnet'],
                        'correo'        =>$row['correo'],
                        'telefono'      =>$row['telefono'],
                        'password'      =>$row['password'],
                        'idRol'         =>$row['idRol'],
                        'rol'           =>$row['rol'],
                        'idEstado'      =>$row['idEstado'],
                        'estado'        =>$row['estado'],
                        'fechaCreacion' =>$row['fechaCreacion']
                    );
                    array_push($usuarios, $item);
                    
                    $mensaje->printJSON($usuarios);
                }
                else
                {
                    $mensaje->error('Usuario Inactivo');
                }
            }
            else
            {
                $mensaje->error('Usuario o password incorrectos');
            }
         }

         
        function updateDUi($item)
        {
            $mensaje = new Mensajes_JSON();
            $usuario = new usuario();
            $var = ['id' => $item['id'], 'accion'=>'buscar'];
            $res = $usuario->obtenerUsuarios($var);
            $row = $res->fetch();

            if($row['dui'] != $item['dui'])
            {
                $res = $usuario->validarDUI($item);
                $row = $res->fetch();
                if($row['var'] != 0)
                {
                    $mensaje->error('ERROR el DUI ya existe!');
                    $i = 1;
                }
                else
                {
                    $i = 0;
                }
            }
            else
            {
                $i = 0;
            }
            $this->i = $i;
        }

        function updateCarnet($item)
        {
            $mensaje = new Mensajes_JSON();
            $usuario = new usuario();
            $var = ['id' => $item['id'], 'accion'=>'buscar'];
            $res = $usuario->obtenerUsuarios($var);
            $row = $res->fetch();

            if($row['carnet'] != $item['carnet'])
            {
                $res = $usuario->validarCarnet($item);
                $row = $res->fetch();
                if($row['var'] != 0)
                {
                    $mensaje->error('ERROR el carnet ya existe!');
                    $e = 1;
                }
                else
                {
                    $e = 0;
                }
            }
            else
            {
                $e = 0;
            }
            $this->e = $e;
        }
         
         //generar password aleatorio por defecto
        function generarPassword()
        {
            $longitud = 8;
            $psswd = substr( md5(microtime()), 1, $longitud);
            $psswd = strtoupper($psswd);

            $this->psswd = $psswd;
        }
    }
?>