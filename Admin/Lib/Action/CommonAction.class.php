<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CommonAction extends Action{

    //check whether login
    public function _initialize(){
        if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name'])){
            $this->redirect('login/index');
        }
    }

}
