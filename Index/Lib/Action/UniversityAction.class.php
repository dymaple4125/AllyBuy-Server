<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UniversityAction extends Action{

    public function viewall(){

        //university model instance
        $db     =   M('university');

        //get country_id id from url
        $country_id  =   I('param.2');

        //get result data
        $result =   $db ->table(array('zebra_university'=>'university', 'zebra_district'=>'district'))
                        ->field("university_id, university_name")
                        ->where("university.district_id=district.district_id "
                                ."AND district.country_id=$country_id")
                        ->order("university_id")
                        ->select();

        //return as JSON
        $this->ajaxReturn($result,'JSON');
    }

}
