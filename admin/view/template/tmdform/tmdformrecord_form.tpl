<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $pdfgenrate; ?>" data-toggle="tooltip" title="<?php echo $button_pdf; ?>" class="btn btn-default"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
		<form action="" method="post" enctype="multipart/form-data" id="form-tmdformrecord" class="form-horizontal">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-file" aria-hidden="true"></i> <?php echo $text_detail; ?></h3>
				  </div>
				  <div class="table-responsive">
					<table class="table">
					  <tbody>
						<tr>
						  <td class="text-left"><span class="btn btn-primary"><i class="fa fa-file"></i></span>&nbsp;  <?php echo $title; ?></td>
						</tr>
						<tr>
						  <td class="text-left"><span class="btn btn-primary"><i class="fa fa-sitemap"></i></span>&nbsp;  <?php echo $sname; ?></td>
						</tr>
						<tr>
						  <td class="text-left"><span class="btn btn-primary"><i class="fa fa-globe"></i></span>&nbsp;  <?php echo $lname; ?></td>
						</tr>
						<tr>
						  <td class="text-left"><span class="btn btn-primary"><i class="fa fa-calendar"></i></span>&nbsp; <?php echo $date_added; ?></td>
						</tr>
					  </tbody>
					</table>
				  </div>
				</div>		
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $text_custdetail; ?></h3>
				  </div>
				  <div class="table-responsive">
					<table class="table">
					  <tbody>
						<tr>
							<?php if($customer_name) { ?>
							<td class="text-left"><span class="btn btn-primary"><i class="fa fa-user"></i></span>&nbsp;  <?php echo $customer_name; ?></td>
							<?php } else { ?>
							<td class="text-left"><span class="btn btn-primary"><i class="fa fa-user"></i></span>&nbsp;  Guest</td>
							<?php } ?>
						</tr>
						<tr>
						  <td class="text-left"><span class="btn btn-primary"><i class="fa fa-desktop"></i></span>&nbsp;  <?php echo $ip; ?></td>
						</tr>
						<tr>
						  <td class="text-left"><span class="btn btn-primary"><i class="fa fa-life-ring" aria-hidden="true"></i></span>&nbsp;  <?php echo $user_agent; ?>...</td>
						</tr>
					  </tbody>
					</table>
				  </div>
				</div>		
			</div>		
		</div>
		<div class="row fields">
			<div class="col-sm-12">
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_fields; ?></h3>
				  </div>
				  <div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td class="text-left" style="width:25%;"><?php echo $entry_fieldname; ?></td>
								<td class="text-left"><?php echo $entry_fieldvalue; ?></td>
							</tr>
						</thead>
						<?php foreach ($field_infos as $fieldinfo) { ?>
						<tbody>
							<tr>
							  <td class="text-left"><label><?php echo $fieldinfo['label'];?></label></td>
							  <td class="text-left"><?php echo $fieldinfo['value'];?></td>
							</tr>
						</tbody>
					 <?php	} ?>
					</table>
				  </div>
				</div>		
			</div>	
		</div>		
		</form>
	</div>
</div>
<?php echo $footer; ?>
<style>
.table td a span{
	margin-right:5px;
}
.table td a{
	color:#333;
}
.panel > .table-responsive > .table-bordered{
	border:1px solid #dddddd;
}
.fields .table-responsive{
	padding:15px !important;
}
</style>
