<?php
require_once('../classes/mysql.class.php');

if(isset($_POST['id']) && isset($_POST['do']) && $_POST['do']=="fetchActivationForm"){

    $showit = new MySQL();

    $myacy = new MySQL();
    $myacy->Query("SELECT * FROM gb_years ORDER BY id DESC limit 2");
/*
    $aresult = $myacy->Row();
    $acacyear = $aresult->id;

    $subcheck = substr($acacyear,-1);


    if($subcheck=="1"){

        $prevyear = $acacyear - 99;

    }elseif($subcheck=="2"){

        $prevyear = $acacyear - 1;

    }
    */

    $prog = new MySQL;
    $prog->Query("SELECT * FROM programs ORDER BY name");

    $camp = new MySQL;
    $camp->Query("SELECT * FROM campus WHERE status = 1");

    $indnumber = base64_decode(trim($_POST['id']));

    $getStudentRecord = new MySQL();
    $getStudentRecord->Query("SELECT progid,campus,level,classification,mobile_phone,nationality FROM stud_main WHERE indexnumber = '$indnumber'");

    $count = $getStudentRecord->RowCount();

    if($count==1){

        $studentRow = $getStudentRecord->Row();
        $studnat = strtolower($studentRow->nationality);

    }else{
        echo "student_not_found";
    }

}else{

    echo "post_error";exit;

}
?>

<br>

<form method="post" name="actForm" id="actForm"  action="process_activation.php">

    <table class="table table-bordered table-condensed table-responsive table-striped" >

        <tr>
            <td><strong>Student ID:</strong></td>
            <td><strong style="color: blue;"><?php echo $indnumber; ?></strong></td>

            <td><strong>Level:</strong></td>
            <td><select name="level" id="level" class="form-control" style="height: 35px;">
                    <option <?php if(!strcmp("100",$studentRow->level)){ echo "selected";} ?> value="100">100</option>
                    <option <?php if(!strcmp("200",$studentRow->level)){ echo "selected";} ?> value="200">200</option>
                    <option <?php if(!strcmp("300",$studentRow->level)){ echo "selected";} ?> value="300">300</option>
                    <option <?php if(!strcmp("400",$studentRow->level)){ echo "selected";} ?> value="400">400</option>
                </select><div id="levelerror"></div></td>

            <td><strong>Session:</strong></td>
            <td><select name="session" id="session" class="form-control" style="height: 35px;">
                    <option <?php if(!strcmp("Morning",$studentRow->classification)){ echo "selected";} ?> value="Morning">Morning</option>
                    <option <?php if(!strcmp("Evening",$studentRow->classification)){ echo "selected";} ?> value="Evening">Evening</option>
                    <option <?php if(!strcmp("Weekend",$studentRow->classification)){ echo "selected";} ?> value="Weekend">Weekend</option>
                </select><div id="sesserror"></div></td>
        </tr>
        <tr>
            <td><strong>Program:</strong></td>
            <td><select name="prog" id="prog" class="form-control" style="height: 35px;">

                    <?php while(!$prog->EndOfSeek()){$prow = $prog->Row();?>
                        <option <?php if(!strcmp($prow->code,$studentRow->progid)){ echo "selected";} ?> value="<?php echo $prow->code; ?>">
                            <?php echo $prow->name ;?>
                        </option>
                    <?php }?>
                </select><div id="progerror"></div></td>
            <td><strong>Phone:</strong></td>
            <td><input type="text" class="form-control"  name="phone" id="phone" value="<?php echo $studentRow->mobile_phone; ?>"><div id="phoneerror"></div></td>
            <td><strong>Campus:</strong></td>
            <td><select name="campus" id="campus" class="form-control" style="height: 35px;">
                    <?php while(!$camp->EndOfSeek()){$crow = $camp->Row();?>
                        <option <?php if(!strcmp($crow->name,$studentRow->campus)){ echo "selected";} ?> value="<?php echo $crow->name; ?>">
                            <?php echo $crow->name ;?>
                        </option>
                    <?php }?>
                </select><div id="campuserror"></div></td>
        </tr>
        <tr>
            <td><strong>Fees Receipt #:</strong></td><td><input type="text" value="" class="form-control"  name="fees" id="fees"><div id="feeserror"></div></td>
            <td><strong>SRC Receipt #:</strong></td><td><input type="text" value="" class="form-control"  name="src" id="src"><div id="srcerror"></div></td>
            <?php if($studnat != "ghanaian"){?>
            <td><strong>ISA Receipt #:</strong></td><td><input type="text" value="" class="form-control"  name="isa" id="isa"><div id="isaerror"></div></td>
            <?php } ?>
            </tr>
        <tr>
            <td><strong>Semester:</strong></td>
            <td><select name="acysem" id="acysem" class="form-control" style="height: 35px;">
                    <option value="" disabled selected>--SELECT OPTION--</option>
                    <?php while(!$myacy->EndOfSeek()){
                        $rrow=$myacy->Row();
                    ?>
                    <option value="<?php echo $rrow->id;?>"><?php echo $showit->showSemester($rrow->id); ?></option>
                    <?php } ?>
            </select><div id="acysemerror"></div></td>
        </tr>
        <tr id="buttonpanel">
            <td colspan="6"><input style="float: right" type="submit" name="activate" id="activate" class="btn btn-success" value="Activate Student Account"></td>
        </tr>
    </table>
    <input type="hidden" value="<?php echo base64_encode($indnumber); ?>" class="form-control"  name="sid" id="sid">
    <input type="hidden" value="<?php echo $studnat; ?>" class="form-control"  name="nationality" id="nationality">
</form>
<script type="text/javascript">
    $(function () {

        var $btns = $("#activate");
        $btns.click(function (e) {
            e.preventDefault();

            $("#progerror").empty();
            $("#sesserror").empty();
            $("#leverror").empty();
            $("#phoneerror").empty();
            $("#campuserror").empty();
            $("#feeserror").empty();
            $("#srcerror").empty();
            $("#isaerror").empty();
            $("#acysemerror").empty();

            $("#d_result").empty();

            var phone = $.trim($("#phone").val());
            var prog = $.trim($("#prog").val());
            var sess = $.trim($("#session").val());
            var level = $.trim($("#level").val());
            var camp = $.trim($("#campus").val());
            var fees = $.trim($("#fees").val());
            var src = $.trim($("#src").val());
            var isa = $.trim($("#isa").val());
            var nati = $.trim($("#nationality").val());
            var acysem = $.trim($("#acysem").val());



            if(phone.length == 0) {

                $("#phoneerror").html('<p><small style="color:red;">field cannot be left blank.</small><p/>');

            }
            if(prog.length == 0) {

                $("#progerror").html('<p><small style="color:red;">no option selected.</small><p/>');

            }
            if(level.length == 0) {

                $("#leverror").html('<p><small style="color:red;">no option selected.</small><p/>');

            }
            if(sess.length == 0) {

                $("#sesserror").html('<p><small style="color:red;">no option selected.</small><p/>');

            }
            if(camp.length == 0) {

                $("#campuserror").html('<p><small style="color:red;">no option selected.</small><p/>');

            }
            if(fees.length == 0) {

                $("#feeserror").html('<p><small style="color:red;">field cannot be left blank.</small><p/>');

            }
            if(src.length == 0) {

                $("#srcerror").html('<p><small style="color:red;">field cannot be left blank.</small><p/>');

            }
            if(acysem.length == 0) {

                $("#acysemerror").html('<p><small style="color:red;">select option.</small><p/>');

            }

            if(nati != "ghanaian") {
                if (isa.length == 0) {

                    $("#isaerror").html('<p><small style="color:red;">field cannot be left blank.</small><p/>');return false;

                }
            }




            if(prog.length != 0 && phone.length != 0 && level.length != 0 && sess.length != 0 && camp.length != 0 && fees.length != 0 && src.length != 0 && acysem.length != 0) {
                $("#d_wait").css("display", "block");
                $("#activate").attr("disabled", "disabled");

                $.ajax({
                    type: "POST",
                    url: "process_activation.php",
                    data: $('#actForm').serialize(),
                    success: function (e) {


                        if (e == "fail") {
                            $("#d_wait").css("display", "none");
                            $("#activate").removeAttr('disabled');

                            $('#d_result').html("<div align='center'><span class='alert alert-danger'><i class='icon icon-remove-sign'></i> Activation Failed</span></div>");
                            $("#d_result").hide().fadeIn(2000).fadeOut(4000);

                        } else if (e == "ok") {

                            $("#d_wait").css("display", "none");
                            $("#activate").removeAttr('disabled');

                            $('#d_result').html("<div align='center'><span class='alert alert-success'><i class='icon icon-ok-sign'></i> Activation successful</span></div>");
                            $("#d_result").hide().fadeIn(2000).fadeOut(4000);
                            $("#buttonpanel").hide();

                            $("#wait").css("display", "block");

                            $.ajax({
                                type: "POST",
                                url: "process_stud_search.php",
                                data: $('#find_stud_form').serialize(),
                                success: function(e) {

                                    if(e=="form_incomplete"){

                                        $("#wait").css("display","none");

                                        $("#result").html("<br><div align='center'><span class='alert alert-danger' style='text-align: center'> Complete search field before searching. Donot leave it blank.</span></div>");
                                        $("#result").hide().fadeIn(2000);

                                    }else if(e=="nonexistent"){

                                        $("#wait").css("display","none");

                                        $("#result").html("<br><div align='center'><span class='alert alert-danger' style='text-align: center;'> Student doesnot exist in this system.</span></div>");
                                        $("#result").hide().fadeIn(2000);

                                    }else{

                                        $("#wait").css("display","none");
                                        $('#result').html(e);

                                    }



                                }
                            });

                        } else if (e == "empty") {

                            $("#d_wait").css("display", "none");
                            $("#activate").removeAttr('disabled');

                            $('#d_result').html("<div align='center'><span class='alert alert-danger'><i class='icon icon-remove-sign'></i> Complete all fields before activating</span></div>")
                            $("#d_result").hide().fadeIn(2000);

                        } else if (e == "nonexistent") {

                            $("#d_wait").css("display", "none");
                            $("#activate").removeAttr('disabled');

                            $('#sid').val("");
                            $('#phone').val("");
                            $('#d_result').html("<div align='center'><span class='alert alert-danger'><i class='icon icon-remove-sign'></i> Student ID doesnot exist in the system</span></div>")
                            $("#d_result").hide().fadeIn(2000);

                        }


                    }
                });
                return false;
            }

        });

    });
</script>
