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
                    $('#admin_name').html("<?php echo ($admin_name); ?>，欢迎登陆猎购盟后台系统");                 
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
                    order: [0, "desc"],
                    columns: [
                        { data: "admin_id"},
                        { data: "admin_name"},
                        { data: "email"},
                        { data: "contact"},
                        { data: "logintime"},
                        { data: "loginip"},
                        { mRender: function(data, type, full) {
                                //get status value
                                var status  =   full['status'];
                                
                                if(status==1)
                                {
                                    return "<span class='label label-success'>已通过</span>";
                                }
                                else
                                {
                                    return "<span class='label label-danger'>未通过</span>";
                                }
                            }
                        }
                    ],
                    columndefs:[
                        {
                        searchable: false,
                        targets: [0,4,5,6]
                    }
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
                
               
                $('#btn_confirm').click( function () {
                    clearMsg();  
                    
                    if(table.row('.selected').length==0){
                        alert('你必须选择一行');
                        return;
                    }
                    
                    
                    $('#confirm_modal .modal-body p').html("确定要要通过用户《"+table.cell('.selected', 1).data()+"》");
                    $('#confirm_modal button[name=confirm_btn]').unbind("click");
                    $('#confirm_modal button[name=confirm_btn]').click(function(){
                        $('#confirm_modal').modal('hide');
                        //post data to delete
                        $.post("<?php echo U('confirm', '', '');?>", {admin_id:table.cell('.selected', 0).data()},
                        function(data){
                            //delete fail
                            if(data['status']==0)
                            {
                                alert('用户通过发生错误');
                            }
                            else if(data['status']==1)
                            {
                                alert('通过用户成功');
                                table.ajax.reload();                            
                            }
                            else if(data['status']==-1)
                            {
                                alert('该用户已被通过');
                            }
                        }, 
                        'json');         
                    });
                    
                    $('#confirm_modal').modal('show'); 
                });
            });
        </script>
    </head>
    <body>
         
        <div class="modal fade" id="confirm_modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">通过验证</h4>
                </div>
                <div class="modal-body">
                  <p></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">取消通过</button>
                  <button type="button" class="btn btn-success" name="confirm_btn">确定通过</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--        header-->
        <div id="main_nav"></div>

        <!--        content-->
        <div class="container-fluid">
            <div class="main" style="margin-left: 10px; margin-right: 10px;">
                <ol class="breadcrumb">
                    <li class="active">Administrator</li>
                </ol>
                <div id="alert_fail" class="alert alert-danger" hidden role="alert">删除未成功</div>
                <div id="alert_success" class="alert alert-success" hidden role="alert">删除成功</div>
                <h4>
                    <div class="btn-group btn-group-sm" role="group"  aria-label="todo">
                        <button id="btn_confirm" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            通过验证
                        </button>
                    </div> 
                    
                </h4>                       
                <div>
                    <table id="datatable" class="table table-hover dt-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Admin name</th>
                                <th width="20%">Email</th>
                                <th width="20%">Contact</th>
                                <th width="20%">Time</th>
                                <th width="10%">IP</th>
                                <th width="5%">status</th>
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