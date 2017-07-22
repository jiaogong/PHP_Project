<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
     class commentResult extends model {
         
         function __construct() {
             $this->table_name = "cardb_comm_result";
             parent::__construct();
         }

        function getAllById($id){
        	
        	 $this->where ="comment_id=$id and comment_result = 1 ";
        	 
             $this->fields = "count(id) as total";
             $this->total = $this->getResult(3);
             return  $this->total;
        }
        
        function insertAdd($ufields){
        	 $this->reset();
             $this->ufields = $ufields;
             return $this->insert();
        	
        }
     }
?>
