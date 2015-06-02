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
               
               $('#main_nav').load("__PUBLIC__/html/nav.html", function(){                     $('#admin_name').html("{$admin_name}，欢迎登陆猎购盟后台系统");                 });
               $('#side_nav').load("__PUBLIC__/html/basic.info.side.nav.html");
               
            });
        </script>
    </head>
    <body>
<!--        header-->
    <!--        header-->
        <div id="main_nav"></div>
        
        <div class="container-fluid">
            <div class="row">
                <div id="side_nav" class="col-sm-3 col-md-2 sidebar"></div> 
                
                <div class="col-sm-10 col-md-10 main">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo U('country/viewall', '', '');?>">Root</a></li>
                        <li><a href="<?php echo U('district/viewall','country_id='.$department['country_id'], '');?>"><?php echo ($department['country_name']); ?></a></li>
                        <li><a href="<?php echo U('university/viewall','district_id='.$department['district_id'], '');?>"><?php echo ($department['district_name']); ?></a></li>
                        <li><a href="<?php echo U('department/viewall','university_id='.$department['university_id'], '');?>"><?php echo ($department['university_name']); ?></a></li>
                        <li class="active">view</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <div class="form-group">
                        <label>Department ID</label>
                        <p style="color: gray;">#<?php echo ($department['department_id']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="departmentInput">Department Name</label>
                        <p style="color: gray;"><?php echo ($department['department_name']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>