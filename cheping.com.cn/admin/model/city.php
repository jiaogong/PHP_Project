<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
       class City extends model {
            function  __construct() {
                $this->table_name = "city";
                parent::__construct();
            }

            function getAllcity() {
                global $_cache;
                $key="city";
                $result=$_cache->getCache($key);
                if($result) {
                    return $result;
                }else {
                    $this->fields = "*";
                    $this->where = "1";
                    $result = $this->getResult(2);
                    $_cache->writeCache($key,$result,3600*24*365);
                    return $result;
                }
            }

            function getCity($pid) {
                if($pid > 0) {
                    $this->table_name = 'city';
                    $this->where = "province_id = $pid";
                    $this->order = array('name' => 'asc');
                    $this->fields = 'id, name, letter';
                    $city = $this->getResult(2);
                }
                else {
                    $city = false;
                }
                return $city;        
            }

            function getCitybycid($cityid) {
                    $this->reset();
                    $this->fields = "*";
                    $this->where = "id='$cityid'";
                    $result = $this->getResult(1);
                    return $result;

            }
            function getCityByName($cityname){
                $this->reset();
                $this->table_name = 'city';
                $this->fields = '*';
                $this->where = "name = '$cityname'";
                return $this->getResult();
            }
            /**
             * 取所有的地级单位
             */
            function getACity(){
//                $this->reset();
                $this->table_name = 'city';
                $this->fields = '*';
                return $this->getResult(2);
            }

            function getCheck($cityname,$province){
                $this->fields = '*';
                $this->where = "name = '$cityname' and province_id=$province";
                return $this->getResult();
            }
            
        }

?>