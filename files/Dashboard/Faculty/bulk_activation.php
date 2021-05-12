<?php
session_start();
require_once('../classes/mysql.class.php');
$security = new MySQL();
$security->checkLogin();

$prog = new MySQL;
$prog->Query("SELECT * FROM programs ORDER BY `name` ASC");

$acy = new MySQL;
$acy->Query("SELECT * FROM gb_years ORDER BY id DESC");

$acy_intake = new MySQL;
$acy_intake->Query("SELECT * FROM intakes ORDER BY id DESC");

$courseLogs = new MySQL;
$sql = "SELECT gb_header.id, gb_header.session, gb_header.status, CONCAT(courses.`code`,' - ',courses.`name`) AS course, gb_header.credit AS credit, CONCAT(staff_employee_pdetail.fname,staff_employee_pdetail.lname) AS lecturer, programs.`code` AS program, gb_header.level
FROM gb_header INNER JOIN courses ON gb_header.courseid = courses.id
INNER JOIN staff_employee_pdetail ON gb_header.lecturerid = staff_employee_pdetail.empID
INNER JOIN programs ON gb_header.program_code = programs.code COLLATE latin1_general_ci";
/*
if(isset($_SESSION['term_User']['sid']) && $_SESSION['term_User']['sid']!="2"){
$sid = $_SESSION['term_User']['sid'];
$sql = "$sql WHERE gb_header.lecturerid = $sid";	
}
*/
$courseLogs->Query($sql);
$courseLogs->MoveFirst();
$select = "<select class='form-control' name='campus' style='width:95px;' size='1.5'>";
$empid = $_SESSION['term_User']['sid'];
$lec = new MySQL;
$lec->Query("SELECT campus FROM usr_users WHERE sid = $empid");
$lec->MoveFirst();
$get_row =  $lec->Row();
if($get_row->campus == "All" || $get_row->campus == "all")
{
    $campus = new MySQL();
    $campus->Query("SELECT name from campus ORDER BY `name` ASC");
    while (!$campus->EndOfSeek())
    {
        $get_campus = $campus->Row();
        $select .=  "<option value=\"$get_campus->name\">$get_campus->name</option>";
    }


}
else
{
    $select .=  "<option value=\"$get_row->campus\">$get_row->campus</option>";
}
$select .= "</select>"
?>
<!DOCTYPE html>
<html>
<head>
    <title>TERM - BULK REGISTERATION</title>
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
    <link href="../css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/elements.css">
    <link rel="stylesheet" type="text/css" href="../css/icons.css">

    <!-- this page specific styles -->
    <link href="../css/lib/jquery.dataTables.css" type="text/css" rel="stylesheet" />
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

    <div class="container-fluid">
        <div class="col-lg-12 col-md-6 col-sm-12" style="border-top:1px solid grey;"><br><br>

            <form method="POST" action="" id="gbhlform">

                <table class="table table-striped table-bordered table-hover table-responsive table-scrollable-borderless" style="width: 900px;" align="center">
                    <tr>
                        <td colspan="6" style="text-align: center;"><h5><strong>Bulk Activation</strong></h5></td>
                    </tr>


                    <tr>
                        <th>Programme</th>
                        <th id="intake">Intake</th>
                        <th>Level</th>
                        <th>Session</th>
                        <?php if(isset($select)&& !empty($select)) {echo "<th>Campus</th>";}?>
                        <th>&nbsp;</th>
                    </tr>

                    <tr>
                        <td nowrap="">

                            <select name="program" id="program" class="input-xlarge" style="height: 35px;">
                                <option>--SELECT PROGRAM--</option>
                                <?php while (!$prog->EndOfSeek()){ $row = $prog->Row();?>
                                    <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                                <?php } ?>
                                <option value="">  All </option>
                            </select>
                        </td>

                        <td nowrap="">
                            <select id="intake" name="intake" style=" height: 35px;" class="form-control">
                                <?php

                                while(!$acy_intake->EndOfSeek()) {
                                    $get_intake = $acy_intake->Row();
                                    ?>
                                    <option value="<?php echo $get_intake->date_month;?>"><?php echo $get_intake->intake_name;?></option>
                                <?php }?>
                            </select>

                        </td>
                        <td>
                            <select name="level" id="level" class=" form-control"  style="height: 35px; width:100px;">
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>

                            </select>
                        </td>
                        <td>
                            <select name="session" id="session" class=" form-control"  style="height: 35px; width:100px;">
                                <option>--SELECT SESSION--</option>
                                <option value="morning">Morning</option>
                                <option value="evening">Evening</option>
                                <option value="weekend">Weekend</option>
                            </select>
                        </td>
                        <td>
                            <?php if(isset($select)&& !empty($select)) { echo $select;} ?>
                        </td>
                        <td>
                            <input type="submit" name="add" id="add" class="btn btn-success rounded-4" value="Go">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div>
            <p align="center" style="display: none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > Loading. Please wait....</p>
        </div>
            <div class="container-fluid" id="response"></div>
        <div class="col-lg-12 col-md-6 col-sm-12 container-fluid" id="list">

        </div>
    </div>

    <!-- scripts -->

    <!-- scripts -->


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
    <script src="../js/jquery.dataTables.min.js"></script>


    <script type="text/javascript" charset="utf-8">

        $(function () {

            var $btns = $("#add");
            $btns.click(function (e) {
                e.preventDefault();
                $("#list").empty();
                $("#wait").css("display","block");
                $("#add").attr("disabled", "disabled");

                $.ajax({
                    type: "POST",
                    url: "process_bulk_activation.php",
                    data: $('#gbhlform').serialize(),
                    success: function(e) {
                        if(e=="empty")
                        {

                            $("#wait").css("display","none");
                            $("#add").removeAttr('disabled');

                            $('#list').html('<div align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i> Sorry no records found.</span></div><br>');

                        }
                        else if(e=="zero")
                        {
                            $("#wait").css("display","none");
                            $("#add").removeAttr('disabled');

                            $('#list').html('<div align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i>Please you need to select either of the following , program , academic year  and level.</span></div><br>');

                        }else
                        {

                            $("#wait").css("display","none");
                            $("#add").removeAttr('disabled');

                            $('#list').html(e);
                        }


                    }
                });
                return false;

            });

        });
        $(document).ready(function() {
            $('#example').dataTable({"sPaginationType": "full_numbers","iDisplayLength": -1});
        });
        $(document).on("click",".check_main",function(e){
            $(this).val('check all');
            var value = $(this).val();
            alert(value);
            if(value == 'check all') {
                $('input:checkbox').attr('checked', 'checked');
                $(this).val('uncheck all');
                value = 'uncheck all';
            }
            else if(value == "uncheck all")
                {
                $('input:checkbox').removeAttr('checked');
                $(this).val('check all');
                value = 'check all';
            }

        });

        $(document).on("click","#activate",function(e){
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 800);
            $(this).attr("disabled","disabled");
            $("#wait").css("display","block");
            if($("#academic_year").val() == 0){
                $('#response').html('<div id="res" align="center"><span class="alert alert-danger">Bulk activation unsuccessful, please select an academic year .</span></div><br>');
                $("#res").fadeOut(15000);
                $("#wait").css("display","none");
                $("#activate").removeAttr("disabled","disabled");
            }
            else {
                $(this).attr("disabled", "disabled");
                $("#wait").css("display", "block");
                var form = $("#b_activate").serialize();
                $.ajax({
                    type: "POST",
                    url: "post_bulk_activation.php",
                    data: form,
                    success: function (k) {
                        if (k == 'success') {
                            $('#response').html('<div id="res" align="center"><span class="alert alert-success">Bulk activation successful.</span></div><br>');
                            $("#res").fadeOut(15000);
                            $("#wait").css("display", "none");
                            //$("#activate").css("disabled", "none");
                            $('html, body').animate({scrollTop: 0}, 800);
                        }
                        else if (k == 'error') {
                            $('#response').html('<div id="res" align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i>Sorry this bulk activation has been done already.</span></div><br>');
                            $("#res").fadeOut(15000);
                            $("#wait").css("display", "none");
                            $("#activate").removeAttr("disabled", "disabled");
                            $('html, body').animate({scrollTop: 0}, 800);
                        }
                    }
                })
            }
        });
        $(document).on("change","#academic_year",function(e){
            if($(this).val() != 0){
                $("#activate").removeAttr("disabled","disabled");
            }
            else {
                $("#activate").attr("disabled", "disabled");
            }
            });
    </script>

</body>
</html>