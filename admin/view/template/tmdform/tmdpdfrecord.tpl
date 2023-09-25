<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style>
		body { font-family: DejaVu Sans, sans-serif; }
	</style>
	</head>
	<body>
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
						  <td class="text-left"> <?php echo $title; ?></td>
						</tr>
						<tr>
						  <td class="text-left"> <?php echo $sname; ?></td>
						</tr>
						<tr>
						  <td class="text-left"> <?php echo $lname; ?></td>
						</tr>
						<tr>
						  <td class="text-left"><?php echo $date_added; ?></td>
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
							<td class="text-left"> <?php echo $customer_name; ?></td>
							<?php } else { ?>
							<td class="text-left"> Guest</td>
							<?php } ?>
						</tr>
						<tr>
						  <td class="text-left"> <?php echo $ip; ?></td>
						</tr>
						<tr>
						  <td class="text-left"> <?php echo $user_agent; ?>...</td>
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
	</body>
</html>
