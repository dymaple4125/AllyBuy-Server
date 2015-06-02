<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CountryAction extends CommonAction{
    
    public function index(){
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    //view all country
    public function viewAll(){
        
        //get result
        $country_list   =   M('country')->where('country_id<>0')->select();
    
        $country_list   =   $country_list!=NULL ? $country_list : array();
        
        $data_array =   array('data'=>$country_list);
        
        //assing country list
        $this->ajaxReturn($data_array);
        
    }
    
    //add country page
    public function add(){
        
        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a country page
    public function edit(){
        
        //get country id
        $country_id =   I('country_id');
        
        //get country result
        $result =  M('country')->where("country_id=$country_id")->find();
        
        //display
        $this->assign('country', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a country page
    public function view(){
        
        //get country id
        $country_id =   I('country_id');
        
        //get country result
        $result =  M('country')->where("country_id=$country_id")->find();
        
        //display
        $this->assign('country', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert country record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'country_name'=>I('country_name')            
        );
        
        //insert data into database
        if(M('country')->data($data)->add())
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
       
        $country_id =   I('country_id');
        
        //create insert field
        $data   =   array(
            'country_name'=>I('country_name')            
        );
        
        //insert data into database
        if(M('country')->where("country_id=$country_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1)); 
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
        
    }
    
    //delete country record
    public function delete(){
        
        if(!IS_AJAX) halt("页面错误");
        
        //get country id
        $country_id =   I('country_id');
        
        //delete
        if(M('country')->where("country_id=$country_id")->delete())
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