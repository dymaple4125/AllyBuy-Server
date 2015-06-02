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
        <!-- date picker-->
        <link rel="stylesheet" href="__PUBLIC__/css/bootstrap-datetimepicker.min.css">
        <!--加入zebra独有样式表-->
        <link rel="stylesheet" href="__PUBLIC__/css/zebra.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!-- date picker js-->
        <script src="__PUBLIC__/js/bootstrap-datetimepicker.min.js"></script>
        <!--load header or footer template -->
        <script>
            $(function(){

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

                   var values = {
                       major_id: <?php echo ($major['major_id']); ?>,
                       department_id: <?php echo ($major['department_id']); ?>,
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


                   $.post("<?php echo U('update', '', '');?>",values,function(data){
                        //add fail
                        if(data['status']==0){
                            $('#alert_fail').html("更新《"+major_name.val()+"》不成功，请再试");
                            $('#alert_fail').attr('hidden', false);
                        }
                        //add success
                        else if(data['status']==1) {
                            $('#alert_success').html("更新《"+major_name.val()+"》成功");
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
                    $('#admin_name').html("<?php echo ($admin_name); ?>，欢迎登陆猎购盟后台系统");
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
                        <li class="active">edit</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <h3><button id="submit_btn" class="btn btn-info">Submit</button></h3>
                    <div class="form-group">
                      <label>Country *</label>
                      <p style="color: gray;"><?php echo ($major['country_name']); ?></p>
<!--                      <select id="country_select" class="form-control">
                            <option selected value="0">none</option>
                            <?php if(is_array($country_list)): foreach($country_list as $key=>$country): ?><option value="<?php echo ($country['country_id']); ?>"><?php echo ($country['country_name']); ?></option><?php endforeach; endif; ?>
                      </select>-->
                    </div>

                    <div class="form-group">
                      <label>District *</label>
                      <p style="color: gray;"><?php echo ($major['district_name']); ?></p>
<!--                      <select id="district_select" class="form-control">
                      </select>-->
                    </div>
                    <div class="form-group">
                      <label>Univeristy *</label>
                      <p style="color: gray;"><?php echo ($major['university_name']); ?></p>
<!--                      <select id="university_select" class="form-control">
                      </select>-->
                    </div>
                    <div class="form-group">
                      <label>Department *</label>
                      <p style="color: gray;"><?php echo ($major['department_name']); ?></p>
<!--                      <select id="department_select" name="department_id" class="form-control">
                      </select>-->
                    </div>
                    <div class="form-group">
                      <label>Subject *</label>
                      <select id="subject_select" name="subject_id" class="form-control">
                            <?php if(is_array($subject_list)): foreach($subject_list as $key=>$subject): if($major['subject_id'] == $subject['subject_id']): ?><option selected value="<?php echo ($subject['subject_id']); ?>"><?php echo ($subject['subject_name']); ?></option>
                                    <?php else: ?> <option value="<?php echo ($subject['subject_id']); ?>"><?php echo ($subject['subject_name']); ?></option><?php endif; ?>
<!--                                <option value="<?php echo ($subject['subject_id']); ?>"><?php echo ($subject['subject_name']); ?></option>--><?php endforeach; endif; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Major Name *</label>
                      <input type="text" class="form-control" name="major_name" placeholder="Add a new major name" value="<?php echo ($major['major_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input id="datetimepicker" type="text" class="form-control" name="deadline" data-date-format="yyyy-mm-dd" placeholder="Major deadline" value="<?php echo ($major['deadline']); ?>">
                    </div>
                    <div class="form-group">
                      <label>TOEFL</label>
                      <input type="text" class="form-control" name="TOEFL_min" placeholder="TOEFL min requirement" value="<?php echo ($major['TOEFL_min']); ?>">
                    </div>
                    <div class="form-group">
                      <label>IELTS</label>
                      <input type="text" class="form-control" name="IELTS_min" placeholder="IELTS min requirement" value="<?php echo ($major['IELTS_min']); ?>">
                    </div>
                    <div class="form-group">
                      <label>GRE</label>
                      <input type="text" class="form-control" name="GRE_min" placeholder="GRE min requirement" value="<?php echo ($major['GRE_min']); ?>">
                    </div>
                    <div class="form-group">
                      <label>GMAT</label>
                      <input type="text" class="form-control" name="GMAT_min" placeholder="GMAT min requirement" value="<?php echo ($major['GMAT_min']); ?>">
                    </div>
                    <div class="form-group">
                      <label>GPA</label>
                      <input type="text" class="form-control" name="GPA_min" placeholder="GPA min requirement" value="<?php echo ($major['GPA_min']); ?>">
                    </div>
                    <div class="form-group">
                      <label>Experience</label>
                      <select id="experience_select" name="experience_min" class="form-control">
                            <?php if(is_array($experience_list)): foreach($experience_list as $key=>$experience): if($major['experience_min'] == $experience['value']): ?><option selected value="<?php echo ($experience['experience_id']); ?>"><?php echo ($experience['experience_name']); ?></option>
                            <?php else: ?><option value="<?php echo ($experience['value']); ?>"><?php echo ($experience['experience_name']); ?></option><?php endif; endforeach; endif; ?>
                      </select>
<!--                      <input type="text" class="form-control" name="experience_min" placeholder="Experience min requirement" value="<?php echo ($major['experience_min']); ?>">-->
                    </div>
                    <div class="form-group">
                      <label>Aims</label>
                      <textarea class="form-control" name="aims" placeholder="Major aims" rows="3"><?php echo ($major['aims']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Prospects</label>
                      <textarea class="form-control" name="prospects" placeholder="Major prospects" rows="3"><?php echo ($major['prospects']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Leaders</label>
                      <textarea class="form-control" name="leaders" placeholder="Major leaders" rows="3"><?php echo ($major['leaders']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Characteristics</label>
                      <textarea class="form-control" name="characteristics" placeholder="Major characteristics" rows="3"><?php echo ($major['characteristics']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Requirements</label>
                      <textarea class="form-control" name="requirements" placeholder="Major requirements" rows="3"><?php echo ($major['requirements']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Fee</label>
                      <textarea class="form-control" name="fee" placeholder="Major fee" rows="3"><?php echo ($major['fee']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Curriculum</label>
                      <textarea class="form-control" name="curriculum" placeholder="Major curriculum" rows="3"><?php echo ($major['curriculum']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Contacts</label>
                      <textarea class="form-control" name="contacts" placeholder="Major contacts" rows="3"><?php echo ($major['contacts']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Remark</label>
                      <textarea class="form-control" name="remark" placeholder="Major remark" rows="3"><?php echo ($major['remark']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Other</label>
                      <input type="text" class="form-control" name="other" placeholder="other" value="<?php echo ($major['other']); ?>">
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>