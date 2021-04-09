<?php header('Content-Type: application/json');


include_once 'include/db_connect.php';
include_once 'include/functions.php';


if (isset($_POST['utilizador'], $_POST['emailF'])) {
    $utilizador = filter_input(INPUT_POST, 'utilizador', FILTER_SANITIZE_STRING);
	$emailF = filter_input(INPUT_POST, 'emailF', FILTER_SANITIZE_STRING);
   
   	$query = $mysqli->query("select id from members where username='$utilizador' AND email='$emailF'") or die($mysqli->errno .' - '. $mysqli->error);
	if($query->num_rows==0){
	$mensagem=0;	
	$htmlmsg="Erro";
	} else {
	$dados = $query->fetch_array();	
	$idusr=$dados['id'];
	$mensagem=1;
	$htmlmsg="Verifique o seu email para redefinir a sua password";
	
	$rcode=generateRandomString();
	 
	$mysqli->query("update members set rcode='$rcode' where id='$idusr'") or die($mysqli->errno .' - '. $mysqli->error);
	
	$body="Caro utilizador, foi solicitado um pedido para redefinir a sua senha de acesso para ".config_val('empresa').".<br><br>Para tal deverá clicar neste <a href=\"".URLBASE."/reset/".$rcode."\">link</a><br><br>Caso não tenha sido você, por favor ignore esta mensagem.";
	$envia=enviaMail($emailF,"Recuperação de password",$body);
		if($envia!=true){
		$htmlmsg=$envia;
		$mensagem=0;	
		}
	}
   
	$response = array("mensagem" => "$mensagem","htmlmsg" => "$htmlmsg");
      
}

echo json_encode($response);
?>