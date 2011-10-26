<?php
include_once ("../include/TBaseModel.inc");

define('INTERDISCIPLINAR_TABLENAME','i_interdisciplinar');
define('IDIOMAS_TABLENAME','i_idioma');
define('QUERY_SELECT_IDIOMA','select codigo, nombre from i_idioma order by nombre');
define('QUERY_SELECT_INTERDISCIPLINAR','select codigo, nombre from i_interdisciplinar order by nombre');

class TMateria extends TBase{
	function load_by_codigo($table, $codigo){
		$query = $this->get_item_as_query($table,'codigo',$codigo);

		if(is_null($this->init($query)))
			return null;
		return true;
	}
}

	function TMateria_find_cod_by_nombre($table, $nombre){
		$bd = new DB_pgsql();
		$bd->conectar();
		$mat = $bd->consultar_unico(sprintf("SELECT codigo FROM $table WHERE nombre = upper('%s') LIMIT 1", pg_escape_string(strtoupper($nombre)) ));
		return $mat;
	}

class TMateriaInterdisciplinar extends TMateria{
	function TMateriaInterdisciplinar_load_by_codigo($codigo){
		return $this->load_by_codigo('i_interdisciplinar', $codigo);
	}
}

	function TMateriaInterdisciplinar_find_by_codigo($codigo){
		$materia = new TMateriaInterdisciplinar();

		if($materia->load_by_codigo($codigo))
			return $materia;
		else
			return null;
	}

	function TMateriaInterdisciplinar_find_by_nombre($nombre){
		$cod_mat = TMateria_find_cod_by_nombre(INTERDISCIPLINAR_TABLENAME, $nombre);
		return TMateriaInterdisciplinar_find_by_codigo($cod_mat);
	}

class TMateriaIdiomas extends TMateria{
	function TMateriaIdiomas_load_by_codigo($codigo){
		return $this->laod_by_codigo('i_idioma', $codigo);
	}
}
	function TMateriaIdiomas_find_by_codigo($codigo){
		$materia = new TMateriaIdiomas();

		if($materia->load_by_codigo($codigo))
			return $materia;
		else
			return null;
	}

	function TMateriaIdiomas_find_by_nombre($nombre){
		$cod_mat = TMateria_find_cod_by_nombre(IDIOMAS_TABLENAME, $nombre);
		return TMateriaIdiomas_find_by_codigo($cod_mat);
	}
?>