 <?php if($act==""){ ?>
  <script src="<?php echo URLBASE;?>/vendors/iCheck/icheck.min.js"></script>
  <script src="<?php echo URLBASE;?>/vendors/fastclick/lib/fastclick.js"></script>
  <script src="<?php echo URLBASE;?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo URLBASE;?>/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
  <script src="<?php echo URLBASE;?>/vendors/autosize/dist/autosize.min.js"></script>
 <script>
$(document).ready(function() {  

$( "form" ).on( "submit", function( event ) {
  event.preventDefault();
  
  $.ajax({
  type: "POST",
  url: "<?php echo URLBASE;?>/data/settings",
  data: $( this ).serialize(),
  success: function(data){
	
	new PNotify({
		title: "Editar <?php echo $ptitle;?>",
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
  dataType: "json",
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

$(".prefs").select2({closeOnSelect:false});

});

</script>
<?php  } ?>