<?php

define('CHARSET','UTF-8');
define('DECODER_FUNC','urldecode');
define('SESSION_PARENT_VAR','user');

/** TIPOS DE USUARIO **/
define('COD_TIPO_ROOT', 0);
define('COD_TIPO_ESTUDIANTE', 1);
define('COD_TIPO_DOCENTE', 2);
define('COD_TIPO_MONITOR', 3);
define('COD_TIPO_ADMIN', 4);
define('COD_TIPO_COORDINADOR', 5);
define('COD_TIPO_DIGITA_ICFES', 6);
define('COD_TIPO_VISITANTE_1', 11);

/** TIPOS DE ESTADOS **/
define('COD_ESTADO_ACTIVO',11);
define('COD_ESTADO_INACTIVO',12);
define('COD_ESTADO_EGRESADO',13);
define('COD_ESTADO_ADMITIDO',14);

/** TIPOS DE PRUEBAS ICFES**/
define('I_TIPO_SIMULACRO', 'SIMULACRO');
define('I_TIPO_OFICIAL', 'PRUEBA OFICIAL');

/** FORMATOS DE FECHA **/
define('DATE_FORMAT',"%b %d %Y ");
define('DB_DATE_FORMAT',"Y-m-d");
define('TIMESTAMP_FORMAT',"%a, %b %d %Y - %r");

/** OTROS **/
define('COD_CIUDAD_CALI', '76001');
?>
