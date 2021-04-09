<?php include_once '../include/db_connect.php';	include_once '../include/functions.php'; header('Content-Type: application/json'); 

sec_session_start();

if (login_check($mysqli) == true) {
	
if (isset($_POST['accaoP'])) {
    $accao = mysqli_real_escape_string($mysqli,$_POST['accaoP']);
}
if (isset($_GET['accaoG'])) {
    $accao = mysqli_real_escape_string($mysqli,$_GET['accaoG']);
}
   
/* ############################################## PESQUISAR############################################### */
if(isset($_GET['act_g']) && $_GET['act_g']=="srchArtigo" && ($_SERVER['REQUEST_METHOD'] === 'GET')){
$term =  mysqli_real_escape_string($mysqli,$_GET['term']); 
$err="";
$materiais=array();    
    
$query = $mysqli->query("SELECT * FROM tbl_materiais WHERE nome LIKE '$term%' order by nome desc") or $err=$mysqli->errno .' - '. $mysqli->error;	
while($dados = $query->fetch_array()){ 
$materiais[]=array(
	"strCodigo"=>$dados['codigo'],
	"strCodCategoria"=>$dados['categoria'],
	"strDescricao"=>$dados['nome'],
    "strAbrevMedVnd"=>"",
    "fltPreco"=>$dados['preco']);
}
    
    
if($err==""){    
$output = $materiais;
} else {
$output = $err;
}

}

/* ############################################## OUTPUT ######################################################### */
echo json_encode($output);
}