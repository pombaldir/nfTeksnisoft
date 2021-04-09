<?php header("Content-type:application/json");
include_once '../include/db_connect.php';
include_once '../include/functions.php';
  
sec_session_start();
if (login_check($mysqli) == true) {
	
if(isset($_POST['accaoP']))	{	$accao=mysqli_real_escape_string($mysqli,$_POST['accaoP']);	}else{$accao="";}
if(isset($_GET['accaoG']))	{	$accaoG=mysqli_real_escape_string($mysqli,$_GET['accaoG']);	}else{$accaoG="";}	


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accaoG=="FuncionbyDept"){ 
$seccao=$_GET['seccao'];

$seccao = implode("','",$seccao);
$listaDepartm=array();
$funcionarios=array();

$query = $mysqli->query("SELECT tbl_seccoes.departamentos FROM tbl_seccoes WHERE tbl_seccoes.idnum IN ('".$seccao."')") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
$deps=unserialize($dados['departamentos']);	
foreach($deps as $dept){
$listaDepartm[]=$dept;	
}
}
//array_unique($listaDepartm);

//print_r($listaDepartm);

$listaDepartm = implode("','",$listaDepartm);

$query = $mysqli->query("SELECT members.nome,members.id FROM members_fields LEFT JOIN members ON members_fields.member = members.id
WHERE members_fields.nomeField='departamentos' and members_fields.value IN ('".$listaDepartm."') GROUP BY members_fields.member") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
$funcionarios[]=array("label"=>$dados['nome'], "title"=>$dados['nome'], "value"=>$dados['id'], "selected"=>false);
}



$output[]=array("funcionarios"=>$funcionarios);

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo json_encode( $output );
}