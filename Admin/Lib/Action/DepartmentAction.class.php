<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DepartmentAction extends CommonAction{
    
    
    public function index(){
        
        //get district id from url
        $university_id  =   I('university_id');
        
        //get whole contru
        $nav   =   M('university')->table(array('zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_university'=>'university'))
                                ->field('university.university_name, university.university_id, country.country_id, country.country_name, district.district_name, district.district_id')
                                ->where("university.district_id=district.district_id "
                                        . "AND district.country_id=country.country_id "
                                        . "AND university.university_id=$university_id")
                                ->find();
        
        $this->assign('nav', $nav)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    
    public function viewall(){
        
        //get district id from url
        $university_id  =   I('university_id');

        //get result data
        $department_list =   M('department')->field("department_id, department_name")
                                            ->where("university_id=$university_id")
                                            ->order("department_id desc")
                                            ->select();
        
        $department_list  =   $department_list!=NULL ? $department_list : array();

        
        $data_array =   array('data'=>$department_list);
        
        $this->ajaxReturn($data_array);
    }
    
    
    //add country page
    public function add(){
        
        //get country id from url
        $university_id =   I('university_id');
        
        //select not none country as insert list
        $nav   =  M('university')->table(array('zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_university'=>'university'))
                                ->field('country.country_name, country.country_id, district.district_name, university.*')
                                ->where("district.country_id=country.country_id "
                                        . "AND university.district_id=district.district_id "
                                        . "AND university.university_id=$university_id")
                                ->find();
        //display the add page
        $this->assign('nav', $nav)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display(); 
    }
    
    //edit a country page
    public function edit(){
        
        //get country id
        $department_id =   I('department_id');
        
        //get country result
        $department   =  M('department')->table(array('zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_university'=>'university', 'zebra_department'=>'department'))
                                        ->field('country.country_name, country.country_id, district.district_name, district.district_id, university.university_name, department.*')
                                        ->where("district.country_id=country.country_id "
                                                . "AND district.district_id=university.district_id "
                                                . "AND university.university_id=department.university_id "
                                                . "AND department.department_id=$department_id")
                                        ->find();
        
        //display
        $this->assign('department', $department)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    //view a country page
    public function view(){
        
        //get country id
        $department_id =   I('department_id');
        
        //get country result
        $department   =  M('department')->table(array('zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_university'=>'university', 'zebra_department'=>'department'))
                                        ->field('country.country_name, country.country_id, district.district_name, district.district_id, university.university_name, department.*')
                                        ->where("district.country_id=country.country_id "
                                                . "AND district.district_id=university.district_id "
                                                . "AND university.university_id=department.university_id "
                                                . "AND department.department_id=$department_id")
                                        ->find();
        
        //display
        $this->assign('department', $department)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
        
    }
    
    
    //insert country record
    public function insert(){
        
        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");
       
        //create insert field
        $data   =   array(
            'department_name'=>I('department_name'),  
            'university_id'=>I('university_id')
        );
        
//        var_dump($data);
            
        //insert data into database
        if(M('department')->data($data)->add())
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
       
        $department_id =   I('department_id');
        
        //create insert field
        $data   =   array(
            'department_name'=>I('department_name')            
        );
        
        //insert data into database
        if(M('department')->where("department_id=$department_id")->save($data))
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
        $department_id =   I('department_id');
        
        
        //delete
        if(M('department')->where("department_id=$department_id")->delete())
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