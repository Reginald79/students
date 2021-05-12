<?php
session_start();
if(!isset($_SESSION['APP_USER'])){
	header("location:auth/login.php");
}
include_once("../config/settings.php");

$path="../";
include_once($path."classes/templateEngine.class.php");
include_once($path."classes/mysql.class.php");


$page=new TemplateEngine($path."template/page.dwt");

$arr=array(
		'page_title'=>'NTL Dashboard',
		'page_header'=>'Dashboard',
		'sidebarArea'=>"",
		'stylesheets'=>$path.'inc/stylesheet.php',
		'javascripts'=>$path.'inc/javascript.php',
		'top_menu'=>$path.'inc/menubar.php',
		'sidebar_menu'=>$path.'inc/sidebar.php',
		'breadcrumbs'=>"",
		'rightsidebar'=>$path.'inc/rightsidebar.php',
		'server_info2'=>"",
		'recent_activities'=>"",
		'internal_chat'=>"",
		'user_list'=>"",
		'to_do_list'=>"",
		'calendar'=>"",
		'visitors_map'=>"",
		'right_animatedbox'=>"",
		'livechatbox'=>"",
		'footer'=>"inc/footer.php",
		'embeded-javascript'=>"",
		'content'=>"",
	);

if(isset($_GET['page'])){
	//$auth=new UserLogin();
	$curpage=$_GET['page'];
	//$curpage=$auth->checkFilePermission($curpage);
	$p=0;
	if(isset($_GET['p'])){
		$p=$_GET['p'];
	}
	$_SESSION['pp']=$p;

	//$hashID=base64_encode($p);
	//echo "The current page is $curpage";
switch ($curpage){

        case "staff":
        $arr['page_header']="<h3>Add Category</h3>";
            $arr['content'] = "./staff.php";
        break;
          case "stafflist":
        $arr['page_header']="<h3>Personnel List</h3>";
        $arr['content']="./list_staff.php";
        break;
        case "editstaff":
        $arr['page_header']="<h3>Edit Personnel</h3>";
        $arr['content']="./edit_staff.php";
        break;
        case "viewstaff":
        $arr['page_header']="<h3>View Personnel</h3>";
        $arr['content']="./view_staff.php";
        break;
        case "faq":
        $arr['page_header']="<h3>Frequently asked questions</h3>";
        $arr['content']="application/faq.php";
        break;
	default:

		//$arr['page_header']="Siaw<small></small>";
		//$arr['content']="files/reports/itemamountsent.php";
	//	$arr['content']="High You missed me?";


	}
}
//var_dump($_SESSION['EVAL_USER']);
$page->replace_tags($arr);
print  $page->output();


?>
<script>
$(document).ready(function(e){
    var page = "<?php echo $_GET['page'];?>";
    if(page === "view"){
        $(".btn-danger").hide();
    }
    $("#res").css('display','none');
$(".select2").select2({placeholder:"--- Select ---"});
var winhash=window.location.hash;
//alert($(""+winhash).closest("li").index())
 var tabindex;
if(winhash==""){
    tabindex=0;
}else{
  tabindex=$(""+winhash).closest("li").index()  
}

$(""+winhash).closest("ul").children().removeClass("active")
$('#appwizard').wizard({
                onInit: function(){
                   // alert("siaw")
                   //$(".wizard-steps li").
                },
                validator: function(){

                    return true;
                },

                onNext:function(){
                    var myhash=$("#appwizard li.current a").attr("href");
                    window.location.hash=myhash

                },
                onBack:function(){
                    var myhash=$("#appwizard li.current a").attr("href");
                    window.location.hash=myhash
                },
                onFinish: function(){
                    $('#validation').submit();
                    /*swal("Message Finish!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");*/
                }
            }).wizard("goTo",tabindex);

$(".wizard-finish").hide();
});


</script>
<script type="text/javascript">
    $(document).on("click","#add",function (e) {
    e.preventDefault();
    $("#firstnameerror").empty();
    $("#surnameerror").empty();
    $("#hometownerror").empty();
    $("#regionerror").empty();
    $("#positionerror").empty();
    $("#emailerror").empty();
    $("#employeeiderror").empty();
    $("#idnoerror").empty();
    $("#idtypeerror").empty();
    $("#mobileerror").empty();
    $("#addresserror").empty();
    $("#residentialaddresserror").empty();
    $("#nkfirstnameerror").empty();
    $("#nklastnameerror").empty();
    $("#nkmobileerror").empty();
    $("#nkemailerror").empty();
    $("#relationshiperror").empty();
    $("#pictureerror").empty();
    $("#nk_addresserror").empty();
    var employeeid = $.trim($("#employeeid").val());
    var relationship = $.trim($("#relationship").val());
    var email = $.trim($("#email").val());
    var sur_name = $.trim($("#surname").val());
    var firstname = $.trim($("#firstname").val());
    var mob = $.trim($("#mobile").val());
    var residential_address = $.trim($("#residential_address").val());
    var address = $.trim($("#address").val());
    var file = $.trim($("#file").val());

    if (relationship.length == 0) {
        $("#relationshiperror").html('<p><small style="color:red;">field cannot be left empty</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    } if (employeeid.length == 0) {
        $("#employeeiderror").html('<p><small style="color:red;">field cannot be left empty</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }if (sur_name.length == 0) {

        $("#surnameerror").html('<p><small style="color:red;">field cannot be left empty</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }
    if (validateEmail(email) === false) {

        $("#emailerror").html('<p><small style="color:red;">Please enter a valid email.</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }
    if (firstname.length == 0) {
        $("#firstnameerror").html('<p><small style="color:red;">field cannot be left empty.</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }
    if (mob.length == 0) {

        $("#mobileerror").html('<p><small style="color:red;">field cannot be left empty..</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    } if (address.length == 0) {

        $("#addresserror").html('<p><small style="color:red;">field cannot be left empty..</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }

    else if (firstname.length != 0 && sur_name.length != 0   && email.length != 0 && mob.length != 0 ) {
        if (file.length == 0) {
            $("#add ").attr("disabled", "disabled");
            $("#wait").css("display", "block");
            var form = $("#form").serialize();
            $.ajax({
                type: "POST",
                url: "../controller/staffController.php",
                data: form,
                success: function (data) {
                    $("#add").removeAttr("disabled", "disabled");
                    $("#wait").css("display", "none");
                    if (data === "success") {
                        $("#response").html('<p class="alert alert-success" align="center"> Staff record created successfully.</p>');
                        $("form")[0].reset();
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else if (data === "error") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Sorry something went wrong,Please make sure all fields are completed properly</p>');
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                }
            });
        }
        else {
            var image = '';

            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            formData.append('name', $('#surname').val());
            formData.append('mobile', $('#mobile').val());
            $.ajax({
                url: '../controller/imageController.php',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    if (data == "error1") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Sorry the image your trying to upload already exist.</p>');
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else if (data == "error2") {
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $('#response').html('<p class="alert alert-danger"> Sorry the image your trying to upload already exist.</p>')
                    }
                    else if (data == "error3") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Invalid file Size or Type</p>');
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else if (data == "error4") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Sorry no file was uploadedss.</p>');
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else {
                        image = data;
                        $('#picture').val(data);
                        $("#add ").attr("disabled", "disabled");
                        $("#wait").css("display", "block");
                        var form = $("#form").serialize();
                        $.ajax({
                            type: "POST",
                            url: "../controller/staffController.php",
                            data: form,
                            success: function (data) {
                                console.log(data);
                                $("#add").removeAttr("disabled", "disabled");
                                $("#wait").css("display", "none");
                                if (data === "success") {
                                    $("#response").html('<p class="alert alert-success" align="center"> Staff record created successfully.</p>');
                                    $("form")[0].reset();
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                }
                                else if (data === "error") {
                                    $("#response").html('<p class="alert alert-danger" align="center"> Sorry something went wrong,Please make sure all fields are completed properly</p>');
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                }
                            }
                        })
                    }
                }
            });
        }
    }
    });
    $(document).on("click","#upStaff",function (e) {
    e.preventDefault();
    $("#firstnameerror").empty();
    $("#surnameerror").empty();
    $("#hometownerror").empty();
    $("#regionerror").empty();
    $("#positionerror").empty();
    $("#emailerror").empty();
    $("#employeeiderror").empty();
    $("#idnoerror").empty();
    $("#idtypeerror").empty();
    $("#mobileerror").empty();
    $("#addresserror").empty();
    $("#residentialaddresserror").empty();
    $("#nkfirstnameerror").empty();
    $("#nklastnameerror").empty();
    $("#nkmobileerror").empty();
    $("#nkemailerror").empty();
    $("#relationshiperror").empty();
    $("#pictureerror").empty();
    $("#nk_addresserror").empty();
    var employeeid = $.trim($("#employeeid").val());
    var relationship = $.trim($("#relationship").val());
    var email = $.trim($("#email").val());
    var sur_name = $.trim($("#surname").val());
    var firstname = $.trim($("#firstname").val());
    var mob = $.trim($("#mobile").val());
    var residential_address = $.trim($("#residential_address").val());
    var address = $.trim($("#address").val());
    var file = $.trim($("#file").val());

    if (relationship.length == 0) {
        $("#relationshiperror").html('<p><small style="color:red;">field cannot be left empty</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    } if (employeeid.length == 0) {
        $("#employeeiderror").html('<p><small style="color:red;">field cannot be left empty</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }if (sur_name.length == 0) {

        $("#surnameerror").html('<p><small style="color:red;">field cannot be left empty</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }
    if (validateEmail(email) === false) {

        $("#emailerror").html('<p><small style="color:red;">Please enter a valid email.</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }
    if (firstname.length == 0) {
        $("#firstnameerror").html('<p><small style="color:red;">field cannot be left empty.</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }
    if (mob.length == 0) {

        $("#mobileerror").html('<p><small style="color:red;">field cannot be left empty..</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    } if (address.length == 0) {

        $("#addresserror").html('<p><small style="color:red;">field cannot be left empty..</small><p/>');
        $("html, body").animate({scrollTop: 0}, "slow");

    }

    else if (firstname.length != 0 && sur_name.length != 0   && email.length != 0 && mob.length != 0 ) {
        if (file.length == 0) {
            $("#add ").attr("disabled", "disabled");
            $("#wait").css("display", "block");
            var form = $("#form").serialize();
            $.ajax({
                type: "POST",
                url: "../controller/staffController.php",
                data: form,
                success: function (data) {
                    $("#add").removeAttr("disabled", "disabled");
                    $("#wait").css("display", "none");
                    if (data === "success") {
                        $("#response").html('<p class="alert alert-success" align="center"> Staff record updated successfully.</p>');
                        $("form")[0].reset();
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else if (data === "error") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Sorry something went wrong,Please make sure all fields are completed properly</p>');
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                }
            });
        }
        else {
            var image = '';

            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            formData.append('name', $('#surname').val());
            formData.append('mobile', $('#mobile').val());
            $.ajax({
                url: '../controller/imageController.php',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    if (data == "error1") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Sorry the image your trying to upload already exist.</p>');
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else if (data == "error2") {
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $('#response').html('<p class="alert alert-danger"> Sorry the image your trying to upload already exist.</p>')
                    }
                    else if (data == "error3") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Invalid file Size or Type</p>');
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else if (data == "error4") {
                        $("#response").html('<p class="alert alert-danger" align="center"> Sorry no file was uploadedss.</p>');
                        $("#wait").css("display", "none");
                        $('#add').removeAttr("disabled", "disabled");
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                    else {
                        image = data;
                        $('#picture').val(data);
                        $("#add ").attr("disabled", "disabled");
                        $("#wait").css("display", "block");
                        var form = $("#form").serialize();
                        $.ajax({
                            type: "POST",
                            url: "../controller/staffController.php",
                            data: form,
                            success: function (data) {
                                console.log(data);
                                $("#add").removeAttr("disabled", "disabled");
                                $("#wait").css("display", "none");
                                if (data === "success") {
                                    $("#response").html('<p class="alert alert-success" align="center"> Staff record updated successfully.</p>');
                                    $("form")[0].reset();
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                }
                                else if (data === "error") {
                                    $("#response").html('<p class="alert alert-danger" align="center"> Sorry something went wrong,Please make sure all fields are completed properly</p>');
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                }
                            }
                        })
                    }
                }
            });
        }
    }
    });

    function validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
    </script>