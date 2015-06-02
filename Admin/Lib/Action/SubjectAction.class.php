<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SubjectAction extends CommonAction{
    
    
    public function index(){
        
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    //view all subject
    public function viewAll(){
        
        //get result
        $subject_list =   M('subject')->select();
                
        $subject_list   =   $subject_list!=NULL? $subject_list: array();
        
        $data_array =   array('data'=>  $subject_list);
                
        //return as ajax
        $this->ajaxReturn($data_array);
   
    }
    
    //add subject page
    public function add(){
        
        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a subject page
    public function edit(){
        
        //get subject id
        $subject_id =   I('subject_id');
        
        //get subject result
        $result =  M('subject')->where("subject_id=$subject_id")->find();
        
        //display
        $this->assign('subject', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a subject page
    public function view(){
        
        //get subject id
        $subject_id =   I('subject_id');
        
        //get subject result
        $result =  M('subject')->where("subject_id=$subject_id")->find();
        
        //display
        $this->assign('subject', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert subject record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'subject_name'=>I('subject_name')            
        );
        
        //insert data into database
        if(M('subject')->data($data)->add())
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
       
        $subject_id =   I('subject_id');
        
        //create insert field
        $data   =   array(
            'subject_name'=>I('subject_name')            
        );
        
        //insert data into database
        if(M('subject')->where("subject_id=$subject_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1)); 
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
        
    }
    
    //delete subject record
    public function delete(){
        
        if(!IS_AJAX) halt("页面错误");
        
        //get subject id
        $subject_id =   I('subject_id');
        
        //delete
        if(M('subject')->where("subject_id=$subject_id")->delete())
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
