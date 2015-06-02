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
        <!-- 加入自主创建的CSS样式  -->
        <link rel="stylesheet" href="__PUBLIC__/css/custom.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!--load header or footer template -->
        <script>
            
            
            //function to add department
            function add(university_id){
                location.href   =   "<?php echo U('/department/add/university_id/"+university_id+"', '', '');?>";           
            }

            //function to edit
            function edit(department_id){
                location.href   =   "<?php echo U('/department/edit/department_id/"+department_id+"', '', '');?>";
            }
            
            //function to view
            function view(department_id){
                location.href   =   "<?php echo U('/department/view/department_id/"+department_id+"', '', '');?>";
            }
            
            function nav(department_id){
                location.href   =   "<?php echo U('/department/viewall/department_id/"+department_id+"', '', '');?>";
            }
    
            function del(department_id, department_name){
                
                clearStatus();
                
                $('#remove_modal .modal-body p').html("确定要删除《"+department_name+"》吗?");
                $('#remove_modal button[name=remove_btn]').unbind("click");
                $('#remove_modal button[name=remove_btn]').click(function(){
                    $('#remove_modal').modal('hide');
                    //post data to delete
                    $.post("<?php echo U('delete', '', '');?>", {department_id:department_id},
                    function(data){
                        //delete fail
                        if(data['status']==0)
                        {
                            $('#alert_fail').html("删除《"+department_name+"》不成功");
                            $('#alert_fail').attr('hidden', false);
                        }
                        else if(data['status']==1)
                        {
                            $('#alert_success').html("删除《"+department_name+"》成功");
                            $('#alert_success').attr('hidden', false);
                            $('#department'+department_id).remove();
                        }
                        location.href="#";
                    }, 
                    'json');         
                });
                $('#remove_modal').modal('show'); 
                
            }
            
            
            $(function(){
               
               $('#main_nav').load("__PUBLIC__/html/nav.html", function(){                     $('#admin_name').html("{$admin_name}，欢迎登陆Majorbox后台系统");                 });
               $('#side_nav').load("__PUBLIC__/html/basic.info.side.nav.html");
               
            });
            
            //clear success or fail image
            function clearStatus(){
                if(!$('#alert_success').attr('hidden')){  
                   $('#alert_success').attr('hidden',true);
                }
               
                if(!$('#alert_fail').attr('hidden')){
                    $('#alert_fail').attr('hidden', true);
                }
            }
            
        </script>
    </head>
    <body>
        
        <div class="modal fade" id="remove_modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header" style="background-color:  darkred;">
                    <h4 class="modal-title" style="color: white;" >删除department</h4>
                </div>
                <div class="modal-body">
                  <p></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">不要删除</button>
                  <button type="button" class="btn btn-danger" name="remove_btn">确定删除</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!--        header-->
        <div id="main_nav"></div>

        <!--        content-->
        <div class="container-fluid">
            <div class="row">
<!--                side bar-->
                <div id="side_nav" class="col-sm-3 col-md-2 sidebar"></div> 
                
                <div class="col-sm-10 col-md-10 main">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo U('country/viewall', '', '');?>">Root</a></li>
                        <li><a href="<?php echo U('district/viewall','country_id='.$nav['country_id'], '');?>"><?php echo ($nav['country_name']); ?></a></li>
                        <li><a href="<?php echo U('university/viewall','district_id='.$nav['district_id'], '');?>"><?php echo ($nav['district_name']); ?></a></li>
                        <li class="active"><?php echo ($nav['university_name']); ?></li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                    <h3>
                        <button type="button" class="btn btn-success" onclick="javascript:add(<?php echo ($nav['university_id']); ?>);">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add
                        </button>  
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed" style="text-align: center;">
                            <?php if(is_array($department_list)): foreach($department_list as $key=>$department): ?><tr id="department<?php echo ($department['department_id']); ?>">
                                    <td style="color: lightgrey;">#<?php echo ($department['department_id']); ?></td>
                                    <td style="width: 80%;"><?php echo ($department['department_name']); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                                            <button type="button" class="btn btn-default" onclick="javascript:view(<?php echo ($department['department_id']); ?>);">
                                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn btn-default" onclick="javascript:edit(<?php echo ($department['department_id']); ?>);">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="javascript:del(<?php echo ($department['department_id']); ?>,'<?php echo ($department['department_name']); ?>');">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </button>
                                        </div> 
                                    </td>
                                </tr><?php endforeach; endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>