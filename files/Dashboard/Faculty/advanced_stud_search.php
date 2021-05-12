<?php
require_once('../classes/mysql.class.php');

$security = new MySQL();
$security->checkLogin();

$sub1 = "stud_adv_srch";

	$navSecurity = new MySQL();
	$navSecurity->checkNavigation($sub1);

$prog = new MySQL();
$prog->Query("SELECT id,code,name FROM programs");

$campus = new MySQL();
$campus->Query("SELECT id,name FROM campus");


?>
<!DOCTYPE html>
<html>
<head>
	<title>TERM - Advanced Student Search</title>
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

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="../css/lib/font-awesome.css">
    <link rel="stylesheet" href="../css/compiled/tables.css" type="text/css" media="screen" />
    <link href="../css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
    
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


                    <!-- left column -->

                     <div class="container-fluid">

                     <div class="col-lg-12 col-md-6 col-sm-12"><button style="float: right;" id="togbtn" class="btn btn-small btn-success">Toggle Search Form</button></div><br><br>
                         <div class="col-lg-12 col-md-6 col-sm-12" id="schfrm" style="display: block;">


                         <form method="post" name="" action="" id="searchform">

                             <table class="table table-bordered table-responsive table-striped">

                                 <thead>


                                 <tr>
                                     <th colspan="8" style="text-align: center;">Advanced Student Search</th>
                                 </tr>
                                 </thead>
                            <tbody>
                                 <tr>
                                     <td style="width:70px;"></td>

                                     <td style="width:100px;"><strong>Index Number</strong></td>

                                     <td style="width:100px;"><select name="indexnumber_op" id="indexnumber_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                             <option value="LIKE">Contains</option>
                                             <option value="NOT LIKE">Does not contain</option>
                                             <option value="LIKE_BEGIN">Begins With</option>
                                             <option value="LIKE_END">Ends With</option>
                                         </select></td>

                                     <td style="width:150px;"><input style="width:150px;" type="text" class="form-control" value="" name="indexnumber"></td>
                                     <td style="width:70px;"><input name="firstname_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="firstname_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td style="width:100px;"><strong>First Name</strong></td>

                                     <td style="width:100px;"><select name="firstname_op" id="firstname_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                             <option value="LIKE">Contains</option>
                                             <option value="NOT LIKE">Does not contain</option>
                                             <option value="LIKE_BEGIN">Begins With</option>
                                             <option value="LIKE_END">Ends With</option>
                                         </select></td>

                                     <td style="width:150px;"><input style="width:150px;" type="text" class="form-control" value="" name="firstname"></td>

                                 </tr>
                            <tr>
                                <td><input name="middlename_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="middlename_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                <td><strong>Middle Name</strong></td>

                                <td><select name="middlename_op" id="middlename_op" style="width:150px; height: 35px; ">
                                        <option value="=">Equal to</option>
                                        <option value="<>">Not equal to</option>
                                        <option value="LIKE">Contains</option>
                                        <option value="NOT LIKE">Does not contain</option>
                                        <option value="LIKE_BEGIN">Begins With</option>
                                        <option value="LIKE_END">Ends With</option>
                                    </select></td>

                                <td style="width:150px;"><input style="width:150px;" type="text" class="form-control" value="" name="middlename"></td>

                                <td><input name="surname_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="surname_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                <td><strong>Surname</strong></td>

                                <td><select name="surname_op" id="surname_op" style="width:150px; height: 35px; ">
                                        <option value="=">Equal to</option>
                                        <option value="<>">Not equal to</option>
                                        <option value="LIKE">Contains</option>
                                        <option value="NOT LIKE">Does not contain</option>
                                        <option value="LIKE_BEGIN">Begins With</option>
                                        <option value="LIKE_END">Ends With</option>
                                    </select></td>

                                <td  style="width:150px;"><input style="width:150px;" type="text" class="form-control" value="" name="surname"></td>


                            </tr>

                                 <tr>
                                     <td><input name="doa_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="doa_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Date of Admission</strong></td>

                                     <td><select name="doa_op" id="doa_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                             <option value="LIKE">Contains</option>
                                             <option value="NOT LIKE">Does not contain</option>
                                             <option value="LIKE_BEGIN">Begins With</option>
                                             <option value="LIKE_END">Ends With</option>
                                         </select></td>

                                     <td style="width:150px;"><input style="width:150px;" type="text" class="form-control input-datepicker" value="" name="doa" id="doa"></td>

                                     <td><input name="doc_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="doc_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Date of Completion</strong></td>

                                     <td><select name="doc_op" id="doc_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                             <option value="LIKE">Contains</option>
                                             <option value="NOT LIKE">Does not contain</option>
                                             <option value="LIKE_BEGIN">Begins With</option>
                                             <option value="LIKE_END">Ends With</option>
                                         </select></td>

                                     <td  style="width:150px;"><input style="width:150px;" type="text" class="form-control input-datepicker" value="" name="doc"></td>


                                 </tr>

                                 <tr>

                                     <td><input name="progid_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="progid_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Program</strong></td>

                                     <td><select name="progid_op" id="progid_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                         </select></td>

                                     <td style="width:150px;"><select name="progid" style="width:150px; height: 35px;">
                                             <option value="" selected disabled>-SELECT OPTION-</option>
                                             <?php while(!$prog->EndOfSeek()){ $row = $prog->Row(); ?>
                                                 <option value="<?php echo $row->code; ?>" ><?php echo $row->name ?></option>
                                             <?php } ?>
                                         </select></td>

                                     <td><input name="gender_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="gender_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Gender</strong></td>

                                     <td><select name="gender_op" id="gender_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                         </select></td>

                                     <td style="width:150px;"><select style="width:150px; height: 35px;" name="gender" class="form-control">
                                             <option value="" selected disabled>-SELECT OPTION-</option>
                                             <option value="MALE">Male</option>
                                             <option value="FEMALE">Female</option>

                                         </select></td>


                                 </tr>


                                 <tr>

                                     <td><input name="campus_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="campus_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Campus</strong></td>

                                     <td><select name="campus_op" id="campus_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                         </select></td>

                                     <td style="width:150px;"><select name="campus" style="width:150px; height: 35px;">
                                             <option value="" selected disabled>-SELECT OPTION-</option>
                                             <?php while(!$campus->EndOfSeek()){ $row = $campus->Row(); ?>
                                                 <option value="<?php echo $row->name; ?>"><?php echo $row->name ; ?></option>
                                             <?php } ?>
                                         </select></td>

                                     <td><input name="level_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="level_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Level</strong></td>

                                     <td><select name="level_op" id="level_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                         </select></td>

                                     <td style="width:150px;"><select style="width:150px; height: 35px;" name="level" class="form-control">
                                             <option value="" selected disabled>-SELECT OPTION-</option>
                                             <option value="100">L100</option>
                                             <option value="200">L200</option>
                                             <option value="300">L300</option>
                                             <option value="400">L400</option>
                                             <option value="500">L500</option>
                                             <option value="600">L600</option>

                                         </select></td>


                                 </tr>
                                 <tr>

                                     <td><input name="session_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="session_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Session</strong></td>

                                     <td><select name="session_op" id="session_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                         </select></td>

                                     <td style="width:150px;"><select name="session" style="width:150px; height: 35px;">
                                             <option value="" selected disabled>-SELECT OPTION-</option>
                                             <option value="Morning">Morning</option>
                                             <option value="Evening">Evening</option>
                                             <option value="Weekend">Weekend</option>
                                         </select></td>

                                     <td><input name="status_andor" type="radio" value="AND" checked>&nbsp;&nbsp;<strong>AND</strong>&nbsp;&nbsp;<input name="status_andor" type="radio" value="OR">&nbsp;&nbsp;<strong>OR</strong></td>

                                     <td><strong>Student Status</strong></td>

                                     <td><select name="status_op" id="status_op" style="width:150px; height: 35px; ">
                                             <option value="=">Equal to</option>
                                             <option value="<>">Not equal to</option>
                                         </select></td>

                                     <td style="width:150px;"><select style="width:150px; height: 35px;" name="status" class="form-control">
                                             <option value="" selected disabled>-SELECT OPTION-</option>
                                             <option value="active">Active</option>
                                             <option value="suspended">Suspended</option>
                                             <option value="dismissed">Dismissed</option>
                                             <option value="deceased">Deceased</option>
                                             <option value="defered">Defered</option>
                                             <option value="withdrawn">Withdrawn</option>
                                             <option value="inactive">Inactive</option>

                                         </select></td>


                                 </tr>
                                 <tr>
                                     <td colspan="8" style="text-align: center;"></td>
                                 </tr>
                            <tr>
                                <td colspan="8" style="text-align: center;"><input type="submit" name="adsearch" id="adsearch" class="btn btn-primary btn-small" value="Search for Student(s)"></td>
                            </tr>
                            <input type="hidden" name="do" value="advanced_search">
                            </tbody>
                             </table>

                         </form>
                             </div>
                  <hr>



                         <div class="col-lg-12">
                             <p align="center" style="display: none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > searching. Please wait....</p>
                         </div>
                         <br><br><div id="slist">


                         </div>


                    </div>

                    <!-- side right column -->

   </div>
  </div>
</div>

    <!-- end main container -->


	<!-- scripts -->
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/theme.js"></script>
<script src="../js/bootstrap.datepicker.js"></script>
       <script src="../js/delete_activate.js"></script>
   <script src="../js/zebra_dialog.js"></script>

<script type="text/javascript">
    $(function () {

        // datepicker plugin
        $('.input-datepicker').datepicker({format: 'm-yyyy'}).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    });
</script>
    <script type="text/javascript">

        $(function () {

            var $btns = $("#togbtn");
            $btns.click(function (e) {

                var btndisp = $("#schfrm").css( "display" );
                if(btndisp=="block"){

                    $("#schfrm").css("display","none");

                }

                if(btndisp=="none"){

                    $("#schfrm").css("display","block");

                }

            });

        });



        $(function () {

            var $btns = $("#adsearch");
            $btns.click(function (e) {
                e.preventDefault();


                $("#adsearch").attr("disabled", "disabled");
                $("#wait").css("display","block");

                $.ajax({
                    type: "POST",
                    url: "../classes/student.php",
                    data: $('#searchform').serialize(),
                    success: function(e) {

					if(e=="fail"){

                            $("#wait").css("display","none");
                            $("#adsearch").removeAttr('disabled');
                            $('#slist').html("<p class='alert alert-danger' style='text-align: center'><i class='icon-remove-sign'></i> Your search failed</p>")
                            $("#slist").hide().fadeIn(2000);

                        }else if(e=="zero"){

                            $("#wait").css("display","none");
                            $("#adsearch").removeAttr('disabled');
                            $('#slist').html("<p class='alert alert-danger' style='text-align: center'><i class='icon-remove-sign'></i> Your search returned no results</p>")
                            $("#slist").hide().fadeIn(2000);

                        }
                        else{

                            $("#wait").css("display","none");
                            $("#schfrm").css("display","none");
                            $("#adsearch").removeAttr('disabled');
                            $('#slist').empty();
                            $('#slist').html(e);

                        }


                    }
                });
                return false;

            });

        });

		

		
		
    </script>
</body>
</html>