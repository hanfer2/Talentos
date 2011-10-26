<?php

	/**
	 * Verifica si un cadena es nula o de longitud cero.
	 * @param string $str cadena a evaluar
	 * @return bool TRUE si es nula o vacío de lo contrario, FALSE.
	 */
	function is_blank($str) {
	 $str = trim($str);
	 return is_null($str) || strlen($str) < 1;
	}

	/**
	 * Alias de @see strtoupper
	 * @see strtoupper
	 */
	function upper($str) {
	 $str = strtoupper($str);
	 $minusculas = array('á','é','í','ó','ú', 'ñ');
	 $mayusculas = array('Á','É','Í','Ó','Ú', 'Ñ');
	 return str_replace($minusculas,$mayusculas, $str);
	}

	/**
	 * Alias de @see strtolower
	 * @see strtolower
	 */
	function lower($str) {
		$minusculas = array('á','é','í','ó','ú', 'ñ');
	  $mayusculas = array('Á','É','Í','Ó','Ú', 'Ñ');
	  $str = strtolower($str);
	  return str_replace($mayusculas,$minusculas, $str);
	}

	if (!function_exists('lcfirst')) {
		function lcfirst($str) {
			return (string) (strtolower(substr($str, 0, 1)) . substr($str, 1));
		}
	}

	/**
	 * Remueve los acentos de una cadena dada
	 * por sus equivalentes caracteres b�sicos.
	 * @param string $s cadena a tratar
	 * @return string cadena sin acentos.
	 */
	function str_remove_accents($s) {
	 if (is_blank($s))
		return $s;
	 $s = preg_replace("/[á]|(&aacute;)/", "a", $s);
	 $s = preg_replace("/[Á]|(&Aacute;)/", "A", $s);
	 $s = preg_replace("/[Í]|(&Iacute;)/", "I", $s);
	 $s = preg_replace("/[í]|(&iacute;)/", "i", $s);
	 $s = preg_replace("/[é]|(&eacute;)/", "e", $s);
	 $s = preg_replace("/[É]|(&Eacute;)/", "E", $s);
	 $s = preg_replace("/[ó]|(&oacute;)/", "o", $s);
	 $s = preg_replace("/[Ó]|(&Oacute;)/", "O", $s);
	 $s = preg_replace("/[ú]|(&uacute;)/", "u", $s);
	 $s = preg_replace("/[Ú]|(&Uacute;)/", "U", $s);
	 return $s;
	}


	/**
	 *
	 * sprintfn('second: %(second)s ; first: %(first)s', array(
	 *  'first' => '1st',
	 *  'second'=> '2nd'
	 * ));
	 *
	 * @param string $format sprintf format string, with any number of named arguments
	 * @param array $args array of [ 'arg_name' => 'arg value', ... ] replacements to be made
	 * @return string|false result of sprintf call, or bool false on error
	 */
	function sprintfn($format, $args = array()) {
	 // map of argument names to their corresponding sprintf numeric argument value
	 $args = extract_assoc_array($args);

	 $arg_nums = array_slice(array_flip(array_keys(array(0 => 0) + $args)), 1);
	 // find the next named argument. each search starts at the end of the previous replacement.
	 for ($pos = 0; preg_match('/(?<=%)\(([a-zA-Z_]\w*)\)/', $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
		$arg_pos = $match[0][1];
		$arg_len = strlen($match[0][0]);
		$arg_key = $match[1][0];

		// programmer did not supply a value for the named argument found in the format string
		if (!array_key_exists($arg_key, $arg_nums)) {
		 user_error("sprintfn(): Missing argument '${arg_key}'", E_USER_WARNING);
		 return false;
		}

		// replace the named argument with the corresponding numeric one
		$format = substr_replace($format, $replace = $arg_nums[$arg_key] . '$', $arg_pos, $arg_len);
		$pos = $arg_pos + strlen($replace); // skip to end of replacement for next iteration
	 }

	 return vsprintf($format, array_values($args));
	}

	function truncate($string, $max = 20, $replacement = ''){
    if (strlen($string) <= $max){
        return $string;
    }
    $leave = $max - strlen ($replacement);
    return substr_replace($string, $replacement, $leave);
	}

	function is_zero($obj) {
	 return $obj === 0 or $obj === '0';
	}

	function pluralize($count, $singular, $plural, $zero=null) {
	 if ((int) $count === 1)
		return "1 $singular";
	 elseif ((int) $count > 1)
		return "$count $plural";
	 else
		return "$zero";
	}

	function startsWith($haystack, $needle, $case=true) {
	 if ($case) {
		return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
	 }
	 return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
	}

	function endsWith($haystack, $needle, $case=true) {
	 if ($case) {
		return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
	 }
	 return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
	}

	/** Funciones obtenidas de PHP-activerecord */

	/**
	 * Turn a string into its camelized version.
	 *
	 * @param string $s string to convert
	 * @return string
	 */
	function camelize($lowerCaseAndUnderscoredWord) {
	 return lcfirst(str_replace(" ", "", ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord))));
	}

	/**
	 * Determines if a string contains all uppercase characters.
	 *
	 * @param string $s string to check
	 * @return bool
	 */
	function is_upper($s) {
	 return (strtoupper($s) === $s);
	}

	/**
	 * Determines if a string contains all lowercase characters.
	 *
	 * @param string $s string to check
	 * @return bool
	 */
	function is_lower($s) {
	 return (strtolower($s) === $s);
	}

	/**
	 * Convert a camelized string to a lowercase, underscored string.
	 *
	 * @param string $s string to convert
	 * @return string
	 */
	function uncamelize($s) {
	 $normalized = '';

	 for ($i = 0, $n = strlen($s); $i < $n; ++$i) {
		if (ctype_alpha($s[$i]) && is_upper($s[$i]))
		 $normalized .= '_' . strtolower($s[$i]);
		else
		 $normalized .= $s[$i];
	 }
	 return trim($normalized, ' _');
	}

	/**
	 * Convert a string with space into a underscored equivalent.
	 *
	 * @param string $s string to convert
	 * @return string
	 */
	function underscorify($s) {
	 return preg_replace(array('/[_\- ]+/', '/([a-z])([A-Z])/'), array('_', '\\1_\\2'), trim($s));
	}

	/**
	 * Camelize underscored strings
	 * @param string $str underscored string
	 * @return string Camelized underscored string
	 */
	function camelizeUS($str) {
	 // Split string in words.
	 $words = explode('_', strtolower($str));

	 $camelize = '';
	 foreach ($words as $word) {
		$camelize .= ucfirst(trim($word));
	 }

	 return $camelize;
	}

	function zeropad($value, $pad_length) {
	 return str_pad($value, $pad_length, '0', STR_PAD_LEFT);
	}

	function is_distinct($str, $haystack) {
	 $args = func_get_args();
	 $haystack = array_slice($args, 1);
	 foreach ($haystack as $item)
		if ($item == $str)
		 return false;
	 return true;
	}

	function check_utf8($str) {
    $len = strlen($str);
    for($i = 0; $i < $len; $i++){
        $c = ord($str[$i]);
        if ($c > 128) {
            if (($c > 247)) return false;
            elseif ($c > 239) $bytes = 4;
            elseif ($c > 223) $bytes = 3;
            elseif ($c > 191) $bytes = 2;
            else return false;
            if (($i + $bytes) > $len) return false;
            while ($bytes > 1) {
                $i++;
                $b = ord($str[$i]);
                if ($b < 128 || $b > 191) return false;
                $bytes--;
            }
        }
    }
    return true;
  } // end of check_utf8 
  
  
  function toBool($value){
    if(is_bool($value))
      return $value;
    $false_values = array(0, '0','OFF','N','NO');
    return ! in_array(strtoupper($value), $false_values);
  }

?>
