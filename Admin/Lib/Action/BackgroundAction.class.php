<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BackgroundAction extends CommonAction{
    
    //index page
    public function index(){
        
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    //view all background
    public function viewAll(){
        
        //get result
        $background_list =   M('background')->select();
        
        $background_list    =   $background_list!=NULL? $background_list: array();
        
        $data_array =   array('data'=>  $background_list);
        
        //return as ajax
        $this->ajaxReturn($data_array);
        
    }
    
    //add background page
    public function add(){
        
        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a background page
    public function edit(){
        
        //get background id
        $background_id =   I('background_id');
        
        //get background result
        $result =  M('background')->where("background_id=$background_id")->find();
        
        //display
        $this->assign('background', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a background page
    public function view(){
        
        //get background id
        $background_id =   I('background_id');
        
        //get background result
        $result =  M('background')->where("background_id=$background_id")->find();
        
        //display
        $this->assign('background', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert background record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'background_name'=>I('background_name')            
        );
        
        //insert data into database
        if(M('background')->data($data)->add())
        {
            $this->ajaxReturn(array('status'=>1)); 
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
    }
    
    
    public function update(){
        
        if(!IS_AJAX) halt("页面错误");
       
        $background_id =   I('background_id');
        
        //create insert field
        $data   =   array(
            'background_name'=>I('background_name')            
        );
        
        //insert data into database
        if(M('background')->where("background_id=$background_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1)); 
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
        
    }
    
    //delete background record
    public function delete(){
        
        if(!IS_AJAX) halt("页面错误");
        
        //get background id
        $background_id =   I('background_id');
        
        //delete
        if(M('background')->where("background_id=$background_id")->delete())
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if delete fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        } 
    }
}
