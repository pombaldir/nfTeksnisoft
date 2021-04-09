 
 <?php if($act=="ad"){ ?>
<script src="<?php echo URLBASE;?>/vendors/iCheck/icheck.min.js"></script>

 <!-- validator -->
<script src="<?php echo URLBASE;?>/vendors/validator/validator.js"></script>
<script type="text/javascript" src="<?php echo URLBASE;?>/build/js/forms.js"></script>
<script type="text/JavaScript" src="<?php echo URLBASE;?>/build/js/sha512.js"></script>


<script>
	
	$(document).ready(function(){
	"use strict";
		$("#submitbtn").click(function() {	
			event.preventDefault();
			if($('#password').val()!="" && $('#password2').val()!=""){
				if(regformhash(userform, document.getElementById("username"), document.getElementById("email"), document.getElementById("password"), document.getElementById("password2"))){
				$.ajax({
						type: "POST",
						url: "<?php echo URLBASE;?>/data/perfil",
  						data: $('#userform').serialize(),
						success: function(data){
							new PNotify({
							title: "Gestão de <?php echo $ptitle;?>",
							type: ""+data.type+"",
							text: ""+data.message+"",
							nonblock: {
							nonblock: true
							},
							styling: 'bootstrap3',
							hide: true
						}); 
						if(data.success==1){						
			 				$("#userform :input").prop('readonly', true);
						 	$("#userform input, #userform button").attr('disabled',true);						
						}
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
				return false;				
				}
  			}
		})
	});
	</script>

 

 <?php } if($act=="edit"){ ?>
<script src="<?php echo URLBASE;?>/vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/iCheck/icheck.min.js"></script>

 <script src="<?php echo URLBASE;?>/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
 <script src="<?php echo URLBASE;?>/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
 <script src="<?php echo URLBASE;?>/vendors/google-code-prettify/src/prettify.js"></script>
<!-- validator -->
<script src="<?php echo URLBASE;?>/vendors/validator/validator.js"></script>
<script type="text/javascript" src="<?php echo URLBASE;?>/build/js/forms.js"></script>
<script type="text/JavaScript" src="<?php echo URLBASE;?>/build/js/sha512.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<script>
$(document).ready(function() {  

$( "form" ).on( "submit", function( event ) {
  event.preventDefault();
  
  var validatorResult = validator.checkAll(this);

  if(validatorResult){

  if($('#password').val()!="" && $('#password2').val()!=""){
	  	formhashJQ(userform, document.getElementById("password"), document.getElementById("password2"));
  }	

  

  $.ajax({
  type: "POST",
  url: "<?php echo URLBASE;?>/data/perfil",
  data: $( this ).serialize(),
  success: function(data){
	
	new PNotify({
		title: "Formulário submetido",
		type: ""+data.type+"",
		text: ""+data.message+"",
		nonblock: {
		nonblock: true
		},
		addclass: 'dark',
		styling: 'bootstrap3',
		hide: true,
			  before_close: function(PNotify) {
				PNotify.update({
				  title: PNotify.options.title + " - Enjoy your Stay",
				  before_close: null
				});

				PNotify.queueRemove();

				return false;
			  }
	}); 
  },
  dataType: "json"
});

}
  
});





	 $('#elimina').click(function() {	 
	 event.preventDefault();
	 		bootbox.confirm("Deseja eliminar este utilizador?", function(result){
		  	if (result) {
			
			$.ajax({
				 type: "POST",
				 url: "<?php echo URLBASE;?>/data/perfil",
				 data: {"accaoP": "deleteUser", "idnum":"<?php echo $num;?>" },
				 dataType: "json",
				 success: function(data){	
					 new PNotify({
						title: "<?php echo $ptitle;?>",
						type: ""+data.type+"",
						text: ""+data.message+"",
						nonblock: {
						nonblock: true
						},
						addclass: 'dark',
						styling: 'bootstrap3',
						hide: true
					}); 
					
					$("button").prop('disabled','disabled');	
				}
			});	
			}
		});	
    });	
	









});	
</script>
<?php } ?>