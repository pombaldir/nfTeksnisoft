<?php

/*
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once 'psl-config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require DOCROOT.'/include/vendor/autoload.php';

function sec_session_start() {
    $session_name = 'sec_session_nf';   // Set a custom session name 
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
		
		$response = array("mensagem" => "0", "redir" => "0", "htmlmsg" => "Could not initiate a safe session (ini_set)");
		echo json_encode($response);
		
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt, grupo,fotoname  FROM members WHERE username = ? and status=1 LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt, $grupo, $fotoname);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt); 
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked 
                return false;
            } else {
                // Check if the password in the database matches 
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
					$nomecliente=get_user($user_id, $mysqli);
					$_SESSION['nome'] = $nomecliente['nome'];
					$_SESSION['usrGrp'] = $grupo;
					$_SESSION['empresa']=config_val('empresa', $mysqli);
					$idrandom = md5(uniqid(mt_rand(), true));
    				$_SESSION["token"] = $idrandom;
                    
                    $settings=unserialize(config_val('settings'));
                    $_SESSION["ERPWS"] = $settings['erp_ws'];
                    $_SESSION["ERPTKN"] = $settings['ws_token'];
					$_SESSION["fotoUser"] = $fotoname;
					addLog("Login");

                    // Login successful. 
                    return true;
                } else {
                    // Password is not correct 
                    // We record this attempt in the database 
                    $now = time();
                    if (!$mysqli->query("INSERT INTO login_attempts(user_id, time) 
                                    VALUES ('$user_id', '$now')")) {
						
							$response = array("mensagem" => "0", "redir" => "0", "htmlmsg" => "=Database error: login_attempts");
							echo json_encode($response);
		
						
                        exit();
                    }

                    return false;
                }
            }
        } else {
            // No user exists. 
            return false;
        }
    } else {
        // Could not create a prepared statement
		$response = array("mensagem" => "0", "redir" => "0", "htmlmsg" => "Database error: cannot prepare statement");
		echo json_encode($response);		
        exit();
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
		$response = array("mensagem" => "0", "redir" => "0", "htmlmsg" => "Database error: cannot prepare statement");
		echo json_encode($response);			
        exit();
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM members 
				      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Could not prepare statement
							$response = array("mensagem" => "0", "redir" => "0", "htmlmsg" => "Database error: cannot prepare statement");
							echo json_encode($response);			

            exit();
        }
    } else {
        // Not logged in 
        return false;
    }
}


function change_password($membersID, $password) {
	global $mysqli;
    $membersID = (int)$membersID;
	$mysqli->query("UPDATE members set password='$password' where id='$membersID'") or die($mysqli->errno .' - '. $mysqli->error);
    if (@mysqli_affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}



function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    
    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);
    
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
   
function get_IdbyUsername($user_id) {
global $mysqli;
$query = $mysqli->query("select id FROM members WHERE username = '$user_id'") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_assoc();
	return $dados['id'];
}

function get_user($user_id) {
global $mysqli;	
$query = $mysqli->query("select nome,email,foto,fotoname FROM members  WHERE id = $user_id") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_assoc();
	return $dados;
}

function get_user_full($user_id, $mysqli) {
$query = $mysqli->query("select * FROM members  WHERE id = $user_id") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_assoc();
	return $dados;
}


function get_member_field($user_id, $field) {
	global $mysqli;
	$arr=array();	
	$arryF = "'" .implode("','", $field) . "'"; 
	
$query = $mysqli->query("select nomeField,value FROM members_fields  WHERE (member = $user_id) AND nomeField IN  (".$arryF.") ") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_array()){
$arr[$dados['nomeField']][]=array("value"=>$dados['value']);
}
	return $arr;
}


function get_depart_byID($depart) {
global $mysqli;	
$query = $mysqli->query("select * FROM tbl_departamentos  WHERE idnum = $depart") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_assoc();
	return $dados;
}



function config_val($nmecpo){ // Função de configuração
global $mysqli;
$query = $mysqli->query("select param,valor from tbl_config where param='$nmecpo'") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_array();
return $dados['valor'];
}

function updateConfig($param, $valor){ 
global $mysqli;
$query = $mysqli->query("UPDATE tbl_config set valor='$valor' where param='$param'") or die($mysqli->errno .' - '. $mysqli->error);
return 1;
}

function addLog($activity,$user="",$target=""){ 
global $mysqli;
if($user==""){ $user=$_SESSION['user_id']; }
if($target==""){ $target="NULL"; }
$query = $mysqli->query("INSERT INTO logs (user,accao,id_target) VALUES ('$user','$activity',$target)") or die($mysqli->errno .' - '. $mysqli->error);
}




function rrmdir($dir,$rmdir=0) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
	 if($rmdir==1){ rmdir($dir);  }
   } 
 }
 
 function mkpath($path)
  {
    if(@mkdir($path) or file_exists($path)) return true;
    return (mkpath(dirname($path)) and mkdir($path));
  }



function getVATdetails($nif)	{ 
		$nifpt=config_val('nifpt');
		$json = file_get_contents("http://www.nif.pt/?json=1&q=$nif&key=$nifpt"); 
		$data = json_decode($json, true);
		return $data;		
}


/*
 * MAILCHIMP
 *
 */
 
 
 function MchimpSubscribe($email,$NOME="",$tpsubs="subscribed",$LOCALIDADE="",$PAIS=""){
 
 	$settings=unserialize(config_val('settings'));
 
 	$apikey=$settings['mailchimp']['mchimp_api']; 
	$server=$settings['mailchimp']['mchimp_server']; 	
	$list=$settings['mailchimp']['list']; 
    $auth = base64_encode( 'user:'.$apikey );
	
	if($tpsubs=="subscribed"){
	$subcmetod="PUT";
	} else {
	$subcmetod="DELETE";	
	} 
  
    $curl = curl_init();
	$data = array(
    'email_address' => "$email",
	'status' => "$tpsubs",
	'status_if_new' => "$tpsubs",
	'merge_fields' => array("NOME"=>"$NOME","LOCALIDADE"=>"$LOCALIDADE","PAIS"=>"$PAIS")
	);
    $json_data = json_encode($data);
		
	curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'https://'.$server.'.api.mailchimp.com/3.0/lists/'.$list.'/members/'.md5($email).'',
	CURLOPT_CUSTOMREQUEST => "$subcmetod",
	CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth),
	CURLOPT_USERAGENT => 'PHP-MCAPI/2.0',
	CURLOPT_USERPWD  => 'pombaldir:'.$apikey,
	CURLOPT_POSTFIELDS => $json_data
	));
	$resp = json_decode(curl_exec($curl), true);
	curl_close($curl);
	
	$status=$resp['status'];	// subscribed
	 
	if($status=="400"){
	$title=$resp['title'];
	$detail=$resp['detail'];
	} else {
	$title="";
	$detail="";	
	}
	
	return $status;


 }
 
 
 
 function MchimpUpdte($email,$data){
 
 	$settings=unserialize(config_val('settings'));
 
 	$apikey=$settings['mailchimp']['mchimp_api']; 
	$server=$settings['mailchimp']['mchimp_server']; 	
	$list=$settings['mailchimp']['list']; 
    $auth = base64_encode( 'user:'.$apikey );
	
	$subcmetod="PUT";
	
  
    $curl = curl_init();
	$data = array(
    'email_address' => "$email",
	'merge_fields' => $data
	);
    $json_data = json_encode($data);
		
	curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'https://'.$server.'.api.mailchimp.com/3.0/lists/'.$list.'/members/'.md5($email).'',
	CURLOPT_CUSTOMREQUEST => "$subcmetod",
	CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth),
	CURLOPT_USERAGENT => 'PHP-MCAPI/2.0',
	CURLOPT_USERPWD  => 'pombaldir:'.$apikey,
	CURLOPT_POSTFIELDS => $json_data
	));
	$resp = json_decode(curl_exec($curl), true);
	curl_close($curl);
		
	return $resp;

 }
 
 
function enviaMail($to,$subject,$body,$destName="",$numCliente="",$cc="",$bcc="",$reply="",$attachments=array()){	
global $mysqli;

$settings=unserialize(config_val('settings'));

$mail = new PHPMailer(true);                              				// Passing `true` enables exceptions
try {
    //Server settings
	$mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;                                 				// Enable verbose debug output
    $mail->isSMTP();                                      				// Set mailer to use SMTP
    $mail->Host = ''.$settings['mail']['smtpserver'].'';  				// Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               				// Enable SMTP authentication
    $mail->Username = ''.$settings['mail']['smtpusername'].'';  		// SMTP username
    $mail->Password = ''.$settings['mail']['smtpass'].'';       		// SMTP password
	if($settings['mail']['smtpauth']!=""){
    $mail->SMTPSecure = ''.$settings['mail']['smtpauth'].'';           	// Enable TLS encryption, `ssl` also accepted
	}
    $mail->Port = $settings['mail']['smtpport'];                   		// TCP port to connect to

    //Recipients
    $mail->setFrom(''.$settings['mail']['mailfrom'].'', ''.config_val('empresa').'');
    $mail->addAddress(''.$to.'', ''.$destName.'');     	// Add a recipient
	if($reply!=""){
    $mail->addReplyTo(''.$reply.'', ''.config_val('empresa').'');
	}
	if($cc!=""){
   	 $mail->addCC(''.$cc.'');
	}
	if($bcc!=""){
	$mail->AddBCC("$bcc", "");
	}

    //Attachments
	foreach ($attachments as $att){
    $mail->addAttachment(''.$att.'');         				// Add attachments
	}

    //Content
    $mail->isHTML(true);                                  	// Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = stripslashes($body);
    $mail->send();
	//$mysqli->query("INSERT INTO mensagens (cliente,dest,mensagem,tipo,nome,assunto) VALUES ('$numCliente','$to','$body','email2','$destName','$subject')");
	//return 'Mensagem enviada';
	return true;
	} catch (Exception $e) {
		return 'Erro ' . $mail->ErrorInfo;
	}	
	
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function verifAcesso($paginas) {
global $mysqli;	
$arrSuc=array();

$pages=explode(",",$paginas);	
$query = $mysqli->query("select tbl_departamentos.perms,tbl_departamentos.idnum FROM members_fields LEFT JOIN tbl_departamentos ON members_fields.value=tbl_departamentos.idnum where members_fields.member='".$_SESSION['user_id']."' and members_fields.nomeField='departamentos'");
while($dados=$query->fetch_array()){
$perms=unserialize($dados['perms']);
if(is_array($perms)){
	foreach($perms as $perm){
	if(in_array($perm,$pages)){	
	$arrSuc[]=$dados['idnum'];	
	} 
	}
}
}
$result = sizeof($arrSuc);
if($result>0 || $_SESSION['usrGrp']==1){
	return true;
} else {
	return false;
}
}

function RegistoById($idnum,$tabela,$retorno){
global $mysqli;
$query = $mysqli->query("select $retorno from $tabela where idnum='$idnum'") or die($mysqli->errno .' - '. $mysqli->error);
$dados = $query->fetch_array();
return $dados[$retorno];
}




function cat_display($tabela, $num="") {
	global $mysqli; 
    $result = $mysqli->query("select nome,idnum FROM ".$tabela." order by nome ");    
	while($row = $result->fetch_array()){
		if($num==$row['idnum']) { $selct=" selected"; } else { $selct=""; }
        echo "<option value=\"".$row['idnum']."\" $selct>".$row['nome']."</option>";
    }
}

 
function cat_display_select($parent, $level, $predefNum, $tabela, $caracter="-") {
	global $mysqli; 
	$qextra="";
	$qextra.="where parent='$parent' and idnum<>'$predefNum'";	

    $result = $mysqli->query("select nome,idnum,parent FROM ".$tabela."  ".$qextra."");     //echo "sselect nome,idnum,parent FROM ".$tabela."  ".$qextra; 
	$indent = str_repeat(''.$caracter.'', $level);
	
    $tpl = '<option value="%s"%s> %s</option>'; 

	while($row = $result->fetch_array()){
		$parnt=cat_parent($predefNum,$tabela);			
		if($parnt==$row['idnum']) { $selct=" selected"; } else { $selct=""; }
        echo sprintf($tpl, $row['idnum'], $selct, $indent . $row['nome']);

        //if ($row['parent'] > 0 || $predefNum=="") {
            cat_display_select($row['idnum'], $level + 1, $predefNum, $tabela);
       //}
    }
}


function cat_parent($levelPred,$tabela) {
	global $mysqli;
	$result = $mysqli->query("select parent FROM ".$tabela." where idnum='".$levelPred."'");
	$row = $result->fetch_array();
	return $row['parent'];
}

function cat_NomebyId($levelPred,$tabela) {
	global $mysqli;
	$result = $mysqli->query("select nome FROM ".$tabela." where idnum='".$levelPred."'");
	$row = $result->fetch_array();
	if($levelPred==0){
	return '==== Topo ====';	
	} else {
	return $row['nome'];
	}
}


function selectFrmTbl($tabela,$field,$default,$nome="campo1",$class="form-control") {
	global $mysqli;
	$result = $mysqli->query("select $field,idnum FROM ".$tabela." order by $field ASC");
	$devolve="<select class=\"$class\" name=\"$nome\" id=\"$nome\"><option value=\"\">Escolha 1 opção</option>";
    while($row = $result->fetch_array()){
    $devolve.="<option "; if($default==$row['idnum']){  $devolve.=" selected"; }
    $devolve.="value=\"".$row['idnum']."\">".$row[$field]."</option>";
    }
	echo $devolve;
}

#######################################################################################################
#######################################################################################################
###########################################  	PROJETOS     ########################################### 
#######################################################################################################
#######################################################################################################

function proj_log($activity,$target,$txt,$user,$extra){
global $mysqli;
if($user==""){ $user=$_SESSION['user_id']; }
if($target==""){ $target="NULL"; }
$query = $mysqli->query("INSERT INTO projetos_log (user,accao,id_target,texto,extra) VALUES ('$user','$activity','$target','$txt','$extra')") or die($mysqli->errno .' - '. $mysqli->error);	
	
}

function proj_NextID($tbl=projetos){
global $mysqli;
$query=$mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = '$tbl' AND table_schema = DATABASE()") or die($mysqli->errno .' - '. $mysqli->error);	
$dados = $query->fetch_assoc();
$nextId=$dados['AUTO_INCREMENT'];	
return $nextId;	
}

function proj_NextCode($cat){
global $mysqli;
$query=$mysqli->query("select idproj from projetos where cat_projeto='$cat' and DATE_FORMAT(dataad_proj, '%Y')=".date('Y')."") or die($mysqli->errno .' - '. $mysqli->error);	
$linhas = $query->num_rows;
$idseguinte=$linhas+1;
if($idseguinte==""){ $idseguinte=1; }  
$nextId="NF".date('y').sprintf('%02d', $cat).sprintf('%04d', $idseguinte);

return $nextId;
}


function convertSegundos($seconds) {
  $t = round($seconds);
  return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}



#### STOCKS
function getStock($produto){
    global $mysqli;
    $query=$mysqli->query("select stock from tbl_materiais where idnum='$produto'") or die($mysqli->errno .' - '. $mysqli->error);	
    $dados = $query->fetch_assoc();
    $valor=$dados['stock'];	
    return $valor; 
}


function movStock($produto,$qtd,$tipo="1",$user=""){
    global $mysqli;
    if($user==""){ $user=$_SESSION['user_id']; } 
    $stock_anterior=getStock($produto);
    
    if($qtd>$stock_anterior){ $sinal=1; } else  $sinal=-1;

    $query=$mysqli->query("select idnum from mov_stock where artigo='$produto'") or die($mysqli->errno .' - '. $mysqli->error);	
    $movimentos = $query->num_rows;
    if($stock_anterior=="" || $movimentos==0){  $qtdUpd=$stock_anterior=$qtd; if($qtd>=0){ $sinal=1;} else  $sinal=-1;  }  else {
        $qtdUpd=abs(number_format($qtd-$stock_anterior,0)); 
    } 

    if($qtdUpd!=0){
    $query=$mysqli->query("INSERT INTO mov_stock (artigo,qtd,sinal,user,tipo) VALUES ($produto,$qtdUpd,$sinal,$user,'$tipo') ") or die($mysqli->errno .' - '. $mysqli->error);	
    return 1;
    } else {
    return 0;   
    }
}

