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
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/datatables/css/dataTables.tableTools.min.css">
        <!--加入zebra独有样式表-->
        <link rel="stylesheet" href="__PUBLIC__/css/zebra.css">
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
                $('#main_nav').load("__PUBLIC__/html/nav.html", function(){
                    $('#admin_name').html("<?php echo ($admin_name); ?>，欢迎登陆Majorbox后台系统");
                });
                
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
                    ajax: "<?php echo U('viewall', '', '');?>",
                    pagingType : "full_numbers",
                    order: [11, "desc"],
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },
                    "columns": [
                        { data:null, defaultContent:"", className:"control"},
                        { data: "user_id", className:"all"},
                        { data: "user_name",   className: "all" },
                        { "data": "nick_name",     className: "all" },
                        { "data": "email",     className: "all" },
                        { "data": "subject_name",       className: "all" },
                        { "data": "TOEFL",       className: "all" },
                        { "data": "IELTS",     className: "all" },
                        { "data": "GRE",       className: "all" },
                        { "data": "GMAT",     className: "all" },
                        { "data": "GPA",       className: "all" },
                        { "data": "last_modify", className: "all"},
                        { "data": "experience_name",     className: "none" },
                        { "data": "sex",        className: "none" },
                        { "data": "home_town", className: "none" },
                        { "data": "address",     className: "none" },
                        { "data": "phone",     className: "none" },
                        { "data": "reg_time",     className: "none" },
                        { "data": "country_name",       className: "none" },
                        { "data": "background_name",     className: "none" }
                    ],
                    columnDefs: [
                    {
                        searchable: false,
                        targets: [0,6,7,8,9,10,12,13,14,15,16,17,18,19]
                    },
                    {
                        orderable: false,
                        targets: [0,12,13,14,15,16,17,18,19]
                    }]
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
                    location.href   =   "<?php echo U('add', '', '');?>";
                });
                
                $('#btn_edit').click(function(){
                   clearMsg();
                   if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    var id  =   table.cell('.selected', 1).data();
                    
                    location.href   =   "<?php echo U('/user/edit/user_id/"+id+"', '', '');?>";
                });
                
                $('#btn_delete').click( function () {
                    clearMsg();  
                    if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    $('#remove_modal .modal-body p').html("确定要删除ID为《"+table.cell('.selected', 1).data()+"》的用户");
                    $('#remove_modal button[name=remove_btn]').unbind("click");
                    $('#remove_modal button[name=remove_btn]').click(function(){
                        $('#remove_modal').modal('hide');
                        //post data to delete
                        $.post("<?php echo U('delete', '', '');?>", {user_id: table.cell('.selected', 1).data()},
                        function(data){
                            //delete fail
                            if(data['status']==0)
                            {
                                $('#alert_fail').html("删除ID为《"+table.cell('.selected', 1).data()+"》的用户不成功");
                                $('#alert_fail').attr('hidden', false);
                            }
                            else if(data['status']==1)
                            {
                                $('#alert_success').html("删除ID为《"+table.cell('.selected', 1).data()+"》的用户成功");
                                $('#alert_success').attr('hidden', false);
                                table.row('.selected').remove().draw( false );
                            }
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
                    <li class="active">User</li>
                </ol>
                <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                <h4>
                    <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                        <button id="btn_add" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            添加一个User
                        </button>
                        <button id="btn_edit" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            编辑一个User
                        </button>
                        <button  id="btn_delete" type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            删除一个User
                        </button>
                    </div> 
                    
                </h4>                       
                <div>
                    <table id="datatable" class="table table-hover dt-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr class="header">
                                <th width="5%"></th>
                                <th class="all" width="5%">#</th>
                                <th class="all" width="10%">User</th>
                                <th class="all" width="10%">Nick name</th>
                                <th class="all" width="15%">Email</th>
                                <th class="all" width="20%">Subject</th>
                                <th class="all" width="5%">TOEFL</th>
                                <th class="all" width="5%">IELTS</th>
                                <th class="all" width="5%">GRE</th>
                                <th class="all" width="5%">GMAT</th>
                                <th class="all" width="5%">GPA</th>
                                <th class="all" width="10%">Last Modify</th>
                                <th class="none">Experience</th>
                                <th class="none">Sex</th>
                                <th class="none">Home Town</th>
                                <th class="none">Address</th>
                                <th class="none">Phone</th>
                                <th class="none">Reg</th>
                                <th class="none">Country</th>
                                <th class="none">Background</th>
                            </tr>
                        </thead>
                       
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>