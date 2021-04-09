<?php $tpPag=1; $ptitle="Utilizadores";	include("header.php"); ?>
<?php if($act==""){?>


  <?php
 $i=1; 
$query = $mysqli->query("select members.nome,members.tlm,members.email,members.id,members.username,members.fotoname,members_group.nome as grupo from members left JOIN members_group ON members.grupo=members_group.idnum where id>1 and status<2") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){

  if($i%2==0){ echo "<div class=\"row\">"; }
 ?>
  <div class="col-xs-6 profile_details">
    <div class="well profile_view" style="width:100%">
      <div class="col-sm-12">
        <h4 class="brief"><i><?php echo $dados['grupo'];?></i></h4>
        <div class="left col-xs-7">
          <h2><?php echo $dados['nome'];?></h2>
          <p><?php echo $dados['username'];?> </p>
          <ul class="list-unstyled">
            <li><i class="fa fa-envelope"></i> <?php echo $dados['email'];?></li>
            <li><i class="fa fa-phone"></i> <?php echo $dados['tlm'];?></li>
          </ul>
        </div>
        <div class="right col-xs-5 text-center">
<?php
  if(is_file($storeFolder."/users/".$dados['fotoname']."")){
 	echo "<img class=\"img-circle img-responsive\" src=\"".URLBASE."/attachments/users/".$dados['fotoname']."\" style=\"width:100px\" alt=\"\">";	 	 
 }  else {
	echo "<img class=\"img-circle img-responsive\" src=\"".URLBASE."/build/images/user.png\" style=\"width:100px\" alt=\"\">"; 
 }
 ?>
        </div>
      </div>
      <div class="col-xs-12 bottom text-center">
        <div class="col-xs-12 col-sm-12 emphasis"> <a  href="/utilizadores/edit/<?php echo $dados['id'];?>" class="btn btn-primary btn-xs"> <i class="fa fa-user"> </i> Editar Utilizador </a> </div>
      </div>
    </div>
  </div>
  <?php 

if($i%2==0){ echo "</div>"; }
$i++; 
}  ?>

<div class="ln_solid"></div>
<a  href="/utilizadores/ad" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-user"> </i> Adicionar Utilizador </a>
<?php  } if(($act=="edit" || $act=="ad") && verifAcesso('tabelas-utilizadores')){
	
	
if($act=="edit"){	
$query = $mysqli->query("select * from members where id=".$num." and id>1 and status<2") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_array();
$nrows=$query->num_rows;
$estado=$dados['status'];
} 
if($act=="ad"){
	
$dados=array("nome"=>"","tlm"=>"","email"=>"","username"=>"","grupo"=>"","fotoname"=>"");
$num="";	
$nrows=1;
$estado=0;
}

if($nrows>0){
?>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Perfil<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content"> <br />
        <form class="form-horizontal form-label-left input_mask" id="userform" name="userform" novalidate>
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="nome" name="nome" value="<?php echo $dados['nome'];?>" placeholder="Nome e Apelido">
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                <input type="text" class="form-control" id="tlm" name="tlm" placeholder="Telemóvel" value="<?php echo $dados['tlm'];?>" >
                <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> </div>
                
                
 <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                <select name="status" id="status" class="form-control has-feedback-left" >
                <option value="1" <?php if($estado==1) { echo "selected"; }?>>Ativo</option>
                 <option value="0" <?php if($estado==0) { echo "selected"; }?>>Inativo</option>
                </select>
                 </div>                
                
                
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="email" class="required form-control has-feedback-left" id="email" name="email" placeholder="Email" value="<?php echo $dados['email'];?>" required="required">
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span> </div>
              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                <input type="text" class="form-control" id="username" name="username" placeholder="Utilizador" value="<?php echo $dados['username'];?>" >
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> </div>
              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                <select name="grupo" id="grupo" class="form-control has-feedback-left" >
                  <?php
				  
				  if($_SESSION['usrGrp']==1){
					$qextra="";  
				  } else {
					$qextra="WHERE idnum>1";    
				  }
				  
                $queryGr = $mysqli->query("select idnum,nome from members_group $qextra") or die($mysqli->errno .' - '. $mysqli->error);
				while($dadosGr = $queryGr->fetch_array()){
				echo "<option value=\"".$dadosGr['idnum']."\"";
				if($dadosGr['idnum']==$dados['grupo']){
				echo " selected";	
				}
				echo">".$dadosGr['nome']."";
				echo "</option>";	
					
				}
                ?>
                </select>
                <span class="fa fa-users form-control-feedback right" aria-hidden="true"></span> </div>
              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"> </div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12"> </div>
              </div>
            </div>
          </div>
          
          <div class="row">
           <div class="col-md-6">
          <div class="item form-group">
            <label for="password" class="control-label col-md-4">Password</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="password" type="password" name="password" data-validate-length="6,8" class="optional form-control col-md-7 col-xs-12">
            </div>
            
          
            
            
          </div>
          <div class="item form-group">
            <label for="password2" class="control-label col-md-4">Repita Password</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="password2" type="password" name="password2" data-validate-linked="password" class="optional form-control col-md-7 col-xs-12">
            </div>
          </div>
          </div>
          
          <div class="col-md-6">
            <label for="departmento" class="control-label">Departamento:</label>
            
             <p style="padding: 5px;">
             
             <?php
			 if($act=="edit"){
			 $dadosDepart=get_member_field($num, array('departamentos'));
			 } else {
			 $dadosDepart=array(); 
			 }
			 $arrDpt=array();
			 if(sizeof($dadosDepart)>0){
			 $dadosDepart=$dadosDepart['departamentos'];
			 foreach($dadosDepart as $dpt){
				$arrDpt[]=$dpt['value'];
			 }
			 }
		
		
                $queryChk = $mysqli->query("select idnum,nome from tbl_departamentos order by nome asc") or die($mysqli->errno .' - '. $mysqli->error);
				while($dadosCH = $queryChk->fetch_array()){
				echo "<input type=\"checkbox\" name=\"departm[]\" id=\"departm".$dadosCH['idnum']."\" value=\"".$dadosCH['idnum']."\" class=\"flat\" ";
				if(in_array($dadosCH['idnum'],$arrDpt)){ echo "checked"; }
				echo"/> ".$dadosCH['nome']."<br />";
				} 
				
				?>

                     
                        </p>
          </div>
          </div>

          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-xs-3"> <a href="/utilizadores" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Voltar</a>
              <?php if($act=="edit"){ ?>
              <button  class="btn btn-danger" id="elimina"><span class="fa fa-trash"></span> Eliminar</button>
              <?php  } ?>
            </div>
            <div class="col-md-9">
              <button type="submit" class="btn btn-success pull-right" id="submitbtn"><span class="fa fa-save"></span> Submeter</button>
              <button class="btn btn-primary pull-right" type="reset"><span class="fa fa-rotate-left"></span> Cancelar</button>
            </div>
          </div>
          <input type="hidden" name="numero" id="numero" value="<?php echo $num;?>">
          <input type="hidden" name="accaoP" id="accaoP" value="user<?php echo $act;?>">
        </form>
      </div>
    </div>
  </div>
</div>
<?php } } include("footer.php"); ?>
