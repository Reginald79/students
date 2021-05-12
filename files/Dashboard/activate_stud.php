<?php
session_start();
require_once('../classes/mysql.class.php');
$security = new MySQL();
$security->checkLogin();

$prog = new MySQL;
$prog->Query("SELECT * FROM programs ORDER BY name");

$camp = new MySQL;
$camp->Query("SELECT * FROM campus WHERE status = 1");



?>
<!DOCTYPE html>
<html>
<head>
	<title>TERM - Activate Student</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- bootstrap -->
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/bootstrap/flat-ui.min.css">
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/elements.css">
    <link rel="stylesheet" type="text/css" href="../css/icons.css">
    <link rel="stylesheet" type="text/css" href="../css/zebra_dialog.css">

    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/jquery.dataTables_themeroller.css">

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="../css/lib/font-awesome.css">
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../css/compiled/new-user.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>

<?php require_once('../nav.php'); ?>
<!-- end navbar -->

<!-- sidebar -->
<?php require_once('../menu.php'); ?>



	<!-- main container -->
    <div class="content">
              
        <div class="container-fluid">
            <div id="pad-wrapper" class="new-user">
                <hr>
                    <!-- left column -->

                     <div class="container-fluid">
					 
					 <h5> <div id="confirmation" style="text-align:center">
                             <p align="center" style="display: none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > Activating student. Please wait....</p>
					 </div></h5>

                         <div class="col-lg-12 col-md-6 col-sm-12"><br>

                             <form method="post" name="actForm" id="actForm"  action="process_activation.php">

                                 <table class="table table-bordered table-condensed table-responsive table-striped" >
                                     <tr>
                                         <td colspan="7" style="text-align: center"><strong>Student Account Activation</strong></td>
                                     </tr>

                                     <tr>
                                         <td><strong>Student ID:</strong></td>
                                         <td><input type="text" value="<?php echo base64_decode($_GET['sid']); ?>" class="form-control"  name="sid" id="sid" readonly></td>

                                         <td><strong>Level:</strong></td>
                                         <td><select name="level" id="level" class="form-control" style="height: 35px;">
										 <option <?php if(!strcmp("100",base64_decode($_GET['level']))){ echo "selected";} ?> value="100">100</option>
										 <option <?php if(!strcmp("200",base64_decode($_GET['level']))){ echo "selected";} ?> value="200">200</option>
										 <option <?php if(!strcmp("300",base64_decode($_GET['level']))){ echo "selected";} ?> value="300">300</option>
										 <option <?php if(!strcmp("400",base64_decode($_GET['level']))){ echo "selected";} ?> value="400">400</option>
										 </select></td>

                                         <td><strong>Session:</strong></td>
                                         <td><select name="session" id="session" class="form-control" style="height: 35px;">
										 <option <?php if(!strcmp("Morning",base64_decode($_GET['session']))){ echo "selected";} ?> value="Morning">Morning</option>
										 <option <?php if(!strcmp("Evening",base64_decode($_GET['session']))){ echo "selected";} ?> value="Evening">Evening</option>
										 <option <?php if(!strcmp("Weekend",base64_decode($_GET['session']))){ echo "selected";} ?> value="Weekend">Weekend</option>
										 </select></td>
                                     </tr>
                                     <tr>
                                         <td><strong>Program:</strong></td>
                                         <td><select name="prog" id="prog" class="form-control" style="height: 35px;">
                                       
                                                 <?php while(!$prog->EndOfSeek()){$prow = $prog->Row();?>
                                                     <option <?php if(!strcmp($prow->code,base64_decode($_GET['prog']))){ echo "selected";} ?> value="<?php echo $prow->code; ?>">
													 <?php echo $prow->name ;?>
													 </option>
                                                 <?php }?>
                                             </select></td>
                                         <td><strong>Phone:</strong></td>
                                         <td><input type="text" class="form-control"  name="phone" id="phone" value="<?php echo base64_decode($_GET['phone']); ?>"></td>									
                                         <td><strong>Campus:</strong></td>
                                         <td><select name="campus" id="campus" class="form-control" style="height: 35px;">
                                                 <?php while(!$camp->EndOfSeek()){$crow = $camp->Row();?>
                                                     <option <?php if(!strcmp($crow->name,base64_decode($_GET['campus']))){ echo "selected";} ?> value="<?php echo $crow->name; ?>">
													 <?php echo $crow->name ;?>
													 </option>
                                                 <?php }?>
                                             </select></td>
                                     </tr>
									 <tr>
									 <td><strong>Fees Receipt #:</strong></td><td><input type="text" value="" class="form-control"  name="fees" id="fees"></td>
									 <td><strong>SRC Receipt #:</strong></td><td><input type="text" value="" class="form-control"  name="src" id="src"></td>
									 <td><strong>ISA Receipt #:</strong></td><td><input type="text" value="" class="form-control"  name="isa" id="isa"></td>
									 <td><input type="submit" name="activate" id="activate" class="btn btn-success" value="Activate"></td>
									 </tr>
                                 </table>
                             </form>
                             </div><br>
                         <hr>
                    </div>
   </div>
  </div>
</div>
        <div>

        </div>

    <!-- end main container -->

    <script type="text/javascript" charset="utf8" src="../DataTables/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="../DataTables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="../DataTables/media/js/jquery.dataTables.min.js"></script>

	<!-- scripts -->
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->


    <script src="../js/jquery-latest.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jqueryformplugin.js"></script>
    <script src="../js/theme.js"></script>
    <script src="../js/zebra_dialog.js"></script>
    <script src="../js/delete_activate.js"></script>
    <script type="text/javascript">
                $(function () {

            var $btns = $("#activate");
            $btns.click(function (e) {
                e.preventDefault();
                $("#wait").css("display","block");
                $("#activate").attr("disabled", "disabled");

                $.ajax({
                    type: "POST",
                    url: "process_activation.php",
                    data: $('#actForm').serialize(),
                    success: function(e) {
					

                        if(e=="fail"){
                            $("#wait").css("display","none");
                            $("#activate").removeAttr('disabled');

                            $('#sid').val("");
                            $('#phone').val("");
                           
                            $('#confirmation').html("<div align='center'><span class='alert alert-danger'><i class='icon icon-remove-sign'></i> Activation Failed</span></div>")
                            $("#confirmation").hide().fadeIn(2000).fadeOut(4000);

                        }else if(e=="ok"){

                            $("#wait").css("display","none");
                            $("#activate").removeAttr('disabled');

                            $('#sid').val("");
                            $('#phone').val("");
                            $('#confirmation').html("<div align='center'><span class='alert alert-success'><i class='icon icon-ok-sign'></i> Activation successful</span></div>")
                            $("#confirmation").hide().fadeIn(2000).fadeOut(4000);

                        }else if(e=="empty"){

                            $("#wait").css("display","none");
                            $("#activate").removeAttr('disabled');

                            $('#sid').val("");
                            $('#phone').val("");
                            $('#confirmation').html("<div align='center'><span class='alert alert-danger'><i class='icon icon-remove-sign'></i> Complete all fields before activating</span></div>")
                            $("#confirmation").hide().fadeIn(2000);

                        }else if(e=="nonexistent"){

                            $("#wait").css("display","none");
                            $("#activate").removeAttr('disabled');

                            $('#sid').val("");
                            $('#phone').val("");
                            $('#confirmation').html("<div align='center'><span class='alert alert-danger'><i class='icon icon-remove-sign'></i> Student ID doesnot exist in the system</span></div>")
                            $("#confirmation").hide().fadeIn(2000);

                        }


                    }
                });
                return false;

            });

        });
    </script>
    

    
</body>
</html>