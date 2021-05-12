<?php session_start();
require_once('../classes/mysql.class.php');
$security = new MySQL();
$security->checkLogin();

$prog = new MySQL;
$prog->Query("SELECT * FROM programs ORDER BY `name` ASC");

$acy = new MySQL;
$acy->Query("SELECT * FROM gb_years");

$courseLogs = new MySQL;
$sql = "SELECT gb_header.id, gb_header.session, gb_header.status, CONCAT(courses.`code`,' - ',courses.`name`) AS course, gb_header.credit AS credit, CONCAT(staff_employee_pdetail.fname,staff_employee_pdetail.lname) AS lecturer, programs.`code` AS program, gb_header.level
FROM gb_header INNER JOIN courses ON gb_header.courseid = courses.id
INNER JOIN staff_employee_pdetail ON gb_header.lecturerid = staff_employee_pdetail.empID
INNER JOIN programs ON gb_header.program_code = programs.code COLLATE latin1_general_ci";
$courseLogs->Query($sql);
$courseLogs->MoveFirst();



$lec = new MySQL;
$lec->Query("SELECT * FROM staff_employee_pdetail WHERE category = 'Academic'");
$lec->MoveFirst();

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
    <title>TERM - HEADERS LIST</title>
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
                    <thead>
                    <tr>
                        <td colspan="5" style="text-align: center;"><h5><strong>Students Class List</strong></h5></td>
                    </tr>


                    <tr>
                        <th>Program</th>
                      <!--  <th>Academic Year</th>-->
                        <th>Level</th>
                        <th>Session</th>
                        <th id="intake">Intake</th>
                        <th> Campus</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>



                    <tr>
                        <td>

                            <select name="program" id="program" class="input-xlarge" style="height: 35px;">
                                <option>--SELECT PROGRAM--</option>
                                <?php while (!$prog->EndOfSeek()){ $row = $prog->Row();?>
                                    <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                                <?php } ?>
                                <option value="">  All </option>
                            </select>
                        </td>

                        <!-- <td>

                            <select name="ac_year" id="ac_year" class="input-xlarge" style="height: 35px;">
                                <option>--SELECT ACADEMIC YEAR--</option>
                                <?php // while (!$acy->EndOfSeek()){ $acrow = $acy->Row();?>
                                    <option value="<?php// echo $acrow->id; ?>"><?php// echo $acrow->id; ?></option>
                                <?php// } ?>
                                <option value="">  All </option>
                            </select>
                        </td>-->
                        <td>
                            <select name="level" id="level" class=" form-control"  style="height: 35px; width:100px;">
                                <option>--SELECT LEVEL--</option>
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
                                <option value="">  All </option>
                            </select>
                        </td>
                        <td id="intake_val">
                            <select name="intake" id="in_take" class=" form-control"  style="height: 35px; width:100px; ">
                                <option value="0"> --SELECT INTAKE-- </option>
                                <option value="1">January</option>
                                <option value="5">May</option>
                                <option value="9">September</option>
                                <option value="">  All </option>
                            </select>
                        </td>
                        <td>
                          <?php if(isset($select)&& !empty($select)) { echo $select;} ?>
                          </td>
                        <td>
                            <input type="submit" name="add" id="add" class="btn btn-success rounded-4" value="Go">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div>
            <p align="center" style="display: none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > Loading. Please wait....</p>
        </div>

        <div class="col-lg-12 col-md-6 col-sm-12 container-fluid" id="list">

        </div>
    </div>



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
    <script src="../js/tableExport.jquery.plugin/tableExport.js"></script>
    <script  src="../js/tableExport.jquery.plugin/jquery.base64.js"></script>


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
                    url: "process_class_list.php",
                    data: $('#gbhlform').serialize(),
                    success: function(e) {
                        if(e=="zero"){

                            $("#wait").css("display","none");
                            $("#add").removeAttr('disabled');

                            $('#list').html('<div align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i>Please you need to select either of the following , program , academic year  and level.</span></div><br>');

                        } else if(e=="empty"){

                            $("#wait").css("display","none");
                            $("#add").removeAttr('disabled');

                            $('#list').html('<div align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i> Sorry no records found.</span></div><br>');

                        }else{

                            $("#wait").css("display","none");
                            $("#add").removeAttr('disabled');

                            $('#list').html(e);
                        }


                    }
                });
                return false;

            });

        });
        $(document).on("click","#excel",function(e){
            e.preventDefault();
            $("#wait").css("display","block");
            var program = $(this).data("program");
            var level = $(this).data("level");
            var intake = $(this).data("intake");
            var session = $(this).data("session");
            var campus = $(this).data("campus");

            $.ajax({
                type:"POST",
                url:"prep_export_classlist.php",
                data:{level:level,program:program,intake:intake,session:session,campus:campus},
                success:function(data){
                    window.open(data,'_blank' );
                    $("#wait").css("display","none");
                }

            })
        });
        $(document).on("click","#excel1",function(e){
            e.preventDefault();
            $("#wait").css("display","block");
            var program = $(this).data("program");
            var level = $(this).data("level");
            var intake = $(this).data("intake");
            var session = $(this).data("session");
            var campus = $(this).data("campus");

            $.ajax({
                type:"POST",
                url:"export_class_list.php",
                data:{level:level,program:program,intake:intake,session:session,campus:campus},
                success:function(data){
                    window.open(data,'_blank' );
                    $("#wait").css("display","none");
                }

            })
        });
        $(document).ready(function() {
            $('#example').dataTable({"sPaginationType": "full_numbers"});
        });
        $(document).on("change","#level",function(e){

            var value = $(this).val();

            if(value != 100)
            {
                $("#intake").css("display","none");
                $("#intake_val").css("display","none");

            }
            else{
                $("#intake").css("display","block");
                $("#intake_val").css("display","block");

            }
        })
    </script>

</body>
</html>