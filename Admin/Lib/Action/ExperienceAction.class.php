<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ExperienceAction extends CommonAction{
    
    public function index(){
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    //view all experience
    public function viewAll(){
        
        //get result
        $experience_list =   M('experience')->select();
        
        $experience_list    =   $experience_list!=NULL? $experience_list: array();
        
        //get data array
        $data_array =   array('data'=>  $experience_list);
        
        //return as ajax
        $this->ajaxReturn($data_array);
        
    }
    
    //add experience page
    public function add(){
        
        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a experience page
    public function edit(){
        
        //get experience id
        $experience_id =   I('experience_id');
        
        //get experience result
        $result =  M('experience')->where("experience_id=$experience_id")->find();
        
        //display
        $this->assign('experience', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a experience page
    public function view(){
        
        //get experience id
        $experience_id =   I('experience_id');
        
        //get experience result
        $result =  M('experience')->where("experience_id=$experience_id")->find();
        
        //display
        $this->assign('experience', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert experience record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'experience_name'=>I('experience_name'),   
            'value'=>I('value')
        );
        
        //insert data into database
        if(M('experience')->data($data)->add())
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
       
        $experience_id =   I('experience_id');
        
        //create insert field
        $data   =   array(
            'experience_name'=>I('experience_name'),
            'value'=>I('value')
        );
        
        //insert data into database
        if(M('experience')->where("experience_id=$experience_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1)); 
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
        
    }
    
    //delete experience record
    public function delete(){
        
        if(!IS_AJAX) halt("页面错误");
        
        //get experience id
        $experience_id =   I('experience_id');
        
        //delete
        if(M('experience')->where("experience_id=$experience_id")->delete())
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