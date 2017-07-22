<?php
class priceerrorlogAction extends action{
	function __construct(){
		parent::__construct();
		 $this->priceerrorlog = new priceerrorlog();
	}

	function doDefault(){
		$limit = 30;
        $page = max(1, intval($_GET['page']));
        $offset = ($page - 1) * $limit;
		$allErrorlog = $this->priceerrorlog->getErrorlog('type = 0',array('id' => 'desc'),$offset,$limit);
		if($allErrorlog){
            $page_bar = $this->multi($allErrorlog['total'], $limit, $page, 'index.php?action=priceerrorlog&page=' . $page);
			$this->tpl->assign('allerrorlog', $allErrorlog['res']);
			$this->tpl->assign('total',$allErrorlog['total']);
			$this->tpl->assign('page_bar', $page_bar);
		}
		$this->template('priceerrorlog');
	}

	function doSearch(){
		$creator = $_POST['creator'] ? $_POST['creator'] : $_GET['creator'];
		if($_GET['time1']){
			$getTime1 = $_GET['time1'];
		}else{
			$getTime1 = strtotime($_POST['get_time1'] . $_POST['timeh1'] . $_POST['timei1'] . $_POST['times1']);
		}
		if($_GET['time2']){
			$getTime2 = $_GET['time2'];
		}else{
			$getTime2 = strtotime($_POST['get_time2'] . $_POST['timeh2'] . $_POST['timei2'] . $_POST['times2']);
		}
		$where = "type = 0 AND creator='$creator'";
		if($getTime1 && $getTime2){
			$where .= " and created between $getTime1 and $getTime2";
		}
		$limit = 30;
        $page = max(1, intval($_GET['page']));
        $offset = ($page - 1) * $limit;
		$allErrorlog = $this->priceerrorlog->getErrorlog($where,array('id' => 'desc'),$offset,$limit);
		if($allErrorlog){
            $page_bar = $this->multi($allErrorlog['total'], $limit, $page, 'index.php?action=priceerrorlog-search&creator=' . $creator . '&time1=' . $getTime1 . '&time2=' . $getTime2);
			$this->tpl->assign('allerrorlog', $allErrorlog['res']);
			$this->tpl->assign('page_bar', $page_bar);
			$this->tpl->assign('creator', $creator);
		}
		$this->template('priceerrorlog');
	}
}
?>