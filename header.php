<?php include_once 'include/db_connect.php';	include_once 'include/functions.php'; 

sec_session_start();


if (login_check($mysqli) == true) {

if(isset($_GET['act'])){
$act=mysqli_real_escape_string($mysqli,$_GET['act']);
} else {$act="";}
if(isset($_GET['token'])){
$token=mysqli_real_escape_string($mysqli,$_GET['token']);
}
if(isset($_GET['num'])){ 
$num=mysqli_real_escape_string($mysqli,$_GET['num']);
} else { $num=""; }

if(isset($_GET['tp'])){ 
$tp=mysqli_real_escape_string($mysqli,$_GET['tp']);
} else { $tp=""; }


$acttitle="";	
if($act=="edit"){
$acttitle="editar ";
$txtaction="Editar"; 	
}
if($act=="ad"){
$acttitle="adicionar ";	
$txtaction="Adicionar"; 
}

if($tp!="" && !isset($title2)){$acttitle.=$tp; } else {	if(isset($title2) && $title2!="") $acttitle.=$title2; }

if(!isset($tpPag)) $tpPag=1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
<title><?php echo config_val('empresa');?> | <?php echo $ptitle;?></title>

<!-- Bootstrap -->
<link href="<?php echo URLBASE;?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="<?php echo URLBASE;?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- NProgress -->
<link href="<?php echo URLBASE;?>/vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- jQuery custom content scroller -->
<link href="<?php echo URLBASE;?>/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
<!-- PNotify -->
<link href="<?php echo URLBASE;?>/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
<link href="<?php echo URLBASE;?>/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
<link href="<?php echo URLBASE;?>/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
<?php
	$p=@end(explode('/',$_SERVER['PHP_SELF']));
	$p=str_replace(".php","",$p);

	if (file_exists(DOCROOT."/include/$p.header.inc.php")) {	
    include(DOCROOT."/include/$p.header.inc.php"); 
	}
?>
<!-- Custom Theme Style -->
<link href="<?php echo URLBASE;?>/build/css/custom.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
<div class="main_container">
<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;"> <a href="<?php echo URLBASE;?>" class="site_title"><i class="fa fa-database"></i> <span><?php echo config_val('empresa');?></span></a> </div>
    <div class="clearfix"></div>
    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <?php 

 if(is_file($storeFolder."/users/".$_SESSION['fotoUser']."")){
 echo "<img id=\"$_SESSION[token]\" class=\"img-circle profile_img\" src=\"".URLBASE."/attachments/users/".$_SESSION['fotoUser']."\" alt=\"\">";	 	 
 } else {
echo "<img class=\"img-circle profile_img\" src=\"".URLBASE."/build/images/user.png\" alt=\"\">";	 
}
?>
      </div>
      <div class="profile_info"> <span>Bem-vindo,</span>
        <h2><?php echo $_SESSION['nome']; ?></h2>
      </div>
    </div>
    <!-- /menu profile quick info --> 
    
    <br />
    
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Menu Geral</h3>
        <ul class="nav side-menu">
          <li><a href="<?php echo URLBASE; ?>"><i class="fa fa-home"></i> Home </a> </li>
          
          <!-- TEKNISOFT CUSTOM MENU -->
          
          <li><a><i class="fa fa-code-fork"></i> Obras / Projetos <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
          
            <?php if(verifAcesso('obras-listagem')){ ?><li><a href="<?php echo URLBASE;?>/projetos">Listagem de obras</a></li><?php } ?>
            <?php if(verifAcesso('obras-adicionar')){ ?><li><a href="<?php echo URLBASE;?>/projetos/ad">Adicionar obra</a></li><?php } ?>    
            <?php if(verifAcesso('obras-listagem')){ ?><li><a href="<?php echo URLBASE;?>/projetos/gallery/1">Galeria de Fotos</a></li><?php } ?>
            </ul>
          </li>
          
          <!-- TEKNISOFT CUSTOM MENU -->
          
          
          
          
          <?php /* if(verifAcesso('tabelas')){ ?>
          
          <li><a><i class="fa fa-table"></i> Tabelas <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
            <?php if(verifAcesso('tabelas-departamentos')){ ?><li><a href="<?php echo URLBASE;?>/tabelas/departamentos/list">Departamentos</a></li><?php } ?>
            <?php if(verifAcesso('tabelas-utilizadores')){ ?><li><a href="<?php echo URLBASE;?>/utilizadores">Utilizadores</a></li><?php } ?>
            <?php if(verifAcesso('cat-projetos')){ ?><li><a href="<?php echo URLBASE;?>/tabelas/projetos-cat/list">Categorias de Trabalhos</a></li><?php } ?>
            </ul>
          </li>
          <?php // } */ ?>
  
 
		<li><a><i class="fa fa-table"></i> Tabelas <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
			<?php if(verifAcesso('tabelas-departamentos')){ ?><li><a href="<?php echo URLBASE;?>/tabelas/departamentos/list">Departamentos</a></li><?php } ?>
           	<?php if(verifAcesso('tabelas-seccoes')){ ?><li><a href="<?php echo URLBASE;?>/tabelas/seccoes/list">Secções</a></li><?php } ?>
			<?php if(verifAcesso('tabelas-utilizadores')){ ?><li><a href="<?php echo URLBASE;?>/utilizadores">Utilizadores</a></li><?php } ?>
                
            <?php if(verifAcesso('tabelas-seccoes')){ ?><li><a href="<?php echo URLBASE;?>/tabelas/materiais/list">Materiais</a></li><?php } ?>
			
                
            <?php if(verifAcesso('cat-projetos') || verifAcesso('status-projetos')){ ?> <li><a>Obras / Projetos<span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li class="sub_menu">
							<?php if(verifAcesso('cat-projetos')){ ?><a href="<?php echo URLBASE;?>/tabelas/projetos-cat/list">Categorias</a><?php } ?>
                            
						</li>
                        <li class="sub_menu">
							<?php if(verifAcesso('status-projetos')){ ?><a href="<?php echo URLBASE;?>/tabelas/projetos-status/list">Estados</a><?php } ?>
                            
						</li>
            		</ul>
				</li>  
            <?php } ?>    
                                     
          		<!-- <li><a href="#level1_2">Level One</a> -->
			</ul>
		</li>          
         
         
          
        </ul>
      </div>
    </div>
    <!-- /sidebar menu --> 
    
    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">  <a href="<?php if($_SESSION['usrGrp']==1){ ?><?php echo URLBASE;?>/settings<?php } else { echo "#"; }  ?>" data-toggle="tooltip" data-placement="top" title="Definições"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> </a>  <a data-toggle="tooltip" data-placement="top" title="FullScreen"> <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span> </a> <a href="<?php echo URLBASE;?>/perfil" data-toggle="tooltip" data-placement="top" title="Perfil"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> </a> <a  data-toggle="tooltip" data-placement="top" title="Terminar sessão" href="<?php echo URLBASE;?>/logout" > <span class="glyphicon glyphicon-off" aria-hidden="true"></span> </a> </div>
    <!-- /menu footer buttons --> 
  </div>
</div>

<!-- top navigation -->
<div class="top_nav hidden-print">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
      <ul class="nav navbar-nav navbar-right">
        <li class=""> <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
<?php
 if(is_file($storeFolder."/users/".$_SESSION['fotoUser']."")){
 	echo "<img class=\"profile_img\" src=\"".URLBASE."/attachments/users/".$_SESSION['fotoUser']."\" alt=\"\">";	 	 
 }  else {
	echo "<img class=\"profile_img\" src=\"".URLBASE."/build/images/user.png\" alt=\"\">"; 
 }
 ?>
          <?php echo $_SESSION['nome']; ?><span class=" fa fa-angle-down"></span> </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="<?php echo URLBASE;?>/perfil"> <i class="fa fa-user pull-right"></i> O Meu Perfil</a></li>
             <?php if($_SESSION['usrGrp']==1){ ?>
            <li><a href="<?php echo URLBASE;?>/utilizadores"> <i class="fa fa-users pull-right"></i> Utilizadores</a></li>
            <li><a href="<?php echo URLBASE;?>/settings"> <i class="fa fa-cog pull-right"></i> Definições</a> </li>
            <?php }  ?> 
            <li><a href="<?php echo URLBASE;?>/logout"><i class="fa fa-sign-out pull-right"></i> Terminar Sessão</a></li>
          </ul>
        </li> <!--
        <li role="presentation" class="dropdown"> <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-envelope-o"></i> <span class="badge bg-green">6</span> </a>
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            <li> <a> <span class="image"><img src="<?php echo URLBASE; ?>/images/user.png" alt="Profile Image" /></span> <span> <span>John Smith</span> <span class="time">3 mins ago</span> </span> <span class="message"> Film festivals used to be do-or-die moments for movie makers. They were where... </span> </a> </li>
            <li> <a> <span class="image"><img src="<?php echo URLBASE; ?>/images/user.png" alt="Profile Image" /></span> <span> <span>John Smith</span> <span class="time">3 mins ago</span> </span> <span class="message"> Film festivals used to be do-or-die moments for movie makers. They were where... </span> </a> </li>
            <li> <a> <span class="image"><img src="<?php echo URLBASE; ?>/images/user.png" alt="Profile Image" /></span> <span> <span>John Smith</span> <span class="time">3 mins ago</span> </span> <span class="message"> Film festivals used to be do-or-die moments for movie makers. They were where... </span> </a> </li>
            <li> <a> <span class="image"><img src="<?php echo URLBASE; ?>/images/user.png" alt="Profile Image" /></span> <span> <span>John Smith</span> <span class="time">3 mins ago</span> </span> <span class="message"> Film festivals used to be do-or-die moments for movie makers. They were where... </span> </a> </li>
            <li>
              <div class="text-center"> <a> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a> </div>
            </li>
          </ul>
        </li> -->
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->

<?php if($tpPag==1){?>
<div class="right_col" role="main">
<div class="">
<div class="row">
<div class="col-xs-12 col-md-12"> 
<div class="x_panel">
<div class="x_title">
  
 
 <?php if(isset($optBar)){  
   
   
    if($act=="gallery"){  
    

    $query = $mysqli->query( "SELECT idnum,nome from tbl_projetos_status")or die( $mysqli->errno . ' - ' . $mysqli->error );
    $options = mysqli_fetch_all($query,MYSQLI_ASSOC);
    }

    foreach ($options as $k=>$v){ 
      if($v['idnum']==$tp){
        $acttitle=" ".$v['nome'];
      }
    }
   ?>

<h2><?php echo $ptitle;?> <small><?php if(!is_numeric($acttitle)) echo $acttitle;?> </small></h2>

 <ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
</li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<?php 
foreach ($options as $k=>$v){ 
  echo "<a class=\"dropdown-item\" href=\"".$v['idnum']."\">".$v['nome']."</a><br>"; 
}
?>
</div>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a>
</li>
</ul>
<?php } else {  ?>
 
  <h2><?php echo $ptitle;?> <small><?php if(!is_numeric($acttitle)) echo $acttitle;?> </small></h2>
  <ul class="nav navbar-right panel_toolbox">
    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
  </ul>
  <?php }   ?>

  <div class="clearfix"></div>
</div>
<div class="x_content">
<?php }   if($tpPag==2){?>
<div class="right_col" role="main">
<div class="clearfix"></div>
<?php } ?>

<!-- content starts here -->
<?php  } else { header("Location: ".URLBASE."/login"); }   ?>
