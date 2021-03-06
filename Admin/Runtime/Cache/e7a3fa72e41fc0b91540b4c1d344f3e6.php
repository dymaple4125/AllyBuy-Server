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
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/datatables/css/jquery.dataTables.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/datatables/css/dataTables.responsive.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/datatables/css/dataTables.tableTools.min.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="__PUBLIC__/datatables/js/jquery.dataTables.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="__PUBLIC__/datatables/js/dataTables.responsive.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="__PUBLIC__/datatables/js/dataTables.tableTools.min.js"></script>

        <!--load header or footer template -->
        
        <script>
            
            //clear success or fail image
            function clearMsg(){
                if(!$('#alert_success').attr('hidden')){  
                   $('#alert_success').attr('hidden',true);
                }
               
                if(!$('#alert_fail').attr('hidden')){
                    $('#alert_fail').attr('hidden', true);
                }
            }
            
            $(function(){
                $('#main_nav').load("__PUBLIC__/html/nav.html");
                var table = $('#datatable').DataTable({
                    dom: "T<'clear'>lfrtip",
                    tableTools: {
                        "aButtons": [{
                            "sExtends": "xls",
                            "sButtonText": "Save to Excel Table"
                        },
                        {
                            "sExtends": "pdf",
                            "sButtonText": "Save to PDF file"
                        }],
                        "sSwfPath": "__PUBLIC__/datatables/swf/copy_csv_xls_pdf.swf"
                    },
                    "ajax": {
                        "url": "<?php echo U('viewall', '', '');?>",
                        "type": 'POST',
                        "data": {
                            university_id: "<?php echo ($nav['university_id']); ?>"
                        }
                    },
                    pagingType : "full_numbers",
                    order: [0, "desc"],
                    "columns": [
                        { data: "department_id"},
                        { data: "department_name"},
                    ]
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
                
                $('#btn_add').click(function(){
                    location.href   =   "<?php echo U('add', 'university_id='.$nav['university_id'], '');?>";
                });
                
                $('#btn_edit').click(function(){
                   clearMsg();
                   if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    var id  =   table.cell('.selected', 0).data();
                    
                    location.href   =   "<?php echo U('/department/edit/department_id/"+id+"', '', '');?>";
                });
                
                $('#btn_delete').click( function () {
                    clearMsg();  
                    if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    $('#remove_modal .modal-body p').html("确定要删除《"+table.cell('.selected', 1).data()+"》");
                    $('#remove_modal button[name=remove_btn]').unbind("click");
                    $('#remove_modal button[name=remove_btn]').click(function(){
                        $('#remove_modal').modal('hide');
                        //post data to delete
                        $.post("<?php echo U('delete', '', '');?>", {department_id:table.cell('.selected', 0).data()},
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
            <div class="main">
                <ol class="breadcrumb">
                    <li><a href="<?php echo U('country/index', '', '');?>">Country</a></li>
                    <li><a href="<?php echo U('district/index','country_id='.$nav['country_id'], '');?>"><?php echo ($nav['country_name']); ?></a></li>
                    <li><a href="<?php echo U('university/index','district_id='.$nav['district_id'], '');?>"><?php echo ($nav['district_name']); ?></a></li>
                    <li class="active"><?php echo ($nav['university_name']); ?></li>
                </ol>
                <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                <h4>
                    <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                        <button id="btn_add" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            Add a new record
                        </button>
                        <button id="btn_edit" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            Edit selected record
                        </button>
                        <button  id="btn_delete" type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            Delete selected record
                        </button>
                    </div> 
                    
                </h4>                       
                <div>
                    <table id="datatable" class="table table-hover dt-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="95%">Department</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>