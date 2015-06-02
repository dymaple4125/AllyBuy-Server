<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UniversityAction extends CommonAction{
    
    
    public function index(){
        
        //get district id from url
        $district_id  =   I('district_id');
        
        //get whole contru
        $nav   =   M('district')->table(array('zebra_country'=>'country', 'zebra_district'=>'district'))
                                ->field('district.*, country.country_name')
                                ->where("district.country_id=country.country_id "
                                        . "AND district.district_id=$district_id")
                                ->find();
        
        $this->assign('nav', $nav)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    
    public function viewall(){
        
        //get district id from url
        $district_id  =   I('district_id');

        //get result data
        $university_list =   M('university')->field("university_id, university_name")
                                            ->where("district_id=$district_id")
                                            ->select();
        
        $university_list  =   $university_list!=NULL ? $university_list : array();

        
        $data_array =   array('data'=>$university_list);
        
        //return ajax data
        $this->ajaxReturn($data_array);
 
    }
 
    //add country page
    public function add(){
        
        //get country id from url
        $district_id =   I('district_id');
        
        //select not none country as insert list
        $nav   =  M('district')->table(array('zebra_country'=>'country', 'zebra_district'=>'district'))
                                ->field('country.country_name, district.*')
                                ->where("district.country_id=country.country_id "
                                        . "AND district.district_id=$district_id")
                                ->find();
        //display the add page
        $this->assign('nav', $nav)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a country page
    public function edit(){
        
        //get country id
        $university_id =   I('university_id');
        
        //get country result
        $university   =  M('district')->table(array('zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_university'=>'university'))
                                ->field('country.country_name, country.country_id, district.district_name, university.*')
                                ->where("district.country_id=country.country_id "
                                        . "AND district.district_id=university.district_id "
                                        . "AND university.university_id=$university_id")
                                ->find();
        
        //display
        $this->assign('university', $university)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a country page
    public function view(){
        
        //get country id
        $university_id =   I('university_id');
        
        //get country result
        $university   =  M('district')->table(array('zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_university'=>'university'))
                                ->field('country.country_name, country.country_id, district.district_name, university.*')
                                ->where("district.country_id=country.country_id "
                                        . "AND district.district_id=university.district_id "
                                        . "AND university.university_id=$university_id")
                                ->find();
        
        //display
        $this->assign('university', $university)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert country record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'university_name'=>I('university_name'),  
            'district_id'=>I('district_id')
        );
        
//        var_dump($data);
            
        //insert data into database
        if(M('university')->data($data)->add())
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
       
        $university_id =   I('university_id');
        
        //create insert field
        $data   =   array(
            'university_name'=>I('university_name')            
        );
        
        //insert data into database
        if(M('university')->where("university_id=$university_id")->save($data))
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
        $university_id =   I('university_id');
        
        
        //delete
        if(M('university')->where("university_id=$university_id")->delete())
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

