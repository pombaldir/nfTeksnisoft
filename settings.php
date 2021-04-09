<?php 
$ptitle="Definições";
$tpPag=2;
include("header.php"); 
?>
<?php if($act==""){ 

$settings=unserialize(config_val('settings'));

?>

<form class="form-horizontal form-label-left" id="demo-form" data-parsley-validate>

      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#tab_content1" id="tab-1" role="tab" data-toggle="tab" aria-expanded="true">Geral</a> </li>
                  <li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab-2" data-toggle="tab" aria-expanded="false">Mensagens</a> </li>
                  <?php if($_SESSION['usrGrp']==1){ ?>
                  <li role="presentation" class=""><a href="#tab_content3" role="tab" id="tab-3" data-toggle="tab" aria-expanded="false">Permissões</a> </li>
                  <?php } ?>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab-1"> <br />
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Nome da empresa</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input value="<?php echo config_val('empresa');?>" name="nomeempresa" id="nomeempresa" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Software ERP</label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" name="erp" id="erp">
                          <option value="">Escolha 1 opção</option>
                          <option <?php if($settings['erp']=="eticadata") echo "selected";?> value="eticadata">Eticadata</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Webservice ERP</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input value="<?php echo $settings['erp_ws'];?>" name="erp_ws" id="erp_ws" type="text" class="form-control" placeholder="Url do webservice">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Token ERP WS</label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['ws_token'];?>" name="ws_token" id="ws_token" type="text" class="form-control" placeholder="Chave de autenticação">
                      </div>
                    </div>
                    <input type="hidden" name="accaoP" id="accaoP" value="edit">
                  </div>
                  <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="tab-2">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-1 col-xs-12">Clickatell API</label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['sms']['clickatell_api'];?>" name="clickatell_api" id="clickatell_api" type="text" class="form-control" placeholder="">
                      </div>
                      <label class="control-label col-md-1 col-sm-1 col-xs-12">Remetente</label>
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['sms']['clickatell_from'];?>" name="clickatell_from" id="clickatell_from" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-1 col-xs-12">Mailchimp API</label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['mailchimp']['mchimp_api'];?>" name="mchimp_api" id="mchimp_api" type="text" class="form-control" placeholder="">
                      </div>
                      <label class="control-label col-md-1 col-sm-1 col-xs-12">Servidor</label>
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['mailchimp']['mchimp_server'];?>" name="mchimp_server" id="mchimp_server" type="text" class="form-control" placeholder="">
                      </div>
                      <label class="control-label col-md-1 col-sm-1 col-xs-12">Lista</label>
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['mailchimp']['list'];?>" name="list" id="list" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-1 col-xs-12">Servidor SMTP</label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['mail']['smtpserver'];?>" name="smtpserver" id="smtpserver" type="text" class="form-control" placeholder="">
                      </div>
                      <label class="control-label col-md-1 col-sm-1 col-xs-12">Utilizador</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input value="<?php echo $settings['mail']['smtpusername'];?>" name="smtpusername" id="smtpusername" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-1 col-xs-12">Password</label>
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <input value="<?php echo $settings['mail']['smtpass'];?>" name="smtpass" id="smtpass" type="password" class="form-control" placeholder="">
                      </div>
                      <label class="control-label col-md-2 col-sm-3 col-xs-12">Autenticação</label>
                      <div class="col-sm-2 col-xs-12">
                        <select class="form-control" name="smtpauth" id="smtpauth">
                          <option value="">Escolha 1 opção</option>
                          <?php
echo "<option value=\"ssl\" "; if($settings['mail']['smtpauth']=="ssl") echo " selected"; echo ">SSL</option>";
echo "<option value=\"tls\" "; if($settings['mail']['smtpauth']=="tls") echo " selected"; echo ">TLS</option>";				   
?>
                        </select>
                      </div>
                      <label class="control-label col-md-1 col-sm-1 col-xs-12">Porta</label>
                      <div class="col-md-1 col-sm-2 col-xs-12">
                        <input value="<?php echo $settings['mail']['smtpport'];?>" name="smtpport" id="smtpport" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    
                    
                    
                     <div class="form-group">
                    <label class="control-label col-md-3 col-sm-1  col-xs-12">Remetente Email</label>
                      <div class="col-md-3 col-sm-3 col-xs-12"> 
                        <input value="<?php echo $settings['mail']['mailfrom'];?>" name="mail_from" id="mail_from" type="email" class="form-control" placeholder="">
                      </div>
                    </div>
                    
                    
                    
                  </div>
                  <?php if($_SESSION['usrGrp']==1){ ?>
                  <div role="tabpanel" class="tab-pane fade in" id="tab_content3" aria-labelledby="tab-3">
                    <?php
$query = $mysqli->query("select * FROM tbl_departamentos") or die($mysqli->errno .' - '. $mysqli->error);
while($dados = $query->fetch_assoc()){	
$prmBD=@unserialize($dados['perms']);
	?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-4 col-xs-12"><?php echo $dados['nome'];?></label>
                      <div class="col-sm-7 col-xs-12">
                        <select style="width:100%" multiple class="form-control prefs" name="permiss[<?php echo $dados['idnum'];?>][]" id="permiss_<?php echo $dados['idnum'];?>">
                          <?php
echo "<option value=\"tabelas-departamentos\" "; if(@in_array("tabelas-departamentos",$prmBD)) echo " selected"; echo ">Departamentos</option>";
echo "<option value=\"tabelas-utilizadores\" "; if(@in_array("tabelas-utilizadores",$prmBD)) echo " selected"; echo ">Utilizadores</option>";				   
echo "<option value=\"obras-listagem\" "; if(@in_array("obras-listagem",$prmBD)) echo " selected"; echo ">Obras (listar)</option>";				   
echo "<option value=\"obras-adicionar\" "; if(@in_array("obras-adicionar",$prmBD)) echo " selected"; echo ">Obras (adicionar)</option>";				   
echo "<option value=\"obras-editar\" "; if(@in_array("obras-editar",$prmBD)) echo " selected"; echo ">Obras (editar)</option>";				   

?>
                        </select>
                      </div>
                    </div>
                    <?php }  ?>
                  </div>
                  <?php }  ?>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-9">
                      <button class="btn btn-primary" type="reset">Cancelar</button>
                      <button type="submit" class="btn btn-success" id="submitbtn">Guardar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   
</form>
<?php } ?>
<?php include("footer.php"); ?>