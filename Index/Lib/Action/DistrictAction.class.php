<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DistrictAction extends Action{

    public function viewall(){

        //model district instance
        $db     =   M('district');

        //get country id from url
        $country_id  =   I('param.2');

        //get result data
        $result =   $db ->field("district_id, district_name")
                        ->where("country_id=$country_id")
                        ->order("district_id")
                        ->select();

        //return as JSON
        $this->ajaxReturn($result,'JSON');
    }

}
