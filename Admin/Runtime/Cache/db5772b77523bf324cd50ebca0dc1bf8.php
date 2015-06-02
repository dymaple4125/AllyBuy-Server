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
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/datatables/css/jquery.dataTables.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/datatables/css/dataTables.responsive.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="__PUBLIC__/datatables/js/jquery.dataTables.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="__PUBLIC__/datatables/js/dataTables.responsive.min.js"></script>

        <!--load header or footer template -->
        <script>

            //function to add major
            function add(){
                location.href   =   "<?php echo U('add', '', '');?>";
            }

            //function to edit
            function edit(major_id){
                location.href   =   "<?php echo U('/major/edit/major_id/"+major_id+"', '', '');?>";
            }
            
            //function to view
            function view(major_id){
                location.href   =   "<?php echo U('/major/view/major_id/"+major_id+"', '', '');?>";
            }
            
            function nav(major_id){
                location.href   =   "<?php echo U('/district/viewall/major_id/"+major_id+"', '', '');?>";
            }
    
            function del(major_id, major_name){
                
                clearStatus();
                
                $('#remove_modal .modal-body p').html("确定要删除《"+major_name+"》吗?");
                $('#remove_modal button[name=remove_btn]').unbind("click");
                $('#remove_modal button[name=remove_btn]').click(function(){
                    $('#remove_modal').modal('hide');
                    //post data to delete
                    $.post("<?php echo U('delete', '', '');?>", {major_id:major_id},
                    function(data){
                        //delete fail
                        if(data['status']==0)
                        {
                            $('#alert_fail').html("删除《"+major_name+"》不成功");
                            $('#alert_fail').attr('hidden', false);
                        }
                        else if(data['status']==1)
                        {
                            $('#alert_success').html("删除《"+major_name+"》成功");
                            $('#alert_success').attr('hidden', false);
                            $('#major'+major_id).remove();
                        }
                        location.href="#";
                    }, 
                    'json');         
                });
                $('#remove_modal').modal('show'); 
                
            }
            
            
            $(function(){
                $('#main_nav').load("__PUBLIC__/html/nav.html", function(){                     $('#admin_name').html("{$admin_name}，欢迎登陆猎购盟后台系统");                 });  
                $('#datatable').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },
                    columnDefs: [ {
                        className: 'control',
                        targets:   0
                    },
                    {
                        searchable: false,
                        targets: [0,1,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    },
                    {
                        orderable: false,
                        targets: [0,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    }
                    ],
                    order: [ 1, 'desc' ],
                    "pagingType": "full_numbers"
                });
                   
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
                    <h4 class="modal-title" style="color: white;" >删除major</h4>
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
                <div id="side_nav" class="col-sm-2 col-md-2 sidebar"></div> 
                
                <div class="col-sm-10 col-md-10 main">
                    <ol class="breadcrumb">
                        <li class="active">Major</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                   
                 
                        <h4>
                            <button type="button" class="btn btn-success" onclick="javascript:add();">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add
                            </button>
                        </h4>
                        <table class="table table-hover dt-responsive no-wrap" id="datatable" cellspacing="0" width="100%">
                            <thead>
                                <tr class="header">
                                    <th class="all" width="5%"></th>
                                    <th class="all" width="5%">#</th>
                                    <th class="all" width="25%">Major Name</th>
                                    <th class="all" width="20%">Department</th>
                                    <th class="all" width="20%">University</th>
                                    <th class="all" width="10%">Deadline</th>
                                    <th class="all" width="15%"></th>
                                    <th class="none">Subject</th>
                                    <th class="none">TOEFL</th>
                                    <th class="none">IELTS</th>
                                    <th class="none">GRE</th>
                                    <th class="none">GMAT</th>
                                    <th class="none">GPA</th>
                                    <th class="none">experience</th>
                                    <th class="none">Aims</th>
                                    <th class="none">Prospects</th>
                                    <th class="none">Leaders</th>
                                    <th class="none">Characteristics</th>
                                    <th class="none">Requirements</th>
                                    <th class="none">Fee</th>
                                    <th class="none">Curriculum</th>
                                    <th class="none">Contacts</th>
                                    <th class="none">Remark</th>
                                    <th class="none">Other</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($major_list)): foreach($major_list as $key=>$major): ?><tr id="major<?php echo ($major['major_id']); ?>">
                                        <td></td>
                                        <td style="color: lightgrey;"><?php echo ($major['major_id']); ?></td>
                                        <td><?php echo ($major['major_name']); ?></td>
                                        <td><?php echo ($major['department_name']); ?></td>
                                        <td><?php echo ($major['university_name']); ?></td>
                                        <td><?php echo ($major['deadline']); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                                                <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapse<?php echo ($major['major_id']); ?>" aria-expanded="false" aria-controls="collapse<?php echo ($major['major_id']); ?>">
                                                    <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" onclick="javascript:edit(<?php echo ($major['major_id']); ?>);">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="javascript:del(<?php echo ($major['major_id']); ?>,'<?php echo ($major['major_name']); ?>');">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                </button>
                                            </div> 
                                        </td>
                                        <td><?php echo ($major['subject_name']); ?></td>
                                        <td><?php echo ($major['TOEFL_min']); ?></td>
                                        <td><?php echo ($major['IELTS_min']); ?></td>
                                        <td><?php echo ($major['GRE_min']); ?></td>
                                        <td><?php echo ($major['GMAT_min']); ?></td>
                                        <td><?php echo ($major['GPA_min']); ?></td>
                                        <td><?php echo ($major['experience_min']); ?></td>
                                        <td><?php echo ($major['aims']); ?></td>
                                        <td><?php echo ($major['prospects']); ?></td>
                                        <td><?php echo ($major['leaders']); ?></td>
                                        <td><?php echo ($major['characteristics']); ?></td>
                                        <td><?php echo ($major['requirements']); ?></td>
                                        <td><?php echo ($major['fee']); ?></td>
                                        <td><?php echo ($major['curriculum']); ?></td>
                                        <td><?php echo ($major['contacts']); ?></td>
                                        <td><?php echo ($major['remark']); ?></td>
                                        <td><?php echo ($major['other']); ?></td>   
                                    </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </body>
</html>