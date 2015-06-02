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
               
               $('#country_select').change(function(){
                   
                    $('#district_select').empty();
                    $('#university_select').empty();
                    $('#department_select').empty();
                   
                    if($(this).val()==0) return;

                    $.post("<?php echo U('district/viewall', '', '');?>",{country_id:$(this).val()},function(data){
                        
                        //reset select values
                        $('#district_select').empty();
                        $('#district_select').append($("<option></option>").attr('selected',true).attr("value",0).text('none'));
                        
                        //append new options to select
                        $.each(data['data'], function(key, value) {
                           $('#district_select').append($("<option></option>").attr("value",value['district_id']).text(value['district_name']));
                        });                  
                   }, 'json');
                   
               });
               
               $('#district_select').change(function(){
                   
                    $('#university_select').empty();
                    $('#department_select').empty();
                   
                    if($(this).val()==0) return;
         
                    $.post("<?php echo U('university/viewall', '', '');?>",{district_id:$(this).val()},function(data){
                        
                        //reset select values
                        $('#university_select').empty();
                        $('#university_select').append($("<option></option>").attr('selected',true).attr("value",0).text('none'));
                        
                        //append new options to select
                        $.each(data['data'], function(key, value) {
                           $('#university_select').append($("<option></option>").attr("value",value['university_id']).text(value['university_name']));
                        });                  
                   }, 'json');
                   
               });
               
               $('#university_select').change(function(){
                   
                    $('#department_select').empty();
                   
                    if($(this).val()==0) return;
        
                    $.post("<?php echo U('department/viewall', '', '');?>",{university_id:$(this).val()},function(data){
                        
                        //reset select values
                        $('#department_select').empty();
                        $('#department_select').append($("<option></option>").attr('selected',true).attr("value",0).text('none'));
                        
                        //append new options to select
                        $.each(data['data'], function(key, value) {
                           $('#department_select').append($("<option></option>").attr("value",value['department_id']).text(value['department_name']));
                        });                  
                   }, 'json');
                   
               });
               
      
               //country action
               $('#submit_btn').click(function(e){
     
                    var country =   $("#country_select");
                    var subject =   $("#subject_select");
                    var experience =   $("#experience_select");
                    var background =   $("#background_select");
                   

                    var values = {
                        user_id: <?php echo ($user['user_id']); ?>,
                        country_id: country.val(),
                        subject_id: subject.val(),
                        experience_id: experience.val(),
                        background_id: background.val(),
                        TOEFL: $("input[name=TOEFL]").val(),
                        IELTS: $("input[name=IELTS]").val(),
                        GRE: $("input[name=GRE]").val(),
                        GMAT: $("input[name=GMAT]").val(),
                        GPA: $("input[name=GPA]").val(),
                    };

                   
                   $.post("<?php echo U('update', '', '');?>",values,function(data){
                        //add fail
                        if(data['status']==0){
                            $('#alert_fail').html("修改用户资料不成功，请再试");
                            $('#alert_fail').attr('hidden', false);
                        }
                        //add success
                        else if(data['status']==1) { 
                            $('#alert_success').html("修改用户资料成功");
                            $('#alert_success').attr('hidden', false);
                            $('input').val('');
                            $('select').val(0);
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
        <div id="main_nav"></div>
<!--        content-->
        <div class="container-fluid">
            <div class="row">
                <div class="main">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo U('index', '', '');?>">User</a></li>
                        <li class="active">edit</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <h3><button id="submit_btn" class="btn btn-info">Submit</button></h3>
                    <div class="form-group">
                      <label>Country *</label>
                      <select id="country_select" class="form-control">
                            <?php if(is_array($country_list)): foreach($country_list as $key=>$country): if($country['country_id'] == $user['country_id']): ?><option selected value="<?php echo ($country['country_id']); ?>"><?php echo ($country['country_name']); ?></option>
                                    <?php else: ?> <option value="<?php echo ($country['country_id']); ?>"><?php echo ($country['country_name']); ?></option><?php endif; endforeach; endif; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Subject *</label>
                      <select id="subject_select" class="form-control">
                            <?php if(is_array($subject_list)): foreach($subject_list as $key=>$subject): if($subject['subject_id'] == $user['subject_id']): ?><option selected value="<?php echo ($subject['subject_id']); ?>"><?php echo ($subject['subject_name']); ?></option>
                                    <?php else: ?><option value="<?php echo ($subject['subject_id']); ?>"><?php echo ($subject['subject_name']); ?></option><?php endif; endforeach; endif; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Experience *</label>
                      <select id="experience_select" class="form-control">
                            <?php if(is_array($experience_list)): foreach($experience_list as $key=>$experience): if($experience['experience_id'] == $user['experience_id']): ?><option selected value="<?php echo ($experience['experience_id']); ?>"><?php echo ($experience['experience_name']); ?></option>
                                        <?php else: ?><option value="<?php echo ($experience['experience_id']); ?>"><?php echo ($experience['experience_name']); ?></option><?php endif; endforeach; endif; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Background *</label>
                      <select id="background_select" class="form-control">
                            <?php if(is_array($background_list)): foreach($background_list as $key=>$background): if($background['background_id'] == $user['background_id']): ?><option selected value="<?php echo ($background['background_id']); ?>"><?php echo ($background['background_name']); ?></option>
                                    <?php else: ?><option value="<?php echo ($background['background_id']); ?>"><?php echo ($background['background_name']); ?></option><?php endif; endforeach; endif; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>TOEFL</label>
                      <input type="text" class="form-control" name="TOEFL" placeholder="TOEFL value" value="<?php echo ($user['TOEFL']); ?>">
                    </div>
                    <div class="form-group">
                      <label>IELTS</label>
                      <input type="text" class="form-control" name="IELTS" placeholder="IELTS value" value="<?php echo ($user['IELTS']); ?>">
                    </div>
                    <div class="form-group">
                      <label>GRE</label>
                      <input type="text" class="form-control" name="GRE" placeholder="GRE value" value="<?php echo ($user['GRE']); ?>">
                    </div>
                    <div class="form-group">
                      <label>GMAT</label>
                      <input type="text" class="form-control" name="GMAT" placeholder="GMAT value" value="<?php echo ($user['GMAT']); ?>">
                    </div>
                    <div class="form-group">
                      <label>GPA</label>
                      <input type="text" class="form-control" name="GPA" placeholder="GPA value" value="<?php echo ($user['GPA']); ?>">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>