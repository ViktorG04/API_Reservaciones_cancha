CREATE DATABASE reservas_utec;
USE reservas_utec;

DROP TABLE IF EXISTS `estado_cancha`;
CREATE TABLE `estado_cancha` (
  `idEstado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `estado_edificio`;
CREATE TABLE `estado_edificio` (
  `idEstado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `estado_historico`;
CREATE TABLE `estado_historico` (
  `idEstado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `estado_reservacion`;
CREATE TABLE `estado_reservacion` (
  `idEstado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `estado_usuario`;
CREATE TABLE `estado_usuario` (
  `idEstado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(10) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `horario_reservacion`;
CREATE TABLE `horario_reservacion` (
  `idHorarioReservacion` int NOT NULL AUTO_INCREMENT,
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  PRIMARY KEY (`idHorarioReservacion`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `rol_usuario`;
CREATE TABLE `rol_usuario` (
  `idRolUsuario` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(20) NOT NULL,
  PRIMARY KEY (`idRolUsuario`),
  UNIQUE KEY `rol_UNIQUE` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tipo_cancha`;
CREATE TABLE `tipo_cancha` (
  `idTipoCancha` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoCancha`),
  UNIQUE KEY `tipo_UNIQUE` (`tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tipo_reservacion`;
CREATE TABLE `tipo_reservacion` (
  `idTipoReservacion` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idTipoReservacion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(12) NOT NULL,
  `nombreCompleto` varchar(50) NOT NULL,
  `dui` varchar(10) NOT NULL,
  `carnet` varchar(12) DEFAULT NULL,
  `correo` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `password` varchar(12) NOT NULL,
  `idRol` int NOT NULL,
  `idEstado` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  UNIQUE KEY `dui_UNIQUE` (`dui`),
  UNIQUE KEY `carnet_UNIQUE` (`carnet`),
  KEY `fk12_idx` (`idRol`),
  KEY `fk13_idx` (`idEstado`),
  CONSTRAINT `fk12` FOREIGN KEY (`idRol`) REFERENCES `rol_usuario` (`idRolUsuario`),
  CONSTRAINT `fk13` FOREIGN KEY (`idEstado`) REFERENCES `estado_usuario` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `edificio`;
CREATE TABLE `edificio` (
  `idEdificio` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `idEstado` int NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `imagen` blob NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  PRIMARY KEY (`idEdificio`),
  KEY `fk14_idx` (`idEstado`),
  CONSTRAINT `fk14` FOREIGN KEY (`idEstado`) REFERENCES `estado_edificio` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `cancha`;
CREATE TABLE `cancha` (
  `idCancha` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `telefonoContacto` varchar(10) NOT NULL,
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  `idEdificio` int NOT NULL,
  `idTipoCancha` int NOT NULL,
  `idEstado` int NOT NULL,
  `imagen` blob,
  `fechaCreacion` datetime NOT NULL,
  PRIMARY KEY (`idCancha`),
  KEY `fk5_idx` (`idEdificio`),
  KEY `fk6_idx` (`idTipoCancha`),
  KEY `fk7_idx` (`idEstado`),
  CONSTRAINT `fk5` FOREIGN KEY (`idEdificio`) REFERENCES `edificio` (`idEdificio`),
  CONSTRAINT `fk6` FOREIGN KEY (`idTipoCancha`) REFERENCES `tipo_cancha` (`idTipoCancha`),
  CONSTRAINT `fk7` FOREIGN KEY (`idEstado`) REFERENCES `estado_cancha` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `reservacion`;
CREATE TABLE `reservacion` (
  `idReservacion` int NOT NULL AUTO_INCREMENT,
  `numReservacion` int NOT NULL,
  `fechayHoraCreacion` datetime NOT NULL,
  `fechaReservacion` date NOT NULL,
  `idUsuario` int NOT NULL,
  `idHorarioReservacion` int NOT NULL,
  `idCancha` int NOT NULL,
  `idEstado` int NOT NULL,
  `idTipoReservacion` int NOT NULL,
  PRIMARY KEY (`idReservacion`),
  UNIQUE KEY `numReservacion_UNIQUE` (`numReservacion`),
  KEY `fk1_idx` (`idEstado`),
  KEY `fk2_idx` (`idHorarioReservacion`),
  KEY `fk3_idx` (`idCancha`),
  KEY `fk4_idx` (`idTipoReservacion`),
  KEY `fk31_idx` (`idUsuario`),
  CONSTRAINT `fk1` FOREIGN KEY (`idEstado`) REFERENCES `estado_reservacion` (`idEstado`),
  CONSTRAINT `fk2` FOREIGN KEY (`idHorarioReservacion`) REFERENCES `horario_reservacion` (`idHorarioReservacion`),
  CONSTRAINT `fk3` FOREIGN KEY (`idCancha`) REFERENCES `cancha` (`idCancha`),
  CONSTRAINT `fk31` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idusuario`),
  CONSTRAINT `fk4` FOREIGN KEY (`idTipoReservacion`) REFERENCES `tipo_reservacion` (`idTipoReservacion`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `historico_reservacion`;
CREATE TABLE `historico_reservacion` (
  `idHistorico` int NOT NULL AUTO_INCREMENT,
  `fechayHoraEvento` datetime NOT NULL,
  `idUsuario` int NOT NULL,
  `idReservacion` int NOT NULL,
  `idEstado` int NOT NULL,
  `comentarios` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idHistorico`),
  KEY `fk9_idx` (`idUsuario`),
  KEY `fk10_idx` (`idReservacion`),
  KEY `fk11_idx` (`idEstado`),
  CONSTRAINT `fk10` FOREIGN KEY (`idReservacion`) REFERENCES `reservacion` (`idReservacion`),
  CONSTRAINT `fk11` FOREIGN KEY (`idEstado`) REFERENCES `estado_historico` (`idEstado`),
  CONSTRAINT `fk9` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `DatosReserva`(in numR int)
BEGIN
	SELECT idReservacion AS idR, E.idEstado AS idE, idUsuario AS usu, fechaReservacion as fecha,
    idCancha as cancha, idHorarioReservacion as hora FROM reservacion
	INNER JOIN estado_reservacion AS E
	ON E.idEstado = reservacion.idEstado 
	WHERE numReservacion = numR;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllCancha`(in _id int, in accion varchar(8))
BEGIN
	IF(_id =0 AND accion = 'listar')
    THEN
		/*listar todas las canchas*/
		SELECT idCancha AS cancha, C.nombre, C.descripcion, telefonoContacto, horaInicio, horaFin,
        C.idEdificio, E.nombre as edificio, C.idTipoCancha, TC.tipo, C.idEstado, estado, C.imagen, C.fechaCreacion
		FROM cancha AS C
		INNER JOIN edificio AS E
		ON E.idEdificio = C.idEdificio
		INNER JOIN tipo_cancha TC
		ON TC.idTipoCancha = C.idTipoCancha
		INNER JOIN estado_cancha 
		ON estado_cancha.idEstado = C.idEstado;
    END IF;
    IF(_id !=0)
    THEN
		IF(accion = 'cancha')
		THEN
			/*listar las canchas por id*/
			SELECT idCancha AS cancha, C.nombre, C.descripcion, telefonoContacto, horaInicio, horaFin, 
            C.idEdificio, E.nombre as edificio, C.idTipoCancha, TC.tipo, C.idEstado, estado, C.imagen, C.fechaCreacion
			FROM cancha AS C
			INNER JOIN edificio AS E
			ON E.idEdificio = C.idEdificio
			INNER JOIN tipo_cancha TC
			ON TC.idTipoCancha = C.idTipoCancha
			INNER JOIN estado_cancha 
			ON estado_cancha.idEstado = C.idEstado
			WHERE idCancha = _id;
		END IF;
        IF(accion = 'edificio')
        THEN
			/*listar las canchas por edificio*/
			SELECT idCancha AS cancha, C.nombre, C.descripcion, telefonoContacto, horaInicio, horaFin, C.idEdificio,
			 E.nombre as edificio, C.idTipoCancha, TC.tipo, C.idEstado, estado, C.imagen, C.fechaCreacion
			FROM cancha AS C
			INNER JOIN edificio AS E
			ON E.idEdificio = C.idEdificio
			INNER JOIN tipo_cancha TC
			ON TC.idTipoCancha = C.idTipoCancha
			INNER JOIN estado_cancha 
			ON estado_cancha.idEstado = C.idEstado
			WHERE E.idEdificio = _id;
        END IF;
        IF(accion = 'tipo')
        THEN
			/*listar las canchas por tipoCancha*/
			SELECT idCancha AS cancha, C.nombre, C.descripcion, telefonoContacto, horaInicio, horaFin, C.idEdificio, E.nombre as edificio, C.idTipoCancha, TC.tipo, C.idEstado, estado, C.imagen, C.fechaCreacion
			FROM cancha AS C
			INNER JOIN edificio AS E
			ON E.idEdificio = C.idEdificio
			INNER JOIN tipo_cancha TC
			ON TC.idTipoCancha = C.idTipoCancha
			INNER JOIN estado_cancha 
			ON estado_cancha.idEstado = C.idEstado
			WHERE TC.idTipoCancha = _id;
        END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllDisponibilidadHorarios`(in cancha int, in fecha date)
BEGIN

	/*Consulta de fechas donde las reservas estan aprobadas*/
	SELECT R.idHorarioReservacion AS Horario
	FROM reservacion AS R
	INNER JOIN horario_reservacion
	ON horario_reservacion.idHorarioReservacion = R.idHorarioReservacion
	INNER JOIN estado_reservacion AS ER
	ON ER.idEstado = R.idEstado
	WHERE R.idEstado = 3 AND idCancha = cancha AND fechaReservacion = fecha;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllDUI`(in id int)
BEGIN
	IF(id = 1)
    THEN	
		SELECT idUsuario, dui FROM usuario WHERE idEstado = 1;
    END IF;
    IF(id = 2)
    THEN
    SELECT idUsuario, dui FROM usuario WHERE idEstado = 1 AND idRol = 3 OR idRol = 2;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllEdificio`(in _id int, in accion varchar(8))
BEGIN
	IF(_id = 0 && accion = "listar")
    THEN
		SELECT edificio.idEdificio, edificio.nombre, direccion, edificio.idEstado, estado, descripcion, 
        imagen, fechaCreacion FROM edificio
		INNER JOIN estado_edificio
		ON estado_edificio.idEstado = edificio.idEstado;

    END IF;
    IF(_id && accion = "buscar")
    THEN
		SELECT edificio.idEdificio, edificio.nombre, direccion, edificio.idEstado, estado, descripcion,
        imagen, fechaCreacion FROM edificio
		INNER JOIN estado_edificio
		ON estado_edificio.idEstado = edificio.idEstado
        WHERE idEdificio = _id;
        
    END IF;
    IF(_id && accion = "eliminar")
    THEN
		DELETE FROM edificio WHERE idEdificio = _id;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllEstadoCancha`(in _idEstado int, in accion varchar(8), in _est varchar(25))
BEGIN
	IF(_idEstado = 0 && accion = "listar")
    THEN
		SELECT * FROM estado_cancha;
    END IF;
    IF(_idEstado && accion = "buscar")
    THEN
		SELECT * FROM estado_cancha WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && accion = "eliminar")
    THEN
		DELETE FROM estado_cancha WHERE idEstado = _idEstado;
	END IF;
    IF(_idEstado && accion = "update")
    THEN
		UPDATE estado_cancha SET estado = _est WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado = 0 && accion = "insertar")
    THEN
		INSERT INTO estado_cancha (estado) VALUES (_est);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllEstadoEdificio`(in _idEstado int, in _accion varchar(8), in _estado varchar(25))
BEGIN
	if(_accion = "listar")
    THEN
		SELECT * FROM estado_edificio;
    END IF;
    IF(_idEstado && _accion = "buscar")
    THEN
		SELECT * FROM estado_edificio WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && _accion = "eliminar")
    THEN
		DELETE FROM estado_edificio WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && _accion = "update")
    THEN
		UPDATE estado_edificio SET estado = _estado
        WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && _accion = "insertar")
    THEN
		INSERT INTO estado_edificio(estado) VALUES (_estado);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllEstadoHistorico`(in _idEstado int, in accion varchar(8), in _est varchar(25))
BEGIN
	IF(_idEstado = 0 && accion = "listar")
    THEN
		SELECT * FROM estado_historico;
    END IF;
    IF(_idEstado && accion = "buscar")
    THEN
		SELECT * FROM estado_historico WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && accion = "eliminar")
    THEN
		DELETE FROM estado_historico WHERE idEstado = _idEstado;
	END IF;
    IF(_idEstado && accion = "update")
    THEN
		UPDATE estado_historico SET estado = _est WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado = 0 && accion = "insertar")
    THEN
		INSERT INTO estado_historico (estado) VALUES (_est);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllEstadoReservacion`(in _idEstado int, in accion varchar(8), in _est varchar(25))
BEGIN
	if(_idEstado = 0 && accion = "listar")
    THEN
		SELECT * FROM estado_reservacion;
    END IF;
    IF(_idEstado && accion = "buscar")
    THEN
		SELECT * FROM estado_reservacion WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && accion = "eliminar")
    THEN
		DELETE FROM estado_reservacion WHERE idEstado = _idEstado;
	END IF;
    IF(_idEstado && accion = "update")
    THEN
		UPDATE estado_reservacion SET estado = _est WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado = 0 && accion = "insertar")
    THEN
		INSERT INTO estado_reservacion (estado) VALUES (_est);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllEstadoUsuario`(in _idEstado int, in accion varchar(8), in _estado varchar(10))
BEGIN
	if(_idEstado = 0 && accion = "listar")
    THEN
		SELECT * FROM estado_usuario;
    END IF;
    IF(_idEstado && accion = "buscar")
    THEN
		SELECT * FROM estado_usuario WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado && accion = "eliminar")
    THEN
		DELETE FROM estado_usuario WHERE idEstado = _idEstado;
	END IF;
    IF(_idEstado && accion = "update")
    THEN
		UPDATE estado_usuario SET estado = _estado WHERE idEstado = _idEstado;
    END IF;
    iF(_idEstado = 0 && accion = "insertar")
    THEN
		INSERT INTO estado_usuario (estado) VALUES (_estado);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllHorarioReservacion`(in _idHorario int, in accion varchar(8))
BEGIN
	if(_idHorario = 0 && accion = "listar")
    THEN
		SELECT * FROM horario_reservacion;
    END IF;
    IF(_idHorario && accion = "buscar")
    THEN
		SELECT * FROM horario_reservacion WHERE idHorarioReservacion = _idHorario;
    END IF;
    iF(_idHorario && accion = "eliminar")
    THEN
		DELETE FROM horario_reservacion WHERE idHorarioReservacion = _idHorario;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllLOGIN`(in _usu varchar(12), in _pass varchar(12))
BEGIN
	SELECT idUsuario, nombreCompleto, usuario, dui, carnet, correo, telefono, password, idRol, rol, 
			usuario.idEstado, estado, fechaCreacion FROM usuario
	INNER JOIN estado_usuario
	ON estado_usuario.idEstado = usuario.idEstado
	INNER JOIN rol_usuario
	ON rol_usuario.idRolUsuario = usuario.idRol
	WHERE usuario = _usu and password = _pass;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllNotiResera`(in num int)
BEGIN
	SELECT numReservacion, fechaReservacion, R.idEstado, estado
	FROM reservacion AS R
	INNER JOIN estado_reservacion AS ER
	ON ER.idEstado = R.idEstado
	WHERE numReservacion >num;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllReservacionesCancha`( in _cancha int)
BEGIN
	IF(_cancha IS NOT NULL AND _cancha !=0)
        THEN
			/*listado de reservaciones filtradas por cancha del ultimo mes*/
			SELECT fechayHoraCreacion, numReservacion, R.idUsuario, nombreCompleto, telefono,fechaReservacion, R.idHorarioReservacion, H.horaInicio, H.horaFin, R.idEstado, estado
			FROM reservacion AS R
			INNER JOIN estado_reservacion
			ON estado_reservacion.idEstado = R.idEstado
			INNER JOIN horario_reservacion AS H
			ON H.idHorarioReservacion = R.idHorarioReservacion
			INNER JOIN usuario
			ON usuario.idUsuario = R.idUsuario
			WHERE R.idCancha = _cancha AND fechayHoraCreacion >= date_sub(curdate(), interval 1 month)
            ORDER BY fechayHoraCreacion desc;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllReservacionesFecha`(in _fechaR date)
BEGIN
        IF(_fechaR IS NOT NULL AND _fechaR !='2020-01-1')
        THEN
			/*listado de todas las reservaciones filtradas por fecha*/
			SELECT fechayHoraCreacion, numReservacion, R.idUsuario, nombreCompleto, telefono,fechaReservacion, R.idHorarioReservacion, 
            H.horaInicio, H.horaFin, R.idCancha, nombre AS cancha, R.idEstado, estado
			FROM reservacion AS R
			INNER JOIN estado_reservacion
			ON estado_reservacion.idEstado = R.idEstado
			INNER JOIN horario_reservacion AS H
			ON H.idHorarioReservacion = R.idHorarioReservacion
			INNER JOIN cancha
			ON cancha.idCancha = R.idCancha 
			INNER JOIN usuario
			ON usuario.idUsuario = R.idUsuario
			WHERE fechaReservacion = _fechaR ORDER BY fechayHoraCreacion asc;
        END IF;
        IF(_fechaR = '2020-01-1')
        THEN
			/*listado de todas las reservaciones del ultimo mes*/
			SELECT fechayHoraCreacion, numReservacion, R.idUsuario, nombreCompleto, telefono,fechaReservacion, R.idHorarioReservacion, 
            H.horaInicio, H.horaFin, R.idCancha, nombre AS cancha, R.idEstado, estado
            FROM reservacion AS R
			INNER JOIN estado_reservacion
			ON estado_reservacion.idEstado = R.idEstado
			INNER JOIN horario_reservacion AS H
			ON H.idHorarioReservacion = R.idHorarioReservacion
			INNER JOIN cancha
			ON cancha.idCancha = R.idCancha 
			INNER JOIN usuario
			ON usuario.idUsuario = R.idUsuario
			WHERE fechayHoraCreacion >= date_sub(curdate(), interval 1 month)
			ORDER BY fechayHoraCreacion desc;
        END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllReservacionesUsuario`(in _usu int, in _rol int)
BEGIN
	IF(_usu IS NOT NULL AND _usu != 0)
        THEN
			IF( _rol = 3)
            THEN
				/*listado de reservaciones creadas por el usuario final*/
				SELECT numReservacion, fechaReservacion, R.idHorarioReservacion, H.horaInicio, H.horaFin, R.idCancha, nombre AS cancha, R.idEstado, estado
				FROM reservacion AS R
				INNER JOIN estado_reservacion
				ON estado_reservacion.idEstado = R.idEstado
				INNER JOIN horario_reservacion AS H
				ON H.idHorarioReservacion = R.idHorarioReservacion
				INNER JOIN cancha
				ON cancha.idCancha = R.idCancha 
				INNER JOIN usuario
				ON usuario.idUsuario = R.idUsuario
				WHERE R.idUsuario = _usu AND idRol = _rol  order by fechaReservacion desc;
            END IF;
            IF(_rol = 1 OR _rol = 2)
            THEN
				/*listado de reservaciones creadas por ADMIN o Asistente*/
				SELECT numReservacion, fechaReservacion, R.idHorarioReservacion, H.horaInicio, H.horaFin, R.idCancha, nombre AS cancha, R.idEstado, estado
				FROM reservacion AS R
				INNER JOIN historico_reservacion HI
				ON HI.idReservacion = R.idReservacion
				INNER JOIN estado_reservacion
				ON estado_reservacion.idEstado = HI.idEstado
				INNER JOIN horario_reservacion AS H
				ON H.idHorarioReservacion = R.idHorarioReservacion
				INNER JOIN cancha
				ON cancha.idCancha = R.idCancha
				INNER JOIN usuario
				ON usuario.idUsuario = HI.idUsuario
				WHERE R.idUsuario = _usu AND idRol = _rol 
                AND fechayHoraCreacion >= date_sub(curdate(), interval 1 month)
				ORDER BY fechayHoraCreacion desc;
			END IF;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllReservasRechazadas`(in fecha date, in hora int, in cancha int)
BEGIN
	SELECT idReservacion AS reserva FROM reservacion WHERE idCancha = cancha AND idHorarioReservacion = hora
    AND fechaReservacion = fecha AND idEstado = 2;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllRolUsuario`(in _idRol int, in accion varchar(8), in _rol varchar(20))
BEGIN
	if(_idRol = 0 && accion = "listar")
    THEN
		SELECT * FROM rol_usuario;
    END IF;
    IF(_idRol && accion = "buscar")
    THEN
		SELECT * FROM rol_usuario WHERE idRolUsuario = _idRol;
    END IF;
    iF(_idRol && accion = "eliminar")
    THEN
		DELETE FROM rol_usuario WHERE idRolUsuario = _idRol;
	END IF;
    IF(_idRol && accion = "update")
    THEN
		UPDATE rol_usuario SET rol = _rol WHERE idRolUsuario = _idRol;
    END IF;
    iF(_idRol = 0 && accion = "insertar")
    THEN
		INSERT INTO rol_usuario (rol) VALUES (_rol);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllSeguimientoReserva`(in _numRe int)
BEGIN
	IF(_numRe IS NOT NULL AND _numRe !=0)
        THEN
			/*seguimiento de una reservacion*/
			SELECT R.fechayHoraCreacion, R.fechaReservacion, numReservacion, (SELECT usuario FROM usuario WHERE idUsuario = HI.idUsuario) AS AdminUsuario, 
            nombreCompleto AS UsuarioFinal, concat(horaInicio, ' - ', horaFin) AS Horario, EH.idEstado, EH.estado,
            comentarios FROM reservacion AS R
			INNER JOIN historico_reservacion AS HI
			ON HI.idReservacion = R.idReservacion
			INNER JOIN estado_historico AS EH
			ON EH.idEstado = HI.idEstado
            INNER JOIN usuario
            ON usuario.idUsuario = R.idUsuario
            INNER JOIN horario_reservacion AS HR
            ON HR.idHorarioReservacion = R.idHorarioReservacion
			WHERE R.numReservacion = _numRe;
        END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllTipoCancha`(in _idTipoCancha int, in _accion varchar(8), in _tipo varchar(20))
BEGIN
	IF(_accion = "listar")
    THEN
		SELECT * FROM tipo_cancha;
    END IF;
    IF(_idTipoCancha && _accion = "buscar")
    THEN
		SELECT * FROM tipo_cancha WHERE idTipoCancha = _idTipoCancha;
    END IF;
    iF(_idTipoCancha && _accion = "eliminar")
    THEN
		DELETE FROM tipo_cancha WHERE idTipoCancha = _idTipoCancha;
    END IF;
    iF(_idTipoCancha && _accion = "update")
    THEN
		UPDATE tipo_cancha SET tipo = _tipo
			WHERE idTipoCancha = _idTipoCancha;
    END IF;
    iF(_accion = "insertar")
    THEN
		INSERT INTO tipo_cancha(tipo) VALUES (_tipo);
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllTipoReservacion`(in _idTipo int, in accion varchar(8))
BEGIN
	IF(_idTipo = 0 && accion = "listar")
    THEN
		SELECT * FROM tipo_reservacion;
    END IF;
    IF(_idTipo && accion = "buscar")
    THEN
		SELECT * FROM tipo_reservacion WHERE idTipoReservacion = _idTipo;
    END IF;
    IF(_idTipo && accion = "eliminar")
    THEN
		DELETE FROM tipo_reservacion WHERE idTipoReservacion = _idTipo;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllUsuario`(in _idUsuario int, in accion varchar(8))
BEGIN
	iF(_idUsuario = 0)
    THEN
		IF(accion = 'listarA')
        THEN
        
			SELECT idUsuario, nombreCompleto, usuario, dui, carnet, correo, telefono, password, U.idRol, 
            rol, U.idEstado, estado, fechaCreacion FROM usuario AS U
			INNER JOIN estado_usuario
			ON estado_usuario.idEstado = U.idEstado
			INNER JOIN rol_usuario
			ON rol_usuario.idRolUsuario = U.idRol 
			ORDER BY idUsuario ASC;
            
        END IF;
        IF(accion = 'listar')
        THEN
			SELECT idUsuario, nombreCompleto, usuario, dui, carnet, correo, telefono, password, U.idRol, 
            rol, U.idEstado, estado, fechaCreacion FROM usuario AS U
			INNER JOIN estado_usuario
			ON estado_usuario.idEstado = U.idEstado
			INNER JOIN rol_usuario
			ON rol_usuario.idRolUsuario = U.idRol 
			WHERE U.idRol = 3 ORDER BY idUsuario ASC;
        END IF;
    END IF;
    IF(_idUsuario !=0 && accion = "buscar")
    THEN
    
		SELECT idUsuario, nombreCompleto, usuario, dui, carnet, correo, telefono, password, U.idRol, 
		rol, U.idEstado, estado, fechaCreacion FROM usuario AS U
		INNER JOIN estado_usuario
		ON estado_usuario.idEstado = U.idEstado
		INNER JOIN rol_usuario
		ON rol_usuario.idRolUsuario = U.idRol 
		WHERE idUsuario = _idUsuario;
        
    END IF;
    iF(_idUsuario !=0 && accion = "eliminar")
    THEN
		
        DELETE FROM usuario WHERE idUsuario=_idUsuario;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getDisponibilidadReserva`(in fecha date, in hora int, in cancha int)
BEGIN
	SELECT count(idReservacion) as var FROM reservacion INNER JOIN horario_reservacion AS H
	ON H.idHorarioReservacion = reservacion.idHorarioReservacion
	WHERE idEstado = 3 AND idCancha = cancha AND fechaReservacion = fecha AND H.idHorarioReservacion = hora;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getEstadoCancha`(in _id int)
BEGIN
	SELECT idEstado AS var FROM cancha WHERE idCancha=_id;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getNumCancelaciones`(in _id int)
BEGIN
	/*conteo de reservaciones canceladas por usuario*/
	SELECT count(idReservacion) AS num FROM reservacion 
	INNER JOIN usuario
	ON usuario.idUsuario = reservacion.idUsuario
	WHERE idRol = 3 AND reservacion.idEstado = 4 AND reservacion.idUsuario = _id;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getValidarCancha`(in _id int, in accion varchar(8))
BEGIN
	IF(_id IS NOT NULL AND _id !=0)
    THEN
		IF(accion = 'eliminar')
		THEN
			/*consulta las canchas que tienen registros de reserva*/
			SELECT count(idReservacion) AS var FROM reservacion
            INNER JOIN cancha
			ON cancha.idCancha = reservacion.idCancha
			WHERE cancha.idCancha =_id;
            
		END IF;
        IF(accion = 'validar')
		THEN
			/*consulta todas las reservaciones aprobadas desde la fecha actual hacia adelante*/
			SELECT count(idReservacion) AS var FROM reservacion AS R
			INNER JOIN cancha AS C
			ON C.idCancha = R.idCancha
			WHERE C.idCancha = _id AND R.idEstado=3 AND fechaReservacion >= curdate();
		END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getValidarEdificio`(in _id int, in accion varchar(8))
BEGIN
	IF(_id IS NOT NULL AND _id !=0)
    THEN
		IF(accion = 'eliminar')
		THEN
			/*consulta las canchas asociadas al edificio*/
			SELECT count(idCancha) AS var FROM cancha INNER JOIN edificio
			ON edificio.idEdificio = cancha.idCancha
			WHERE edificio.idEdificio =_id;
            
		END IF;
        IF(accion = 'validar')
		THEN
			/*consulta todas las reservaciones aprobadas desde la fecha actual hacia adelante*/
			SELECT count(idReservacion) AS var FROM reservacion AS R
			INNER JOIN cancha AS C
			ON C.idCancha = R.idCancha
			INNER JOIN edificio AS E
			ON E.idEdificio = C.idEdificio
			WHERE E.idEdificio = _id AND R.idEstado=3 AND fechaReservacion >= curdate();
		END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getValidarHorario`(in _usuario int, in _fecha date)
BEGIN
	SELECT count(idReservacion) AS var FROM reservacion INNER JOIN usuario
	ON usuario.idUsuario = reservacion.idUsuario 
	WHERE idRol = 3 AND reservacion.idUsuario = _usuario AND fechaReservacion = _fecha;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCancha`(in _nombre varchar(20),in _descripcion varchar(50),
					in _telefono varchar(10), in _horaIn time,in _horaEnd time, in _idEdi int, in _tipo int, 
					in _estado int, in _ima blob)
BEGIN
	INSERT INTO cancha (nombre, descripcion, telefonoContacto, horaInicio, horaFin, idEdificio, idTipoCancha, idEstado, imagen, fechaCreacion)
	
    VALUES (_nombre, _descripcion, _telefono, _horaIn, _horaEnd, _idEdi, _tipo, _estado, _ima, sysdate());
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertEdificio`(in _nom varchar(25), in _dire varchar(50), in _id int, 
								   in _descri varchar(100), in _ima blob)
BEGIN
		INSERT INTO edificio (nombre, direccion, idEstado, descripcion, imagen, fechaCreacion) 
		VALUES (_nom, _dire, _id, _descri, _ima, sysdate());
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertHistorico`(in usu int, in id int)
BEGIN
	/*insert tabla historico*/
	INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
	VALUES(sysdate(), usu, id, 2, 'EXISTE OTRA RESERVACION APROBADA A LA MISMA HORA');
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertHorarioReservacion`(in _horaInicio time, in _horaFin time)
BEGIN
    INSERT INTO horario_reservacion (horaInicio, horaFin) VALUES (_horaInicio, _horaFin);
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertReservacion`(in fecha date, in usuRe int, 
							in hora int, in cancha int, in est int, in tipo int)
BEGIN
    DECLARE contador INT DEFAULT 0;
    
    SET contador = (SELECT idRol FROM usuario WHERE idusuario=usuRe);
    
    IF(contador = 1)
    THEN
		INSERT INTO reservacion(numReservacion, fechayHoraCreacion, fechaReservacion, idUsuario, 
							idHorarioReservacion, idCancha, idEstado, idTipoReservacion)
			VALUES( (SELECT count(H.idEstado)+1 FROM historico_reservacion as H
			INNER JOIN estado_historico
			WHERE estado = 'creado'), sysdate(), fecha, usuRe, hora, cancha, 3, tipo);
	
		/*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usuRe, (select last_insert_id()), 3, '');
        
    END IF;
    IF(contador = 2)
    THEN
		INSERT INTO reservacion(numReservacion, fechayHoraCreacion, fechaReservacion, idUsuario, 
							idHorarioReservacion, idCancha, idEstado, idTipoReservacion)
			VALUES( (SELECT count(H.idEstado)+1 FROM historico_reservacion as H
			INNER JOIN estado_historico
			WHERE estado = 'creado'), sysdate(), fecha, usuRe, hora, cancha, est, tipo);
	
		/*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usuRe, (select last_insert_id()), est, '');
    END IF;
    IF(contador = 3)
    THEN
		INSERT INTO reservacion(numReservacion, fechayHoraCreacion, fechaReservacion, idUsuario, 
							idHorarioReservacion, idCancha, idEstado, idTipoReservacion)
			VALUES( (SELECT count(H.idEstado)+1 FROM historico_reservacion as H
			INNER JOIN estado_historico
			WHERE estado = 'creado'), sysdate(), fecha, usuRe, hora, cancha, est, tipo);
	
		/*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usuRe, (select last_insert_id()), est, '');
		END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertReservacionAdmin`(in fecha date, in usuAd int,in usuRe int, 
							in hora int, in cancha int, in est int, in tipo int)
BEGIN
	DECLARE contador INT DEFAULT 0;
    
    SET contador = (SELECT idRol FROM usuario WHERE idusuario=usuRe);
    
    IF(contador = 1)
    THEN
		INSERT INTO reservacion(numReservacion, fechayHoraCreacion, fechaReservacion, idUsuario, 
					idHorarioReservacion, idCancha, idEstado, idTipoReservacion)
		VALUES( (SELECT count(H.idEstado)+1 FROM historico_reservacion as H
		INNER JOIN estado_historico
		WHERE estado = 'creado'), sysdate(), fecha, usuRe, hora, cancha, 3, tipo);
        
        /*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usuAd, (select last_insert_id()), 3, '');
    END IF;
    IF(contador = 2 or contador = 3)
    THEN
		INSERT INTO reservacion(numReservacion, fechayHoraCreacion, fechaReservacion, idUsuario, 
					idHorarioReservacion, idCancha, idEstado, idTipoReservacion)
		VALUES( (SELECT count(H.idEstado)+1 FROM historico_reservacion as H
		INNER JOIN estado_historico
		WHERE estado = 'creado'), sysdate(), fecha, usuRe, hora, cancha, est, tipo);
        
        /*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usuAd, (select last_insert_id()), est, '');
	END IF;
    
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertTipoReservacion`(in _tipo varchar(20), in _des varchar(50))
BEGIN

	INSERT INTO tipo_reservacion (tipo, descripcion) VALUES (_tipo, _des);
    
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertUsuario`(in _usu varchar(12), in _nom varchar(50), 
in _dui varchar(10), in _carn varchar(12), in _corr varchar(30), in _tele varchar(10), in _pass varchar(12), 
in _rol int, in _estado int)
BEGIN
	
		INSERT INTO usuario(usuario, nombreCompleto, dui, carnet, correo, telefono, password, idRol, idEstado,
        fechaCreacion) 
		VALUES (_usu, _nom, _dui, _carn, _corr, _tele, _pass, _rol, _estado, sysdate());
    
		SELECT usuario, password, fechaCreacion FROM usuario WHERE idUsuario = (select last_insert_id());
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateCancha`(in _idCancha int, in _nombre varchar(20),in _descripcion varchar(50),
				in _telefono varchar(10), in _horaInicio time,in _horaFin time, in _idEdificio int, 
                in _idTipoCancha int, in _idEstado int, in _ima blob)
BEGIN
	IF(_idCancha IS NOT NULL AND _idCancha !=0)
    THEN
		UPDATE cancha SET imagen = _ima WHERE idCancha = _idCancha;
        
        IF (_nombre IS NOT NULL AND _nombre != '')
		THEN
			UPDATE cancha 
			SET nombre 	= _nombre
			WHERE idCancha = _idCancha;
		END IF;
		IF (_descripcion IS NOT NULL AND _descripcion != '')
		THEN
			UPDATE cancha 
			SET descripcion = _descripcion
			WHERE idCancha = _idCancha;
		END IF;
		IF (_telefono IS NOT NULL AND _telefono != '')
		THEN
			UPDATE cancha 
			SET telefonoContacto 	= _telefono
			WHERE idCancha = _idCancha;
		END IF;
			IF (_horaInicio IS NOT NULL AND _horaInicio != '')
		THEN
			UPDATE cancha 
			SET horaInicio = _horaInicio
			WHERE idCancha = _idCancha;
		END IF;
		IF (_horaFin IS NOT NULL AND _horaFin != '')
		THEN
			UPDATE cancha 
			SET horaFin = _horaFin
			WHERE idCancha = _idCancha;
		END IF;
		IF (_idEdificio IS NOT NULL AND _idEdificio != 0)
		THEN
			UPDATE cancha 
			SET  idEdificio = _idEdificio
			WHERE idCancha = _idCancha;
		END IF;
		IF (_idTipoCancha IS NOT NULL AND _idTipoCancha != 0)
		THEN
			UPDATE cancha 
			SET  idTipoCancha = _idTipoCancha
			WHERE idCancha = _idCancha;
		END IF;
		 IF (_idEstado IS NOT NULL AND _idEstado != 0)
		THEN
			UPDATE cancha 
			SET idEstado = _idEstado
			WHERE idCancha = _idCancha;
		END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateEdificio`(in _idEdi int, in _nom varchar(25), in _dire varchar(50), in _id int, 
								   in _descrip varchar(100), in _ima blob)
BEGIN
	IF(_idEdi IS NOT NULL AND _idEdi !=0)
    THEN
		UPDATE edificio SET imagen = _ima WHERE idEdificio = _idEdi;
        
		IF (_nom IS NOT NULL AND _nom != '')
		THEN
			UPDATE edificio
			SET  nombre = _nom
			WHERE idEdificio = _idEdi;
		END IF;
		
		IF (_dire IS NOT NULL AND _dire != '')
		THEN
			UPDATE edificio
			SET  direccion = _dire
			WHERE idEdificio = _idEdi;
		END IF;
		
		IF (_id IS NOT NULL AND _id != '')
		THEN
			UPDATE edificio
			SET  idEstado = _id
			WHERE idEdificio = _idEdi;
            
            UPDATE cancha SET idEstado = _id WHERE idEdificio = _idEdi;
		END IF;
		
		IF (_descrip IS NOT NULL AND _descrip != '')
		THEN
			UPDATE edificio
			SET  descripcion = _descrip
			WHERE idEdificio = _idEdi;
		END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateHorarioReservacion`(in _idHorario int, 
												in _horaInicio time, in _horaFin time)
BEGIN
	IF(_idHorario IS NOT NULL AND _idHorario !=0)
    THEN
		IF (_horaInicio IS NOT NULL AND _horaInicio != '')
		THEN
			UPDATE horario_reservacion 
			SET horaInicio 	= _horaInicio
			WHERE idHorarioReservacion = _idHorario;
		END IF;
		IF (_horaFin IS NOT NULL AND _horaFin != '')
		THEN
			UPDATE horario_reservacion 
			SET horaFin = _horaFin
			WHERE idHorarioReservacion = _idHorario;
		END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateReservacion`(in id int, in usu int, in est int, in comen varchar(100))
BEGIN
	DECLARE fecha DATE;
    DECLARE hora INT DEFAULT 0;
    DECLARE cancha INT DEFAULT 0;
    
    IF(est = 2)
    THEN
		/*update estado reservacion*/
		UPDATE reservacion SET idEstado = est WHERE idReservacion = id;
        
        /*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usu, id, est, '');
    END IF;
    IF(est = 3)
    THEN
		/*primero pasa todas las reservas a rechazadas*/
        SET fecha = (SELECT fechaReservacion FROM reservacion WHERE idReservacion = id);
		SET hora = (SELECT idHorarioReservacion FROM reservacion WHERE idReservacion = id);
		SET cancha = (SELECT idCancha FROM reservacion WHERE idReservacion = id);
        
        UPDATE reservacion SET idEstado = 2 WHERE fechaReservacion = fecha AND idHorarioReservacion = hora AND idCancha = cancha;
        
		/*update estado aprobado*/
		UPDATE reservacion SET idEstado = est WHERE idReservacion = id;
        
         /*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usu, id, est, '');
    END IF;
    IF(est = 4)
    THEN
		/*update estado reservacion*/
		UPDATE reservacion SET idEstado = est WHERE idReservacion = id;
        
        /*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usu, id, est, comen);
    END IF;
    IF(est = 5 or est = 6 or est = 7)
    THEN
		/*update estado reservacion*/
		UPDATE reservacion SET idEstado = est WHERE idReservacion = id;
        
        /*insert tabla historico*/
		INSERT INTO historico_reservacion(fechayHoraEvento, idUsuario, idReservacion, idEstado, comentarios)
		VALUES(sysdate(), usu, id, est, '');
    END IF;
    
    SELECT estado FROM reservacion INNER JOIN estado_reservacion AS E
	ON E.idEstado = reservacion.idEstado  WHERE idReservacion = id;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateTipoReservacion`(in _idTipo int, in _tipo varchar(20), in _des varchar(50))
BEGIN
	IF(_idTipo IS NOT NULL AND _idTipo !=0)
    THEN
		IF (_tipo IS NOT NULL AND _tipo != '')
		THEN
			UPDATE tipo_reservacion
			SET  tipo = _tipo
			WHERE idTipoReservacion = _idTipo;
		END IF;
		
		IF (_des IS NOT NULL AND _des != '')
		THEN
			UPDATE tipo_reservacion 
			SET descripcion = _des
			WHERE idTipoReservacion = _idTipo;
		END IF;
    END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUsuario`(in _id int, in _nom varchar(50), in _carn varchar(12), 
								 in _dui varchar(10), in _corr varchar(30), in _tele varchar(10), 
                                 in _pass varchar(12), in _rol int, in _estado int)
BEGIN
	IF (_id IS NOT NULL AND _id !=0)
    THEN
		IF (_nom IS NOT NULL AND _nom != '')
		THEN
			UPDATE usuario 
			SET nombreCompleto 	= _nom
			WHERE idUsuario = _id;
		END IF;
		IF (_dui IS NOT NULL AND _dui != '')
		THEN
			UPDATE usuario 
			SET dui = _dui
			WHERE idUsuario = _id;
		END IF;
		IF (_carn IS NOT NULL AND _carn != '')
		THEN
			UPDATE usuario 
			SET carnet	= _carn
			WHERE idUsuario = _id;
		END IF;
		IF (_corr IS NOT NULL AND _corr != '')
		THEN
			UPDATE usuario 
			SET correo	= _corr
			WHERE idUsuario = _id;
		END IF;
		IF (_tele IS NOT NULL AND _tele != '')
		THEN
			UPDATE usuario 
			SET telefono	= _tele
			WHERE idUsuario = _id;
		END IF;
		IF (_pass IS NOT NULL AND _pass != '')
		THEN
			UPDATE usuario 
			SET password = _pass
			WHERE idUsuario = _id;
		END IF;
		IF (_rol IS NOT NULL AND _rol != '')
		THEN
			UPDATE usuario 
			SET idRol	= _rol
			WHERE idUsuario = _id;
		END IF;
		IF (_estado IS NOT NULL AND _estado != '')
		THEN
			UPDATE usuario 
			SET idEstado = _estado
			WHERE idUsuario = _id;
		END IF;
    END IF;
END ;;
DELIMITER ;
