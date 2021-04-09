
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/bootstrap-multiselect/dist/css/bootstrap-multiselect.css">
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/select2/dist/css/select2.min.css">
<link href="<?php echo URLBASE;?>/vendors/ekko-lightbox/dist/ekko-lightbox.css" rel="stylesheet">

<style>
td.details-control {
    background: url('<?php echo URLBASE;?>/build/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('<?php echo URLBASE;?>/build/images/details_close.png') no-repeat center center;
}
</style>    


<?php if($act=="ad"){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/jQuery-Smart-Wizard/styles/demo_style.css">
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/jQuery-Smart-Wizard/styles/smart_wizard.css">
<!-- bootstrap-datetimepicker -->
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">



 <style>
 

.autocomplete-suggestions { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-no-suggestion { padding: 2px 5px;}
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: bold; color: #000; }
.autocomplete-group { padding: 2px 5px; font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }

</style>
<?php }   if($act=="view"){ ?>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/blueimp-file-upload/css/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo URLBASE;?>/vendors/blueimp-file-upload/css/jquery.fileupload-ui.css">

 <!-- iCheck -->
<link href="<?php echo URLBASE;?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<style>
.top_profiles{
	height:auto !important;
}
</style>


<?php }  ?>
