<?php
$ptitle = "Projetos";
if ( $_GET[ 'act' ] == "view" ) {
    $tpPag = 2;
}
if ( $_GET[ 'act' ] == "gallery" ) {
    $ptitle .= " - Galeria de fotos";
    $optBar=1;
}

include( "header.php" );
if ( $act == "" ) {
    ?>

    <table id="table<?php echo $p;?>" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%"></th>
                <th></th>
                <th width="10%">Código</th>
                <th>Cliente</th>
                <th>Projeto</th>
                <th>Tipo</th>
                <th width="10%">Criação</th>
                <th width="10%">Últ Atualiz.</th>
                <th width="5%">Ação</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        </tfoot>
    </table>
    <?php } if($act=="ad"){   ?>

    <!-- Smart Wizard -->

    <form class="form-horizontal form-label-left" id="formProjeto">
        <div id="wizard<?php echo $p;?>" class="form_wizard wizard_horizontal">
            <ul class="wizard_steps">
                <li> <a href="#step-1"> <span class="step_no">1</span> <span class="step_descr"> Entidade<br />
        <small>Dados do cliente</small> </span> </a> </li>
                <li> <a href="#step-2"> <span class="step_no">2</span> <span class="step_descr"> Projeto<br />
        <small>Detalhes do projeto</small> </span> </a> </li>
                <li> <a href="#step-3"> <span class="step_no">3</span> <span class="step_descr"> Concluir<br />
        <small>Submeter dados</small> </span> </a> </li>
            </ul>
            <div id="step-1"> 
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="tpo">NIF <span class="required">*</span> </label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="strNumContrib" id="strNumContrib" type="text" class="form-control pesquisacustomer" placeholder="" required autofocus>
                    </div>
                    <label class="control-label col-sm-2 col-xs-12" for="tpo">Nº Cliente</label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="ncliente" id="ncliente" type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="tpo">Nome <span class="required">*</span> </label>
                    <div class="col-sm-6 col-xs-12">
                        <input value="" name="strNome" id="strNome" type="text" class="form-control pesquisacustomer" placeholder="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="morada">Morada </label>
                    <div class="col-sm-7 col-xs-12">
                        <input value="" name="morada" id="morada" type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="cp">CP</label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="cp" id="cp" type="text" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-1 col-xs-12" for="localidade">Localidade</label>
                    <div class="col-sm-4 col-xs-12">
                        <input value="" name="localidade" id="localidade" type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="telefone">Telefone</label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="telefone" id="telefone" type="text" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-1 col-xs-12" for="telemovel">Telemóvel</label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="telemovel" id="telemovel" type="text" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-1 col-xs-12" for="email">Email</label>
                    <div class="col-sm-3 col-xs-12">
                        <input value="" name="email" id="email" type="email" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="responsavel">Responsável</label>
                    <div class="col-sm-5 col-xs-12">
                        <input value="" name="responsavel" id="responsavel" type="text" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-1 col-xs-12" for="funcao">Função</label>
                    <div class="col-sm-3 col-xs-12">
                        <input value="" name="funcao" id="funcao" type="text" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
            <div id="step-2">
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="norcamento">Nº Orçamento</label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="norcamento" id="norcamento" type="text" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-1 col-xs-12" for="nrequisicao">Requisição</label>
                    <div class="col-sm-2 col-xs-12">
                        <input value="" name="nrequisicao" id="nrequisicao" type="text" class="form-control" placeholder="">
                    </div>
                    <label for="p-in" class="control-label col-xs-1">Conclusão</label>
                    <div class="col-sm-2 col-xs-12">
                        <div class="input-group date" id="conclusaoPicker2">
                            <input type='text' class="form-control js-datetimepicker" name="conclusao" id="conclusaoPicker"/>
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="titulo">Titulo da Obra <span class="required">*</span> </label>
                    <div class="col-sm-5 col-xs-12">
                        <input value="" name="titulo" id="titulo" type="text" class="form-control" placeholder="" required>
                    </div>
                    <label class="col-sm-1 control-label">Categoria</label>
                    <div class="col-sm-3 controls">
                        <select name="categoria" id="categoria" class="form-control">
                            <?php  
cat_display_select(0, 1, "", "tbl_projetos_cat","- ");
?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="seccao">Secção</label>
                    <div class="col-sm-3 controls">
                        <select name="seccao[]" id="seccao" class="form-control" multiple="multiple">
                            <?php  
cat_display_select(0, 1, "", "tbl_seccoes","");
?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label" for="funcionarios">Funcionários</label>
                    <div class="col-sm-3 controls">
                        <select name="funcionarios[]" id="funcionarios" class="form-control" multiple="multiple">
          </select>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12" for="comentarios">Comentários</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name="comentarios" id="comentarios" rows="6" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div id="step-3">
                <div class="progress right" id="progress">
                    <div class="progress-bar progress-bar-warning" data-transitiongoal="0"></div>
                </div>
                <div id="texto2" align="center"><span id="textomsg" class="textomsg"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="accaoP" value="<?php echo $act;?>" id="accaoP">
        <input type="hidden" name="tpoHidden" value="" id="tpoHidden">
    </form>
    <!-- End SmartWizard Content -->

    <?php
}
if ( $act == "view" ) {


    $query = $mysqli->query( "SELECT * from projetos  where idproj='$num'" )or die( $mysqli->errno . ' - ' . $mysqli->error );
    $dlinha = $query->fetch_assoc();

    $projtitle = $dlinha[ 'titulo' ];

    ?>
    <div class="">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> <?php echo $dlinha['codprojeto'];?> <small><?php echo $projtitle;?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="<?php echo $ptitle;?>Tab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#proj_detail" id="proj_detailT" role="tab" data-toggle="tab" aria-expanded="true">Detalhes</a> </li>
                            <li role="presentation" class=""><a href="#proj_interv" role="tab" id="proj_intervT" data-toggle="tab" aria-expanded="false">Intervenções</a> </li>
                           <!-- <li role="presentation" class=""><a href="#proj_materials" role="tab" id="proj_materialsT" data-toggle="tab" aria-expanded="false">Materiais ERP</a> </li> -->
                            <li role="presentation" class=""><a href="#proj_matGasto" role="tab" id="proj_matGastoT" data-toggle="tab" aria-expanded="false">Material Gasto</a> </li>
                            <li role="presentation" class=""><a href="#proj_fotos" role="tab" id="proj_fotosT" data-toggle="tab" aria-expanded="false">Fotos</a> </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="proj_detail" aria-labelledby="proj_detailT">

                                <!-- page content -->

                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="x_panel">
                                            <div class="x_content">
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <ul class="stats-overview">
                                                        <li> <span class="name"> Nº Orçamento </span>
                                                            <span class="value text-success">
                                                                <?php echo $dlinha['norcamento'];?> </span>
                                                        </li>
                                                        <li> <span class="name"> Nº Requisição </span>
                                                            <span class="value text-success">
                                                                <?php echo $dlinha['nrequisicao'];?> </span>
                                                        </li>
                                                        <li class="hidden-phone"> <span class="name"> Data Prevista Conclusão</span>
                                                            <span class="value text-success">
                                                                <?php echo $dlinha['conclusao'];?> </span>
                                                        </li>
                                                    </ul>
                                                    <br/>
                                                    <!-- <div id="mainb" style="height:150px;" class="panel"></div>-->

                                                    <div class="panel panel-default">

                                                        <div class="panel-footer">

                                                            <div class="row">



                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <div class="x_panel">

                                                                        <div class="x_content">
                                                                            <canvas id="lineChart"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-4 col-xs-12">
                                                                    <h4>Tarefas Concluídas</h4>
                                                                    <canvas width="150" height="80" id="chart_gauge_01" class="" style="width: 160px; height: 100px;"></canvas>
                                                                    <div class="goal-wrapper">
                                                                        <span id="gauge-text" class="gauge-value gauge-chart pull-left">0</span>
                                                                        <span class="gauge-value pull-left">%</span>
                                                                        <span id="goal-text" class="goal-value pull-right">100%</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>







                                                    <div>
                                                        <h4><a href="#" data-toggle="modal" data-target="#comentModal" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Adicionar Comentário</a></h4>

                                                        <!-- end of user messages -->
                                                        <ul class="messages">
                                                            <?php


                                                            $queryC = $mysqli->query( "SELECT members.id,texto,DAY(data_ad) as dia,MONTHNAME(data_ad) as mes,nome from projetos_log left join members ON projetos_log.user=members.id  where id_target='$num' and accao='comment_ad' order by idnum desc" )or die( $mysqli->errno . ' - ' . $mysqli->error );
                                                            while ( $dlinhaC = $queryC->fetch_assoc() ) {
                                                                $userDetails=get_user($dlinhaC['id']) ;
                                                                
                                                                
                                                                echo "<li>";
                                                                if ( is_file( $storeFolder . "/users/" . $userDetails['fotoname'] . "" ) ) {
                                                                    echo "<img class=\"avatar\" src=\"" . URLBASE . "/attachments/users/" . $userDetails['fotoname'] . "\" alt=\"\">";
                                                                } else {
                                                                    echo "<img class=\"avatar\" src=\"" . URLBASE . "/build/images/user.png\" alt=\"\">";
                                                                }
                                                                ?>
                                                            <div class="message_date">
                                                                <h3 class="date text-info">
                                                                    <?php echo $dlinhaC['dia'];?>
                                                                </h3>
                                                                <p class="month">
                                                                    <?php echo $dlinhaC['mes'];?>
                                                                </p>
                                                            </div>
                                                            <div class="message_wrapper">
                                                                <h4 class="heading">
                                                                    <?php echo $dlinhaC['nome'];?>
                                                                </h4>
                                                                <blockquote class="message">
                                                                    <?php echo $dlinhaC['texto'];?>
                                                                </blockquote>
                                                                <br/>
                                                                <!--
                              <p class="url">
                                <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                              </p> -->
                                                            </div>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                        <!-- end of user messages -->

                                
                                                    
                                                    </div>
                                                
                                                
                                                </div>

                                                <!-- start project-detail sidebar -->
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <section class="panel">
                                                        <div class="x_title">
                                                            <h2>Estado: <a href="#" id="estado" data-type="select" data-value="<?php echo $dlinha['estado'];?>" data-title="estado"></a></h2>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <h4 class="green"><i class="fa fa-cog"></i> Detalhes</h4>
                                                            <p>
                                                                <?php echo $dlinha['comentarios'];?>
                                                            </p>
                                                            <br/>
                                                            <div class="project_detail">
                                                                <p class="title">Cliente</p>
                                                                <p>
                                                                    <?php echo $dlinha['clientenome'];?>
                                                                </p>
                                                                <p class="title">Responsável cliente</p>
                                                                <p>
                                                                    <?php echo $dlinha['responsavel'];?>
                                                                </p>
                                                            </div>
                                                            <br/>
                                                            <h5>Anexos</h5>
                                                            <ul class="list-unstyled project_files">
                                                                <?php
                                                                $query = $mysqli->query( "SELECT * from projetos_att where (tipo='anexos') and projeto='$num' order by idatt desc" )or die( $mysqli->errno . ' - ' . $mysqli->error );
                                                                while ( $dlinha = $query->fetch_assoc() ) {
                                                                    if ( is_file( $storeFolder . "/projetos/" . $num . "/" . $dlinha[ 'tipo' ] . "/" . $dlinha[ 'filename' ] ) ) {
                                                                        $fnmel = URLBASE . "/attachments/projetos/" . $num . "/" . $dlinha[ 'tipo' ] . "/" . $dlinha[ 'filename' ];

                                                                        echo "<li id=\"anexo" . $dlinha[ 'idatt' ] . "\"><a target=\"_blank\" href=\"" . $fnmel . "\"><i class=\"fa fa-paperclip\"></i> " . $dlinha[ 'filename' ] . "</a> <a href=\"#\" class=\"right-align btn btn-xs btn-error delfileAtt\" id=\"" . $dlinha[ 'idatt' ] . "\" data-tipo=\"anexos\"><span class=\"fa fa-trash\"></span></a>";
                                                                    }
                                                                }
                                                                ?>


                                                            </ul>
                                                            <br/>
                                                            <div class="text-center mtop20">
                                                                <div id="progressATT" class="progress">
                                                                    <div class="progress-bar progress-bar-success"></div>
                                                                </div>
                                                                <a href="#" role="button" class="fileinput-button btn btn-sm btn-primary"> <i class="fa fa-upload"></i> Anexar ficheiros
                              <input id="fileuploadAnexo" type="file" name="files[]" data-form-data='{"num": "<?php echo $num;?>","tipo": "anexos_projeto"}' multiple>
                              </a> </div>
                                                        </div>
                                                        
                                                        
                                                        <div align="center"><button  class="btn btn-sm btn-danger elimProjeto"><span class="fa fa-trash"></span> Eliminar Obra</button></div>
                                                        
                                                    </section>
                                                </div>
                                                <!-- end project-detail sidebar -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- comentModal -->
                                <div class="modal fade" id="comentModal" tabindex="-1" role="dialog" aria-labelledby="comentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="comentModalLabel">Adicionar Comentário</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal form-label-left" id="comentForm">
                                                    <div class="form-group">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <textarea name="comentario" id="comentario" class="resizable_textarea form-control" placeholder="Insira o comentário aqui"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-primary" id="btnSbmComment"><i class="fa fa-save"></i> Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comentModal -->

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="proj_interv" aria-labelledby="proj_intervT">

                                <!-- Start to do list -->
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Tarefas <small>a executar</small></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="plusLink"><i class="fa fa-plus"></i></a> </li>
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                                <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="">
                                                <ul class="to_do">
                                                    <?php
                                                    $queryT = $mysqli->query( "SELECT * from projetos_ent where (tipo='tarefa_done' OR tipo='tarefa_undone') and projeto='$num' order by idnum desc" )or die( $mysqli->errno . ' - ' . $mysqli->error );
                                                    while ( $dTlinha = $queryT->fetch_assoc() ) {
                                                        echo "<li><p><input name=\"tasklist[]\" id=\"" . $dTlinha[ 'idnum' ] . "\"  type=\"checkbox\" class=\"flat chektask\" value=\"" . $dTlinha[ 'idnum' ] . "\" ";
                                                        if ( $dTlinha[ 'tipo' ] == "tarefa_done" ) {
                                                            echo " checked";
                                                        }
                                                        echo "> " . $dTlinha[ 'valor' ] . "</p></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End to do list -->



                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Intervenientes <small></small></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="plusIntervLink"><i class="fa fa-plus"></i></a> </li>
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                                <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="x_content">
                                            <div class="">



                           <ul class="list-unstyled top_profiles scroll-view">

                           <?php
                           $i = 0;
                                                    $queryInterv = $mysqli->query( "SELECT * from projetos_ent where (tipo='funcionario') and projeto='$num' order by idnum desc" ) or die("ERR". $mysqli->errno . ' - ' . $mysqli->error );
                            if($queryInterv->num_rows>0){
                                                    while ( $linhaInterv = $queryInterv->fetch_assoc() ) {
                                                    if($linhaInterv[ 'valor' ]!=""){
                                                        $dadosinterven = get_user( $linhaInterv[ 'valor' ] );
                                                        $dadosDepart = get_member_field( $linhaInterv[ 'valor' ], array( 'departamentos' ) );
                                                        $dadosDepart = @$dadosDepart[ 'departamentos' ];

                                                        $dept = "";
                                                        if ( is_array( $dadosDepart ) && sizeof( $dadosDepart ) > 0 ) {
                                                            foreach ( $dadosDepart as $dpt ) {
                                                                $d = get_depart_byID( $dpt[ 'value' ] );
                                                                $dept .= $d[ 'nome' ] . ", ";
                                                            }
                                                            $dept = substr( $dept, 0, -2 );
                                                        }

                                                        echo '
                          <li class="media event">
                            <a class="pull-left ';
                                                        if ( $i % 2 == 0 ) {
                                                            $mtipo = "aero";
                                                        } else {
                                                            $mtipo = "green";
                                                        }
                                                        echo 'border-' . $mtipo . ' profile_thumb">
                              <i class="fa fa-user ' . $mtipo . '"></i>
                            </a>
                            <div class="media-body">
                              <a class="title" href="#">' . $dadosinterven[ 'nome' ] . '</a>
                              <!--<p><strong>$2300. </strong> Agent Avarage Sales </p>-->
                              <p> <small>' . $dept . '</small>
                              </p>
                            </div>
                          </li>';

                                                        $i++;
                                                    } }  } 

                                                    ?>


                                                </ul>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Tempos <small></small></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="plusIntervTime"><i class="fa fa-plus"></i></a> </li>
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                                <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="x_content">
                                            <div class="listaTempos">

                                                <?php      
$queryTimer=$mysqli->query("SELECT idnum,nome,timer,timerstatus,timerupdt,linha from projetos_timer LEFT JOIN members ON projetos_timer.user=members.id where projeto='$num' order by idnum DESC");	
$numTimers=$queryTimer->num_rows;   
echo '<input type="hidden" value="'.$numTimers.'" name="numTimers" id="numTimers">';  
    
    
$i=1;    
while($linhaTimer=$queryTimer->fetch_assoc()){  

$timerID=$linhaTimer['idnum'];
$linhaRec=$linhaTimer['linha'];    
$classsTimer="btn-primary";   
$playClass="fa-play";        
$timer=$linhaTimer['timer'];	
$timerstatus=$linhaTimer['timerstatus'];
$timerupdt=$linhaTimer['timerupdt']; 

if($timerstatus=="running" || $timerstatus=="paused"){
    if($timerstatus=="running" ){    
    $classsTimer="btn-primary";      
    $playClass="fa-play blink_me";   
    $timeFirst  = strtotime($timerupdt);
    $timeSecond = strtotime(date('Y-m-d H:i:s'));
    $differenceInSeconds = $timeSecond - $timeFirst;
    $timer=$timer+$differenceInSeconds;    
    }
    if($timerstatus=="paused" ){    
    $classsTimer="btn-danger";      
    $playClass="fa-pause";   
    }
}
if($timerstatus=="stopped" || $timerstatus=="" ){
$classsTimer="btn-success";
$playClass="fa-stop";        
$timer=0; 
}     
    
    
echo '<a id="timer'.$timerID.'" class="btn '.$classsTimer.' button-xs btnmodalClock" data-sec="'.$timer.'"  data-status="'.$timerstatus.'" data-idtimer="'.$timerID.'" data-nome="'.$projtitle.'" data-toggle="modal" href="#modalTimer"><i class="fa '.$playClass.'" id="icone'.$timerID.'"></i> <span id="timer'.$timerID.'clock" class="divtempo">'.convertSegundos($timer).'</span></a> <a class="dynamicTempo" href="#" id="dynamicTempo'.$timerID.'" data-idtimer="'.$timerID.'" data-numlinha="'.$linhaRec.'" data-type="select" data-name="intervtimeusr" data-title="Escolha o colaborador">'.$linhaTimer['nome'].'</a><br>';
    
 $i++;    
}
    ?>


                                            </div>
                                        </div>



                                        <!-- Modal -->
                                        <div class="modal fade" id="modalTimer" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="nomeProjetoTimer"></h4>
                                                    </div>
                                                    <div class="modal-body">


                                                        <div class="col-sm-6 text-right">
                                                            <button id="btntimer_1" class="btn btn-info btn-md btntimer"> <i class="append-icon icon-fixed-width fa fa-play" id="iconetimer"></i> <span id="timerLegend"></span></button>

                                                        </div>


                                                        <div class="col-sm-6 text-left">
                                                            <button id="btnstoptimer" class="btn btn-info btn-md btnstoptimer"> <i class="fa fa-stop" id="iconetimerStop"></i> Stop</button>
                                                        </div>

                                                        <br> <br> <br>

                                                        <section id="formTempo">
                                                            <form class="form-horizontal" action="#" id="projetosTimer">
                                                                <div class="form-group">
                                                                    <label class="col-sm-2">Comentários:</label>
                                                                    <div class="col-sm-8">
                                                                        <textarea style="width:100%" name="timercoment" id="timercoment"><?php // echo $comentario;?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-2">Tempo (s)</label>
                                                                    <div class="col-sm-3"><input class="form-control" type="text" name="timerModal" id="timerModal" placeholder="HH:MM:SS"> </div>
                                                                    <div class="col-sm-3"><input type="submit" class="btn btn-sm btnEditaTime" value="Ok">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </section>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


<?php /*
                            <div role="tabpanel" class="tab-pane fade" id="proj_materials" aria-labelledby="proj_materialsT">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-striped jambo_table bulk_action" id="tabelacompon1">
                                                <input type="hidden" name="accaoP" id="accaoP" value="updLinhasArt">
                                                <input type="hidden" name="idProjLin" id="idProjLin" value="<?php echo $num;?>">
                                               <input type="hidden" name="tipomater" id="tipomater" value="erp">
                                                
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" width="10%">Nº </th>
                                                        <!--  <th class="column-title" width="12%">Armaz</th> -->
                                                        <th class="column-title" width="42%">Artigo </th>
                                                        <!--    <th class="column-title" width="8%">Cálculo </th>-->
                                                        <th class="column-title" width="13%">Fórmula/Qtd</th>
                                                        <th class="column-title" width="8%">Unid</th>
                                                        <th class="column-title" width="15%">Custo Unit</th>
                                                        <th class="column-title" width="15%">Total</th>
                                                        <!--  <th class="column-title" width="8%">Custo %</th> -->
                                                        <th class="column-title no-link last" width="5%"><span class="nobr">Ação</span> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <div id="sectionsComp">
                                                        <div class="sectionComp">

                                                            <?php 
    
    $rt=$mysqli->query("select * from projetos_artigos where proj='$num' and tipo='erp'") or $mensagem=$mysqli->error;   
    if($rt->num_rows==0){     
        $composicao[]=array("intNumero"=>1,"strCodArtigoComp"=>"","strDescricao"=>"","FormulaQtd"=>1,"Custo"=>"","Total"=>"","strAbrevMedVnd"=>"");
    } else {
    while($linhaART=$rt->fetch_assoc()){  
        $composicao[]=array("intNumero"=>$linhaART['linha'],"strCodArtigoComp"=>$linhaART['codigo'],"strDescricao"=>$linhaART['descricao'],"FormulaQtd"=>$linhaART['qtd'],"Custo"=>$linhaART['custo'],"Total"=>$linhaART['stotal'],"strAbrevMedVnd"=>$linhaART['un']);
    }    
    }

    $i=0; foreach($composicao as $linhaCompos){ ?>

                                                            <tr class="<?php if($i%2==0){ echo " even "; } else { echo "odd "; } ;?> pointer">
                                                                <td class=" "><input value="<?php echo $linhaCompos['intNumero'];?>" name="compon[<?php echo $i;?>][cLinha]" id="cLinha_1_<?php echo $i+1;?>" type="number" class="form-control numerador">
                                                                </td>
                                                                <input type="hidden" name="compon[<?php echo $i;?>][armazem]" id="armazem_1_<?php echo $i+1;?>" value="1">


                                                                <td class="a-right a-right "><select class="form-control artList1" style="width:100%" name="compon[<?php echo $i;?>][artigo]" id="artigo_1_<?php echo $i+1;?>">
                  <option value="<?php echo $linhaCompos['strCodArtigoComp'];?>"><?php echo $linhaCompos['strDescricao'];?></option></select>
                                                                </td>
                                                                <input type="hidden" name="compon[<?php echo $i;?>][calculo]" id="c_calculo_1_<?php echo $i+1;?>" value="0">
                                                                <td class=" "><input name="compon[<?php echo $i;?>][formula]" data-tabela="1" id="cformula_1_<?php echo $i+1;?>" type="text" class="form-control" value="<?php echo $linhaCompos['FormulaQtd'];?>">
                                                                </td>
                                                                <td class="">
                                                                    <span class="compon_unid" id="compon_1_<?php echo $i;?>_unid">
                                                                        <?php echo $linhaCompos['strAbrevMedVnd'];?>
                                                                    </span>
                                                                </td>
                                                                <td class=" "><input name="compon[<?php echo $i;?>][cunit]" id="cunit_1_<?php echo $i+1;?>" data-tabela="1" type="text" class="form-control" value="<?php echo $linhaCompos['Custo'];?>">
                                                                </td>
                                                                <td class=" "><input name="compon[<?php echo $i;?>][total]" id="c_total_1_<?php echo $i+1;?>" type="text" class="form-control" value="<?php echo $linhaCompos['Total'];?>">
                                                                </td>
                                                                <td class="last">
                                                                    <?php if($i==0){ ?><a href="#" id="bt_plus_<?php echo $i+1;?>" class="btn btn-info btn-sm addsectionCompon" data-tabela="1"><i class="fa fa-plus"></i></a>
                                                                    <?php } else { ?>
                                                                    <a href="#" class="btn btn-danger btn-sm remLinhaCompon" data-tabela="2" data-nLinha="<?php echo $i;?>"><i class="fa fa-minus"></i></a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php $i++; } $totalcomp=sizeof($composicao);  ?>
                                                        </div>
                                                    </div>
                                                </tbody>
                                                    
                                                 <input type="hidden" name="totalCompon1" id="totalCompon1" value="<?php echo $totalcomp;?>">
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td colspan="2"><a href="#" class="btn btn-primary btn-md pull-right btnArtigosSave"><i class="fa fa-save"></i> Guardar alterações</a>
                                                        </td>

                                                    </tr>


                                                </tfoot>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        
           */?>
                        
     <div role="tabpanel" class="tab-pane fade" id="proj_matGasto" aria-labelledby="proj_matGastoT">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="table-responsive"> 
                                            <table class="table table-striped jambo_table bulk_action" id="tabelacompon2">
                                                <input type="hidden" name="tipomater" id="tipomater" value="mat">
                                                <input type="hidden" name="accaoP" id="accaoP" value="updLinhasArt2">
                                                <input type="hidden" name="idProjLin" id="idProjLin2" value="<?php echo $num;?>">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" width="10%">Nº </th>
                                                        <th class="column-title" width="42%">Artigo </th>
                                                        <th class="column-title" width="13%">Fórmula/Qtd</th>
                                                        <th class="column-title" width="8%">Unid</th>
                                                        <th class="column-title" width="15%">Custo Unit</th>
                                                        <th class="column-title" width="15%">Total</th>
                                                        <th class="column-title no-link last" width="5%"><span class="nobr">Ação</span> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <div id="sectionsComp2">
                                                        <div class="sectionComp2">

                                                            <?php 
    $composicao=array();
    
    $rt=$mysqli->query("select * from projetos_artigos where proj='$num' and tipo='mat'") or $mensagem=$mysqli->error;   
    if($rt->num_rows==0){     
        $composicao[]=array("intNumero"=>1,"strCodArtigoComp"=>"","strDescricao"=>"","FormulaQtd"=>1,"Custo"=>"","Total"=>"","strAbrevMedVnd"=>"");
    } else {
    while($linhaART=$rt->fetch_assoc()){  
        $composicao[]=array("intNumero"=>$linhaART['linha'],"strCodArtigoComp"=>$linhaART['codigo'],"strDescricao"=>$linhaART['descricao'],"FormulaQtd"=>$linhaART['qtd'],"Custo"=>$linhaART['custo'],"Total"=>$linhaART['stotal'],"strAbrevMedVnd"=>$linhaART['un']);
    }    
    }

    $i=0; foreach($composicao as $linhaCompos){ ?>

                                                            <tr class="<?php if($i%2==0){ echo " even "; } else { echo "odd "; } ;?> pointer">
                                                                <td class=" "><input value="<?php echo $linhaCompos['intNumero'];?>" name="compon[<?php echo $i;?>][cLinha]" id="cLinha_2_<?php echo $i+1;?>" type="number" class="form-control numerador">
                                                                </td>
                                                                <input type="hidden" name="compon[<?php echo $i;?>][armazem]" id="armazem_2_<?php echo $i+1;?>" value="1">


                                                                <td class="a-right a-right "><select class="form-control artList2" style="width:100%" name="compon[<?php echo $i;?>][artigo]" id="artigo_2_<?php echo $i+1;?>">
                  <option value="<?php echo $linhaCompos['strCodArtigoComp'];?>"><?php echo $linhaCompos['strDescricao'];?></option></select>
                                                                </td>
                                                                <input type="hidden" name="compon[<?php echo $i;?>][calculo]" id="c_calculo_2_<?php echo $i+1;?>" value="0">
                                                                <td class=" "><input name="compon[<?php echo $i;?>][formula]" data-tabela="2" id="cformula_2_<?php echo $i+1;?>" type="text" class="form-control" value="<?php echo $linhaCompos['FormulaQtd'];?>">
                                                                </td>
                                                                <td class="">
                                                                    <span class="compon_unid" id="compon_2_<?php echo $i;?>_unid">
                                                                        <?php echo $linhaCompos['strAbrevMedVnd'];?>
                                                                    </span>
                                                                </td>
                                                                <td class=" "><input name="compon[<?php echo $i;?>][cunit]" data-tabela="2" id="cunit_2_<?php echo $i+1;?>" type="text" class="form-control" value="<?php echo $linhaCompos['Custo'];?>">
                                                                </td>
                                                                <td class=" "><input name="compon[<?php echo $i;?>][total]" id="c_total_2_<?php echo $i+1;?>" type="text" class="form-control" value="<?php echo $linhaCompos['Total'];?>">
                                                                </td>
                                                                <td class=" last">
                                                                    <?php if($i==0){ ?><a href="#" id="bt_plus_<?php echo $i+1;?>" class="btn btn-info btn-sm addsectionCompon" data-tabela="2"><i class="fa fa-plus"></i></a>
                                                                    <?php } else { ?>
                                                                    <a href="#" class="btn btn-danger btn-sm remLinhaCompon" data-tabela="2" data-nLinha="<?php echo $i;?>"><i class="fa fa-minus"></i></a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php $i++; } $totalcomp=sizeof($composicao);  ?>
                                                        </div>
                                                    </div>
                                                </tbody>
                                                 <input type="hidden" name="totalCompon1" id="totalCompon2" value="<?php echo $totalcomp;?>">

                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td colspan="2"><a href="#" class="btn btn-primary btn-md pull-right btnArtigosSave2"><i class="fa fa-save"></i> Guardar alterações</a>
                                                        </td>

                                                    </tr>


                                                </tfoot>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>                   
                        
                        
                        

                            <div role="tabpanel" class="tab-pane fade" id="proj_fotos" aria-labelledby="proj_fotosT">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Galeria de Fotos <small> </small></h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-upload"></i> Enviar Fotos</a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <br>
                                                            <li><a href="#" role="button" data-toggle="modal" data-target="#fotoModal"><i class="fa fa-camera"></i> Tirar Foto</a> </li>
                                                            <!-- <li><a href="#" role="button" class="imageUpload"><i class="fa fa-upload"></i> Anexar imagem</a> </li>-->
                                                            <li> <a href="#" role="button" class="fileinput-button"> <i class="fa fa-upload"></i> Enviar imagem
                              <input id="fileupload" type="file" name="files[]" data-form-data='{"num": "<?php echo $num;?>","tipo": "imagens_projeto"}' multiple>
                              </a> </li>
                                                            <br>
                                                        </ul>
                                                    </li>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">

                                                    <!-- The global progress bar -->
                                                    <div id="progressB" class="progress">
                                                        <div class="progress-bar progress-bar-success"></div>
                                                    </div>
                                                    <!-- The container for the uploaded files -->
                                                    <div id="files" class="files"></div>
                                                    <span id="listafotos"></span>
                                                    <?php
                                                    $query = $mysqli->query( "SELECT * from projetos_att where (tipo='fotos' OR tipo='imagens') and projeto='$num' order by idatt desc" )or die( $mysqli->errno . ' - ' . $mysqli->error );
                                                    while ( $dlinha = $query->fetch_assoc() ) {
                                                        if ( is_file( $storeFolder . "/projetos/" . $num . "/" . $dlinha[ 'tipo' ] . "/" . $dlinha[ 'filename' ] ) ) {
                                                            $fnmel = URLBASE . "/attachments/projetos/" . $num . "/" . $dlinha[ 'tipo' ] . "/" . $dlinha[ 'filename' ];
                                                        }

                                                        ?>
                                                    <div class="col-md-55" id="foto<?php echo $dlinha['idatt'];?>">
                                                        <div class="thumbnail">
                                                            <div class="image view view-first"><img class="img-fluid" style="width: 100%; display: block;" src="<?php echo $fnmel;?>" alt="image"/>
                                                                <div class="mask">
                                                                    <p>
                                                                        <?php echo $dlinha['filename'];?>
                                                                    </p>
                                                                    <div class="tools tools-bottom"> <a target="_blank" data-toggle="lightbox" href="<?php echo $fnmel;?>"><i class="fa fa-eye"></i></a>
                                                                        <!-- <a href="#" class="editFoto" id="<?php echo $dlinha['idatt'];?>"><i class="fa fa-pencil"></i></a> --><a href="#" class="elimFoto" id="<?php echo $dlinha['idatt'];?>" data-tipo="<?php echo $dlinha['tipo'];?>"><i class="fa fa-times"></i></a> </div>
                                                                </div>
                                                            </div>
                                                            <div class="caption">
                                                                <p>
                                                                    <a href="#" class="descricaofoto" id="<?php echo $dlinha['idatt'];?>" data-tipo="<?php echo $dlinha['tipo'];?>">
                                                                        <?php echo $dlinha['legenda'];?>
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                        
                        <div class="row">
                                    <div class="col-md-12">
                     <a class="btn btn-primary " href="#" role="button" data-toggle="modal" data-target="#fotoModal"><i class="fa fa-camera"></i> Tirar Foto</a> 
                    
                        
                           </div>
                                </div>
                        
                        
                                <!-- fotoModal -->
                                <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fotoModalLabel">Anexar Foto</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                            <div class="modal-body">
                                                <div align="center" id="camera_foto"></div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-primary take_snapshot"><i class="fa fa-camera"></i> Tirar Foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /fotoModal -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } if ( $act == "gallery" ) {

echo "<div class=\"row\">";

$query = $mysqli->query( "SELECT idproj,codprojeto,titulo,tipo,filename,clientenome,legenda,idatt from projetos LEFT JOIN  projetos_att ON  projetos.idproj=projetos_att.projeto where estado='$tp' and projetos_att.tipo='fotos'" )or die( $mysqli->errno . ' - ' . $mysqli->error );
if($query->num_rows>0){

while($dlinha = $query->fetch_assoc()){

$projtitle = $dlinha[ 'titulo' ];
$projid = $dlinha[ 'idproj' ];
$codprojeto = $dlinha[ 'codprojeto' ];
$fname = $dlinha[ 'filename' ];
$clientenome = $dlinha[ 'clientenome' ];
$legenda = $dlinha[ 'legenda' ];

if (is_file( $storeFolder . "/projetos/" . $projid . "/" . $dlinha[ 'tipo' ] . "/" . $dlinha[ 'filename' ] ) ) {
    $fnmel = URLBASE . "/attachments/projetos/" . $projid . "/" . $dlinha[ 'tipo' ] . "/" . $dlinha[ 'filename' ];
    
}

?>


<div class="col-md-55">
<div class="thumbnail">
<div class="image view view-first">
<img style="width: 100%; display: block;" src="<?php echo $fnmel;?>" alt="image" />
<div class="mask">
<p><?php echo $legenda;?></p>
<div class="tools tools-bottom">

<a target="_blank" href="<?php echo $fnmel; ?>"><i class="fa fa-link"></i></a>
<a href="#"><i class="fa fa-eye" data-toggle="lightbox" href="<?php echo $fnmel; ?>"></i></a>
<!-- <a href="#" class="delfileAtt" id="<?php echo $dlinha[ 'idatt' ];?>" data-tipo="anexos"><i class="fa fa-times"></i></a> -->


</div>
</div>
</div>
<div class="caption">
<p><a href="<?php echo URLBASE;?>/projetos/<?php echo $projid;?>"><?php echo $codprojeto;?></a></p><p><?php echo $clientenome;?></p>
</div>
</div>
</div>


<?php } } else { echo "<h3>Não existem fotos nesta galeria</h3>"; } ?>
</div>
 
    <?php } include("footer.php"); ?>