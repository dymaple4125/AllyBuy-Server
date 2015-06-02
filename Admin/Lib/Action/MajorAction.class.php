<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MajorAction extends CommonAction{

    public function index(){

        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }


    //viewall majors under a specific department
    public function viewall(){

        //get result data
        $major_list =   M('major')  ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university', 'zebra_subject'=>'subject'))
                                    ->field("major.*, department.department_name, university.university_name, subject.subject_name")
                                    ->where("major.department_id=department.department_id "
                                            . "AND department.university_id=university.university_id "
                                            . "AND major.subject_id=subject.subject_id")
                                    ->select();

        $major_list =   $major_list!=NULL? $major_list: array();

        $data_array =   array('data'=> $major_list);

        //return as ajax
        $this->ajaxReturn($data_array);

    }

    //view resent changed items
    public function viewrecent(){
        $major_list =   M('major')  ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university', 'zebra_subject'=>'subject'))
                                    ->field("major.*, department.department_name, university.university_name, subject.subject_name")
                                    ->where("major.department_id=department.department_id "
                                            . "AND department.university_id=university.university_id "
                                            . "AND major.subject_id=subject.subject_id")
                                    ->group('major_id')
                                    ->order('major_id desc')
                                    ->limit('20')
                                    ->select();

        $major_list =   $major_list!=NULL? $major_list: array();

        $data_array =   array('data'=> $major_list);

        //return as ajax
        $this->ajaxReturn($data_array);

    }

    //edit a country page
    public function edit(){

        //get country id
        $major_id =   I('major_id');

        //get country result
        $major =  M('major')->table(array('zebra_major'=>'major', 'zebra_country'=>'country', 'zebra_district'=>'district', 'zebra_department'=>'department','zebra_university'=>'university', 'zebra_subject'=>'subject'))
                            ->field("major.*, country.country_name, district.district_name, department.department_name, university.university_name, subject.subject_name")
                            ->where("major.department_id=department.department_id "
                                    . "AND department.university_id=university.university_id "
                                    . "AND university.district_id=district.district_id "
                                    . "AND district.country_id=country.country_id "
                                    . "AND major.subject_id=subject.subject_id "
                                    . "AND major.major_id=$major_id")
                            ->find();

        //get subject list
        $subject_list   =   M('subject')->where('subject_id<>0')->select();
        //get experience list
        $experience_list    =   M('experience')->select();

        //display
        $this   ->assign('major', $major)
                ->assign('subject_list', $subject_list)
                ->assign('experience_list', $experience_list)
                ->assign('admin_name', $_SESSION['admin_name'])
                ->display();

    }


    //add country page
    public function add(){

        //get country list
        $country_list   =   M('country')->where('country_id<>0')->select();

        //get subject list
        $subject_list   =   M('subject')->where('subject_id<>0')->select();

        //get experience list
        $experience_list    =   M('experience')->select();

        //display the add page
        $this   ->assign('country_list', $country_list)
                ->assign('subject_list', $subject_list)
                ->assign('experience_list', $experience_list)
                ->assign('admin_name', $_SESSION['admin_name'])
                ->display();
    }

    //insert major record
    public function insert(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        //create insert field
        $data   =   array(
            'department_id'=>I('department_id'),
            'subject_id'=>I('subject_id'),
            'major_name'=>I('major_name'),
            'TOEFL_min'=>I('TOEFL_min'),
            'IELTS_min'=>I('IELTS_min'),
            'GRE_min'=>I('GRE_min'),
            'GMAT_min'=>I('GMAT_min'),
            'GPA_min'=>I('GPA_min'),
            'experience_min'=>I('experience_min'),
            'aims'=>I('aims'),
            'prospects'=>I('prospects'),
            'leaders'=>I('leaders'),
            'characteristics'=>I('characteristics'),
            'requirements'=>I('requirements'),
            'fee'=>I('fee'),
            'curriculum'=>I('curriculum'),
            'contacts'=>I('contacts'),
            'remark'=>I('remark'),
            'other'=>I('other'),
        );

        if(empty(I('deadline'))) $data['deadline']=NULL;
        else $data['deadline']    =   I('deadline');


        //insert data into database
        if(M('major')->data($data)->add())
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

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        $major_id   =   I('major_id');

        //create insert field
        $data   =   array(
            'department_id'=>I('department_id'),
            'subject_id'=>I('subject_id'),
            'major_name'=>I('major_name'),
            'TOEFL_min'=>I('TOEFL_min'),
            'IELTS_min'=>I('IELTS_min'),
            'GRE_min'=>I('GRE_min'),
            'GMAT_min'=>I('GMAT_min'),
            'GPA_min'=>I('GPA_min'),
            'experience_min'=>I('experience_min'),
            'aims'=>I('aims'),
            'prospects'=>I('prospects'),
            'leaders'=>I('leaders'),
            'characteristics'=>I('characteristics'),
            'requirements'=>I('requirements'),
            'fee'=>I('fee'),
            'curriculum'=>I('curriculum'),
            'contacts'=>I('contacts'),
            'remark'=>I('remark'),
            'other'=>I('other'),
            'last_modify'=>date('Y-m-d H:i:s',time())
        );

        if(empty(I('deadline'))) $data['deadline']=NULL;
        else $data['deadline']    =   I('deadline');

        //insert data into database
        if(M('major')->where("major_id=$major_id")->save($data))
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
        $major_id =   I('major_id');

        //delete
        if(M('major')->where("major_id=$major_id")->delete())
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
