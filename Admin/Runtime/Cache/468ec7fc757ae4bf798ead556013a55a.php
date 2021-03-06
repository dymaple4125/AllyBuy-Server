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
                    order: [7, "desc"],
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },
                    "columns": [
                        { data:null, defaultContent:"", className:"control"},
                        { data: "major_id", className:"all"},
                        { data: "major_name",   className: "all" },
                        { "data": "department_name",     className: "all" },
                        { "data": "university_name",        className: "all" },
                        { "data": "deadline", className: "all" },
                        { "data": "subject_name",     className: "all" },
                        { "data": "last_modify", className:"all"},
                        { "data": "TOEFL_min",       className: "none" },
                        { "data": "IELTS_min",     className: "none" },
                        { "data": "GRE_min",       className: "none" },
                        { "data": "GMAT_min",     className: "none" },
                        { "data": "GPA_min",       className: "none" },
                        { "data": "experience_min",     className: "none" },
                        { "data": "aims",       className: "none" },
                        { "data": "prospects",     className: "none" },
                        { "data": "leaders",       className: "none" },
                        { "data": "characteristics",     className: "none" },
                        { "data": "requirements",       className: "none" },
                        { "data": "fee",     className: "none" },
                        { "data": "curriculum",       className: "none" },
                        { "data": "contacts",     className: "none" },
                        { "data": "remark",       className: "none" },
                        { "data": "other",       className: "none" }
                    ],
                    columnDefs: [
                    {
                        searchable: false,
                        targets: [0,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23]
                    },
                    {
                        orderable: false,
                        targets: [0,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23]
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
                    
                    location.href   =   "<?php echo U('/major/edit/major_id/"+id+"', '', '');?>";
                });
                
                $('#btn_delete').click( function () {
                    clearMsg();  
                    if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    $('#remove_modal .modal-body p').html("确定要删除《"+table.cell('.selected', 2).data()+"》");
                    $('#remove_modal button[name=remove_btn]').unbind("click");
                    $('#remove_modal button[name=remove_btn]').click(function(){
                        $('#remove_modal').modal('hide');
                        //post data to delete
                        $.post("<?php echo U('delete', '', '');?>", {major_id: table.cell('.selected', 1).data()},
                        function(data){
                            //delete fail
                            if(data['status']==0)
                            {
                                $('#alert_fail').html("删除《"+table.cell('.selected', 2).data()+"》不成功");
                                $('#alert_fail').attr('hidden', false);
                            }
                            else if(data['status']==1)
                            {
                                $('#alert_success').html("删除《"+table.cell('.selected', 2).data()+"》成功");
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
                    <li class="active">Major</li>
                </ol>
                <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                <h4>
                    <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                        <button id="btn_add" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            添加一个Major
                        </button>
                        <button id="btn_edit" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            编辑一个Major
                        </button>
                        <button  id="btn_delete" type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            删除一个Major
                        </button>
                    </div> 
                    
                </h4>                       
                <div>
                    <table id="datatable" class="table table-hover dt-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr class="header">
                                <th width="5%"></th>
                                <th class="all" width="5%">#</th>
                                <th class="all" width="20%">Major</th>
                                <th class="all" width="20%">Department</th>
                                <th class="all" width="20%">University</th>
                                <th class="all" width="10%">Deadline</th>
                                <th class="all" width="10%">Subject</th>
                                <th class="all" width="10%">Last Modify</th>
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
                       
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>