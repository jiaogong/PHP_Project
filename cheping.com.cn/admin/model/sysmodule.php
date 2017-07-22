<?php
/**
 * model code of sys module table 
 * $Id$
 * @author David Shaw <tudibao@163.com>
 */

class sysmodule extends model{
    function __construct() {
        parent::__construct();
        $this->table_name = 'sys_module';
    }
    
    function getModulesByCode($module_code = ''){
        $this->where = "module_code='{$module_code}'";
        $this->fields = "module_id";
        return $this->getResult(3);
    }
}

