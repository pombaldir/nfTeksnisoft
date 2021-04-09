<?php include_once '../include/db_connect.php';	include_once '../include/functions.php'; header('Content-Type: application/json'); 

sec_session_start();

if (login_check($mysqli) == true) {
	
if (isset($_POST['accaoP'])) {
    $accao = mysqli_real_escape_string($mysqli,$_POST['accaoP']);
}
if (isset($_GET['accaoG'])) {
    $accao = mysqli_real_escape_string($mysqli,$_GET['accaoG']);
}
/* ############################################## EDITAR / ADICIONAR ############################################### */

if (isset($_POST['accaoP']) && $accao == "deleteR" && $_SERVER['REQUEST_METHOD'] == "POST") {
$tipoTbl = filter_input(INPUT_POST, 'tipoTbl', FILTER_SANITIZE_STRING);	
$tipoTbl=str_replace("-","_",$tipoTbl);
$num = filter_input(INPUT_POST, 'idnum', FILTER_SANITIZE_STRING);	
$nme=RegistoById($num,"tbl_".$tipoTbl."","nome");

$r1=$mysqli->query("select idfield from members_fields where nomeField='$tipoTbl' and value='$num'") or die($mysqli->errno .' - '. $mysqli->error);
if($r1->num_rows>0){	
$sucesso=0;	$html_msg="Existem utilizadores pertencentes a este grupo. Remova-os antes de eliminar o registo."; $type="error";
} else {

	if($tipoTbl=="materiais"){
		$mysqli->query("delete from mov_stock where artigo='$num'") or die($mysqli->errno .' - '. $mysqli->error);
	}  

$mysqli->query("delete from tbl_".$tipoTbl." where idnum='$num'") or die($mysqli->errno .' - '. $mysqli->error);
$sucesso=1;	$html_msg="Registo eliminado com êxito ($tipoTbl - $nme)"; $type="success";
}


if($sucesso==1){
	addLog("Tabela eliminada $tipoTbl - $nme", $_SESSION['user_id'], $num); 
}


$output = array("success" => "$sucesso", "type" => "$type", "message" => "$html_msg");

}


/* ############################################## EDITAR / ADICIONAR ############################################### */

if (isset($_POST['accaoP']) && ($accao == "edit" || $accao == "ad") && $_SERVER['REQUEST_METHOD'] == "POST") {
$tipoTbl = filter_input(INPUT_POST, 'tipoTbl', FILTER_SANITIZE_STRING);	
$num = isset($_POST['num']) ? filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING):NULL;
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);	
$catmae = isset($_POST['catmae']) ? filter_input(INPUT_POST, 'catmae', FILTER_SANITIZE_STRING):0;
$tipoTbl=str_replace("-","_",$tipoTbl);
$qextraEdit="";	
$qextraInsert=array();	


if($tipoTbl=="seccoes"){
$departm = isset($_POST['departm']) ? serialize($_POST['departm']):NULL;	
$qextraEdit=",parent=$catmae,departamentos='$departm'";
$qextraInsert=array("cpo"=>"departamentos","valor"=>$departm);	
}

if($tipoTbl=="projetos_cat"){
$qextraEdit=",parent=$catmae";
}

if($tipoTbl=="materiais"){
$categoria = isset($_POST['categoria']) ? filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING):0;   
$preco = isset($_POST['preco']) ? "'".filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_STRING)."'":"NULL";    
$unidade = isset($_POST['unidade']) ? "'".filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_STRING)."'":"NULL";    
$naomovstk = isset($_POST['naomovstk']) ? 1:0;    
$stock = isset($_POST['stock']) &&  $_POST['stock']!="" ? "'".filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_STRING)."'":"NULL";   
$qextraEdit=",categoria=$categoria,preco=$preco,unidade=$unidade,naomovstk=$naomovstk";
if($stock!="NULL" && $accao == "edit") { $qextraEdit.=",stock=$stock"; movStock($num,$_POST['stock']);  }

}    
    
    
if($tipoTbl=="projetos_status"){
$statusinicial = filter_input(INPUT_POST, 'status-inicial', FILTER_SANITIZE_STRING);	
$statusfinal = filter_input(INPUT_POST, 'status-final', FILTER_SANITIZE_STRING);	
$statusinvoice = filter_input(INPUT_POST, 'status-invoice', FILTER_SANITIZE_STRING);	
    
if($statusinicial==1)       $mysqli->query("UPDATE tbl_".$tipoTbl." SET started=0");
if($statusfinal==1)         $mysqli->query("UPDATE tbl_".$tipoTbl." SET finished=0");
if($statusinvoice==1)       $mysqli->query("UPDATE tbl_".$tipoTbl." SET invoice=0");


$qextraEdit=",started=$statusinicial,finished=$statusfinal,invoice=$statusinvoice";
}    


if($accao == "edit"){	
$mysqli->query("UPDATE tbl_".$tipoTbl." set nome='$nome' ".$qextraEdit." where idnum='".$num."'") or die($mysqli->errno .' - '. $mysqli->error);
$sucesso=1;	$html_msg="Registo $nome editado com êxito ($tipoTbl)"; $type="info";
}


if($accao == "ad"){
if(is_array($qextraInsert) && sizeof($qextraInsert)>0){
	$cp1=",".$qextraInsert['cpo'];	
	$cv1=",'".$qextraInsert['valor']."'";	
} else {
	$cp1="";
	$cv1="";	
}
if($tipoTbl=="projetos_cat"){	
$mysqli->query("INSERT INTO tbl_".$tipoTbl." (nome,parent".$cp1.") VALUES ('$nome','$catmae'".$cv1.")") or die($mysqli->errno .' - '. $mysqli->error);
} else if ($tipoTbl=="materiais"){	
$mysqli->query("INSERT INTO tbl_".$tipoTbl." (nome,categoria,preco,unidade,naomovstk,stock) VALUES ('$nome',$categoria,$preco,$unidade,$naomovstk,$stock)") or die($mysqli->errno .' - '. $mysqli->error);
 if($naomovstk==0){ movStock($mysqli->insert_id,$_POST['stock']); }  
} else {    
$mysqli->query("INSERT INTO tbl_".$tipoTbl." (nome".$cp1.") VALUES ('$nome'".$cv1.")") or die($mysqli->errno .' - '. $mysqli->error);
}

$sucesso=1;	$html_msg="Registo $nome criado com êxito ($tipoTbl)"; $type="success";
$num = $mysqli->insert_id;
}

if($sucesso==1){
	addLog("Tabela $accao $tipoTbl - $nome", $_SESSION['user_id'], $num); 
}

$output = array("success" => "$sucesso", "type" => "$type", "message" => "$html_msg");


}


/* ############################################## OUTPUT ######################################################### */
echo json_encode($output);
}