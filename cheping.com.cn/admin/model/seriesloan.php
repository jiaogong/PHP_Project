<?php
class seriesLoan extends model
{
	function __construct()
	{
		parent::__construct();
		$this->table_name = "cardb_series_loan";
	}

	function getSeriesLoan($where,$fields='*',$type=1){
		$this->where = $where;
		$this->fields = $fields;
		return $this->getResult($type);
	}

	#关联车系表信息查询
	function getSeries($where,$fields='*',$type=1,$order=''){
		$this->tables = array(
			'cardb_series_loan' => 'csl',
			'cardb_series' => 'cs'
		);
		$this->fields = $fields;
		$this->where = $where;
		if($order){
			$this->order = $order;
		}
		//$this->limit = $limit;
		return $this->joinTable($type);
	}
}

?>