<?php 
require_once("../classes/staff.class.php");
require_once("../classes/accounts.class.php");
require_once("../classes/position.class.php");
if(isset($_POST['action']) && ($_POST['action'] =="createstaff" || $_POST['action']=='editstaff')){
    $staff=new Staff();
    echo $staff->createStaff($_POST);	
}
//#bf6ae2d4d71b0424a33cf5a41b0d2be9efeddbef
//var_dump($_POST);
if(isset($_POST['action']) && ($_POST['action'] =="createcategory" || $_POST['action']=='editcategory')){
    $staff=new Staff();
    $input=array();
    $input['name']=MYSQL::SQLValue(filter_input(0, "name",513));
    $input['description']=MYSQL::SQLValue(filter_input(0, "description",513));
    $input['leave_allocation']=MYSQL::SQLValue(filter_input(0, "leaves",513));
    $input['medical_allocation']=MYSQL::SQLValue(filter_input(0, "medicals",513));

    if(in_array($_POST['status'],array(0,1))){
        $input['status']=MYSQL::SQLValue(filter_input(0, "status",513));
    }else{
        $input['status']=1;
    }
    $input['created_by']=$_SESSION['APP_USER']->staffid;
    $input['created_on']='now()';
    $input['last_updated_on']='now()';
    $input['last_updated_by']=$_SESSION['APP_USER']->staffid;
   //var_dump($input);
    $where=array();
    if(filter_has_var(0, "catid")){
        $where['id']=base64_decode(filter_input(0, "catid",513));
       
    }
    $rs=$staff->createStaffCat($input,$where);
    if($rs){
        include_once("files/category/list_staff_cat.php");
    }else{
        echo $rs;
    }    
}

if(isset($_POST['action']) && ($_POST['action'] =="changedepartmentstatus")){

      $position=new Position();
      $pid=base64_decode(filter_input(0,'pid',513));
      $status=filter_input(0,'state',FILTER_SANITIZE_NUMBER_INT);           
      echo $rs=$position->changePositionState($pid,$status);
    
}

if(isset($_POST['action']) && ($_POST['action'] =="createposition")){
    $position=new Position();
    $position->position_name=MySQL::SQLValue(filter_input(0,"name","513"));
    $position->department=MySQL::SQLValue(filter_input(0,"department",FILTER_SANITIZE_NUMBER_INT));
    $position->description=MySQL::SQLValue(filter_input(0,"description","513"));
    $position->status=MySQL::SQLValue(filter_input(0,"status","513"));
    if(filter_has_var(0, "positionid")){        
        $position->positionid=MySQL::SQLValue(base64_decode(filter_input(0,"positionid","513")),"number");
        $position->exists=true;
    }
    $rs=$position->createPosition();
    if($rs){
        $activedepartment=0;
        include_once("files/positions/listpositions.php");
    }else{
        echo -1;
    }
}

if(isset($_POST['action']) && ($_POST['action'] =="createbank" || $_POST['action']=='updatebank')){
    $account=new Account();
    $post=$_POST;
    //var_dump($post);
    
    $rs= $account->createStaffBank($post);
    if($rs==1){
        $bsid= base64_decode(filter_input(0,'sid',513));
        include_once('files/bank/listbanks.php');
    }else{
        echo $rs;
    }
}

if(isset($_POST['action']) && ($_POST['action'] =="createdependant" || $_POST['action']=='updatedependant')){
    $staff=new Staff();
    $post=$_POST;
    //var_dump($post);
    
    $rs= $staff->createDependant($post);
    if($rs==1){
        $dsid= base64_decode(filter_input(0,'sid',513));
        include_once('files/dependants/dependantlist.php');
    }else{
        echo $rs;
    }
}

if(isset($_POST['action']) && ($_POST['action'] =="createqualification" || $_POST['action']=='updatequalification')){
    $staff=new Staff();
    $post=$_POST;
    // var_dump($post);
    // die();
    $rs= $staff->createQualification($post);
    if($rs==1){
        $qsid= base64_decode(filter_input(0,'sid',513));
        include_once('files/qualifications/qualificationlist.php');
    }else{
        echo $rs;
    }
}

if(isset($_POST['action']) && ($_POST['action'] =="createbeneficiary" || $_POST['action']=='updatebeneficiary')){
    $staff=new Staff();
    $post=$_POST;
    //var_dump($post);
    
   $rs= $staff->createBeneficiary($post);
    if($rs==1){
        $bnsid= base64_decode(filter_input(0,'sid',513));
        include_once('files/beneficiaries/beneficiarylist.php');
    }else{
        echo $rs;
    }
}

if(isset($_POST['action']) && $_POST['action'] =="getForm"){
    $form = $_POST['form'];
    
    $siid = $_POST['sid'];
   
   
    switch($form){
        case "dependant":
            include_once("files/dependants/createdependant.php");
        break;
        case "bank":
            include_once("files/bank/createbank.php");
        break;
        case "beneficiary":
            include_once("files/beneficiaries/createbeneficiary.php");
        break;
        case "qualification":
            // "nice";
            $siid = $_POST['sid'];
            include_once("files/qualifications/createqualification.php");
        break;
    }
}



if(isset($_POST['action']) && $_POST['action'] =="fetchstaffbydepartment" ){
    $activedepartment=filter_input(0,"department",513);    
    include_once ('files/personal/list_staff.php');  
      
}


if(isset($_POST['action']) && $_POST['action'] =="getchilddepartment" ){
    $id=filter_input(0,"id",FILTER_SANITIZE_NUMBER_INT);    
    $staff=new Staff();
    $staff->getActiveDepartments($id) ;
    $options="";
    if($staff->RowCount()){


    while(!$staff->EndOfSeek()){
        $row=$staff->Row();
        $options.="<option value='".$row->id."'>".$row->name."</option>";
    }
    echo $options;
}else{
    echo 0;
}
}


if(filter_has_var(0, "action") && $_POST['action']=="fetchpositionsbydepartment"){
    $activedepartment=filter_input(0,"department",513);    
    include_once ('files/positions/listpositions.php');  
}

if(isset($_POST['action']) && $_POST['action'] =="changebank" ){
    $staff=new Staff();
    $post=$_POST;
    //var_dump($post);
    $rs= $staff->changeBank($post);
    if($rs){
       $bsid=$rs;
       include_once ('files/bank/listbanks.php');  
       
         
    }else{
        echo -1;
    }
}

if(isset($_POST['action']) && $_POST['action'] =="dpswitch" ){
    $staff=new Staff();
    $sid=base64_decode(filter_input(0,"sid",513));
    $status=filter_input(0,"status",513);
    $did=base64_decode(filter_input(0, "did",513));
    //var_dump($post);
    $rs= $staff->changeDependantStatus($did,$status);
    if($rs){
        $dsid=$sid;
        include_once ('files/dependants/dependantlist.php'); 
        
         
    }else{
        echo -1;
    }
}

if(isset($_POST['send_mail']) && $_POST['send_mail'] =="send_mail"){
	$user=new userLogin();
	if(isset($_POST['category'])){
		$cats=$_POST['category'];
		$catss="";
		for($i=0;$i<count($cats);$i++){
			$catss.=$cats[$i].",";	
		}
		
	echo $user->sendBulkEmails(rtrim($catss,","));
	}
}
if(isset($_POST['send_mail_p']) && $_POST['send_mail_p'] =="send_mail_p"){
	$user=new userLogin();
    $email=base64_decode($_POST['email']);
    $userid=base64_decode($_POST['userid']);
    $message=$_POST['message'];
	echo $user->sendSingleEmail($message,$email);
	
}

if(isset($_POST['change_pwd']) && $_POST['change_pwd'] =="change_pwd"){
	$user=new userLogin();
	$new=$_POST['new_password'];
	$old=$_POST['old_password'];
	echo $user->changePassword($old,$new);
	
}

if(isset($_POST['change_single_pwd']) && $_POST['change_single_pwd'] =="change_single_pwd") {
   // var_dump($_POST);
    $userid=base64_decode($_POST['user']);
    $password=addslashes($_POST['password']);
    $user=new userLogin();
   echo $user->changeSinglePassword($userid,$password);
}
?>