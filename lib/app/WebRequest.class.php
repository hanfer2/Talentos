<?php 
  /**
   * Representa una solicitud enviada al servidor.
   * 
   * Ofrece métodos utiles asociados a cada request enviado al Servidor.
   */
  class WebRequest {
    
    /**
     * Retorna el metodo empleado por el Request.
     * @return string POST o GET
     */
    function getMethod(){
      return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Indica si la solicitud es enviada a traves de XMLHttpRequest (Ajax)
     * @return boolean TRUE si por medio de Ajax, FALSE de lo contrario.
     */
    function isXHR(){
      return	(isset($_SERVER['HTTP_X_REQUESTED_WITH'])	&&	$_SERVER['HTTP_X_REQUESTED_WITH']	==	'XMLHttpRequest') ? TRUE: FALSE;
    }
    
    /**
     * Indica si el metodo empleado por el Request es POST
     * @return boolean TRUE si la solicitud es enviada empleando POST, de lo contrario, FALSE
     * 
     * @see WebRequest::getMethod
     */
    function isPOST(){
      return $this->getMethod() == 'POST';
    }
    
    /**
     * Indica si el metodo empleado por el Request es GET
     * @return boolean TRUE si la solicitud es enviada empleando GET, de lo contrario, FALSE
     * 
     * @see WebRequest::getMethod
     */
    function isGET(){
      return $this->getMethod() == 'GET';
    }
    
    function _sanitize($params){
      unset($params['controlador'], $params['accion']);
      return $params;
    }
    
    /**
     * 
     */
    function getAllParams(){
      return $this->_sanitize($_REQUEST);
    }
    
    function getPostParams(){
      return $this->_sanitize($_POST);
    }
    
    function getGetParams(){
      return $this->_sanitize($_GET);
    }
    
    function getPostParam($param){
      return $this->_sanitize($_POST[$param]);
    }
    
    function getGetParam($param){
      return $this->_sanitize($_GET[$param]);
    }
    
    function hasParam($param){
      return isset($_REQUEST[$param]);
    }
    
    function getParam($param, $default = null){
      $r = $this->_sanitize($_REQUEST[$param]);
      return ($r == null)? $default: $r; 
    }
    
    
    function getFiles(){
      return $_FILES;
    }
    
    function getFile($name){
      return $_FILES[$name];
    }
    
  }
?>
