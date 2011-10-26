<?php
	include_once("TBaseModel.inc");

	define('QUERY_SELECT_PERIODO','SELECT codigo, nombre from a_periodo ORDER BY codigo DESC');
	class TPeriodo extends TBase{
		var $tablename = 'a_periodo';
		function load_by_codigo($codigo){
			return $this->load('a_periodo', 'codigo', $codigo);
		}

		function actual(){
			$bd= DB_new();
			$query = "select max(codigo) from a_periodo";
			return $bd->consultar_unico($query);
		}

		function nombre($codigo){
			$bd= DB_new();
			$query = "select nombre from a_periodo where codigo = '$codigo'";
			return $bd->consultar_unico($query);
		}

		function descripcion($codigo){
			$bd= DB_new();
			$query = "select descripcion from a_periodo where codigo = '$codigo'";
			return $bd->consultar_unico($query);
		}

		function load($codigo){
			$bd= DB_new();
			$query = "select * from a_periodo where codigo = '$codigo'";
			return $bd->fetch_array($query);
		}

        function query_select($cod_programa=null){
            if(is_blank($cod_programa))
              $cod_programa = " ( SELECT codigo FROM a_programa ORDER BY codigo DESC LIMIT 1 )";
            return "SELECT codigo, nombre FROM a_periodo WHERE codigo IN (
                            SELECT cod_periodo FROM a_periodos_programas WHERE cod_programa = $cod_programa) ORDER BY codigo DESC ";

        }
	}

		function TPeriodo_find_by_codigo($codigo){
			$periodo = new TPeriodo();
			if($periodo->load_by_codigo($codigo))
				return $periodo;
			return null;
		}
?>