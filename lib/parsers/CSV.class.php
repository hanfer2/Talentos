<?php
/**
 * Clase que permite manipular archivos CSV
 */
class	CSV	{

  /**
   *  Carga un archivo CSV y genera un arreglo con los valores contenidos
   * @param string $filename ruta del archiv
   * @param string $separator separador de datos
   * @return array datos del archivo almacenados como un arreglo
   * @static
   */
	function	load($filename,	$separator=',')	{
		$file	=	fopen($filename,	'r');
		$lines	=	array();
		while	(($data	=	fgetcsv($file,	1000,	$separator))	!==	FALSE)	{
			$lines[]	=	$data;
		}
		fclose($file);
		return	$lines;
	}

	function	save($filename,	$array,	$separator=',')	{
		$file	=	fopen($filename,	'w');
		foreach	($array	as	$line)
			if	(function_exists('fputcsv'))
				fputcsv($file,	$line,	$separator);
			else	{
				$text	=	implode($separator,	$line)	.	"\n";
				if	(fwrite($file,	$text)	===	FALSE)	{
					echo	'CANNOT WRITE <br/>';
					debug($line);
					return	FALSE;
				}
			}
		fclose($file);
	}

}
?>
