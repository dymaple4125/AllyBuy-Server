<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DistrictAction extends CommonAction{
    
    public function index(){
        
        $country_id =   I('country_id');
        
        //get country
        $nav   =   M('country')->where("country_id=$country_id")->find();
        
        $this->assign('nav', $nav)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    public function viewall(){
 
        //get country id from url
        $country_id  =   I('country_id');

        //get result data
        $district_list =   M('district')->field("district_id, district_name")
                                        ->where("country_id=$country_id")
                                        ->select();
        
        $district_list  =   $district_list!=NULL ? $district_list : array();
        
        $data_array =   array('data'=>$district_list);
        
        $this->ajaxReturn($data_array);
        
    
    }
    
    
    //add country page
    public function add(){
        
        //get country id from url
        $country_id =   I('country_id');
        
        //select not none country as insert list
        $nav    =   M('country')->where("country_id=$country_id")->find();

        //display the add page
        $this->assign('nav', $nav)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a country page
    public function edit(){
        
        //get country id
        $district_id =   I('district_id');
        
        //get country result
        $district   =  M('district')->table(array('zebra_country'=>'country', 'zebra_district'=>'district'))
                                ->field('country.country_name, district.*')
                                ->where("district.country_id=country.country_id "
                                        . "AND district.district_id=$district_id")
                                ->find();
        
        //display
        $this->assign('district', $district)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a country page
    public function view(){
        
        //get country id
        $district_id =   I('district_id');
        
             
        //get country result
        $district   =   M('district')  ->table(array('zebra_country'=>'country', 'zebra_district'=>'district'))
                                        ->field('district.*, country.country_name')
                                        ->where("district.country_id=country.country_id "
                                                . "AND district.district_id=$district_id")
                                        ->find();
        
        //display
        $this->assign('district', $district)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert country record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'district_name'=>I('district_name'),  
            'country_id'=>I('country_id')
        );
        
//        var_dump($data);
            
        //insert data into database
        if(M('district')->data($data)->add())
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
       
        $district_id =   I('district_id');
        
        //create insert field
        $data   =   array(
            'district_name'=>I('district_name')            
        );
        
        //insert data into database
        if(M('district')->where("district_id=$district_id")->save($data))
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
        $district_id =   I('district_id');
        
        //delete
        if(M('district')->where("district_id=$district_id")->delete())
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