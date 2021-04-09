<?php $ptitle="Tabelas"; 

switch ($_GET['tp']) {
    case 'departamentos':
        $title2="Departamentos";
		$title2_singular="Departamento";
		$tblMysql="tbl_departamentos";
        break;
    case 'projetos-cat':
        $title2="Categoria de Projetos";
		$title2_singular="Categoria de Projeto";
		$tblMysql="tbl_projetos_cat";
        break;
    case 'projetos-status':
        $title2="Estados dos Projetos";
		$title2_singular="Estado de Projeto";
		$tblMysql="tbl_projetos_status";
        break;    
    case 'seccoes':
        $title2="Secções";
		$title2_singular="Secção";
		$tblMysql="tbl_seccoes";
        break;
    case 'materiais':
        $title2="Materiais";
		$title2_singular="Material";
		$tblMysql="tbl_materiais";
        break;        
	default:
}
 
include("header.php"); ?>






<?php  if($act=="list"){?>
<table id="table<?php echo $p;?>" class="table table-striped jambo_table">
<?php  if($tp=="departamentos" || $tp=="seccoes" || $tp=="projetos-status"){?>
  <thead>
    <tr class="headings">
      <th class="column-title" width="80%">Nome</th>
      <th class="column-title" width="20%">Ação</th>
    </tr>
  </thead>
  <tbody>
<?php 
  $query = $mysqli->query("select idnum,nome FROM ".$tblMysql."") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
echo "<tr><td>$dados[nome]</td><td><a class=\"btn btn-info btn-xs btnEdit\" href=\"/tabelas/$tp/edit/".$dados['idnum']."\"><i class=\"fa fa-edit\"></i> editar</a> <a id=\"".$dados['idnum']."\" class=\"btn btn-danger btn-xs btnDelete\" href=\"#\"><i class=\"fa fa-trash\"></i> eliminar</a></td></tr>";
}

} if($tp=="projetos-cat"){?>
  <thead>
    <tr class="headings">
      <th class="column-title" width="50%">Nome</th>
      <th class="column-title" width="30%">Categ-mãe</th>
      <th class="column-title" width="20%">Ação</th>
    </tr>
  </thead>
  <tbody>
<?php
  $query = $mysqli->query("select idnum,nome,parent FROM tbl_projetos_cat") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
echo "<tr><td>$dados[nome]</td><td>".cat_NomebyId($dados['parent'],"tbl_projetos_cat")."</td><td><a class=\"btn btn-info btn-xs btnEdit\" href=\"/tabelas/$tp/edit/".$dados['idnum']."\"><i class=\"fa fa-edit\"></i> editar</a> <a id=\"".$dados['idnum']."\" class=\"btn btn-danger btn-xs btnDelete\" href=\"#\"><i class=\"fa fa-trash\"></i> eliminar</a></td></tr>";
}

 } 
      
if($tp=="materiais"){?>
  <thead>
    <tr class="headings">
      <th class="column-title" width="40%">Nome</th>
      <th class="column-title" width="30%"><?php if($tp=="materiais"){ echo "Categoria"; } ?></th>
      <th class="column-title" width="10%">Stock</th>
      <th class="column-title" width="20%">Ação</th>
    </tr>
  </thead>
  <tbody>
<?php
  $query = $mysqli->query("select idnum,nome,categoria,stock FROM tbl_materiais") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
echo "<tr><td>$dados[nome]</td><td>".cat_NomebyId($dados['categoria'],"tbl_materiais_cat")."</td><td>$dados[stock]</td><td><a class=\"btn btn-info btn-xs btnEdit\" href=\"/tabelas/$tp/edit/".$dados['idnum']."\"><i class=\"fa fa-edit\"></i> editar</a> <a id=\"".$dados['idnum']."\" class=\"btn btn-danger btn-xs btnDelete\" href=\"#\"><i class=\"fa fa-trash\"></i> eliminar</a></td></tr>";
}

 }
?>      
      






</tbody>
  <tfoot>
  </tfoot>
</table>

<?php   } ?>




<?php 
if($act=="edit" || $act=="ad"){

 if($tp=="departamentos" || $tp=="projetos-cat" || $tp=="seccoes" || $tp=="projetos-status" || $tp=="materiais"){ 
		
 if($act=="edit"){
	 
	$tipoTbl=str_replace("-","_",$tp);
	$departamentos=array();
	 
	$query = $mysqli->query("select * FROM tbl_".$tipoTbl." where idnum='$num'") or die("erro 1 ".$mysqli->errno .' - '. $mysqli->error);
    $dados = $query->fetch_array();
     

     $nome=$dados['nome'];     
     
     
	if($tp=="seccoes"){
		if($dados['departamentos']!=""){
		$departamentos=unserialize($dados['departamentos']);	
		}
	}	
 }
 
 if($act=="ad"){
	$nome="";
    $dados=array(); 
    $dados['preco']=""; 
	$departamentos=array();
 }

	
	?>

<form class="form-horizontal form-label-left" id="tabelasForm">
  <div class="form-group">
    <label class="col-sm-3 control-label">Nome</label>
    <div class="col-sm-6 controls">
      <input value="<?php echo $nome;?>" class="form-control" type="text" placeholder="<?php echo $title2_singular;?>" data-toggle="tooltip" data-placement="top" data-original-title="Nome de <?php echo $title2_singular;?>" id="nome" name="nome" required>
    </div>
  
  
  </div>
  
  <?php if($tp=="seccoes"){ ?>
    <div class="form-group">
    <label class="col-sm-3 control-label">Departamentos</label>
    <div class="col-sm-6 controls">
<?php 
	$queryChk = $mysqli->query("select idnum,nome from tbl_departamentos order by $fnome asc") or die($mysqli->errno .' - '. $mysqli->error);
		while($dadosCH = $queryChk->fetch_array()){
			echo "<input type=\"checkbox\" name=\"departm[]\" id=\"departm".$dadosCH['idnum']."\" value=\"".$dadosCH['idnum']."\" class=\"flat\" ";
				if(in_array($dadosCH['idnum'],$departamentos)){ echo "checked"; }
			echo"/> ".$dadosCH['nome']."<br />";
		}     
?>
				</div>
  
  
  </div>
  
    <?php }  ?>
  
  
  
  <?php   if($tp=="projetos-cat"){ ?>
		
  
   <div class="form-group">
    <label class="col-sm-3 control-label">Categoria Superior</label>
    <div class="col-sm-3 controls">
<select  name="catmae" id="catmae" class="form-control" >
<option value="0">========= Topo =========</option>
<?php  
cat_display_select(0, 1, $num, "tbl_projetos_cat");
?>

</select>
    </div>  
  </div> 
  
   <?php   } ?>
    
    
  <?php   if($tp=="materiais"){ ?>
		
  
   <div class="form-group">
    <label class="col-sm-3 control-label">Categoria</label>
    <div class="col-sm-3 controls">
<select  name="categoria" id="categoria" class="form-control" >
<option value="0">========= Topo =========</option>
<?php  
cat_display("tbl_materiais_cat",$dados['categoria']);
?>

</select>
    </div>  
  </div> 
    

    <div class="form-group">
        <label class="control-label col-sm-3 col-xs-12" for="preco">Preço</label>
            <div class="col-sm-2 col-xs-12">
                <input step="any" value="<?php echo $dados['preco'];?>" name="preco" id="preco" type="number" class="form-control" placeholder="0,00">
        </div>           
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3 col-xs-12" for="unidade">Unidade</label>
            <div class="col-sm-2 col-xs-12">
            <select  name="unidade" id="unidade" class="form-control" >
            <option value=""></option>
            <option value="un" <?php if($act=="edit" && $dados['unidade']=="un") echo "selected";?>>Unidade</option>
            <option value="kg" <?php if($act=="edit" && $dados['unidade']=="kg") echo "selected";?>>Kg</option>
            <option value="ml" <?php if($act=="edit" && $dados['unidade']=="ml") echo "selected";?>>Metro linear</option>
            <option value="m2" <?php if($act=="edit" && $dados['unidade']=="m2") echo "selected";?>>Metro quadrado</option>
            <option value="m3" <?php if($act=="edit" && $dados['unidade']=="m3") echo "selected";?>>Metro cúbico</option>
            <option value="tn" <?php if($act=="edit" && $dados['unidade']=="tn") echo "selected";?>>Tonelada</option>
            <option value="bb" <?php if($act=="edit" && $dados['unidade']=="bb") echo "selected";?>>Big-bag</option>
            <option value="pa" <?php if($act=="edit" && $dados['unidade']=="pa") echo "selected";?>>Palete</option>
            </select>    
                
        </div>           
    </div>


    <div class="form-group">
        <label class="control-label col-sm-3 col-xs-12" for="naomovstk">Não Movimenta Stock</label>
            <div class="col-sm-1 col-xs-12">
    <input type="checkbox" id ="naomovstk" name ="naomovstk" class ="flat" <?php if($act=="edit" && $dados['naomovstk']=="1") echo "checked";?>>
    </div>           
    </div>



    <div class="form-group">
        <label class="control-label col-sm-3 col-xs-12" for="stock">Stock</label>
            <div class="col-sm-1 col-xs-12">
                <input step="any" value="<?php echo $dados['stock'];?>" name="stock" id="stock" type="number" class="form-control" placeholder="0" <?php if($act=="edit" && $dados['naomovstk']=="1") echo "disabled";?>>
        </div>           
    </div>

  
   <?php   } ?>    
    
    
    

  <?php   if($tp=="projetos-status"){ ?>
		
  
   <div class="form-group">
    <label class="col-sm-3 control-label">Estado Inicial</label>
    <div class="col-sm-2 controls">
<select  name="status-inicial" id="status-inicial" class="form-control" >
<option value="0">Não</option>
    <option value="1">Sim</option>

</select>
    </div> 
       
       
<label class="col-sm-2 control-label">Estado Finalizado</label>
    <div class="col-sm-2 controls">
<select  name="status-final" id="status-final" class="form-control" >
<option value="0">Não</option>
    <option value="1">Sim</option>

</select>
    </div>        
        
       
  </div> 
    
    
<div class="form-group">
    <label class="col-sm-3 control-label">Estado Faturado</label>
    <div class="col-sm-2 controls">
<select  name="status-invoice" id="status-invoice" class="form-control" >
<option value="0">Não</option>
    <option value="1">Sim</option>

</select>
    </div> </div>    
    
  
   <?php   } ?>    
    
    
  
  
  <div class="ln_solid"></div>
    <div class="form-actions row mgbt-xs-0 text-right">
    <div class="col-sm-1">
      <a onclick="history.go(-1); return false;" class="btn btn-default btn-sm" href="#"><span class="menu-icon"><i class="fa fa-fw fa-step-backward"></i></span> Retroceder</a>
    </div>
    <div class="col-sm-11">
      <button class="btn btn-info btn-sm" type="reset"><span class="menu-icon"><i class="fa fa-fw fa-times-circle"></i></span> Cancelar</button>
      <button class="btn btn-success btn-sm" type="submit" id="btnsubmit"><span class="menu-icon"><i class="fa fa-fw fa-check-circle"></i></span> <?php echo $txtaction;?> Registo</button>
    </div>
  </div>
  <input name="accaoP" id="accaoP" type="hidden" value="<?php echo $act;?>">
  <input name="num" id="num" type="hidden" value="<?php echo $num;?>">
  <input name="tipoTbl" id="tipoTbl" type="hidden" value="<?php echo $tp;?>">
  
</form>

<?php }  } ?>


<?php include("footer.php"); ?>