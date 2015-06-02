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
        <!-- date picker-->
        <link rel="stylesheet" href="__PUBLIC__/css/bootstrap-datetimepicker.min.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!-- date picker js-->
        <script src="__PUBLIC__/js/bootstrap-datetimepicker.min.js"></script>
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
               
               
                $('#datetimepicker').datetimepicker({
                    autoclose:true,
                    format:'yyyy-mm-dd',
                    minView: 2
                });

               //country action
               $('#submit_btn').click(function(e){
                   
                   var major_name =   $("input[name=major_name]");
                   var department    =   $("#department_select");
                   var subject  =   $("#subject_select");
                   
                   if(major_name.val()==''){
                        alert('major name不能为空');
                        major_name.focus();
                        return;
                   }
                                      
                   if(department.val()==0 || department.val()==null){
                        alert('department不能为空');
                        department.focus();
                        return;
                   }
//                   alert(subject.val());
                   if(subject.val()==0){
                        alert('你必须选取一个subject');
                        subject.focus();
                        return;
                   }

                   var values = {
                       department_id: department.val(),
                       subject_id: subject.val(),
                       major_name: major_name.val(),
                       deadline: $("input[name=deadline]").val(),
                       TOEFL_min: $("input[name=TOEFL_min]").val(),
                       IELTS_min: $("input[name=IELTS_min]").val(),
                       GRE_min: $("input[name=GRE_min]").val(),
                       GMAT_min: $("input[name=GMAT_min]").val(),
                       GPA_min: $("input[name=GPA_min]").val(),
                       experience_min: $("#experience_select").val(),
                       aims: $("textarea[name=aims]").val(),
                       prospects: $("textarea[name=prospects]").val(),
                       leaders: $("textarea[name=leaders]").val(),
                       characteristics: $("textarea[name=characteristics]").val(),
                       requirements: $("textarea[name=requirements]").val(),
                       fee: $("textarea[name=fee]").val(),
                       curriculum: $("textarea[name=curriculum]").val(),
                       contacts: $("textarea[name=contacts]").val(),
                       remark: $("textarea[name=remark]").val(),
                       other: $("input[name=other]").val()
                   };
                   
                   
                   $.post("<?php echo U('insert', '', '');?>",values,function(data){
                        //add fail
                        if(data['status']==0){
                            $('#alert_fail').html("添加《"+major_name.val()+"》不成功，请再试");
                            $('#alert_fail').attr('hidden', false);
                        }
                        //add success
                        else if(data['status']==1) { 
                            $('#alert_success').html("添加《"+major_name.val()+"》成功");
                            $('#alert_success').attr('hidden', false);
                            $('input').val('');
                            $('textarea').val('');
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
                        <li><a href="<?php echo U('index', '', '');?>">Major</a></li>
                        <li class="active">add</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <h3><button id="submit_btn" class="btn btn-info">Submit</button></h3>
                    <div class="form-group">
                      <label>Country *</label>
                      <select id="country_select" class="form-control">
                            <option selected value="0">none</option>
                            <?php if(is_array($country_list)): foreach($country_list as $key=>$country): ?><option value="<?php echo ($country['country_id']); ?>"><?php echo ($country['country_name']); ?></option><?php endforeach; endif; ?>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label>District *</label>
                      <select id="district_select" class="form-control">
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Univeristy *</label>
                      <select id="university_select" class="form-control">
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Department *</label>
                      <select id="department_select" name="department_id" class="form-control">
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Subject *</label>
                      <select id="subject_select" name="subject_id" class="form-control">
                            <option selected value="0">none</option>
                            <?php if(is_array($subject_list)): foreach($subject_list as $key=>$subject): ?><option value="<?php echo ($subject['subject_id']); ?>"><?php echo ($subject['subject_name']); ?></option><?php endforeach; endif; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Major Name *</label>
                      <input type="text" class="form-control" name="major_name" placeholder="Add a new major name">
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input type="text" class="form-control" name="deadline" data-date-format="yyyy-mm-dd" placeholder="Major deadline" id="datetimepicker">
                    </div>
                    <div class="form-group">
                      <label>TOEFL</label>
                      <input type="text" class="form-control" name="TOEFL_min" placeholder="TOEFL min requirement">
                    </div>
                    <div class="form-group">
                      <label>IELTS</label>
                      <input type="text" class="form-control" name="IELTS_min" placeholder="IELTS min requirement">
                    </div>
                    <div class="form-group">
                      <label>GRE</label>
                      <input type="text" class="form-control" name="GRE_min" placeholder="GRE min requirement">
                    </div>
                    <div class="form-group">
                      <label>GMAT</label>
                      <input type="text" class="form-control" name="GMAT_min" placeholder="GMAT min requirement">
                    </div>
                    <div class="form-group">
                      <label>GPA</label>
                      <input type="text" class="form-control" name="GPA_min" placeholder="GPA min requirement">
                    </div>
                    <div class="form-group">
                      <label>Experience</label>
                      <select id="experience_select" name="experience_min" class="form-control">
                            <?php if(is_array($experience_list)): foreach($experience_list as $key=>$experience): if($experience['value'] == 0): ?><option selected value="<?php echo ($experience['experience_id']); ?>"><?php echo ($experience['experience_name']); ?></option>
                            <?php else: ?><option value="<?php echo ($experience['value']); ?>"><?php echo ($experience['experience_name']); ?></option><?php endif; endforeach; endif; ?>
                      </select>
<!--                      <input type="text" class="form-control" name="experience_min" placeholder="Experience min requirement">-->
                    </div>
                    <div class="form-group">
                      <label>Aims</label>
                      <textarea class="form-control" name="aims" placeholder="Major aims" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Prospects</label>
                      <textarea class="form-control" name="prospects" placeholder="Major prospects" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Leaders</label>
                      <textarea class="form-control" name="leaders" placeholder="Major leaders" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Characteristics</label>
                      <textarea class="form-control" name="characteristics" placeholder="Major characteristics" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Requirements</label>
                      <textarea class="form-control" name="requirements" placeholder="Major requirements" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Fee</label>
                      <textarea class="form-control" name="fee" placeholder="Major fee" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Curriculum</label>
                      <textarea class="form-control" name="curriculum" placeholder="Major curriculum" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Contacts</label>
                      <textarea class="form-control" name="contacts" placeholder="Major contacts" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Remark</label>
                      <textarea class="form-control" name="remark" placeholder="Major remark" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Other</label>
                      <input type="text" class="form-control" name="other" placeholder="other">
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>