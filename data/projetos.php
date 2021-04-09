<?php header("Content-type:application/json");
include_once '../include/db_connect.php';
include_once '../include/functions.php';
  
sec_session_start();
if (login_check($mysqli) == true) {
	
if(isset($_POST['accaoP']))	{	$accao=mysqli_real_escape_string($mysqli,$_POST['accaoP']);	}else{$accao="";}
if(isset($_GET['accaoG']))	{	$accaoG=mysqli_real_escape_string($mysqli,$_GET['accaoG']);	}else{$accaoG="";}	


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accao=="ad"){ 

$strNumContrib=mysqli_real_escape_string($mysqli,$_POST['strNumContrib']);
$ncliente=isset($_POST['ncliente']) && $_POST['ncliente']!="" ? mysqli_real_escape_string($mysqli,$_POST['ncliente']):NULL;
$nome=isset($_POST['strNome'])? mysqli_real_escape_string($mysqli,$_POST['strNome']):NULL;
$morada=isset($_POST['morada'])  && $_POST['morada']!="" ? mysqli_real_escape_string($mysqli,$_POST['morada']):NULL;
$cp=isset($_POST['cp'])? mysqli_real_escape_string($mysqli,$_POST['cp']):NULL;
$localidade=isset($_POST['localidade'])? mysqli_real_escape_string($mysqli,$_POST['localidade']):NULL;
$telefone=isset($_POST['telefone'])? mysqli_real_escape_string($mysqli,$_POST['telefone']):NULL;
$telemovel=isset($_POST['telemovel'])? mysqli_real_escape_string($mysqli,$_POST['telemovel']):NULL;
$email=isset($_POST['email'])? mysqli_real_escape_string($mysqli,$_POST['email']):NULL;
$responsavel=isset($_POST['responsavel'])? mysqli_real_escape_string($mysqli,$_POST['responsavel']):NULL;
$funcao=isset($_POST['funcao'])? mysqli_real_escape_string($mysqli,$_POST['funcao']):NULL;
$norcamento=isset($_POST['norcamento'])? mysqli_real_escape_string($mysqli,$_POST['norcamento']):NULL;
$nrequisicao=isset($_POST['nrequisicao'])? mysqli_real_escape_string($mysqli,$_POST['nrequisicao']):NULL;
$titulo=isset($_POST['titulo'])? mysqli_real_escape_string($mysqli,$_POST['titulo']):NULL;
$categoria=isset($_POST['categoria'])? mysqli_real_escape_string($mysqli,$_POST['categoria']):'00';
$seccao=@$_POST['seccao'];
$funcionarios=@$_POST['funcionarios'];
$comentarios=isset($_POST['comentarios'])? mysqli_real_escape_string($mysqli,$_POST['comentarios']):NULL;
$conclusao=isset($_POST['conclusao'])? mysqli_real_escape_string($mysqli,$_POST['conclusao']):NULL;
$estado=1;    

$codprojeto=proj_NextCode($categoria);

$query = $mysqli->query("INSERT INTO projetos (codprojeto,clientenum,clientenome,titulo,cat_projeto,dataupt_proj,added_by,morada,cpostal,localidade,telefone,telemovel,email,responsavel,funcao,norcamento,nrequisicao,comentarios,conclusao,estado) VALUES ('$codprojeto','$ncliente','$nome','$titulo','$categoria',NOW(),".$_SESSION['user_id'].",'".$morada."','$cp','$localidade','$telefone','$telemovel','$email','$responsavel','$funcao','$norcamento','$nrequisicao','$comentarios','$conclusao','$estado')") or die($mysqli->errno .' - '. $mysqli->error);
$ulTid=$mysqli->insert_id;

if(is_array($seccao) && sizeof($seccao)>0){
	foreach($seccao as $sect){
		$query = $mysqli->query("INSERT INTO projetos_ent (tipo,projeto,valor) VALUES ('departamento','$ulTid','$sect')");
	}
}

if(is_array($funcionarios) && sizeof($funcionarios)>0){
	foreach($funcionarios as $funcionario){
		$query = $mysqli->query("INSERT INTO projetos_ent (tipo,projeto,valor) VALUES ('funcionario','$ulTid','$funcionario')");
	}
}


proj_log("projetos_ad",$ulTid,"Projeto criado","",serialize(array("seccao"=>$seccao,"funcionarios"=>$funcionarios)));

$sucesso=1;	$html_msg="Registo criado com exito!<br>";

$output = array("success" => "$sucesso", "type" => "info", "message" => "$html_msg", "idprojeto" => "$ulTid");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accaoG=="uploadFoto"){ 

$proj=mysqli_real_escape_string($mysqli,$_GET['proj']);	
$imgName=$proj.date('Ymdhis').".jpg";
$imgDate=date('Y-m-d H:i');


 if(!is_dir($storeFolder."/projetos/".$proj)){
	mkdir($storeFolder."/projetos/".$proj);	 
 }
 if(!is_dir($storeFolder."/projetos/".$proj."/fotos")){
	mkdir($storeFolder."/projetos/".$proj."/fotos");	 
 }

$query=$mysqli->query("SELECT projeto from projetos_att where projeto='$proj' and filename='$imgName'") or die($mysqli->errno .' - '. $mysqli->error);	
if($query->num_rows==0){
 
if(move_uploaded_file($_FILES['webcam']['tmp_name'], $storeFolder."/projetos/".$proj."/fotos/".$imgName)){


$query = $mysqli->query("INSERT INTO projetos_att (projeto,filename,tipo,added_by,legenda) VALUES ('$proj','$imgName','fotos','".$_SESSION['user_id']."','$imgDate')") or die($mysqli->errno .' - '. $mysqli->error);
$idfile=$mysqli->insert_id; 

$sucesso=1;	$html_msg="Foto ".$imgName." adicionada";

proj_log("projetos_adFoto",$proj,"Foto enviada","",serialize(array("idfoto"=>$idfile)));


} else {
$sucesso=0;	$html_msg="Foto ".$imgName." não enviada";
	
}
}


$output = array("success" => "$sucesso", "type" => "info", "fname" => "$imgName", "idFile" => "$idfile", "descr" => "$imgDate", "message" => "$html_msg");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accaoG=="Interv"){ 
$proj=mysqli_real_escape_string($mysqli,$_GET['proj']);
$arrinterv=array();

$queryInterv=$mysqli->query("SELECT valor from projetos_ent where (tipo='funcionario') and projeto='$proj' order by idnum desc") or die($mysqli->errno .' - '. $mysqli->error);	
while($linhaInterv=$queryInterv->fetch_assoc()){  
$arrinterv[]=$linhaInterv['valor'];
}

$arryF = "'" .implode("','", $arrinterv) . "'"; 

$query = $mysqli->query("select id,nome FROM members  WHERE id NOT IN  (".$arryF.") ") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
$output[]= array("value" => $dados['id'], "text" => $dados['nome']);
}
}
    
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accao=="elimina"){ 
$num=mysqli_real_escape_string($mysqli,$_POST['num']);
$mysqli->query("UPDATE projetos set estado=0 WHERE idproj='$num'") or die($mysqli->errno .' - '. $mysqli->error);	    
proj_log($accao,$num,"Projeto eliminado","","");
    
$output = array("success" => 1);
}    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accao=="eliminaAtt"){ 

$idAtt=mysqli_real_escape_string($mysqli,$_POST['idAtt']);
$projeto=mysqli_real_escape_string($mysqli,$_POST['projeto']);
$tipo=mysqli_real_escape_string($mysqli,$_POST['tipo']);

if($tipo=="imagens" || $tipo=="fotos"){
	$tpoDel="projetos_delImg";
	$descrtipo="Imagem";
	$txteliminad="eliminada";
}

if($tipo=="anexos"){
	$tpoDel="projetos_delAtt";
	$descrtipo="Ficheiro";
	$txteliminad="eliminado";
}

$query=$mysqli->query("SELECT * from projetos_att where tipo='$tipo' and projeto='$projeto' and idatt='$idAtt'") or die($mysqli->errno .' - '. $mysqli->error);	
$dlinha=$query->fetch_assoc();
if(is_file($storeFolder."/projetos/".$dlinha['projeto']."/".$dlinha['tipo']."/".$dlinha['filename'])){
	if(unlink($storeFolder."/projetos/".$dlinha['projeto']."/".$dlinha['tipo']."/".$dlinha['filename'])){
	$mysqli->query("delete from projetos_att where tipo='".$dlinha['tipo']."' and projeto='$projeto' and idatt='$idAtt'") or die($mysqli->errno .' - '. $mysqli->error);	
	}
	$sucesso=1;	$html_msg="$descrtipo ".$dlinha['filename']." $txteliminad"; $type="info";
	proj_log($tpoDel,$projeto,"$descrtipo $txteliminad","",serialize(array("idfoto"=>$idAtt,"fname"=>$dlinha['filename'])));
	
} else {
	$sucesso=0;	$html_msg="$descrtipo ".$storeFolder."/projetos/".$dlinha['projeto']."/".$dlinha['tipo']."/".$dlinha['filename']." não foi $txteliminad";	
	$type="warning";
}


$output = array("success" => "$sucesso", "type" => "$type", "message" => "$html_msg");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accao=="addComent"){ 

$projeto=mysqli_real_escape_string($mysqli,$_POST['projeto']);
$coment=mysqli_real_escape_string($mysqli,$_POST['coment']);

$duser=get_user_full($_SESSION['user_id'], $mysqli);

$nome=$duser['nome'];

 if(is_file($storeFolder."/users/".$_SESSION['fotoUser']."")){
 	$foto=URLBASE."/attachments/users/".$_SESSION['fotoUser'];	 	 
 }  else {
	$foto=URLBASE."/build/images/user.png"; 
 }
 
 
$mes=date('M');
$dia=date('d');


$sucesso=1;	$html_msg="Comentário adicionado"; $type="info";
proj_log("comment_ad",$projeto,"$coment","","");
	
$output = array("success" => "$sucesso", "type" => "$type", "message" => "$html_msg", "mes" => "$mes", "dia" => "$dia", "nome" => "$nome", "foto" => "$foto");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['pk']) && isset($_POST['name'])){ 

//print_r($_POST);
$name=mysqli_real_escape_string($mysqli,$_POST['name']);
$valor=mysqli_real_escape_string($mysqli,$_POST['value']);
//$tipo=mysqli_real_escape_string($mysqli,$_POST['pk']['tipo']);
$projeto=mysqli_real_escape_string($mysqli,$_POST['pk']['projeto']);

if($name=="estado"){
$mysqli->query("update projetos set $name='$valor' where idproj='$projeto'") or die($mysqli->errno .' - '. $mysqli->error);	
proj_log("projetos_$name",$projeto,"".ucfirst($name)." atualizado","",serialize(array("txt"=>$valor)));	
}

if($name=="interv"){
$rn=$mysqli->query("select idnum from projetos_ent where projeto='$projeto' and tipo='funcionario' and valor='$valor'");	
if($rn->num_rows==0){
$mysqli->query("INSERT INTO projetos_ent (tipo,projeto,valor) VALUES  ('funcionario','$projeto','$valor')") or die($mysqli->errno .' - '. $mysqli->error);	
proj_log("projetos_interv",$projeto,"Colaborador adicionado","",serialize(array("idcol"=>$valor)));	
}
}
    

    
if($name=="intervtimeusr"){
$timer=mysqli_real_escape_string($mysqli,$_POST['timer']); 
$tipoAct=mysqli_real_escape_string($mysqli,$_POST['tipoAct']); 
$numlinha=mysqli_real_escape_string($mysqli,$_POST['numlinha']);     

$rt=$mysqli->query("select idnum from projetos_timer where projeto='$projeto' and linha='$numlinha'");	     
$nRegistos=$rt->num_rows;     
if($nRegistos==0 && $tipoAct=="add" && $timer>0){    
$mysqli->query("INSERT INTO projetos_timer (user,projeto,linha,timer,timerstatus,timerupdt,addedBy) VALUES ('$valor','$projeto','$timer',0,'stopped',NOW(),'".$_SESSION['user_id']."')");
} if($nRegistos==1 || $tipoAct=="edit" ){  
$mysqli->query("update projetos_timer set user='$valor' where projeto='$projeto' and linha='$numlinha'");    
}  
 
}    
    
    

else {
$mysqli->query("update projetos_att set legenda='$valor' where projeto='$projeto' and idatt='$name'") or die($mysqli->errno .' - '. $mysqli->error);	
}

$sucesso=1;	
$output = array("success" => "$sucesso");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accao=="updtTask"){ 

$accaotask=mysqli_real_escape_string($mysqli,$_POST['accaotask']);
$projeto=mysqli_real_escape_string($mysqli,$_POST['projeto']);
$numero=mysqli_real_escape_string($mysqli,$_POST['numero']);

$mysqli->query("update projetos_ent set tipo='$accaotask' where projeto='$projeto' and idnum='$numero'") or die($mysqli->errno .' - '. $mysqli->error);	

proj_log("$accaotask",$projeto,"Tarefa atualizada","",serialize(array("txt"=>$accaotask,"idtask"=>$numero)));	

$sucesso=1;	
$output = array("success" => "$sucesso");
}
    
    
    
    
    
    
######################################################################################################################################
if($accaoG=="gettimer" && $_SERVER['REQUEST_METHOD']=="GET") {
$idtimer=mysqli_real_escape_string($mysqli,$_GET['idtimer']);
$projeto=mysqli_real_escape_string($mysqli,$_GET['projeto']);
    
  
$query=$mysqli->query("select timer,timerstatus,timerupdt,obs from projetos_timer where projeto='$projeto' and idnum='$idtimer' and (timerstatus='running' OR timerstatus='paused') order by idnum desc limit 0,1") or die($mysqli->errno .' - '. $mysqli->error);	
$l=$query->fetch_assoc();    
    
$timer=$l['timer'];	
$timerstatus=$l['timerstatus'];
$timerupdt=$l['timerupdt']; 
$obs=$l['obs'];     

if($timerstatus=="running"){
$timeFirst  = strtotime($timerupdt);
$timeSecond = strtotime(date('Y-m-d H:i:s'));
$differenceInSeconds = $timeSecond - $timeFirst;
$timer=$timer+$differenceInSeconds;
}
if($timerstatus=="stopped" || $timerstatus=="" ){
$timer=0; 
}      
$output=array("timerstatus"=>$timerstatus,"timer"=>$timer,"timerupdt"=>$timerupdt,"obs"=>$obs);   
}
######################################################################################################################################

if($accao=="updatetimer" && $_SERVER['REQUEST_METHOD']=="POST") { 
$projeto=mysqli_real_escape_string($mysqli,$_POST['projeto']);    
$idtimer=mysqli_real_escape_string($mysqli,$_POST['idtimer']);
$estado=mysqli_real_escape_string($mysqli,$_POST['estado']);
$tempo=mysqli_real_escape_string($mysqli,$_POST['tempo']); 
$qxtra=""; 
    
$rt=$mysqli->query("select idnum from projetos_timer where idnum='$idtimer' and (timerstatus='running' OR timerstatus='paused' OR timerstatus='stopped') order by idnum desc limit 0,1") or $tempo=$mysqli->error;
if($rt->num_rows==1){    
    $l=$rt->fetch_assoc();
    $idTimer=$l['idnum']; 
    //if($tempo>0) { 
    if(isset($_POST['timercoment'])){
        $timercoment=mysqli_real_escape_string($mysqli,$_POST['timercoment']);  
        $qxtra.=", obs='$timercoment'";
    }
    
    $mysqli->query("UPDATE projetos_timer set timer='$tempo', timerstatus='$estado',timerupdt=NOW()".$qxtra." where idnum='$idTimer'") or $tempo=$mysqli->error;	
    /*} else {
    $mysqli->query("UPDATE projetos_timer set timerstatus='$estado',timerupdt=NOW() where idnum='$idTimer'") or die($mysqli->errno .' - '. $mysqli->error);	
    }*/ 
} else {
    if($idtimer==0){
    $rtL=$mysqli->query("select linha from projetos_timer where projeto='$projeto'");	
    $nextLine=($rtL->num_rows)+1; 
    
    $mysqli->query("INSERT INTO projetos_timer (timer,linha,timerstatus,projeto,addedBy) VALUES ('$tempo',$nextLine,'$estado','$projeto', '".$_SESSION['user_id']."') ") or $tempo=$mysqli->error;
    $idtimer=$mysqli->insert_id;
    }
}
$output = array("response"=>"1","dados"=>"$tempo","idRec"=>$idtimer); 
} 

######################################################################################################################################

if(isset($_POST['accaoP']) && $accao=="edittimer" && $_SERVER['REQUEST_METHOD']=="POST") { 
$idtimer=mysqli_real_escape_string($mysqli,$_POST['idtimer']);
$timercoment=mysqli_real_escape_string($mysqli,$_POST['timercoment']);
$tempo=mysqli_real_escape_string($mysqli,$_POST['timeedit']);
$projeto=mysqli_real_escape_string($mysqli,$_POST['projeto']);
    
$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $tempo);
sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;    
    
 // and addedBy='".$_SESSION['usrId']."' s
$rt=$mysqli->query("select idnum from projetos_timer where idnum='$idtimer' and projeto='$projeto' and timerstatus='paused' order by idnum desc limit 0,1") or $tempo=$mysqli->error;   
if($rt->num_rows==1){     
    $mysqli->query("UPDATE projetos_timer set timer='$time_seconds', obs='$timercoment',timerupdt=NOW() where idnum='$idtimer' and projeto='$projeto'") or $tempo=$mysqli->error;
} 
$output = array("response"=>"1","dados"=>"$tempo","sec"=>"$time_seconds");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['accaog']) && $accao=="openTimer"){
$rt=mysql_query("select idnum from timers where timerstatus='running' and addedBy='".$_SESSION['usrId']."' order by idnum desc limit 0,1");   
   if(mysql_num_rows($rt)==1){
    $response = 1;   
   } else {
    $response = 0;      
   }
}    
    
    
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
if($accaoG=="IntervTimer" && $_SERVER['REQUEST_METHOD']=="GET") {    
$proj=mysqli_real_escape_string($mysqli,$_GET['proj']);
$arrinterv=array();

$queryInterv=$mysqli->query("SELECT projetos_ent.valor,members.nome from projetos_ent LEFT JOIN members ON projetos_ent.valor=members.id where (projetos_ent.tipo='funcionario') and projetos_ent.projeto='$proj' order by members.nome desc") or die($mysqli->errno .' - '. $mysqli->error);	
while($linhaInterv=$queryInterv->fetch_assoc()){  
$output[]= array("value" => $linhaInterv['valor'], "text" => $linhaInterv['nome']);
}
    
}    
      

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accao=="addTask"){ 

$projeto=mysqli_real_escape_string($mysqli,$_POST['projeto']);
$nome=mysqli_real_escape_string($mysqli,$_POST['nome']);

$mysqli->query("insert into projetos_ent (tipo,projeto,valor) VALUES ('tarefa_undone','$projeto','$nome')") or die($mysqli->errno .' - '. $mysqli->error);	
$ulTid=$mysqli->insert_id;

proj_log("addTask",$projeto,"Tarefa criada","",serialize(array("txt"=>$nome,"idtask"=>$ulTid)));	

$sucesso=1;	
$output = array("success" => "$sucesso","idtask" => "$ulTid");
}
    
    
######################################################################################################################################

if(($accao=="updLinhasArt" || $accao=="updLinhasArt2") && $_SERVER['REQUEST_METHOD']=="POST") { 
$projeto=mysqli_real_escape_string($mysqli,$_POST['idProjLin']);  
$tipomater=mysqli_real_escape_string($mysqli,$_POST['tipomater']);      
    
$linhas=$_POST['compon'];   
$mensagem="";    
    
foreach($linhas as $l){
    $cLinha=$l['cLinha'];  
    $armazem=$l['armazem'];  
    $artigo=$l['artigo'];  
    $calculo=$l['calculo'];  
    $qtd=$l['formula']; 
    $cunit=$l['cunit'];  
    $total=$l['total'];  
 
$rt=$mysqli->query("select idnum from projetos_artigos where proj='$projeto' and linha='$cLinha' and tipo='$tipomater'") or $mensagem=$mysqli->error;   
if($rt->num_rows==1){     
    $mysqli->query("UPDATE projetos_artigos set codigo='$artigo', descricao='$artigo',qtd='$qtd',custo='$cunit',stotal='$total' where proj='$projeto' and linha='$cLinha' and tipo='$tipomater'") or $mensagem=$mysqli->error;
}  else {
    $mysqli->query("INSERT INTO projetos_artigos (codigo, descricao,qtd,proj,linha,custo,stotal,tipo,addedby) VALUES ('$artigo','$artigo','$qtd','$projeto','$cLinha','$cunit','$total','$tipomater','".$_SESSION['user_id']."')") or $mensagem=$mysqli->error;
}    
}   
    
$output = array("response"=>1,"dados"=>$mensagem); 
}     

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($accaoG=="listProjetos"){ 
$aColumns = array( 'idproj', 'clientenum', 'codprojeto', 'clientenome',  'titulo', 'cat_projeto', 'dataad_proj', 'dataupt_proj', 'added_by'); 
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'idproj';
// DB table to use
$sTable = 'projetos';
// Input method (use $_GET, $_POST or $_REQUEST)
$input =& $_GET;
/**
 * Paging
 */
$sLimit = "";
if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
    $sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
}
/**
 * Ordering
 */
$aOrderingRules = array();
if ( isset( $input['iSortCol_0'] ) ) {
    $iSortingCols = intval( $input['iSortingCols'] );
    for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
        if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
            $aOrderingRules[] =
                "`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` "
                .($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
        }
    }
}
 
if (!empty($aOrderingRules)) {
    $sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
} else {
    $sOrder = "";
}
  
/**
 * Filtering
 */
$iColumnCount = count($aColumns);
 
if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
    $aFilteringRules = array();
    for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
        if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
            $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$mysqli->real_escape_string( $input['sSearch'] )."%'";
        }
    }
    if (!empty($aFilteringRules)) {
        $aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
    }
}
  
// Individual column filtering
for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
    if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
        $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$mysqli->real_escape_string($input['sSearch_'.$i])."%'";
    }
}
    
    
if ( isset( $input['status'] ) && $input['status'] != '' ) {
    $aFilteringRules[] = " estado='".$input['status']."' ";
}    
   
if ( isset( $input['cat'] ) && $input['cat'] != '' ) {
    $aFilteringRules[] = " cat_projeto='".$input['cat']."' ";
}    
    
    
if (!empty($aFilteringRules)) {
    $sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
} else {
    $sWhere = "";
}


if (!empty($aFilteringRules)) {
    $sWhere .= " AND $sIndexColumn<>'' and estado>0";
} else {
    $sWhere = " WHERE $sIndexColumn<>'' and estado>0";
}
  
  
/**
 * SQL queries
 * Get data to display
 */
$aQueryColumns = array();
foreach ($aColumns as $col) {
    if ($col != ' ') {
        $aQueryColumns[] = $col;
    }
}
 
$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`,DATE_FORMAT(dataad_proj,'%Y-%m-%d')  as dataad_proj,DATE_FORMAT(dataupt_proj,'%Y-%m-%d')  as dataupt_proj,tbl_projetos_cat.nome
    FROM `".$sTable."`
    LEFT JOIN tbl_projetos_cat ON ".$sTable.".cat_projeto=tbl_projetos_cat.idnum
    ".$sWhere.$sOrder.$sLimit;
    
   // die($sQuery);
 
$rResult = $mysqli->query( $sQuery ) or die($mysqli->error);
  
// Data set length after filtering
$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $mysqli->query( $sQuery ) or die($mysqli->error);
list($iFilteredTotal) = $rResultFilterTotal->fetch_row();
 
// Total data set length
$sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
$rResultTotal = $mysqli->query( $sQuery ) or die($mysqli->error);
list($iTotal) = $rResultTotal->fetch_row();
  
  
/**
 * Output
 */
$output = array(
    "sEcho"                => intval($input['sEcho']),
    "iTotalRecords"        => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData"               => array(),
);
  
while ( $aRow = $rResult->fetch_assoc() ) {
    $row = array();
    for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
        if ( $aColumns[$i] == 'added_by' ) {			
            $row[] = "<a href=\"projetos/".$aRow[$aColumns[0]]."\" class=\"btn btn-primary btn-xs\">Consultar</a>";
        } 
        else if ( $aColumns[$i] == 'clientenum' ) {			
            $rPics = $mysqli->query("select idatt,filename,tipo from projetos_att where projeto='".$aRow[$aColumns[0]]."' and (tipo='fotos' OR tipo='imagens') LIMIT 0,4");
            if($rPics && $rPics->num_rows>0){
               $row[] = $rPics->fetch_all(MYSQLI_ASSOC);
            } else {
            $row[] = array(); 
            }
        }         
        else if ( $aColumns[$i] == 'cat_projeto' ) {			
            $row[] = $aRow['nome'];
        }
        
        elseif ( $aColumns[$i] != ' ' ) {
            // General output
            $row[] = $aRow[ $aColumns[$i] ];
        }
    }
    $output['aaData'][] = $row;
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo json_encode( $output );
}