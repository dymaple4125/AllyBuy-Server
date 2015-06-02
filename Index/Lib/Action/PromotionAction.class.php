<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PromotionAction extends Action{
    
    
    public function viewall(){
        
        //promotion model instance
        $db =   M('promotion');
        
        //get promotion result  
        $result =   $db->select();
        
        //return format JSON
        $this->ajaxReturn($result);

    }
    
    
    
}