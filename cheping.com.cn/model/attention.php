<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class attention extends model {

    function __construct() {
        $this->table_name = "cardb_attention";
        parent::__construct();
//配置小图标
        $this->pz_img = array(
            'ssn' => array(
                'st98' => '泊车辅助',
                'st97' => '定速巡航',
                'st95' => '多功能方向盘',
                'st74' => '感应钥匙',
                'st75' => '手动模式',
                'st86' => '天窗',
                'st100' => '行车电脑',
                'st102' => '真皮座椅',
                'st171' => '自动空调',
                'st112' => '座椅电加热',
                'st150' => '自动头灯',
                'st107' => '座椅方向调节'
            ),
            'aqn' => array(
                'st80' => '车身稳定控制',
                'st148' => '氙灯',
                'st69' => '胎压监测',
                'qinang' => '安全气囊'
            ),
            'ss' => array(
                'st98' => 'bcfz',
                'st97' => 'dsxh',
                'st95' => 'dgnfxp',
                'st74' => 'gyys',
                'st75' => 'sdms',
                'st86' => 'tch',
                'st100' => 'xcdn',
                'st102' => 'zpzy',
                'st171' => 'zdkt',
                'st112' => 'zydjr',
                'st107' => 'zyfxtj',
                'st150' => 'xq'
            ),
            'aq' => array(
                'st80' => 'aqqn',
                'st148' => 'cswdkz',
                'st69' => 'tyjc',
                'qinang' => 'zdtd'
            )
        );
    }

    function insertAttention($ufields) {
        $this->ufields = $ufields;
        $id = $this->insert();
        return $id;
    }

    function getAttentionModel($uidList, $type_id, $st4) {
        $this->table_name = 'cardb_model cm';
        $this->tables = array('cardb_attention' => 'ca');
        $this->fields = 'cm.*, IF(bingo_price>0,bingo_price,dealer_preice_low) as bingobang_price';
        $this->join_condition = array("cm.model_id = ca.model_id");
        $this->where = "ca.user_id in ($uidList) AND cm.type_id = $type_id";
        $this->group = 'cm.series_id';
        $this->order = array(
            'cm.views' => 'DESC',
            'cm.model_price' => 'DESC'
        );
        $this->limit = 21;
        $sameType = $this->leftJoin(2);
        if (!empty($sameType)) {
            $seriesIds = array();
            foreach ($sameType as $row) {
                $seriesIds[] = $row['series_id'];
            }
            $seriesIdList = implode(',', $seriesIds);
        }
        $this->where = "ca.user_id in ($uidList) AND cm.st4 = '$st4'";
        if (!empty($seriesIdList))
            $this->where .= " AND cm.series_id not in ($seriesIdList)";
        $this->limit = 20;
        $sameSt = $this->leftJoin(2);

        if (count($sameType) >= 3) {
            $num = array_rand($sameType, 3);
            $tmp1[] = $sameType[$num[0]];
            $tmp1[] = $sameType[$num[1]];
            $tmp1[] = $sameType[$num[2]];
            $result['same_type'] = $tmp1;
            if (count($sameSt) > 2) {
                $num = array_rand($sameSt, 2);
                $tmp2[] = $sameSt[$num[0]];
                $tmp2[] = $sameSt[$num[1]];
                $result['same_st'] = $tmp2;
            } else {
                $result['same_st'] = $sameSt;
            }
        } else {
            $sameTypeNum = count($sameType);
            $result['same_type'] = $sameType;
        }

        if ($sameTypeNum == 1) {
            if (count($sameSt) > 4) {
                $num = array_rand($sameSt, 4);
                $tmp2[] = $sameSt[$num[0]];
                $tmp2[] = $sameSt[$num[1]];
                $tmp2[] = $sameSt[$num[3]];
                $tmp2[] = $sameSt[$num[4]];
                $result['same_st'] = $tmp2;
            } else {
                $result['same_st'] = $sameSt;
            }
        } elseif ($sameTypeNum == 2) {
            if (count($sameSt) > 3) {
                $num = array_rand($sameSt, 3);
                $tmp2[] = $sameSt[$num[0]];
                $tmp2[] = $sameSt[$num[1]];
                $tmp2[] = $sameSt[$num[2]];
                $result['same_st'] = $tmp2;
            } else {
                $result['same_st'] = $sameSt;
            }
        } else {
            if (count($sameSt) > 5) {
                $num = array_rand($sameSt, 5);
                $tmp2[] = $sameSt[$num[0]];
                $tmp2[] = $sameSt[$num[1]];
                $tmp2[] = $sameSt[$num[2]];
                $tmp2[] = $sameSt[$num[3]];
                $tmp2[] = $sameSt[$num[4]];
                $result['same_st'] = $tmp5;
            } else {
                $result['same_st'] = $sameSt;
            }
        }


        return $result;
    }

    function getAttention($fields = "*", $where = " 1 ", $order = array(), $type = 2) {
        $this->reset();
        $this->fields = $fields;
        $this->where = $where;
        $this->order = $order;
        return $this->getResult($type);
    }

    //获取关注，分页,关联cardb_series表
    function getAttentorseries($fields = "*", $where = "1", $order = array(), $offset = 0, $limit = 5) {
        $this->reset();
//        $this->fields="count(*)";
        $this->where = $where . " and ca.series_id=cs.series_id";
        $this->tables = array("cardb_attention" => "ca", "cardb_series" => "cs");
//        $this->total=$this->joinTable(3);

        $this->fields = $fields;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        $attention = $this->joinTable(2);
        return $attention;
    }

    #获取user_id的关注车款，分页，关联cardb_model表

    function getArrenToModel($user_id, $page, $limit, $offset) {
        $this->reset();
        $this->fields = 'count(*)';
        $this->where = "ca.model_id=cm.model_id and ca.user_id=$user_id and ca.state=1";
        $this->tables = array("cardb_attention" => "ca", "cardb_model" => "cm");
        $total = $this->joinTable(3);
        $this->fields = 'cm.*';
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = array('ca.created' => 'desc');
        $res = $this->joinTable(2);
        return array(
            'total' => $total,
            'res' => $res
        );
    }

    //更具条件获取总数
    function getCount($where = "1") {
        $this->reset();
        $this->fields = "count(ca.id)";
        $this->where = $where . " and ca.series_id=cs.series_id";
        $this->tables = array("cardb_attention" => "ca", "cardb_series" => "cs");
        return $this->joinTable(3);
    }

    function getCountattention($where = "1") {
        $this->reset();
        $this->fields = "count(id)";
        $this->where = $where;
        return $this->getResult(3);
    }

    #处理小图片

    function getSsSq($model) {
        $pzImg = $this->pz_img;
        $ssKey = array_keys($pzImg['ss']);
        $aqKey = array_keys($pzImg['aq']);
        //气囊个数
        $i = 0;
        if ($model["st62"] == "标配") {
            $i++;
        }
        if ($model["st63"] == "标配") {
            $i++;
        }
        if ($model["st64"] == "标配") {
            $i+=2;
        }
        if ($model["st65"] == "标配") {
            $i+=2;
        }
        if ($model["st66"] == "标配") {
            $i++;
        }
        if ($model["st67"] == "标配") {
            $i++;
        }
        if ($model["st68"] == "标配") {
            $i+=2;
        }
        $model['qinang'] = $i > 0 ? '标配' : '无';
        $model["qinang_count"] = $i;

        $ss = $aq = array();
        foreach ($model as $kk => $vv) {
            if (in_array($kk, $ssKey)) {
                if ($vv == '')
                    $vv = '无';
                $ss[$kk] = $vv;
            }
            if (in_array($kk, $aqKey)) {
                if ($vv == '')
                    $vv = '无';
                $aq[$kk] = $vv;
            }
        }
        asort($ss);
        asort($aq);
        $model['ss'] = $ss;
        $model['aq'] = $aq;
        return $model;
    }

    function delOne($uid, $mid) {
        $this->ufields = array('state' => 0);
        $this->where = "user_id=$uid and model_id=$mid";
        return $this->update();
    }

    function updateAtt($ufields, $where) {
        $this->ufields = $ufields;
        $this->where = $where;
        return $this->update();
    }

}

?>
