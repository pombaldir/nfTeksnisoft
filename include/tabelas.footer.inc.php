<?php if($act=="list"){?>
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
<!-- iCheck -->
<script src="<?php echo URLBASE;?>/vendors/iCheck/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<?php } ?>

<!-- iCheck -->
<script src="<?php echo URLBASE;?>/vendors/iCheck/icheck.min.js"></script>


<script>


$(document).ready(function() {   
 
 <?php if($act=="list"){?>
<?php if($tp=="departamentos" || $tp=="projetos-cat" || $tp=="projetos-status" || $tp=="seccoes"  || $tp=="materiais"){?>

var oTable = $('#table<?php echo $p;?>').DataTable( {
			"aaSorting": [[ 0, "asc" ]],
			"bProcessing": true,
			"bServerSide": false,
	        "bPaginate": true, 
	        "bSort": true,
			"sDom": "<'row'<'dataTables_header clearfix'<'col-md-3'l><'col-md-9'f   >r>>t<'row'<'dataTables_footer clearfix'<'col-md-2 btnAdd'><'col-md-4'i><'col-md-6'p>>>",
			"oLanguage": {
				"sInfo": "_START_ a _END_ de _TOTAL_ registos",
				"sLengthMenu": "_MENU_ /pág",
				"sInfoEmpty": "Não existem registos",	
				"sEmptyTable": "Não existem registos",	
				"sZeroRecords": "Não existem registos a exibir",
				"sSearch": "Pesquisar: ",
				"oPaginate": {
				  "sPrevious": "Anterior",
				  "sNext": "Seguinte",
				  "sFirst": "Início",
				  "sLast": "Última"
				},
				"sInfoFiltered": ""
			}
	       });

	$('.btnAdd').html('<a href="/<?php echo $p;?>/<?php echo $tp;?>/ad" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Adicionar<a>');
		   	
	$(document).on('click', '.btnDelete', function() {	
	 event.preventDefault();
	 var idRegisto=this.id;  
		 bootbox.confirm("<h4>Deseja eliminar este registo?</h4>", function(result){
		  	if (result) {			
			$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/<?php echo $p;?>",
				 data: {"accaoP": "deleteR", "idnum":""+idRegisto+"", "tipoTbl":"<?php echo $tp;?>" },
				 dataType: "json",
				 success: function(data){	
					 new PNotify({
						title: "Eliminar <?php echo $tp;?>",
						type: ""+data.type+"",
						text: ""+data.message+"",
						nonblock: {
						nonblock: true
						},
						styling: 'bootstrap3',
						hide: true
					}); 
					
					if(data.success==1){
						setTimeout(function(){ location.reload(); },3000); 
					}
				}
			});	
			}
		});	
    });	
	
<?php } }  
if($act=="edit" || $act=="ad"){

if($tp=="departamentos" || $tp=="projetos-cat" || $tp=="seccoes" || $tp=="projetos-status" || $tp=="materiais" ){?>

$( "form" ).on( "submit", function( event ) {
	event.preventDefault();
	  $.ajax({
	  type: "POST",
	  url: "<?php echo URLBASE;?>/data/tabelas",
	  data: $( this ).serialize(),
	  dataType: "json",
	  success: function(data){
		
		 new PNotify({
				title: "<?php echo $acttitle;?> ",
				type: ""+data.type+"",
				text: ""+data.message+"",
				styling: 'bootstrap3',
				hide: true
		  });
		  
		  <?php if($act=="ad"){?>
		  if(data.success==1){
			 $("#tabelasForm :input").prop('readonly', true);
			 $("#tabelasForm input, #tabelasForm button").attr('disabled',true);
		  }
		<?php } ?>
	  },
	  error: function(xhr, status, error) {    
		  new PNotify({
				title: "Ocorreu um Erro",
				type: "error",
				text: ""+xhr.responseText+"",
				styling: 'bootstrap3',
				hide: true
		  }); 
	}
	});
});	


	$('#naomovstk').on('ifChecked',function() {
		$('#stock').prop('disabled',true);		
		
	});
	$('#naomovstk').on('ifUnchecked', function(event){
		$('#stock').prop('disabled',false);
	});
	
<?php } } ?>	
});		</script>
