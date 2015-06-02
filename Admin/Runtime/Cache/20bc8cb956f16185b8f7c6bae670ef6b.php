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
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="__PUBLIC__/datatables/js/jquery.dataTables.min.js"></script>

        <!--load header or footer template -->
        
        <script>
            
            //clear success or fail image
            function clearStatus(){
                if(!$('#alert_success').attr('hidden')){  
                   $('#alert_success').attr('hidden',true);
                }
               
                if(!$('#alert_fail').attr('hidden')){
                    $('#alert_fail').attr('hidden', true);
                }
            }
            
            //function to add subject
            function add(){
                location.href   =   "<?php echo U('add');?>";
            }

            function edit(subject_id){
                location.href   =   "<?php echo U('/subject/edit/subject_id/"+subject_id+"', '', '');?>";
            }

            //function to remove subject
            function del(subject_id, subject_name){
                
                
                $('#remove_modal .modal-body p').html("确定要删除《"+subject_name+"》吗?");
                
                $('#remove_modal button[name=remove_btn]').unbind("click");
                $('#remove_modal button[name=remove_btn]').click(function(){
                    $('#remove_modal').modal('hide');
                    //post data to delete
                    $.post("<?php echo U('delete', '', '');?>", {subject_id:subject_id},
                    function(data){
                        //delete fail
                        if(data['status']==0)
                        {
                            $('#alert_fail').html("删除《"+subject_name+"》不成功");
                            $('#alert_fail').attr('hidden', false);
                        }
                        else if(data['status']==1)
                        {
                            $('#alert_success').html("删除《"+subject_name+"》成功");
                            $('#alert_success').attr('hidden', false);
                            $('#subject'+subject_id).remove();
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
                var table = $('#datatable').DataTable({
                    pagingType : "full_numbers",
                    order: [0, "desc"]
                });
                
                $('#datatable tbody').on( 'click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
                $('#btn_delete').click( function () {
                    clearStatus();  
                    if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    $('#remove_modal .modal-body p').html("确定要删除《"+table.cell('.selected', 1).data()+"》");
                    $('#remove_modal button[name=remove_btn]').unbind("click");
                    $('#remove_modal button[name=remove_btn]').click(function(){
                        $('#remove_modal').modal('hide');
                        //post data to delete
                        $.post("<?php echo U('delete', '', '');?>", {subject_id:table.cell('.selected', 0).data()},
                        function(data){
                            //delete fail
                            if(data['status']==0)
                            {
                                $('#alert_fail').html("删除《"+table.cell('.selected', 1).data()+"》不成功");
                                $('#alert_fail').attr('hidden', false);
                            }
                            else if(data['status']==1)
                            {
                                $('#alert_success').html("删除《"+table.cell('.selected', 1).data()+"》成功");
                                $('#alert_success').attr('hidden', false);
                                table.row('.selected').remove().draw( false );
                            }
                            //location.href="#";
                        }, 
                        'json');         
                    });
                    
                    $('#remove_modal').modal('show'); 
                });
            });
        </script>
    </head>
    <body>
        
        <div class="modal fade" id="remove_modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header" style="background-color:  darkred;">
                    <h4 class="modal-title" style="color: white;" >删除</h4>
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
                        <li class="active">subject</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                    <h4>
                        <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                            <button type="button" class="btn btn-default" onclick="javascript:edit(<?php echo ($subject['subject_id']); ?>);">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            </button>
                            <button  id="btn_delete" type="button" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </div> 
                        <button type="button" class="btn btn-success" onclick="location.href='__APP__/subject/add';">Add</button>
                    </h4>                       
                    <div>
                        <table class="table table-hover dt-responsive no-wrap" id="datatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="95%">Subject Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($subject_list)): foreach($subject_list as $key=>$subject): ?><tr id="subject<?php echo ($subject['subject_id']); ?>">
                                        <td style="color: lightgrey;"><?php echo ($subject['subject_id']); ?></td>
                                        <td><?php echo ($subject['subject_name']); ?></td>
                                    </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>