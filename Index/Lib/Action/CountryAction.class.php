<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CountryAction extends Action{
    
    public function viewall(){
        
        //country model instance
        $db     =   M('country');
        
        //select result
        $result =   $db ->field("country_id, country_name")
                        ->order("country_id")
                        ->select();
                
        //return JSON form
        $this->ajaxReturn($result,'JSON');
    }
    
}