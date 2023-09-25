<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-information').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
		  
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
												
						<td class="text-left"><?php if ($sort == 'title') { ?>
							<a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'preview') { ?>
							<a href="<?php echo $sort_preview; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_preview; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_preview; ?>"><?php echo $column_preview; ?></a>
							<?php } ?>
						</td>
						<td class="text-left"><?php if ($sort == 'status') { ?>
							<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
							<?php } ?>
						</td>					
						<td class="text-right"><?php echo $column_action; ?></td>
					</tr>
				</thead>
					<?php if ($forms) { ?>
					<?php foreach ($forms as $form) { ?>
					<tr>
						<td class="text-center"><?php if (in_array($form['form_id'], $selected)) { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $form['form_id']; ?>" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $form['form_id']; ?>" />
							<?php } ?></td>
						
						<td class="text-left"><?php echo $form['title']; ?></td>
						<td class="text-left"><a target="_blank" href="<?php echo $form['preview']; ?>"><?php echo $form['preview']; ?></a></td>
						<td class="text-left"><?php echo $form['status']; ?></td>
						<td class="text-right">
						<!--/// new code 27 march 2020 // -->
							<a data-toggle="modal" rel1="<?php echo $form['title']; ?>" rel2="<?php echo $form['form_id']; ?>" data-target="#help-modal2" class="btn btn-success tmdhelptopic"><i class="fa fa-code"></i></a>
						<!--/// new code 27 march 2020 // -->
							<a href="<?php echo $form['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
							<a href="<?php echo $form['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-warning"><i class="fa fa-eye"></i></a>
							<a href="<?php echo $form['export']; ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Export"><i class="fa fa-download"></i></a>
						</td>
					</tr>
						<?php } ?> 
						<?php } else { ?>
					<tr>
						<td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
					</tr>
					<?php } ?>
            </table>
        </div>
    </form>
        <div class="row">
			<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          	<div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>
<!--/// new code 27 march 2020 // -->
<div class="modal modal-wide fade" id="help-modal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>  
 <script type="text/javascript">
  $(document).on('click','.tmdhelptopic',function(e) {
    html='';
    html+='<div class="modal-dialog">';
    html+=' <div class="modal-content">';
    html+='   <div class="modal-header">';
    html+='     <button type="button" class="close" data-dismiss="modal">&times;</button>';
    html+='     <h4 class="modal-title"><?php echo $text_copy; ?></h4>';
    html+='   </div>';
    html+='   <div class="modal-body"><button onclick="tmdCopy()" class="pull-right btn btn-primary copy"><i class="fa fa-copy"></i> Copy</button>';
    html+='     <p><textarea class="form-control" id="copy"><a data-toggle="modal" onclick="return tmdFormPopup('+$(this).attr('rel2')+')" data-target="#help-modal2" class="btn-primary btn-lg btn-block text-center">'+$(this).attr('rel1')+'</a></textarea></p>';
    html+='   </div>';
    html+='   <div class="modal-footer">';
    html+='     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    html+='   </div>';
    html+=' </div>';
    html+='</div>'
  $('#help-modal2').html('');
  $('#help-modal2').append(html);
});

function tmdCopy() {
  var copyText = document.getElementById("copy");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
}
 </script>
<style type="text/css">
  .modal.modal-wide .modal-dialog {
    width: 70%;
  }.copy {
    margin-bottom:2px;
  }
</style>
<!--/// new code 27 march 2020 // -->