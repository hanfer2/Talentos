<?php 

    /**
     * Representa al Usuario Registrado en el Sistema.
     */

    class AppUser {
      /**
       * @var $attributes array listado de atributos del usuario.
       */
      var $attributes = null;
      
      /**
       * @var $credentials array listado de credenciales del usuario,
       * que permitiran definir si tiene permisos de acceder a algun recurso.
       */
      var $credentials = array();
      
      function AppUser(){
        $this->__userInfo = $_SESSION[SESSION_PARENT_VAR];
        $this->_autoloadCredentials();
      }
      
      function _autoloadCredentials(){
        $filename = "credentials.ini";
        $filepath = AppConst::get("siat_configs_dir").$filename;
        
        if(!file_exists($filepath)){
          return false;
        }
        
        $credentials = parse_ini_file($filepath);
        foreach($credentials as $credential=>$cedulas){
          if($this->in(explode(",",$cedulas))){
            $this->addCredential($credential);
          }
        }
      }
      
      /**
       * Retorna el atributo indicado
       * @param string $name nombre del atributo
       * @param mixed  $default valor a retornar en caso de no tener definido el atributo
       * @return mixed valor del atributo indicado.
       */
      function getAttribute($name, $default=null){
         return !isset($this->attributes[$name]) ? $default: $this->attributes[$name];
      }
      
      /**
       * Define y asigna un atributo al usuario
       * @param $name string nombre del atributo
       * @param $value mixed valor del atributo
       */
      function setAttribute($name, $value){
        $this->attributes[$name] = $value;
      }
      
      /**
       * Agrega una credencial al usuario
       * @param $credential string nombre de la credencial a agregar
       */
      function addCredential($credential){
        $this->credentials[] = $credential;
      }
      
      /**
       * Remueve una credencial al usuario
       * @param $credential string nombre de la credencial a remover
       */
      function removeCredential($credential){
        array_remove_item($this->credentials, $credential);
      }
      
      /**
       * Retorna el valor de uno de los campos del usuario
       * @param string $field nombre del campo
       * @return int|string valor del campo especificado
       */
      function get($field){
        return $this->__userInfo[$field];
      }
      
      /**
       * Retorna el codigo interno del usuario
       * @return int Codigo Interno del Usuario.
       */
      function getId(){
        return $this->get('cod_interno');
      }
      
      /**
       * Retorna el codigo del rol del usuario
       * @return int Rol del Usuario.
       */
      function getRoleId(){
        return $this->get('cod_tipo_persona');
      }
      
      /**
       * Retorna la cedula del usuario
       * @return int Cedula del Usuario.
       */
      function getCedula(){
        return $this->get('cedula');
      }
      
      /**
       * Verifica si el usuario posee uno de los roles indicados.
       * @return bool TRUE si el usuario posee el rol indicado; de lo contrario, FALSE
       */
      function is(){
        $roles_id = func_get_args();
        $role_id = $this->getRoleId();
        return in_array($role_id, $roles_id);
      }
      
      /**
       * Verifica si el usuario está enmascarado. 
       * Es decir, esta empleando la funcionalidad de estar registrado como otro usuario.
       * @return bool TRUE si hay otro usuario de fondo; de lo contrario, FALSE
       */
      function isBgUser(){
        return $this->__userInfo['bg_user'] != null;
      }
      
      /**
       * Valida si el usuario registrado es ROOT
       */
      function isRoot(){
        return $this->is(COD_TIPO_ROOT);
      }
      
      
      /**
       * Valida si el usuario registrado es SUPER ADMINISTRADOR (ROOT | ADMIN)
       */
      function isSuperAdmin(){
        return $this->is(COD_TIPO_ROOT, COD_TIPO_ADMIN);
      }
      
      /**
       * Valida si el usuario registrado es MONITOR
       */
      function isMonitor(){
        return $this->is(COD_TIPO_MONITOR);
      }
      
      /**
       * Valida si el usuario registrado es ADMINISTRADOR (ROOT | ADMIN | MONITOR)
       */
      function isAdmin(){
        return $this->isSuperAdmin() || $this->isMonitor();
      }
      
      
      /**
       * Valida si el usuario registrado es DOCENTE
       */
      function isTutor(){
        return $this->is(COD_TIPO_DOCENTE);
      }
      
      /**
       * Valida si el usuario registrado es ESTUDIANTE
       */
      function isStudent(){
        return $this->is(COD_TIPO_ESTUDIANTE);
      }
      
      /**
       * Valida si el usuario registrado es COORDINADOR
       */
      function isCoordinator(){
        return $this->is(COD_TIPO_COORDINADOR);
      }
      
      /**
       * Valida si el usuario registrado es DIGITA_ICFES
       */
      function isIcfesTyper(){
        return $this->is(COD_TIPO_DIGITA_ICFES);
      }
      
      /**
       * Valida si el usuario registrado es VISITANTE
       */
      function isVisitor1(){
        return $this->is(COD_TIPO_VISITANTE_1);
      }
      
      /**
       * Verifica si el usuario posee la credencial indicada
       * @param $credential string credencial a buscar
       * @return bool
       */
      function hasCredential($credential){
        if($this->isRoot())
          return true;
        return in_array($credential,$this->credentials);
      }
      
      /**
       * Valida si una cedula o rol, pertenece al usuario.
       * @param mixed $cedula_or_role cedula o rol a buscar. 
       * @return bool TRUE si alguna de las cedulas o roles indicados pertenecen al usuario.
       */
      function in($cedula_or_role){
        $args = $cedula_or_role;
        if(!is_array($args))
          $args = func_get_args();
        
        foreach($args as $arg){
          $arg = upper(trim($arg));
          if($arg == 'NONE')
            return false;
          if(is_numeric($arg) && $this->cedulaIn($arg))
            return true;
          $role = 'COD_TIPO_'.$arg;
          if(!defined($role))
            continue;
          $role_id = constant($role);
          if($this->is($role_id))
            return true;
        }
        return false;
      }
      
       /**
       * Valida si la cedula indicada pertenece al usuario.
       * @return bool TRUE si alguna de las cedulas indicadas pertenece al usuario.
       */
      function cedulaIn($cedulas){
        $args = $cedulas;
        if(!is_array($args))
          $args = func_get_args();
        $args = array_map('trim',$args);
        return in_array($this->getCedula(), $args);
      }
            
    }
?>
