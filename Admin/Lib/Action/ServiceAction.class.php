<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServiceAction extends CommonAction{
    
    public function index(){
        
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    //view all services
    public function viewAll(){
        
        //get result
        $service_list =   M('service')->select();
                
        $service_list   =   $service_list!=NULL? $service_list: array();
        
        $data_array =   array('data'=>  $service_list);
                
        //return as ajax
        $this->ajaxReturn($data_array);
        
    }
    
    //get edit page
    public function edit(){
        
        //get country id
        $service_id =   I('service_id');
        
        //get country result
        $result =  M('service')->where("service_id=$service_id")->find();
        
        //display
        $this->assign('service', $result)->assign('admin_name', $_SESSION['admin_name'])->display();
        

    }
    
    
    public function insert(){
       
        //create upload object
        $upload = createUploadObj(40000, './Public/Uploads/Service/');
        
        if (!$upload->upload()) {
           //捕获上传异常
           $this->error($upload->getErrorMsg());
        } 
        else {
           //取得成功上传的文件信息
           $uploadList = $upload->getUploadFileInfo();
           //import("@.ORG.Image");
           //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
           //Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], APP_PATH.'Tpl/Public/Images/logo.png');
        
           $data    =   array(
               'title'=>I('title'),
               'description'=>I('description'),
               'quota'=>I('quota'),
               'category'=>I('category'),
               'img'=>$uploadList[0]['savename']
           );
           
           if(M('service')->add($data)){
               $this->success('新建service成功', U('add', '', ''));
           }
           else
           {
               $this->error('新建service失败', U('add', '', ''));
           }
        }

    }
    
    public function update(){
        
        //get service id
        $service_id =   I('service_id');
        
        //get all update data
        $data    =   array(
            'title'=>I('title'),
            'description'=>I('description'),
            'quota'=>I('quota'),
            'category'=>I('category'),
        );
        
        //if upload img file
        if(!empty($_FILES['img']['name'])){
             //create upload object
            $upload = createUploadObj(40000, './Public/Uploads/Service/');

            if (!$upload->upload()) {
               //捕获上传异常
               $this->error($upload->getErrorMsg());
            } 
            //upload success
            else{
                $uploadList = $upload->getUploadFileInfo();
                
                //insert more data into data list
                $data['img']    =   $uploadList[0]['savename'];
            }
        }
        
        if(M('service')->where("service_id=$service_id")->save($data)){
            $this->success('更新service成功', U('index', '', ''));
        }
        else
        {
            $this->error('更新service失败', U('index', '', ''));
        }
  
    }
    
    //delete service record
    public function delete(){
        
        if(!IS_AJAX) halt("页面错误");
        
        //get country id
        $service_id =   I('service_id');
        
        //delete
        if(M('service')->where("service_id=$service_id")->delete())
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