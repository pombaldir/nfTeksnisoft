<?php include_once 'include/db_connect.php'; include_once 'include/functions.php'; sec_session_start();

if(isset($_GET['act'])){
$act=mysqli_real_escape_string($mysqli,$_GET['act']);
} else {		$act="";	}

if(isset($_GET['code'])){
$code=mysqli_real_escape_string($mysqli,$_GET['code']);
} else {		$code="";	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo config_val('empresa');?> | Redefinir Password</title>
	<!-- Bootstrap -->
	<link href="<?php echo URLBASE;?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo URLBASE;?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?php echo URLBASE;?>/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="<?php echo URLBASE;?>/vendors/animate.css/animate.min.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo URLBASE;?>/build/css/custom.min.css" rel="stylesheet">
	<!-- jQuery -->
	<script src="<?php echo URLBASE;?>/vendors/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo URLBASE;?>/build/js/forms.js"></script>
	<script type="text/JavaScript" src="<?php echo URLBASE;?>/build/js/sha512.js"></script>
    
    <!-- validator -->
    <script src="<?php echo URLBASE;?>/vendors/validator/validator.js"></script>
    
<?php
$query = $mysqli->query("select id,email,username from members where rcode='$code'") or die($mysqli->errno .' - '. $mysqli->error);
if($query->num_rows==0){
	$disabled=1;
	$msg='<div class="alert alert-error alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button><strong></strong> <br>Ocorreu um erro.</div>';
}

else {
	$disabled=0;
$dados = $query->fetch_array();	
$idusr=$dados['id'];
$email=$dados['email'];
$username=$dados['username'];
}

$mysqli->query("update members set rcode='' where rcode='$code'") or die($mysqli->errno .' - '. $mysqli->error);
	
?>
    
	<script>
	
	$(document).ready(function(){
	"use strict";
	
		$( "#resetPass" ).click(function() {	
			event.preventDefault();
			$("#recovermsg").html('');
			if($('#password').val()!="" && $('#password2').val()!=""){
				if(regformhash(resetform, "<?php echo $code;?>", "<?php echo $email;?>", document.getElementById("password"), document.getElementById("password2"))){
				$.ajax({
						type: "POST",
						url: "<?php echo URLBASE;?>/data/perfil",
						data: $('#resetform').serialize(),
						success: function(data){
							if(data.success=="1"){ 
							$("#recovermsg").html('<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button><strong></strong> <br>'+data.message+'</div>');;
							$("#resetPass").prop('disabled','disabled');
							}
							if(data.success=="0"){
							$("#recovermsg").html('<div class="alert alert-error alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button><strong></strong> <br>'+data.message+'</div>');
							} 
						}
					});
				return false;				
				}
  			}
		});
	});
	</script>
</head>

	<body class="login">
	
    <div>
      <div class="login_wrapper">
        <div id="reset" class="form reset_form">
          <section class="login_content">
            <form id="resetform">
            <input type="hidden" name="accaoP" id="accaoP" value="resetPass">
            <input type="hidden" name="username" id="username" value="<?php echo $username;?>">
            <input type="hidden" name="memberid" id="memberid" value="<?php echo $idusr;?>">
            
              <h1>Modificar password</h1>
              <!--<div>
                <input type="text" name="emailF" id="emailF" class="form-control" placeholder="Email" required="" />
              </div> -->
              <div>
                <input  type="password" name="password" id="password" class="form-control" placeholder="Nova Password" required=""  <?php if($disabled==1){ echo "disabled"; };?>/>
              </div>
              <div>
                <input  type="password" name="password2" id="password2" data-validate-linked="password"  class="form-control" placeholder="Repita a Password" required="" <?php if($disabled==1){ echo "disabled"; };?> />
              </div>
              <div>
              
              <!-- <a id="btnForgot" class="btn btn-default" href="#">Submeter</a> -->
              
              <button id="resetPass" class="btn btn-success" <?php if($disabled==1){ echo "disabled"; };?>>Submeter</button>
            
              </div>
              <div class="clearfix"></div>
              <div class="separator"> <span id="recovermsg"><?php echo $msg;?></span>
                <p class="change_link"> <a href="/login#signin" class="to_register"> Iniciar sessão </a> </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><i class="fa fa-building"></i> <?php echo config_val('empresa');?></h1>
                  <p>©<?php echo date('Y');?> Todos os direitos reservados | Pombaldir.com</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
</body>
</html>
