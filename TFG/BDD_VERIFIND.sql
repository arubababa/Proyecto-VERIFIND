--creacion de la base de datos llamada: VERIFIND


CREATE TABLE USUARIOS (
  ID_USUARIO    INT NOT NULL AUTO_INCREMENT,
  NOMBRE        VARCHAR(100) DEFAULT NULL,
  EMAIL         VARCHAR(100) UNIQUE,
  TLF           VARCHAR(20),
  PASS          VARCHAR(60) NOT NULL,
  FECHA_ALTA    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID_USUARIO)
);



CREATE TABLE INCIDENCIAS (
  ID_INCIDENCIA       INT NOT NULL AUTO_INCREMENT,
  ID_USUARIO          INT,
  TIPO_INC            VARCHAR(100) DEFAULT NULL,
  TELEFONO_MALICIOSO  VARCHAR(20) DEFAULT NULL,
  MAIL_MALICIOSO      VARCHAR(100),
  IP_MALICIOSO        VARCHAR(100),
  COMENTARIOS         VARCHAR(300),
  PRIMARY KEY (ID_INCIDENCIA),
  FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS(ID_USUARIO)
);


CREATE TABLE REPORTES (
  ID_REPORTE           INT NOT NULL AUTO_INCREMENT,
  MAIL_MALICIOSO       VARCHAR(100),
  TELEFONO_MALICIOSO   VARCHAR(20),
  IP_MALICIOSO        VARCHAR(100),
  NUM_REPORTE          INT,
  TIPO_INC             VARCHAR(100),
  PRIMARY KEY (ID_REPORTE)
);

-- Limpia las tablas si ya tienen datos
DELETE FROM REPORTES;
DELETE FROM INCIDENCIAS;
DELETE FROM USUARIOS;

-- Insertar datos en la tabla USUARIOS, pasada por la interfaz de creacion de usuario para que la contraseña este hasheada
INSERT INTO USUARIOS (NOMBRE, EMAIL, TLF, PASS, FECHA_ALTA) VALUES 

-- Insertar datos en la tabla INCIDENCIAS
INSERT INTO INCIDENCIAS (ID_USUARIO, TIPO_INC, TELEFONO_MALICIOSO, MAIL_MALICIOSO, IP_MALICIOSO) VALUES


--FUNCIONES 
DELIMITER //
CREATE FUNCTION	ContadorReportesMail(mail VARCHAR(100))
RETURNS INT
BEGIN
    DECLARE mailCount INT;
    SET mailCount = (SELECT COUNT(*) FROM INCIDENCIAS WHERE MAIL_MALICIOSO = mail AND TIPO_INC = 'mail');
    RETURN mailCount;
END //
DELIMITER ;

--verificacion
SELECT ContadorReportesMail('example@example.com');



DELIMITER //
CREATE FUNCTION	ContadorReportesTelefono(phone VARCHAR(20))
RETURNS INT
BEGIN
    DECLARE phoneCount INT;
    SET phoneCount = (SELECT COUNT(*) FROM INCIDENCIAS WHERE TELEFONO_MALICIOSO = phone AND TIPO_INC = 'telefono');
    RETURN phoneCount;
END  //
DELIMITER ;

--verificacion
SELECT ContadorReportesTelefono('<tlf_exameple>');




DELIMITER //
CREATE FUNCTION ContadorReportesIP(ip VARCHAR(100))
RETURNS INT
BEGIN
    DECLARE ipCount INT;
    SET ipCount = (SELECT COUNT(*) FROM INCIDENCIAS WHERE IP_MALICIOSO = ip AND TIPO_INC = 'ip');
    RETURN ipCount;
END //
DELIMITER ;

--verificacion
SELECT ContadorReportesIP('<ip_example>');


--PROCEDIMIENTOS
DELIMITER //
CREATE PROCEDURE UpdateReportes()
BEGIN
    DECLARE mail VARCHAR(100);
    DECLARE phone VARCHAR(20);
    DECLARE ip VARCHAR(100);
    DECLARE mailCount, phoneCount, ipCount INT;
    DECLARE done INT DEFAULT 0;
    
    -- Declaración de cursores
    DECLARE mailCursor CURSOR FOR 
    SELECT MAIL_MALICIOSO FROM INCIDENCIAS WHERE TIPO_INC = 'mail' GROUP BY MAIL_MALICIOSO;
    
    DECLARE phoneCursor CURSOR FOR 
    SELECT TELEFONO_MALICIOSO FROM INCIDENCIAS WHERE TIPO_INC = 'telefono' GROUP BY TELEFONO_MALICIOSO;
    
    DECLARE ipCursor CURSOR FOR 
    SELECT IP_MALICIOSO FROM INCIDENCIAS WHERE TIPO_INC = 'ip' GROUP BY IP_MALICIOSO;

    -- Handler para finalizar los cursores
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Procesar reportes por mail
    OPEN mailCursor;
    read_mail: LOOP
        FETCH mailCursor INTO mail;
        IF done THEN 
            LEAVE read_mail; 
        END IF;
        SET mailCount = ContadorReportesMail(mail);
        IF EXISTS (SELECT 1 FROM REPORTES WHERE MAIL_MALICIOSO = mail) THEN
            UPDATE REPORTES SET NUM_REPORTE = mailCount WHERE MAIL_MALICIOSO = mail;
        ELSE
            INSERT INTO REPORTES (MAIL_MALICIOSO, NUM_REPORTE, TIPO_INC) VALUES (mail, mailCount, 'mail');
        END IF;
    END LOOP;
    CLOSE mailCursor;
    SET done = 0; -- Reset done for the next cursor

    -- Procesar reportes por teléfono
    OPEN phoneCursor;
    read_phone: LOOP
        FETCH phoneCursor INTO phone;
        IF done THEN 
            LEAVE read_phone; 
        END IF;
        SET phoneCount = ContadorReportesTelefono(phone);
        IF EXISTS (SELECT 1 FROM REPORTES WHERE TELEFONO_MALICIOSO = phone) THEN
            UPDATE REPORTES SET NUM_REPORTE = phoneCount WHERE TELEFONO_MALICIOSO = phone;
        ELSE
            INSERT INTO REPORTES (TELEFONO_MALICIOSO, NUM_REPORTE, TIPO_INC) VALUES (phone, phoneCount, 'telefono');
        END IF;
    END LOOP;
    CLOSE phoneCursor;
    SET done = 0; -- Reset done for the next cursor

    -- Procesar reportes por IP
    OPEN ipCursor;
    read_ip: LOOP
        FETCH ipCursor INTO ip;
        IF done THEN 
            LEAVE read_ip; 
        END IF;
        SET ipCount = ContadorReportesIP(ip);
        IF EXISTS (SELECT 1 FROM REPORTES WHERE IP_MALICIOSO = ip) THEN
            UPDATE REPORTES SET NUM_REPORTE = ipCount WHERE IP_MALICIOSO = ip;
        ELSE
            INSERT INTO REPORTES (IP_MALICIOSO, NUM_REPORTE, TIPO_INC) VALUES (ip, ipCount, 'ip');
        END IF;
    END LOOP;
    CLOSE ipCursor;
END //
DELIMITER ;


--verificar su existencia
SHOW PROCEDURE STATUS WHERE Db = 'verifind';
--llamada del procedimiento
CALL UpdateReportes();


--EVENTOS
-- Habilitar el programador de eventos (si no está habilitado)
SET GLOBAL event_scheduler = ON;

-- Crear el evento que ejecuta el procedimiento cada una hora
CREATE EVENT EventoUpdateReportes
ON SCHEDULE EVERY 1 HOUR
DO
  CALL UpdateReportes();

-- Verificar que el evento se ha creado
SHOW EVENTS;
