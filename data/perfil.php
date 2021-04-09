<?php include_once '../include/db_connect.php';	include_once '../include/functions.php'; header('Content-Type: application/json'); 

sec_session_start();


if (login_check($mysqli) == true || ($_POST['accaoP']=="resetPass")) {
	
if (isset($_POST['accaoP'])) {
    $accao = mysqli_real_escape_string($mysqli,$_POST['accaoP']);
}
if (isset($_GET['accaoG'])) {
    $accao = mysqli_real_escape_string($mysqli,$_GET['accaoG']);
}


/* ############################################## ELIMINA #################################################### */
if (isset($_POST['accaoP']) && $accao == "deleteUser" && $_SERVER['REQUEST_METHOD'] == "POST") {
$idnum = filter_input(INPUT_POST, 'idnum', FILTER_SANITIZE_STRING);	

/*
$query = $mysqli->query("select fotoname from members where id='$idnum'") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_array();
$fotoOld=$dados['fotoname'];
 if(is_file(DOCROOT."/images/user_".$fotoOld)){
 	unlink(DOCROOT."/images/user_".$fotoOld); 	 
 }  
 */  
$mysqli->query("update members set status=2 where id='".$idnum."'") or die($mysqli->errno .' - '. $mysqli->error);
//$mysqli->query("delete from members_fields where member='".$idnum."'") or die($mysqli->errno .' - '. $mysqli->error);
addLog($accao,$_SESSION['user_id'],$idnum);
$output = array("success" => "1", "message" => "O utilizador foi eliminado");
}
/* ############################################## RESET PASSWORD #################################################### */

if (isset($_POST['accaoP']) && $accao == "resetPass" && $_SERVER['REQUEST_METHOD'] == "POST") {

$p = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);	
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);	
$memberid=filter_input(INPUT_POST, 'memberid', FILTER_SANITIZE_STRING);	

$html_msg="";
$errPass=array();

if($p !=""){ 
	
	if ($stmt = $mysqli->prepare("SELECT password,salt FROM members  WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $memberid); 
        $stmt->execute();    
        $stmt->store_result();
        $stmt->bind_result($db_password, $salt);
        $stmt->fetch();
	}
	
	$nova_pass=hash('sha512', $p . $salt);
	if($nova_pass==$db_password){
		$errPass[]="A Password não pode ser igual à antiga";	
	} 
	if(sizeof($errPass)==0){
	change_password($memberid, $nova_pass);
	$sucesso=1;	
	$html_msg.="A password foi alterada.<br>";
	} else {
		foreach($errPass as $errop){
		$html_msg.="$errop<br>";
		$sucesso=0;		
		}
	}
}

$output = array("success" => "$sucesso", "message" => "$html_msg");
}
/* ############################################## EDITAR PERFIL #################################################### */

if (isset($_POST['accaoP']) && ($accao == "edit" || $accao == "useredit" || $accao == "userad") && $_SERVER['REQUEST_METHOD'] == "POST") {


$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);	
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);	
$password = filter_input(INPUT_POST, 'p1', FILTER_SANITIZE_STRING);	
$password2 = filter_input(INPUT_POST, 'p2', FILTER_SANITIZE_STRING);	
$tlm = filter_input(INPUT_POST, 'tlm', FILTER_SANITIZE_STRING);	
$grupo=filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_STRING);	
$status=filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);	
$html_msg="";
$error="";
$type="info";
$errPass=array();

if($accao == "edit" || $accao == "useredit"){
	
if($accao == "edit"){
$ideditar=$_SESSION['user_id'];	
}
if($accao == "useredit"){
$ideditar=filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);	
}
	

if($password !="" && ($password == $password2)){ 
	
	if ($stmt = $mysqli->prepare("SELECT password,salt FROM members  WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $ideditar); 
        $stmt->execute();    
        $stmt->store_result();
        $stmt->bind_result($db_password, $salt);
        $stmt->fetch();
	}
	
	$nova_pass=hash('sha512', $password2 . $salt);
	if($nova_pass==$db_password){
		$errPass[]="A Password não pode ser igual à antiga";	
	} 
	if(sizeof($errPass)==0){
	change_password($ideditar, $nova_pass);
	$html_msg.="A password foi alterada.<br>";
	addLog("Password alterada");
	} else {
		foreach($errPass as $errop){
		$html_msg.="$errop<br>";	
		}
	}	
}

if($accao == "edit"){
$mysqli->query("UPDATE members set nome='$nome',email='$email',tlm='$tlm' where id='".$ideditar."'") or die($mysqli->errno .' - '. $mysqli->error);
}

if($accao == "useredit"){
$mysqli->query("UPDATE members set nome='$nome',email='$email',tlm='$tlm',grupo='$grupo',status='$status' where id='".$ideditar."'") or die($mysqli->errno .' - '. $mysqli->error);
}




$sucesso=1;	$html_msg.="Perfil editado com exito!";
} if($accao == "userad"){
$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);	
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);	
$query = $mysqli->query("select id from members where username='$username' or email='$email'") or die($mysqli->errno .' - '. $mysqli->error);
if($query->num_rows==0){	

 if (strlen($password) != 128) {
        $errPass[]='Invalid password configuration.';
 }

} else {
$errPass[]="O utilizador já existe";	
}

if(sizeof($errPass)==0){
$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
// Create salted password 
$password = hash('sha512', $password . $random_salt);
// Insert the new user into the database 
if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, nome, grupo, email, tlm, password, salt,status) VALUES (?, ?, ?, ?, ?, ?, ?,?)")) {
$insert_stmt->bind_param('ssssssss', $username, $nome, $grupo, $email, $tlm, $password, $random_salt, $status);
	// Execute the prepared query.
	$insert_stmt->execute();
	$sucesso=1;
	$html_msg="O utilizador foi criado com êxito<br>";	
	$ideditar=$insert_stmt->insert_id;
}
} else {
		$sucesso=0;
		$type="error";
		foreach($errPass as $errop){
		$html_msg.="$errop<br>";	
		}
	}		
}

if($sucesso==1){
	if($ideditar!=$_SESSION['user_id']){
	addLog("".$accao,$_SESSION['user_id'],$ideditar);
	} else {
	addLog("Perfil ".$accao); 
	}
}


if(isset($_POST['departm']) && isset($ideditar) && $ideditar>0)
{ 
    foreach ($_POST['departm'] as $value ) 
    {
	$rQ=$mysqli->query("SELECT idfield from members_fields where nomeField='departamentos' AND member='$ideditar' AND value='$value'") or $error=$mysqli->errno .' - '. $mysqli->error;
		if ($rQ->num_rows==0) {
			$mysqli->query("INSERT INTO members_fields (nomeField,member,value) VALUES ('departamentos','$ideditar','$value')")  or $error=$mysqli->errno .' - '. $mysqli->error;
		}
    }
	$arryF = "'" .implode("','", $_POST['departm']) . "'"; 	
	$mysqli->query("DELETE from members_fields where nomeField='departamentos' AND member='$ideditar' AND value NOT IN (".$arryF.") ") or $error=$mysqli->errno .' - '. $mysqli->error;

}


$output = array("success" => "$sucesso", "type" => "$type", "message" => "$html_msg $error");

}

/* ############################################## EDITAR FOTO #################################################### */

if (isset($_POST['accaoP']) && $accao == "editafoto" && $_SERVER['REQUEST_METHOD'] == "POST") {
$imgContent=addslashes(file_get_contents($_FILES['uploadfile']['tmp_name']));
$imgName=$_FILES['uploadfile']['name'];
$imgName=str_replace(" ","_",$imgName);
$idusredit = filter_input(INPUT_POST, 'idusredit', FILTER_SANITIZE_STRING);	


$query = $mysqli->query("select fotoname from members where id='$idusredit'") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_array();
$fotoOld=$dados['fotoname'];

$mysqli->query("UPDATE members set foto='$imgContent',fotoname='$imgName' where id='$idusredit'") or die($mysqli->errno .' - '. $mysqli->error);

 if(is_file($storeFolder."/users/".$fotoOld)){
	unlink($storeFolder."/users/".$fotoOld);	 
 }
 
move_uploaded_file($_FILES['uploadfile']['tmp_name'], $storeFolder."/users/".$imgName);

$_SESSION["fotoUser"]=$imgName;
   
$mensagem="1";
$htmlmsg="Foto editada com sucesso!";
$output = array("success" => "$mensagem","type" => "info", "message" => "$htmlmsg", "src" => "data:image/png;base64,$imgContent");    
}

/* ############################################## OBTER FOTO #################################################### */
if (isset($_GET['accaoG']) && $accao == "getUserPic" && $_SERVER['REQUEST_METHOD'] == "GET") {
$user_id = mysqli_real_escape_string($mysqli,$_GET['user_id']);
$query = $mysqli->query("select foto FROM members  WHERE id = $user_id") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_assoc();
$output = array("success" => "1","type" => "info","fotodata" => base64_encode($dados['foto']));	
}
/* ############################################## EDITAR NOTAS #################################################### */
if (isset($_POST['accaoP']) && $accao == "editNotes" && $_SERVER['REQUEST_METHOD'] == "POST") {
$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);	

$mysqli->query("UPDATE members set notes='$notes' where id='".$_SESSION['user_id']."'") or die($mysqli->errno .' - '. $mysqli->error);

$htmlmsg="Notas editadas";
$output = array("success" => "1","type" => "info","message" => "$htmlmsg");	
}

/* ############################################## OUTPUT ######################################################### */
echo json_encode($output);
}