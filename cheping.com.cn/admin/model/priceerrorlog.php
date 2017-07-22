<?php
class priceerrorlog extends model{
  
	function __construct(){
		$this->table_name = "import_price_errorlog";
		parent::__construct();
	}

	function getErrorlog($where,$order,$offset,$limit){
		$this->where = $where;
		$this->fields = 'count(*) count';
		$this->total = $this->getResult();
		$this->fields = '*';
		$this->where = $where;
		$this->order = $order;
		$this->offset = $offset;
		$this->limit = $limit;
		$res = $this->getResult(2);
		if($this->total)
			return array('total' => $this->total['count'], 'res' => $res);
		else
			return false;
	}
	function insertErrorLog($ufields) {
		$this->ufields = $ufields;
		$id = $this->insert();
		return $id;
	}
}
?>