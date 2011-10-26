<?php
	class SearchParser{
		
		var $str = null;
		var $pieces = null;
		var $results = null;
		
		function SearchParser($str){
			$this->str = $str;
			$pieces = explode(':', $str);
			debug($pieces);
			foreach($pieces as $option){
				debug($option);
				//$this->pieces[$coincidencias['clave']] = $coincidencias['valor'] ;
			}
		}
		
		function getOption($option){
			$pos = preg_split("/[!<>=]]/");
		}
		
		function instance($str){
			static $instance;
			if($instance == null)
				$instance = new SearchParser($str);
			return $instance;
		}
		
		function parse($str){
			if(strpos($str,':') === FALSE)
				return null;
			$parser = SearchParser::instance($str);
			$parser->process();
			return $parser->pieces;
		}
		
		function process(){
			
		}
	}
?>
