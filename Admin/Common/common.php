<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//transfer current json format to array json format
function toArrayJSON($list){
    
    //create data array
    $data   =   array();
    //get all items in list
    foreach($list as $item){
        
        //each item is array
        $keys   = array_keys($item);
        
        //create a temp array
        $temp   =   array();
        //push each key value into a temp array
        foreach($keys as $key){
            $temp[$key] =   $item[$key];
            //array_push($temp, $item[$key]);
        }
        
        array_push($data, $temp);
    }
    
    return $data;
}

//create upload object
function createUploadObj($max_size, $save_path, $isThumb=true){
    
    import('ORG.Net.UploadFile');
    //导入上传类
    $upload = new UploadFile();
     //设置上传文件大小
    $upload->maxSize = $max_size;
     //设置上传文件类型
    $upload->allowExts = array('png', 'jpg', 'jpeg');
     //设置附件上传目录
    $upload->savePath = $save_path;
    
    //如果不需要生成缩略图(默认为需要缩略图)
    if(!$isThumb) return $upload;
    
    //设置需要生成缩略图，仅对图像文件有效
    $upload->thumb = true;
    //rename the pic
     //设置需要生成缩略图的文件后缀
    $upload->thumbPrefix = 's_';  
     //设置缩略图最大宽度
    $upload->thumbMaxWidth = '100';
     //设置缩略图最大高度
    $upload->thumbMaxHeight = '100';
     //删除原图
    $upload->thumbRemoveOrigin = true;
    
    return $upload;
}

