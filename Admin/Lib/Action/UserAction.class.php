<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserAction extends CommonAction{

    public function index(){
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    public function viewall(){

        //get result data
        $user_list =   M('user')  ->table(array('zebra_user'=>'user', 'zebra_country'=>'country','zebra_experience'=>'experience', 'zebra_background'=>'background', 'zebra_subject'=>'subject'))
                                    ->field("user.*, experience.experience_name, background.background_name, country.country_name, subject.subject_name")
                                    ->where("user.experience_id=experience.experience_id "
                                            . "AND user.background_id=background.background_id "
                                            . "AND user.subject_id=subject.subject_id "
                                            . "AND user.country_id=country.country_id")
                                    ->select();

        $user_list =   $user_list!=NULL? $user_list: array();

        $data_array =   array('data'=> $user_list);

        //return as ajax
        $this->ajaxReturn($data_array);
    }

    public function viewrecent(){

        //get result data
        $user_list =   M('user')  ->table(array('zebra_user'=>'user', 'zebra_country'=>'country','zebra_experience'=>'experience', 'zebra_background'=>'background', 'zebra_subject'=>'subject'))
                                    ->field("user.*, experience.experience_name, background.background_name, country.country_name, subject.subject_name")
                                    ->where("user.experience_id=experience.experience_id "
                                            . "AND user.background_id=background.background_id "
                                            . "AND user.subject_id=subject.subject_id "
                                            . "AND user.country_id=country.country_id")
                                    ->group('user_id')
                                    ->order('user_id desc')
                                    ->limit('100')
                                    ->select();

        $user_list =   $user_list!=NULL? $user_list: array();

        $data_array =   array('data'=> $user_list);

        //return as ajax
        $this->ajaxReturn($data_array);
    }

    //add country page
    public function add(){

        //get country list
        $country_list   =   M('country')->select();

        //get subject list
        $subject_list   =   M('subject')->select();

        //get experience list
        $experience_list   =   M('experience')->select();

        //get background list
        $background_list   =   M('background')->select();

        //display the add page
        $this   ->assign('country_list', $country_list)
                ->assign('subject_list', $subject_list)
                ->assign('experience_list', $experience_list)
                ->assign('background_list', $background_list)
                ->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
    }


    //add country page
    public function edit(){

        $user_id   =   I('user_id');

        //get country list
        $country_list   =   M('country')->select();

        //get subject list
        $subject_list   =   M('subject')->select();

        //get experience list
        $experience_list   =   M('experience')->select();

        //get background list
        $background_list   =   M('background')->select();

        $user =   M('user')->where("user_id=$user_id")->find();

        //display the add page
        $this   ->assign('country_list', $country_list)
                ->assign('subject_list', $subject_list)
                ->assign('experience_list', $experience_list)
                ->assign('background_list', $background_list)
                ->assign('user', $user)
                ->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //get a specific user info based on user id
    public function view(){

        //user model instance
        $db =   M('user');

        //get user id
        $user_id    =   I('user_id', '', 'htmlspecialchars');

        //get user info
        $result =   $db ->table(array('zebra_user'=>'user', 'zebra_subject'=>'subject', 'zebra_country'=>'country', 'zebra_experience'=>'experience', 'zebra_background'=>'background'))
                        ->field('user.*, subject.subject_name, country.country_name, experience.experience_name, background.background_name')
                        ->where("user.country_id=country.country_id "
                                . "AND user.subject_id=subject.subject_id "
                                . "AND user.experience_id=experience.experience_id "
                                . "AND user.background_id=background.background_id "
                                . "AND user_id=$user_id")
                        ->select();

        //return as JSON
        $this->ajaxReturn($result);
    }

    //insert major record
    public function insert(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");


        //create insert field
        $data   =   array(
            'country_id'=>I('country_id'),
            'subject_id'=>I('subject_id'),
            'experience_id'=>I('experience_id'),
            'background_id'=>I('background_id'),
            'TOEFL'=>I('TOEFL'),
            'IELTS'=>I('IELTS'),
            'GRE'=>I('GRE'),
            'GMAT'=>I('GMAT'),
            'GPA'=>I('GPA')
        );


        //insert data into database
        if(M('user')->data($data)->add())
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
    }

    //insert major record
    public function update(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        $user_id    =   I('user_id');

        //create insert field
        $data   =   array(
            'country_id'=>I('country_id'),
            'subject_id'=>I('subject_id'),
            'experience_id'=>I('experience_id'),
            'background_id'=>I('background_id'),
            'TOEFL'=>I('TOEFL'),
            'IELTS'=>I('IELTS'),
            'GRE'=>I('GRE'),
            'GMAT'=>I('GMAT'),
            'GPA'=>I('GPA'),
            'last_modify'=>date('Y-m-d H:i:s', time())
        );


        //insert data into database
        if(M('user')->where("user_id=$user_id")->save($data))
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
        $user_id =   I('user_id');

        //delete
        if(M('user')->where("user_id=$user_id")->delete())
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
