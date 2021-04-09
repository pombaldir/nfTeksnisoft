
<script src="<?php echo URLBASE;?>/vendors/ekko-lightbox/dist/ekko-lightbox.min.js"></script>

<?php  
if($act==""){ ?>
<!-- Datatables -->
<script src="<?php echo URLBASE;?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo URLBASE;?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/jszip/dist/jszip.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/pdfmake/build/vfs_fonts.js"></script>

<script src="<?php echo URLBASE;?>/vendors/select2/dist/js/select2.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/select2/dist/js/i18n/pt.js"></script>

<script>
$(document).ready(function() {  
  
function format ( d ) { //console.log(d[0]);
    var tabelaFotos='<table cellpadding="5" cellspacing="5" border="0" style="width:100%;"><tr><td colspan="8">';
    if(d[1].length>0){
    $.each( d[1], function( key, value ) {
            var flDerImg=value['tipo'];
        tabelaFotos+='<a target="_blank" data-toggle="lightbox" href="<?php echo URLBASE;?>/attachments/projetos/'+d[0]+'/'+flDerImg+'/'+value['filename']+'"><img height="80" src="<?php echo URLBASE;?>/attachments/projetos/'+d[0]+'/'+flDerImg+'/'+value['filename']+'">'; 
    });  } else {
        tabelaFotos+='Não existem fotos';
    }  
    tabelaFotos+='</td></tr></table>'; 
    return tabelaFotos;        
}    
    
var oTable=$('#table<?php echo $p;?>').DataTable( {
			"aaSorting": [[ 0, "desc" ]],
			"bProcessing": true,
			"bServerSide": true,
			"aoColumnDefs": [ 
		 	{ "bVisible":  false, "bSearchable": false, "aTargets": [ 1 ]},
			{ "bVisible":  true, "bSearchable": false, "bSortable": false, "aTargets": [ 5 ]},
            { "sClass":'details-control', "sortable":false,"data":null,"defaultContent": '', "targets": [0] }
	 		],
			"sAjaxSource": "<?php echo URLBASE;?>/data/projetos", 
	        "bPaginate": true, 
	        "bSort": true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"sDom": "<'row'<'dataTables_header clearfix'<'col-md-1'l><'col-md-2 projStatus'><'col-md-2 projCateg'><'col-md-7'f>r>>t<'row'<'dataTables_footer clearfix'<'col-md-2 btnAdd'><'col-md-4'i><'col-md-6'p>>>",
			"fnServerParams": function ( aoData ) {
		    	aoData.push({ "name": "accaoG", "value": "listProjetos" },{ "name": "status", "value": $('#estado option:selected').val() },{ "name": "cat", "value": $('#categoria option:selected').val() });
		    },
			"oLanguage": {
				"sLengthMenu": "_MENU_",
				"sSearch": "Pesquisar: ",
				"sInfo": "_START_ a _END_ de _TOTAL_ registos",
				"sInfoEmpty": "Não existem registos",	
				"sEmptyTable": "Não existem registos",	
				"sZeroRecords": "Não existem registos a exibir",
				"sInfoFiltered": ""
			}
	       });
		   $('.btnAdd').html('<a href="<?php echo $p;?>/ad" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Criar Projeto<a>');		
            $('.projStatus').html('<?php selectFrmTbl("tbl_projetos_status","nome","","estado","form-control sel2 input-sm");?>');	
            $('.projCateg').html('<select  name="categoria" id="categoria" class="form-control sel2"><option value=""> ======- Categoria -======</option><?php  cat_display_select(0, 1, "", "tbl_projetos_cat","- ");?></select>');
    

    $(".sel2, .dataTables_length2").select2({
        multiple: false,
        allowClear: true,
        width: '100%',
        language: "pt",
    }).on('select2:select', function (e) {
     oTable.draw();
    }); 
 
 
    // Add event listener for opening and closing details
    $('#table<?php echo $p;?> tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = oTable.row( tr );
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });    
    
    
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
 });
        
});

</script>
<?php } if($act=="ad"){ ?>
<!-- jQuery Tags Input -->
<script src="<?php echo URLBASE;?>/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>

<!-- jQuery Smart Wizard -->
<script src="<?php echo URLBASE;?>/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo URLBASE;?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script> 
<script src="<?php echo URLBASE;?>/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script src="<?php echo URLBASE;?>/vendors/bootbox.js/bootbox.js"></script>


<script src="<?php echo URLBASE;?>/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/moment/locale/pt.js"></script>
<!-- bootstrap-datetimepicker -->    

<script src="<?php echo URLBASE;?>/vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<script>

$(document).ready(function() { 

'use strict';
   
$('#wizard<?php echo $p;?>').smartWizard({
  // Properties
    selected: 0,  // Selected Step, 0 = first step   
    keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
    enableAllSteps: false,  // Enable/Disable all steps on first load
    transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
    contentURL:null, // specifying content url enables ajax content loading
    contentURLData:null, // override ajax query parameters
    contentCache:true, // cache step contents, if false content is fetched always from ajax url
    cycleSteps: false, // cycle step navigation
    enableFinishButton: false, // makes finish button enabled always
	hideButtonsOnDisabled: true, // when the previous/next/finish buttons are disabled, hide them instead
    errorSteps:[],    // array of step numbers to highlighting as error steps
    labelNext:'Seguinte', // label for Next button
    labelPrevious:'Anterior', // label for Previous button
    labelFinish:'Terminar',  // label for Finish button        
    noForwardJumping:false,
    ajaxType: 'POST',
  	// Events
    onLeaveStep: null, // triggers when leaving a step
    onShowStep: null,  // triggers when showing a step
    onFinish: termina,  // triggers when Finish button is clicked  
    buttonOrder: ['prev', 'next','finish']  // button order, to hide a button remove it from the list
}); 


 $('#conclusaoPicker').datetimepicker({
        format: 'YYYY-MM-DD'
 });
 	  
	  
<?php $settings=unserialize(config_val('settings')); ?>

  
$(document).on('focusin','.pesquisacustomer', function(el) {    
var idElem=this.id;  
    $('#'+idElem).devbridgeAutocomplete({ 
        serviceUrl: '<?php echo $settings['erp_ws'];?>/clientes.php?act_g=search&field='+idElem+'&auth_userid=<?php echo $settings['ws_token'];?>',
        minChars: 3,
        dataType : "json",
        //groupBy : "strNumContrib",
        width: "400"/*,
        transformResult: function(response) {
            return {
            suggestions: $.map(response.suggestions, function(dataItem) {
                return { value: dataItem.value, data: dataItem };
            })
            };
        }*/,
        formatResult: function (suggestion) {
            return ''  + suggestion.strNumContrib + ' - <small>'  + suggestion.strNome + '</small> ';
        },
        onSelect: function (suggestion) { 
            var Morada2=suggestion.strMorada_lin2;
         preenche(suggestion.strNumContrib,suggestion.strNome,suggestion.intCodigo,suggestion.strMorada_lin1,suggestion.strMorada_lin2,suggestion.strPostal,suggestion.strLocalidade,suggestion.strTelefone,suggestion.strTelemovel,suggestion.strEmail);
        }
    });
});
    

/*
var focusNum = 0;
$('#nif').focusout(function() {
	focusNum++;
	if(focusNum==1){
	if($('#nome').val()==""){
		
	}
	}
});
*/

$('#seccao').multiselect({
	includeSelectAllOption: true,
	selectAllText: 'Selecionar tudo',
	buttonWidth: '100%',	
	dropRight: false,
    buttonText: function(options, select) {			
		if (options.length === 0) {
        	return 'Escolha as opções';
        }
        else if (options.length > 1) {
        	return 'Várias opções';
        }
        else {
        var labels = [];
        options.each(function() {
        if ($(this).attr('label') !== undefined) {
        	labels.push($(this).attr('label'));
        }
        else {
            labels.push($(this).html());
        }
            });
            return labels.join(', ') + '';
         }
      },
	 onChange: function(option, checked, select) {
			$.ajax({
			   type: "GET",
			   data: {seccao:$('#seccao').val(),accaoG:"FuncionbyDept"}, 
			   url: "<?php echo URLBASE;?>/data/utils",
			   success: function(data, textStatus, jqXHR){
			   $('#funcionarios').multiselect('refresh');   
			   $.each(data, function(i, item) {			   
			   $('#funcionarios').multiselect('dataprovider', item['funcionarios']);
			   });	
			   }
			});	
	 }

});
		
$('#categoria').multiselect({
buttonWidth: '100%',	
dropRight: false,
   on: {
     	change: function(option, checked) {
        var values = [];
        $('#categoria').each(function() {
        	if ($(this).val() !== option.val()) {
            	values.push($(this).val());
             }
        });
        $('#categoria').multiselect('deselect', values);
        }
   }
});

$('#funcionarios').multiselect({ 
buttonWidth: '100%',	
dropRight: false,
includeSelectAllOption: true,
selectAllText: 'Selecionar tudo',
buttonText: function(options, select) {		  
  if (options.length === 0) {
        	return 'Escolha as opções';
  }  
  }
});

	$('.buttonNext').addClass('btn btn-success');
	$('.buttonPrevious').addClass('btn btn-primary');
	$('.buttonFinish').addClass('btn btn-default');		

});




function preenche(nif,nome,ncliente,morada,morada2,cp,localidade,telefone,telemovel,email){
		if(morada2==null) morada2="";
		$('#strNome').val(nome);
		$('#ncliente').val(ncliente);
		$('#morada').val(morada+" "+morada2);
		$('#cp').val(cp.substr(0,cp.indexOf(' ')));
		$('#localidade').val(localidade);
		$('#telefone').val(telefone.replace(/\s/g, ''));
		$('#telemovel').val(telemovel.replace(/\s/g, ''));
		$('#email').val(email);	
        $('#strNumContrib').val(nif);	
    
}


function termina(){
	
	bootbox.confirm("<h4>Deseja criar este projeto?</h4>", function(result){
		  	if (result) {
			$('.progress-bar').css('width', '0%').attr('data-transitiongoal', 0);		
			setTimeout(function(){		
			$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: $('#formProjeto').serialize(),
				 dataType: "json",
				 success: function(data){	
					
					if(data.success==1){
					$('.buttonFinish, .buttonPrevious, .btn').attr("disabled", true).addClass('buttonDisabled').hide();	
					$('#formProjeto').attr("disabled", true);
					 setTimeout(function(){		
						 new PNotify({
							title: "Projetos",
							type: ""+data.type+"",
							text: ""+data.message+"",
							nonblock: {
							nonblock: true
							},
							styling: 'bootstrap3',
							hide: true
						}); 
						}, 3000);	
					 
					setTimeout(function(){ window.location.href = '<?php echo URLBASE;?>/projetos/'+data.idprojeto+'#proj_fotos';},5000); 						
						
					}
					
					$('.progress-bar').css('width', '100%').attr('data-transitiongoal', 100);
				},
				error: function(xhr, status, error) {
				   new PNotify({
						title: "Erro",
						type: "warning",
						text: ""+xhr.responseText+"",
						nonblock: {
						nonblock: true
						},
						styling: 'bootstrap3',
						hide: true
					}); 
				}
			});	
			}, 2000);
			}
		});	
	
}



	
</script>  
  
  
<?php } if($act=="view"){ ?>

<script src="<?php echo URLBASE;?>/vendors/webcamjs/webcam.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/bootbox.js/bootbox.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script src="<?php echo URLBASE;?>/vendors/select2/dist/js/select2.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/select2/dist/js/i18n/pt.js"></script>

<script src="<?php echo URLBASE;?>/vendors/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo URLBASE;?>/vendors/blueimp-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo URLBASE;?>/vendors/blueimp-file-upload/js/jquery.fileupload.js"></script>
<script src="<?php echo URLBASE;?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?php echo URLBASE;?>/vendors/iCheck/icheck.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/gauge.js/dist/gauge.min.js"></script>

<link href="<?php echo URLBASE;?>/vendors/nprogress/nprogress.css" rel="stylesheet">

<script src="<?php echo URLBASE;?>/build/js/timer.jquery.js"></script>

<!-- Chart.js -->
<script src="<?php echo URLBASE;?>/vendors/Chart.js/dist/Chart.min.js"></script>

<script src="<?php echo URLBASE;?>/vendors/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

<script>
$(document).ready(function() { 
'use strict';

var hashUrl = window.location.hash.substr(1);
if(hashUrl!=""){
	$('#'+hashUrl+'T').click();
}


<!-- Camera -->
$('#fotoModal').on('show.bs.modal', function (event) {

    
	Webcam.set({
			width: '100%',
			height: '80vh',
			dest_width: 640,
			dest_height: 480,
			image_format: 'jpeg',
            constraints: {
            //video: true,    
            facingMode: "environment",
            },
			jpeg_quality: 90
		});
		Webcam.attach( '#camera_foto' );	
		
	var shutter = new Audio();
	shutter.autoplay = false;
	shutter.src = navigator.userAgent.match(/Firefox/) ? '<?php echo URLBASE;?>/vendors/webcamjs/shutter.ogg' : '<?php echo URLBASE;?>/vendors/webcamjs/shutter.mp3';
	
		function take_snapshot() {
			shutter.play();
			
			Webcam.snap( function(data_uri) {
				// display results in page
				/*
				document.getElementById('results').innerHTML = 
					'<h2>Here is your large image:</h2>' + 
					'<img src="'+data_uri+'"/>';
				*/
				
  				//Webcam.freeze();
				
				Webcam.on( 'uploadProgress', function(progress) {
				// Upload in progress
				// 'progress' will be between 0.0 and 1.0
				});
				
				Webcam.on( 'uploadComplete', function(code, text) {
					// Upload complete!
				} );
					
				var urlFoto = '<?php echo URLBASE;?>/data/<?php echo $p;?>.php?proj=<?php echo $num;?>&accaoG=uploadFoto';
				Webcam.upload( data_uri, urlFoto, function(code, text) {
					
					var texto=JSON.parse(text);
					
					if(code==200 && texto.success==1){
					$('#listafotos').prepend('<div class="col-md-55" id="foto'+texto.idFile+'"><div class="thumbnail"><div class="image view view-first"><img style="width: 100%; display: block;" src="'+data_uri+'" alt="image" /><div class="mask"> <p>'+texto.fname+'</p> <div class="tools tools-bottom"><a href="#"><i class="fa fa-link"></i></a><a href="#" class="editFoto" id="'+texto.idFile+'"><i class="fa fa-pencil"></i></a>  <a href="#" class="elimFoto" id="'+texto.idFile+'" data-tipo="fotos"><i class="fa fa-times"></i></a></div></div></div><div class="caption"><p><a href="#" class="descricaofoto">'+texto.descr+'</a></p> </div></div></div>');
					}
					//setTimeout(Webcam.unfreeze(), 30000);
				});
			});
		}		
	
	$(".take_snapshot").click(function() {		
		take_snapshot();	
	});		
	
});

$('#fotoModal').on('hide.bs.modal', function (event) {
Webcam.reset();
});
<!-- /Camera -->


<!-- Elimina Foto -->
$(document).on('click', '.elimFoto', function(){
event.preventDefault();
var idFoto=(this).id;
var tipoAtt=$(this).attr("data-tipo");
eliminaATT(tipoAtt,idFoto); 
});	
<!-- /Elimina Foto -->


<!-- Elimina Anexo -->
$(document).on('click', '.delfileAtt', function(){
event.preventDefault();
var idFoto=(this).id;
var tipoAtt=$(this).attr("data-tipo");
eliminaATT(tipoAtt,idFoto); 
});	
<!-- /Elimina Anexo -->



function eliminaATT(tipo,idFoto){
bootbox.confirm("<h4>Deseja eliminar este ficheiro?</h4>", function(result){
		  	if (result) {
			$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: {accaoP:"eliminaAtt",idAtt:""+idFoto+"",projeto:"<?php echo $num;?>",tipo:""+tipo+""},
				 dataType: "json",
				 success: function(data){	
					
					new PNotify({
							title: "Eliminar Ficheiro",
							type: ""+data.type+"",
							text: ""+data.message+"",
							nonblock: {
							nonblock: true
							},
							styling: 'bootstrap3',
							hide: true
					}); 
						
					if(data.success==1 && (tipo=="imagens" || tipo=="fotos")){
						$("#foto"+idFoto).remove();				
					}
					if(data.success==1 && tipo=="anexos"){
						$("#anexo"+idFoto).remove();				
					}
				},
				error: function(xhr, status, error) {
				   new PNotify({
						title: "Erro",
						type: "warning",
						text: ""+xhr.responseText+"",
						nonblock: {
						nonblock: true
						},
						styling: 'bootstrap3',
						hide: true
					}); 
				}
			});	
			}
		});	
}
<!-- /Elimina Foto -->

$('.descricaofoto').editable({
    type: 'text',
    pk: {numero: $(this).id, accaoP: 'editLegenda', projeto: '<?php echo $num;?>'},
    url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
    title: 'Legenda',
	success: function(response, newValue) {
        console.log(response);
    }
});

		
	
    // Change this to the location of your server-side upload handler:
    $('#fileupload').fileupload({
        url: '<?php echo URLBASE;?>/data/UploadHandler',
        dataType: 'json',
        done: function (e, data) {
			
            $.each(data.result.files, function (index, file) {
			$('#listafotos').parent().prepend('<div class="col-md-55" id="foto'+file.idnum+'"><div class="thumbnail"><div class="image view view-first"><img style="width: 100%; display: block;" src="'+file.url+'" alt="image" /><div class="mask"> <p>'+file.name+'</p> <div class="tools tools-bottom"><a href="#"><i class="fa fa-link"></i></a><a href="#" class="editFoto" id="'+file.idnum+'"><i class="fa fa-pencil"></i></a>  <a href="#" class="elimFoto" id="'+file.idnum+'"  data-tipo="'+file.tipo+'"><i class="fa fa-times"></i></a></div></div></div><div class="caption"><p><a href="#" class="descricaofoto" id="'+file.idnum+'" data-tipo="'+file.tipo+'">'+file.legenda+'</a></p> </div></div></div>');
            });
			$( "#progressB" ).hide();
			$( "#progressATT" ).hide();
        },
		error: function (jqXHR, textStatus, errorThrown) {
			
			new PNotify({
						title: "Erro",
						type: "warning",
						text: ""+errorThrown+"",
						nonblock: {
						nonblock: true
						},
						styling: 'bootstrap3',
						hide: true
			}); 
		
		},
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressB .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');	


$( "#progressB" ).hide();
$( "#progressATT" ).hide();


$(".fileinput-button").click(function() {	
$( "#progressB" ).show();
$( "#progressATT" ).show();
});	



$('#fileuploadAnexo').fileupload({
        url: '<?php echo URLBASE;?>/data/UploadHandler',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
				$( ".project_files" ).prepend('<li id="anexo'+file.idnum+'"><a target="_blank" href="'+file.url+'"><i class="fa fa-paperclip"></i> '+file.name+'</a> <a href="#" class="right-align btn btn-xs btn-error delfileAtt" id="'+file.idnum+'" data-tipo="anexos"><span class="fa fa-trash"></span></a>');
            });
			$( "#progressATT" ).hide();
			$( "#progressB" ).hide();
        },
		error: function (jqXHR, textStatus, errorThrown) {
			
			new PNotify({
						title: "Erro",
						type: "warning",
						text: ""+errorThrown+"",
						nonblock: {
						nonblock: true
						},
						styling: 'bootstrap3',
						hide: true
			}); 
		
		},
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressATT .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');	


$("#btnSbmComment").click(function() {	
		$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: {accaoP:"addComent",projeto:"<?php echo $num;?>",coment:$("#comentario").val()},
				 dataType: "json",
				 success: function(data){						
					if(data.success==1){
						$('#comentModal').modal("hide");
						$( ".messages" ).prepend('<li><img class="avatar" src="'+data.foto+'" alt=""><div class="message_date"><h3 class="date text-info">'+data.dia+'</h3><p class="month">'+data.mes+'</p></div><div class="message_wrapper"><h4 class="heading">'+data.nome+'</h4><blockquote class="message">'+$("#comentario").val()+'</blockquote><br /></div></li>');
					}
				},
				error: function(xhr, status, error) {
				   new PNotify({
						title: "Erro",
						type: "warning",
						text: ""+xhr.responseText+"",
						nonblock: {
						nonblock: true
						},
						styling: 'bootstrap3',
						hide: true
					}); 
				}
		});	
});	


$('#estado').editable({
        prepend: "selecione estado",
        source: [<?php $queryStatus=$mysqli->query("SELECT idnum,nome from tbl_projetos_status ");	while($dlinhaStatus=$queryStatus->fetch_assoc()){ echo "{value: ".$dlinhaStatus['idnum'].", text: \"".$dlinhaStatus['nome']."\"},";  }  ?>
        ],
        display: function(value, sourceData) {
             var colors = {"": "gray", "criado": "green", "iniciado": "blue", "terminado": "red"},
                 elem = $.grep(sourceData, function(o){return o.value == value;});
             if(elem.length) {    
                 $(this).text(elem[0].text).css("color", colors[value]); 
             } else {
                 $(this).empty(); 
             }
        },
		pk: {accaoP: 'editField', projeto: '<?php echo $num;?>'},
    	url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
		success: function(response, newValue) {
        	console.log(response);
    	}   
    });    


$(document).on('ifChecked', '.chektask', function(){
		$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: {accaoP:"updtTask",accaotask:"tarefa_done",projeto:"<?php echo $num;?>",numero:$(this).val()},
				 dataType: "json",
				 success: function(data){							
					if(data.success==1){
						new PNotify({
							title: "Editar Tarefa",
							type: "info",
							text: "Tarefa marcado como concluída",
							nonblock: {
							nonblock: true
							},
							styling: 'bootstrap3',
							hide: true
						}); 		
					}			
				}
		});	
});	


$(document).on('ifUnchecked', '.chektask', function(){
		$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: {accaoP:"updtTask",accaotask:"tarefa_undone",projeto:"<?php echo $num;?>",numero:$(this).val()},
				 dataType: "json",
				 success: function(data){
					if(data.success==1){
						new PNotify({
							title: "Editar Tarefa",
							type: "info",
							text: "Tarefa marcado como não concluída",
							nonblock: {
							nonblock: true
							},
							styling: 'bootstrap3',
							hide: true
						}); 		
					}			
				}
		});	
});	

$(document).on('ifChanged', '.chektask', function(){
gaugeUpdt();
});	

$(".plusLink").click(function() { 
    var name;
    do {
        name=prompt("Introduza a tarefa");
    }
    while(name.length < 4);
		$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: {accaoP:"addTask",projeto:"<?php echo $num;?>",nome:name},
				 dataType: "json",
				 success: function(data){
					if(data.success==1){
						new PNotify({
							title: "Adicionar Tarefa",
							type: "info",
							text: "Tarefa adicionada",
							nonblock: {
							nonblock: true
							},
							styling: 'bootstrap3',
							hide: true
						}); 
				$( ".to_do" ).prepend('<li><p><input name="tasklist[]" id="'+data.idtask+'" type="checkbox" class="flat chektask" value="'+data.idtask+'"> '+name+'</p></li>');
				$('#'+data.idtask).iCheck({
				checkboxClass: 'icheckbox_flat-green'
				});
				gaugeUpdt();
				
				}
			}
		});		

});


function gaugeUpdt(){
var numeroOpt=($('.to_do>li').length);
var numeroCheck=($('.to_do>li :checked').length);
if(numeroOpt==0){
var percent=100;	
} else {
var percent=((numeroCheck/numeroOpt)*100).toFixed(0);
}

var opts = {
  angle: 0.15, // The span of the gauge arc
  lineWidth: 0.44, // The line thickness
  radiusScale: 1, // Relative radius
  pointer: {
    length: 0.6, // // Relative to gauge radius
    strokeWidth: 0.035, // The thickness
    color: '#000000' // Fill color
  },
  limitMax: false,     // If false, max value increases automatically if value > maxValue
  limitMin: false,     // If true, the min value of the gauge will be fixed
  colorStart: '#6FADCF',   // Colors
  colorStop: '#8FC0DA',    // just experiment with them
  strokeColor: '#E0E0E0',  // to see which ones work best for you
  generateGradient: true,
  highDpiSupport: true,     // High resolution support
  
};
var target = document.getElementById('chart_gauge_01'); // your canvas element
var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
gauge.maxValue = 100; // set max gauge value
gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
gauge.animationSpeed = 70; // set animation speed (32 is default value)
gauge.set(percent); // set actual value
$('#gauge-text').text(percent); 
}

gaugeUpdt();


var ctx = document.getElementById("lineChart");
			  var lineChart = new Chart(ctx, {
				type: 'line',
				data: {
				  labels: ["January", "February", "March", "April", "May", "June", "July"],
				  datasets: [{
					label: "Horas",
					backgroundColor: "rgba(38, 185, 154, 0.31)",
					borderColor: "rgba(38, 185, 154, 0.7)",
					pointBorderColor: "rgba(38, 185, 154, 0.7)",
					pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(220,220,220,1)",
					pointBorderWidth: 1,
					data: [31, 74, 6, 39, 20, 85, 7]
				  }, {
					label: "Intervenções",
					backgroundColor: "rgba(3, 88, 106, 0.3)",
					borderColor: "rgba(3, 88, 106, 0.70)",
					pointBorderColor: "rgba(3, 88, 106, 0.70)",
					pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(151,187,205,1)",
					pointBorderWidth: 1,
					data: [82, 23, 66, 9, 99, 4, 2]
				  }]
				},
});

var inumerador=1;
$(document).on('click', '.plusIntervLink', function(){
$( ".top_profiles" ).prepend('<li><a class="dynamicInterv" href="#" id="dynamicInterv'+inumerador+'" data-type="select" data-name="interv" data-title="Escolha o colaborador"></a>');

  $('#dynamicInterv'+inumerador).editable({
        prepend: "Escolha o colaborador",
		source:"<?php echo URLBASE;?>/data/<?php echo $p;?>?accaoG=Interv&proj=<?php echo $num;?>",
		pk: {accaoP: 'addInterv', projeto: '<?php echo $num;?>'},
    	url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
		success: function(response, newValue) {
        	console.log(response);
			window.location.href = '<?php echo URLBASE;?>/projetos/<?php echo $num;?>#proj_interv';
    	}    
    }); 
	inumerador++;
});	

     
    
// Materiais   

$('.addsectionCompon').click(function () {
    var tabela=$(this).attr("data-tabela"); 
    
	$('.artList'+tabela).select2("destroy");
	$('#totalCompon'+tabela).val(Number($('#totalCompon'+tabela).val())+1); 
    $('#tabelacompon'+tabela+' tbody').append($('#tabelacompon'+tabela+' tbody tr:last').clone());
			
	$('#tabelacompon'+tabela+' tbody tr:last').find('input[name*="formula"]').val(1);
	$('#tabelacompon'+tabela+' tbody tr:last').find('input[name*="cunit"]').val(0);
	$('#tabelacompon'+tabela+' tbody tr:last').find('input[name*="total"]').val(0);
	$('#tabelacompon'+tabela+' tbody tr:last').find('select[name*="compon['+Number($('#totalCompon'+tabela).val()+1)+'][artigo]"]').select2("destroy");

	correLinhaCompon(tabela);
});	
	

$(document).on('click', '.remLinhaCompon', function() {
    var tabela=$(this).attr("data-tabela"); 
	$(this).parents("tr").remove();		
	correLinhaCompon(tabela);	
	calcTotalComp(0,tabela);
});

	
function correLinhaCompon(tabela){
    $('#tabelacompon'+tabela+' tr').each(function(i) {
		var textinput = $(this).find('input');
		textinput.eq(0).attr('id', 'cLinha_'+tabela+'_' + i).val(i).attr('name', 'compon['+i+'][cLinha]');
		textinput.eq(1).attr('id', 'armazem_'+tabela+'_' + i).val(i).attr('name', 'compon['+i+'][armazem]');
		textinput.eq(2).attr('id', 'c_calculo_'+tabela+'_' + i).attr('name', 'compon['+i+'][calculo]');
		textinput.eq(3).attr('id', 'cformula_'+tabela+'_' + i).attr('name', 'compon['+i+'][formula]');
		textinput.eq(4).attr('id', 'cunit_'+tabela+'_' + i).attr('name', 'compon['+i+'][cunit]');
		textinput.eq(5).attr('id', 'c_total_'+tabela+'_' + i).attr('name', 'compon['+i+'][total]');
		
		var selectinput = $(this).find('select');
		selectinput.eq(0).attr('id', 'artigo_'+tabela+'_' + i).attr('name', 'compon['+i+'][artigo]'); 
		if($('#totalCompon'+tabela).val()<=i || ($('#totalCompon'+tabela).val()==1 && i==0)){
			selectinput.eq(0).val('');	
		} 
		
		
				
		if(i>1){
		var btn = $(this).closest('tr').find("td.last > a");
		btn.removeClass('btn-info').addClass('btn-danger').addClass('remLinhaCompon');
		btn.find("i").removeClass('fa-plus').addClass('fa-minus');
		}
					
		textinput.eq(3).trigger('change');	
		
    });
	select_2_Artigo(tabela);	
	
	
}


function select_2_Artigo(tabela){
    if(tabela==1){
        var urlSrch="<?php echo $_SESSION["ERPWS"]."/artigos.php";?>";
    } else {
        urlSrch="/data/materiais.php";
    }
$(".artList"+tabela).select2({
	multiple: false,
	allowClear: true,
	language: "pt",
	debug: true,
	placeholder: "Escolha 1 opção",
    minimumInputLength: 2,
    minimumResultsForSearch: 10,
    ajax: {
        url: ""+urlSrch+"",
        dataType: "json",
        type: "GET",
        data: function (params) {
            var queryParameters = {
                term: params.term,
				auth_userid: "<?php echo $_SESSION["ERPTKN"];?>",
				act_g: "srchArtigo"
            }
            return queryParameters;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.strDescricao,
						preco: item.fltPreco,
						unidade: item.strAbrevMedVnd,
                        id: item.strCodigo
                    }
                })
            };
        }
    }
}).on("select2:select", function (e) { 
 var data = e.params.data;
	$(this).closest("tr").find('input[name*="cunit"]').val(parseFloat(data.preco).toFixed(2)); 
	$(this).closest("tr").find('.compon_unid').text(""+data.unidade+""); 
	
	calcTotalComp();
}).on('select2:unselect', function (e) {
   $(this).closest("tr").find('input[name*="formula"]').val(1);	
   $(this).closest("tr").find('input[name*="cunit"]').val(0);	
   $(this).closest("tr").find('input[name*="total"]').val(0);	
   calcTotalComp(0);   
});
}
 
/**/

$(document).on('keyup', 'input[name*="formula"],input[name*="cunit"]', function() {
	calcTotalComp(0,$(this).data("tabela"));
});



function calcTotalComp(saveRes,tabela){
	var acumulado = 0;
	$('#tabelacompon'+tabela+' tr').each(function(i) {
		var qtd=$(this).closest("tr").find('input[name*="formula"]').val();	
		var cUnit=$(this).closest("tr").find('input[name*="cunit"]').val();	
		var sTotal=(cUnit*qtd).toFixed(2);
		if(isNaN(sTotal)==false){
		acumulado+=parseFloat(sTotal);
		}
		$(this).closest("tr").find('input[name*="total"]').val(sTotal);	
	});	
	$('#pc_ref').val(acumulado.toFixed(2));
    
    if(saveRes==0){
	console.log("Função calcTotalComp()"); 
    }
    
    if(saveRes==1){
        $.ajax({
            url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
            type: 'POST',
            data: $('#tabelacompon'+tabela+' :input').serialize(),
            success: function(data){ 
                
                
            console.log("Salvar Registos");        
            },
            error: function(xhr, status, error) {
                alert("ERRO ao salvar linhas" + status + "\nErro: " + xhr.responseText); 
                console.log($('#tabelacompon'+tabela+' :input').serialize());
            }
        });           

        
        
        
    }
    
}
    

    
$(document).on('click', '.btnArtigosSave', function() {
    calcTotalComp(1,1);
}); 
$(document).on('click', '.btnArtigosSave2', function() {
    calcTotalComp(1,2); 
});     
    

select_2_Artigo(1);
select_2_Artigo(2);    
    

//remove section
$('#sections').on('click', '.remove', function() {
var idbt=jQuery(this).attr("id");
bootbox.confirm({
    title: "Remover opção?",
    message: "Pretende remover esta opção? <br>Se sim, não poderá desfazer esta ação após confirmação.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancelar'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirmar'
        }
    },
    callback: function (result) {	
		 if(result){
			$('.remove#'+idbt).parent().fadeOut(300, function(){
			$('.remove#'+idbt).parent().parent().parent().empty();
			$( "#submeteForm" ).trigger( "click" );
			return false;
			});
		 	bootbox.hideAll();
    		return false;
		}		
	}
});
});	 

    
    
    
    
    

//remove section
$('body').on('click', 'button.elimProjeto', function (e) {    
bootbox.confirm({
    title: "Eliminar esta obra?",
    message: "Pretende remover esta obra? <br>Se sim, não poderá desfazer esta ação após confirmação.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancelar'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirmar'
        }
    },
    callback: function (result) {	
		 if(result){
            $.ajax({
            url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
            type: 'POST',
            data: {"accaoP":"elimina","num":"<?php echo $num;?>"},
            success: function(data){ 
            window.location.href = '<?php echo URLBASE;?>/projetos';    
                
            console.log("eliminado");        
            },
            error: function(xhr, status, error) {
                alert("ERRO \n" + status + "\nErro: " + xhr.responseText); 
            }
        });   			
		}		
	}
});
});	    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
 });
    
        

$('body').on('click', 'a.btnmodalClock', function (e) {
    var idtimer=$(this).data("idtimer");  
    $('.nomeProjetoTimer').text($(this).data("nome")); 
    
    $("#timerModal").text(""); 
    
    $.ajax({
        url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
        type: 'GET',
        data: { accaoG: "gettimer", idtimer: idtimer, projeto: <?php echo $num;?>},
        success: function(data){ 

            var timerTempo=data['timer'];  
            var timerstatus=data['timerstatus']; 
            var obs=data['obs']; 

            $('.btntimer').attr("id",idtimer); 
            if(obs!="" && obs!=null){
            $('#timercoment').val(''+obs+''); 
            } 

            if(timerTempo==null)    var timerTempo=0;
            if(timerstatus==null)   var timerstatus="stopped";

            console.log( "Timer: "+idtimer+" Status: " + timerstatus + " Timer: " + timerTempo );

            $("#timerModal").timer({
                seconds:    timerTempo,  
                format:     '%H:%M:%S'    
            }); 
            
	       indicadorEstado(timerstatus,idtimer);        
        },
        error: function(xhr, status, error) {
            alert("ERRO 1" + status + "\nErro: " + xhr.responseText); 
        }
    });    
});        
    
    
function indicadorEstado(estado,IDelemento){
     if(estado=="paused") {       
         $('#timerModal').timer('pause'); 
         $('#btnstoptimer').removeAttr("disabled");
         $('#icone'+IDelemento+', #iconetimer').addClass('fa-pause').removeClass('fa-play').removeClass('blink_me');
         $('.btntimer, #timer'+IDelemento+'').addClass('btn-danger').removeClass('btn-info');
         $('#timercoment').removeAttr("disabled");
         $('#timerModal, .btnEditaTime').attr("disabled", false); 
         $('#timerLegend').text('Continuar');   
     } 
	 if(estado=="running"){       
         $('#btnstoptimer').attr("disabled", "disabled");
         $('#icone'+IDelemento+', #iconetimer').removeClass('fa-stop').addClass('fa-play').removeClass('fa-pause').addClass('blink_me');
         $('.btntimer, #timer'+IDelemento+'').addClass('btn-primary').removeClass('btn-success').removeClass('btn-danger').removeClass('btn-info');
         $('#timercoment').attr("disabled", "disabled");
         $('#timerModal, #timercoment, .btnEditaTime').attr("disabled", "disabled");
         $('#timerLegend').text('Pausar');
     }
	 if(estado=="stopped"){       
         $('#timerModal').timer('pause'); 
         $('.btntimer, #timer'+IDelemento+'').addClass('btn-success').removeClass('btn-danger');
         $('#icone'+IDelemento+', #iconetimerStop').addClass('fa-stop').removeClass('fa-play').removeClass('fa-pause').removeClass('blink_me');
         //$('#iconetimer').addClass('fa-play').removeClass('fa-stop').removeClass('fa-pause').removeClass('blink_me');
         $('#timerLegend').text('Iniciar'); 
         $('#timerModal, .btnEditaTime, #timercoment, .btnstoptimer').attr("disabled", "disabled");
     }  
       console.log("estado "+estado);
}
    
    
    
$('.btntimer').click(function(){
		var estado = $('#timerModal').data('state');     // running | paused | stopped
		var tempo = $("#timerModal").data('seconds');
        var idBtn = $(this).attr('id');
        
        jQuery("#"+idBtn).attr("disabled", 'disabled');  
		if(estado=="running"){
		$('#timerModal').timer('pause');  
		}
		if(estado=="paused"){
		$('#timerModal').timer('resume');
		}
		if(estado=="stopped"){
		$('#timerModal').timer('start');
		}	
		if(estado==null){
		$("#timerModal").timer({
			seconds:    timerTempo,  
			format:     '%H:%M:%S'    
		});
		}
		
		var estado2 = $('#timerModal').data('state');
		 console.log(estado+" > "+tempo+"sec > "+estado2);  
		 atualizatempo(idBtn,estado2,tempo); 
	});
	
    
   
$('.btnstoptimer').click(function(){     
    var tempo = 0;
    var idBtn = $('.btntimer').attr('id');
    atualizatempo(idBtn,"stopped",tempo);
    $('#modalTimer').modal('hide');   
});
    
	function atualizatempo(idtimer,estado,tempo){
        indicadorEstado(estado,idtimer);
        $.ajax({
          type: "POST",
          url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
          data: {"accaoP":"updatetimer","projeto":<?php echo $num;?>,"idtimer":idtimer,"estado":""+estado+"","tempo":""+tempo+""},
            success: function(data, textStatus, jqXHR) {
                $('.btntimer').attr("id",data.idRec);  
               // $('#lasttimerID').val(data.idRec);
                $(".btntimer").removeAttr("disabled");  
                $('.btntimer').button(); 
                if(estado=="stopped"){ var valorTmpo="00:00:00";  } else { valorTmpo=$("#timerModal").val(); } 
                $("#timer"+idtimer+"clock").text(valorTmpo);
                console.log("Editado ID "+idtimer+" = "+valorTmpo);
            },
            error: function(xhr, status, error) {
            alert("ERRO 2 " + status + "\nErro: " + xhr.responseText); 
            }
        });	
	}    
 
    
$('#modalTimer').on('hidden.bs.modal', function (e) {
        $("#timerModal").timer('remove'); 
        $('#timercoment').val('');     
});
$('#modalTimer').on('shown.bs.modal', function (e) {
        $('#timerModal').mask('00:00:00');        
});      
    
    
  /*
 $( "a.btnmodalClock" ).each(function( index, element ) {
   if ( $( this ).hasClass( "running" )) {
        var elemntClock=$(this).attr('id'); 
        $("#"+elemntClock+"clock").timer({
            seconds:    $("#"+elemntClock).data("sec"), 
            format:     '%H:%M:%S'    
        });
        console.log("Elemento Clock: "+elemntClock+" Seg: "+$("#"+elemntClock).data("sec"));
    } 
 }); 
  */  

 $('#projetosTimer').on('submit', function(event){
        event.preventDefault();
        var iDTimerc=$('.btntimer').attr('id');
        var timeVal=$('#timerModal').val();
        $.ajax({
          type: "POST",
          url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
          data: {"accaoP":"edittimer","timercoment":$('#timercoment').val(),"timeedit":timeVal,"idtimer":iDTimerc,"projeto":"<?php echo $num;?>"},
            success: function(data, textStatus, jqXHR) {
               console.log(data);
                //$('#modalTimer').modal('hide');  
                $('#timerModal').timer('remove'); 
                $('#timerModal').timer({
			         seconds:    data.sec,  
			         format:     '%H:%M:%S'    
		          });
                $('#timerModal').timer('pause');
                $("#timer"+iDTimerc+"clock").text($("#timerModal").val());
            },  error: function(xhr, status, error) {
            alert("" + status + "\nErro: " + xhr.responseText);
        }
        });	
 });     
    
   
$(document).on('click', '.plusIntervTime', function(){
var inumerador=parseInt($('#numTimers').val())+1;   
    $( ".listaTempos" ).prepend('<a id="timer'+inumerador+'" class="btn btn-primary button-xs btnmodalClock" data-sec="0" data-status="stopped" data-idtimer="0" data-nome="<?php echo $projtitle;?>" data-toggle="modal" href="#modalTimer"><i class="fa fa-play" id="icone'+inumerador+'"></i> <span id="timer'+inumerador+'clock" class="divtempo">00:00:00</span></a> <a class="dynamicTempo" href="#" id="dynamicTempo'+inumerador+'" data-idtimer="0" data-numlinha="'+inumerador+'" data-type="select" data-name="intervtimeusr" data-title="Escolha o colaborador">Escolha o colaborador</a><br>');
    $('#numTimers').val(inumerador);
    TempoDinamico('add');
});	   
  
function TempoDinamico(tipo){    
$('.dynamicTempo').editable({
        prepend: "Escolha o colaborador",
		source:"<?php echo URLBASE;?>/data/<?php echo $p;?>?accaoG=IntervTimer&proj=<?php echo $num;?>",
		pk: {accaoP: 'addIntervTime', projeto: '<?php echo $num;?>'},
        params: function(params) {
            params.timer = $(this).editable().data('idtimer');
            params.numlinha = $(this).editable().data('numlinha');
            params.tipoAct = tipo;
            return params;
        },
    	url: '<?php echo URLBASE;?>/data/<?php echo $p;?>',
		success: function(response, newValue) {
        	console.log(response);
            //$('#numTimers').val(response.success); 
            
           // alert($(this).editable().data('idtimer'));
    	}    
});    
}
    
    
TempoDinamico('edit');    
    
	
});	
</script>  


<?php } if($act=="gallery"){ ?>

<script src="<?php echo URLBASE;?>/vendors/ekko-lightbox/dist/ekko-lightbox.min.js"></script>


<script>
$(document).ready(function() { 
'use strict';


	$(document).on('click', '[data-toggle="lightbox"]', function(event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	});	

	
});	
</script>  

<?php }  ?>




   

        
