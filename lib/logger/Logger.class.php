<?php
	class Logger{

		function log($level, $msg){
			$level = strtoupper($level);
			echo "<div class='logger-$level-msg'><span>(".date('Y-m-d|H:i:s').")[$level]</span> <span>$msg</span></div>";
		}
		
		function debug($msg){
			Logger::log('DEBUG', $msg);
		}
		
		function info($msg){
			Logger::log('INFO', $msg);
		}
		
		function warn($msg){
			Logger::log('WARNING', $msg);
		}
		
		function error($msg){
			Logger::log('ERROR', $msg);
		}
		
		function fatal($msg){
			Logger::log('FATAL', $msg);
		}
		
		function sql($msg){
			Logger::debug("SQL: $msg");
		}
    
    
    function &getDefault(){
      static $logger = null;
      if($logger == null){
        $logger = new Logger();
      }
      return $logger;
    }
    
    function Logger(){
      $this->registered_queries = array();
    }
    
    function register_query($sql){
      $this->registered_queries[] = $sql;
    }
    
	}
?>
