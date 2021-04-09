<?php include_once '../include/db_connect.php';	include_once '../include/functions.php'; header('Content-Type: application/json'); 

sec_session_start();

if (login_check($mysqli) == true) {
	
if (isset($_POST['accaoP'])) {
    $accao = mysqli_real_escape_string($mysqli,$_POST['accaoP']);
}
if (isset($_GET['accaoG'])) {
    $accao = mysqli_real_escape_string($mysqli,$_GET['accaoG']);
}
/* ############################################## EDITAR PERFIL #################################################### */

if (isset($_POST['accaoP']) && $accao == "edit" && $_SERVER['REQUEST_METHOD'] == "POST") {

$importar=array();
$nomeempresa = filter_input(INPUT_POST, 'nomeempresa', FILTER_SANITIZE_STRING);	
$erp = filter_input(INPUT_POST, 'erp', FILTER_SANITIZE_STRING);	
$store = filter_input(INPUT_POST, 'store', FILTER_SANITIZE_STRING);	
$erp_ws = filter_input(INPUT_POST, 'erp_ws', FILTER_SANITIZE_STRING);	
$store_url=filter_input(INPUT_POST, 'store_url', FILTER_SANITIZE_URL);
$ws_token=filter_input(INPUT_POST, 'ws_token', FILTER_SANITIZE_STRING);
$ws_api=filter_input(INPUT_POST, 'ws_api', FILTER_SANITIZE_STRING);
$ws_secret=filter_input(INPUT_POST, 'ws_secret', FILTER_SANITIZE_STRING);
$preco_linha=filter_input(INPUT_POST, 'preco_linha', FILTER_SANITIZE_STRING);
$payment_status=filter_input(INPUT_POST, 'payment_status', FILTER_SANITIZE_STRING);
$clickatell_api=filter_input(INPUT_POST, 'clickatell_api', FILTER_SANITIZE_STRING);
$clickatell_from=filter_input(INPUT_POST, 'clickatell_from', FILTER_SANITIZE_STRING);
$entidade=filter_input(INPUT_POST, 'pag_entidade', FILTER_SANITIZE_STRING);
$subentidade=filter_input(INPUT_POST, 'pag_subentidade', FILTER_SANITIZE_STRING);
$tpdocs=@$_POST['docs_vendas'];
$minutosVND=filter_input(INPUT_POST, 'minutosVND', FILTER_SANITIZE_STRING);
$minPts=filter_input(INPUT_POST, 'minPts', FILTER_SANITIZE_STRING);
$mchimp_api=filter_input(INPUT_POST, 'mchimp_api', FILTER_SANITIZE_STRING);
$mchimp_server=filter_input(INPUT_POST, 'mchimp_server', FILTER_SANITIZE_STRING);
$list=filter_input(INPUT_POST, 'list', FILTER_SANITIZE_STRING);
$smtpserver=filter_input(INPUT_POST, 'smtpserver', FILTER_SANITIZE_STRING);
$smtpusername=filter_input(INPUT_POST, 'smtpusername', FILTER_SANITIZE_STRING);
$smtpass=filter_input(INPUT_POST, 'smtpass', FILTER_SANITIZE_STRING);
$smtpauth=filter_input(INPUT_POST, 'smtpauth', FILTER_SANITIZE_STRING);
$smtpport=filter_input(INPUT_POST, 'smtpport', FILTER_SANITIZE_STRING);
$mailfrom=filter_input(INPUT_POST, 'mail_from', FILTER_SANITIZE_STRING);


if(isset($_POST['permiss'])){
	$permiss=$_POST['permiss']; 
	$perms=array();
	$Listaperms=array(); 
	foreach($permiss as $k=>$v){
		$perms[$k]=$v;
	}
	foreach($perms as $k=>$v){
	$mysqli->query("UPDATE tbl_departamentos set perms='".serialize($v)."' where idnum='".$k."'");
	$Listaperms[]=$k;
	}
	$arryF = "'" .implode("','", $Listaperms) . "'"; 	
	$mysqli->query("UPDATE tbl_departamentos set perms=NULL where idnum NOT IN (".$arryF.")");
} else {
	$mysqli->query("UPDATE tbl_departamentos set perms=NULL");	
}


$sms=array("clickatell_api"=>$clickatell_api,"clickatell_from"=>$clickatell_from);
$pagam=array("entidade"=>$entidade,"subentidade"=>$subentidade);
$avisos=array("tpdocs"=>$tpdocs,"minutosVND"=>$minutosVND,"minPts"=>$minPts);
$mailchimp=array("mchimp_api"=>$mchimp_api,"mchimp_server"=>$mchimp_server,"list"=>$list);
$mail=array("smtpserver"=>$smtpserver,"smtpusername"=>$smtpusername,"smtpass"=>$smtpass,"smtpauth"=>$smtpauth,"smtpport"=>$smtpport,"mailfrom"=>$mailfrom);

$settings=serialize(array("erp"=>$erp,"store"=>$store,"erp_ws"=>$erp_ws,"store_url"=>$store_url,"ws_token"=>$ws_token,"ws_api"=>$ws_api,"ws_secret"=>$ws_secret,"importar"=>serialize($importar),"preco_linha"=>$preco_linha,"payment_status"=>$payment_status,"sms"=>$sms,"pagamento"=>$pagam,"avisos"=>$avisos,"mailchimp"=>$mailchimp,"mail"=>$mail));


updateConfig('empresa', $nomeempresa);
updateConfig('settings', $settings);


$sucesso=1;	$html_msg="Definições editadas com êxito!";
$output = array("success" => "$sucesso", "type" => "info", "message" => "$html_msg");



}


/* ############################################## OUTPUT ######################################################### */
echo json_encode($output);
}