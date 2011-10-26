<?php
  require_once 'TBaseModel.inc';
  

  class TEstado extends TBase{
		
		function __construct(){
			parent::__construct();
			$this->tablename = $this->Config->Get(__CLASS__);
		}
		
    function get($codigo, $select, $options=array()){
			$Model = null;
			if(!is_a($this, __CLASS__ ))
				$Model = new TEstado();
			else
				$Model = $this;
			$sql = "SELECT $select FROM {$Model->tablename} WHERE codigo = $codigo";
			return $Model->db->fetchOne($sql);
    }

    function nombre($codigo) {
     return TEstado::get($codigo, 'nombre');
    }
    
    function toArray(){
			return parent::toArray(__CLASS__);
		}
  }
?>
