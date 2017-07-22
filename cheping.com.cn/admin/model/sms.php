<?php
/**
* cntv article interface
* $Id: sms.php 448 2015-08-07 15:26:23Z xiaodawei $
*/

class sms extends model{
  var $type = array(
        '用户名'=>'name',
        '车主姓名'=>'demander',
        '订单号'=>'order_num',
        '购车码'=>'buyinfo_num',
        '购车有效期截止时间'=>'endtime',
        '验证有效期截止时间'=>'endtime2',
        '团购时间' => 'grouptime',
        '品牌' => 'brand_name',
        '厂商' => 'factory_name',
        '车系' => 'series_name',
        '车款' => 'model_name',
        '价格' => 'bingo_price',
        '经销商名称'=>'dealer_name',
        '经销商地址'=>'dealer_area',
        '店内负责人'=>'link_man',
        '联系电话'=>'link_tel',
        '优惠金额' => 'promo_price',
        '优惠码' => 'promo_code',
        '优惠码过期时间' => 'promo_endtime',
        '定金金额' => 'earnest',
        '首选颜色' => 'first_color',
        '备选颜色' => 'second_color',
        '身份证号' => 'id_card',
        '成交价' => 'transaction_price',
        '尾款' => 'final_payment',
        '提车验证码' => 'getcar_code',
        '提车截止时间' => 'getcar_endtime',
        '提车时间' => 'getcar_time',
        '找回密码' => 'get_code',
        '注册验证码' => 'reg_code'
    );

  function __construct(){
    $this->table_name = "cardb_smstpl";
    parent::__construct();
  }

  function getSms($file="*",$where="1",$order=array(),$offset=0,$limit=0){
      $this->fields = "count(id)";
      $this->where = $where;
      $this->total = $this->getResult(3);
      
      $this->fields = $file;
      $this->order = $order;
      $this->offset = $offset;
      $this->limit = $limit;
      $result = $this->getResult(2);
      return $result;
  }
  function getSmsContent($title) {
      $this->fields = 'content';
      $this->where = "title = '$title'";
      $content = $this->getResult(3);
      return $content;
  }

  function getSmsbyid($id, $state=1){
      $this->fields = "*";
      $this->where = "id='$id'" . ($state ? " and state in ({$state})" : "");
      return $this->getResult(1);
  }

}
?>