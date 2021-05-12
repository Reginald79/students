<?php
session_start();
require_once('../classes/mysql.class.php');
$security = new MySQL();
$security->checkLogin();

	$sub1 = "act_history";

	$navSecurity = new MySQL();
	$navSecurity->checkNavigation($sub1);
?>
<!DOCTYPE html>
<html>
<head>
	<title>TERM - Check Student Account Activation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- bootstrap -->
	
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="../css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../css/lib/font-awesome.css" type="text/css" rel="stylesheet" />
    <link href="../css/lib/jquery.dataTables.css" type="text/css" rel="stylesheet" />
    
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/elements.css">
    <link rel="stylesheet" type="text/css" href="../css/icons.css">

    <!-- this page specific styles -->
    <link rel="stylesheet" href="../css/compiled/index.css" type="text/css" media="screen" />   

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <!-- navbar -->
	<?php require_once('../nav.php'); ?>
    <!-- end navbar -->

    <!-- sidebar -->
    <?php require_once('../menu.php'); ?>
    <!-- end sidebar -->


	<!-- main container -->
    <div class="content">

        <div class="container-fluid"><br>
            		<div class="col-lg-12 col-md-6 col-sm-12">
                                  		   		
			<form method="POST" action="" id="find_stud_form">
			
			<table style="width: 600px;" align="center" class="table table-striped table-bordered table-hover table-responsive">
				<thead>
				
				<tr>
                    <th colspan="3" style="text-align: center;"><h5><strong>Student Account Activation History</strong></h5></th>
				</tr>
				</thead>
				<tbody>
						
				
					  <tr>
                          <th style="width: 200px; text-align: right;">Student ID :</th>
					  <td><input type="text" name="stud_num_act" id="stud_num_act" class="form-control" data-toggle="tooltip" data-trigger="focus" title="Please insert a valid GTUC student ID number"><div id="inumerror"></div></td>
					  

					  
				
					 
					  <td><input type="submit" name="find" id="find" class="btn btn-flat" value="Find Activation History"></td>
					  </tr>
					  

				 </tbody>
				</table>
                    <input type="hidden" name="do" value="activationHistory">
				</form>
				</div>


		<hr>
			<div class="col-lg-12 col-md-6 col-sm-12" id="result"><br>


			</div><br>

            <div>
                <p align="center" style="display: none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > processing. Please wait....</p>
            </div>
			
			
        </div>
    </div>
    <div class="modal fade" id="procwithdrawal" role="dialog" style="width: 700px;">
        <div class="modal-dialog" style="width: 700px;">
            <div class="modal-content" style="width: 700px;">

                <div class="modal-header" style="text-align: center;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div><h5><strong><i class="icon icon-edit"></i>Edit Student Account Activation</strong></h5></div>

                </div>
                <div class="modal-body">
                    <div style="display:none; text-align: center; color: limegreen;" id="w_wait"><img src="../img/uploading.gif" > processing. Please wait....</div>
                    <div id="w_record"></div>
                    <div id="w_result"></div>

                    <div id="w_record"></div>
                </div>


            </div>

        </div>
    </div>
	<!-- scripts -->
	
	<script type="text/javascript" src="DataTables/media/js/jquery.js"></script>

	
	
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>

    <!-- knob -->
    <script src="../js/jquery.knob.js"></script>
    <!-- flot charts -->
    <script src="../js/jquery.flot.js"></script>
    <script src="../js/jquery.flot.stack.js"></script>
    <script src="../js/jquery.flot.resize.js"></script>
    <script src="../js/theme.js"></script>

    <script type="text/javascript" charset="utf-8">
	$(function () {

            var $btns = $("#find");
            $btns.click(function (e) {
                e.preventDefault();

                $("#inumerror").empty();
                $("#result").empty();
                var inum = $.trim($("#stud_num_act").val());


                if(inum.length == 0){

                    $("#inumerror").html('<p><small style="color:red;">Field Required!</small><p/>');

                }

                if(inum.length != 0){

                   $("#wait").css("display","block");

                $.ajax({
                    type: "POST",
                    url: "../classes/student.php",
                    data: $('#find_stud_form').serialize(),
                    success: function(e) {

                        if(e=="form_incomplete"){

                            $("#wait").css("display","none");

                            $("#result").html("<br><div align='center'><span class='alert alert-danger' style='text-align: center'> Complete search field before searching. Do not leave it blank.</span></div>");
                            $("#result").hide().fadeIn(2000);

                        }else if(e=="zero"){

                            $("#wait").css("display","none");

                            $("#result").html("<br><div align='center'><span class='alert alert-danger' style='text-align: center;'> No data found.</span></div>");
                            $("#result").hide().fadeIn(2000);

                        }else{

                            $("#wait").css("display","none");
                            $('#result').html(e);

                        }
							

                            
                    }
                });
                return false;
                }

            });

        });
	
        $(document).on("click","#edit",function (e) {
            $("#w_wait").css("display","block");
            var indexnumber = $(this).data("index");
            var acy = $(this).data("acy");
            var id = $(this).data("id");
            $.ajax({
                type:"POST",
                url:"prepEditPage.php",
                data:{indexnumber:indexnumber,acy:acy,id:id},
                success:function (data) {
                    $("#w_wait").css("display","none");
                        $("#w_result").html(data);
                }
            })
        });
        $(document).on("click","#saveWith",function (e) {
            e.preventDefault();
            $("#w_wait").css("display","block");
            $("#saveWith").attr("disabled","disabled");
            var form = $("#processActivationEditForm").serialize();
            $.ajax({
                type:"POST",
                url:"updateActivation.php",
                data:form,
                success:function (data) {
                    $("#w_wait").css("display","none");
                    $(this).attr("disabled","disabled");
                    if(data === "success")
                    {
                            $("#w_record").html("<p class='alert alert-success'>Activation updated successfully</p>");
                        $(".alert-success").delay(1500).fadeTo("slow", 0.0);
                    }else{
                        $("#w_record").html("<p class='alert alert-danger'>Activation update unsuccessfully</p>");
                        $(".alert-danger").delay(1500).fadeTo("slow", 0.0);
                    }
                }
            })
        });
        $(document).on("click","#delete",function (e) {
            e.preventDefault();
            $("#w_wait").css("display","block");
            $(this).attr("disabled","disabled");
            var form = $("#processActivationEditForm").serialize();
            $.ajax({
                type:"POST",
                url:"deleteActivation.php",
                data:form,
                success:function (data) {
                    $("#w_wait").css("display","none");
                    $("#delete").attr("disabled","disabled");
                    if(data === "success")
                    {
                            $("#w_record").html("<p class='alert alert-success'>Activation deleted successfully</p>");
                        $(".alert-success").delay(1500).fadeTo("slow", 0.0);
                    }else{
                        $("#w_record").html("<p class='alert alert-danger'>Activation delete unsuccessfully</p>");
                        $(".alert-danger").delay(1500).fadeTo("slow", 0.0);
                    }
                }
            })
        });

    </script>


	
</body>
</html>