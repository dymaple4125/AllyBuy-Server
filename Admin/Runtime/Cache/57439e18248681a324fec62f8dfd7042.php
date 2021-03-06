<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css">
        <!-- 可选的Bootstrap主题文件（一般不用引入） -->
        <link rel="stylesheet" href="__PUBLIC__/css/bootstrap-theme.min.css">
        <!--加入zebra独有样式表-->
        <link rel="stylesheet" href="__PUBLIC__/css/zebra.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!--load header or footer template -->
        <script>
            $(function(){
               
               //department action
               $('#submit_btn').click(function(e){
                   
                   var department_name =   $("input[name=department_name]");
                   var department_id   =  <?php echo ($department['department_id']); ?>; 
                                     
                   if(department_name.val()==''){
                       alert('department name不能为空');
                       department_name.focus();
                       return;
                   }
                   
                   $.post("<?php echo U('update', '', '');?>",{department_id: department_id, department_name:department_name.val()},function(data){
                        //add fail
                        if(data['status']==0){
                            $('#alert_fail').html("更新《"+department_name.val()+"》不成功，请再试");
                            $('#alert_fail').attr('hidden', false);
                        }
                        //add success
                        else if(data['status']==1) { 
                            $('#alert_success').html("更新《"+department_name.val()+"》成功");
                            $('#alert_success').attr('hidden', false);
                        }
                       
                   }, 'json');
               });
        
               $('input').focus(function(e){
                   $('#alert_fail').attr('hidden', true);
                   $('#alert_success').attr('hidden', true);
               });
        
            });
            
            $(function(){
               
                $('#main_nav').load("__PUBLIC__/html/nav.html", function(){
                    $('#admin_name').html("<?php echo ($admin_name); ?>，欢迎登陆Majorbox后台系统");
                });
            });
        </script>
    </head>
    <body>
<!--        header-->
    <!--        header-->
        <div id="main_nav"></div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="main">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo U('country/index', '', '');?>">Country</a></li>
                        <li><a href="<?php echo U('district/index','country_id='.$department['country_id'], '');?>"><?php echo ($department['country_name']); ?></a></li>
                        <li><a href="<?php echo U('university/index','district_id='.$department['district_id'], '');?>"><?php echo ($department['district_name']); ?></a></li>
                        <li><a href="<?php echo U('department/index','university_id='.$department['university_id'], '');?>"><?php echo ($department['university_name']); ?></a></li>
                        <li class="active">edit</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <div class="form-group">
                        <label>Department ID</label>
                        <p style="color: gray;">#<?php echo ($department['department_id']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="departmentInput">Department Name</label>
                        <input type="text" value="<?php echo ($department['department_name']); ?>" class="form-control" id="department_name_input" name="department_name" placeholder="Add a new department name">
                    </div>
                    <button id="submit_btn" class="btn btn-default">Submit</button>
                </div>
            </div>
        </div>
    </body>
</html>