<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BackgroundAction extends Action{
    
    public function viewall(){
        
        $db     =   M('background');
        $result =   $db->select();
        
        //以JSON数据格式返回
        $this->ajaxReturn($result,'JSON');
    }
    
}
