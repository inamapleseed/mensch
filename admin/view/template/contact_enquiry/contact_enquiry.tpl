<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <!--<div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>-->
        <!--<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-customer').submit() : false;"><i class="fa fa-trash-o"></i></button>-->
      <!--</div>-->
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
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-contact_name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_contact_name" value="<?php echo $filter_contact_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-contact_name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-contact_message"><?php echo "Message"; ?></label>
                <input type="text" name="filter_contact_message" value="<?php echo $filter_contact_message; ?>" placeholder="<?php echo "Message"; ?>" id="input-contact_message" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-contact_phone"><?php echo "Phone"; ?></label>
                <input type="text" name="filter_contact_phone" value="<?php echo $filter_contact_phone; ?>" placeholder="<?php echo "Phone"; ?>" id="input-contact_phone" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-contact_status"><?php echo "Status"; ?></label>
                <select name="filter_contact_status" id="input-contact_status" class="form-control">
                    <option value=''>Select One</option>
                    <option value="0" <?php if($filter_contact_status == "0"){echo "SELECTED";}?> >Pending</option>
                    <option value="1" <?php if($filter_contact_status == "1"){echo "SELECTED";}?> >Complete</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-contact_email"><?php echo "Email"; ?></label>
                <input type="text" name="filter_contact_email" value="<?php echo $filter_contact_email; ?>" placeholder="<?php echo "Email"; ?>" id="input-contact_email" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-contact_date"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_contact_date" value="<?php echo $filter_contact_date; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-contact_date" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                  <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-customer">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <!--<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>-->
                  <td class="text-left">No.</td>
                  <td class="text-left">
                        <?php if ($sort == 'contact_name') { ?>
                            <a href="<?php echo $sort_contact_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo "Name"; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $sort_contact_name; ?>"><?php echo "Name"; ?></a>
                        <?php } ?>
                  </td>
                  <td class="text-left">
                        <?php if ($sort == 'contact_phone') { ?>
                            <a href="<?php echo $sort_contact_phone; ?>" class="<?php echo strtolower($order); ?>"><?php echo "Phone"; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $sort_contact_phone; ?>"><?php echo "Phone"; ?></a>
                        <?php } ?>
                  </td>
                  <td class="text-left">
                        <?php if ($sort == 'contact_email') { ?>
                            <a href="<?php echo $sort_contact_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo "Email"; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $sort_contact_email; ?>"><?php echo "Email"; ?></a>
                        <?php } ?>
                  </td>
                  <td class="text-left">
                      Message
                  </td>
                  <td class="text-left">
                        <?php if ($sort == 'contact_date') { ?>
                            <a href="<?php echo $sort_contact_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $sort_contact_date; ?>"><?php echo $column_date_added; ?></a>
                        <?php } ?>
                  </td>
                  <td class="text-left">
                        <?php if ($sort == 'contact_status') { ?>
                            <a href="<?php echo $sort_contact_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo "Status"; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $sort_contact_status; ?>"><?php echo "Status"; ?></a>
                        <?php } ?>
                  </td>
                </tr>
              </thead>
              <tbody>
                <?php if ($enquirys) { $i=1;?>
                    <?php foreach ($enquirys as $enquiry){ ?>
                    <tr>
                    <td><?= $i; ?></td>
                    <td class="text-left"><?php echo $enquiry['contact_name']; ?></td>
                    <td class="text-left"><?php echo $enquiry['contact_phone']; ?></td>
                    <td class="text-left"><?php echo $enquiry['contact_email']; ?></td>
                    <td class="text-left">
                        <?php echo "Subject: ". $enquiry['contact_subject']."<br>Message:<br>".nl2br($enquiry['contact_message']); ?>
                    </td>
                    <td class="text-left"><?php echo $enquiry['contact_date']; ?></td>
                    <td class="text-left">
                        <select class="form-control change_status" data-id="<?= $enquiry['contact_id']; ?>">
                            <option value="0" <?php if($enquiry['contact_status'] == 0){echo "SELECTED";} ?>>Pending</option>
                            <option value="1" <?php if($enquiry['contact_status'] == 1){echo "SELECTED";} ?>>Completed</option>
                        </select>
                    </td>
                    </tr>
                    <?php $i++;
                    } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
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
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=contact_enquiry/contact_enquiry&token=<?php echo $token; ?>';
	
	var filter_contact_name = $('input[name=\'filter_contact_name\']').val();
	
	if (filter_contact_name) {
		url += '&filter_contact_name=' + encodeURIComponent(filter_contact_name);
	}
	
	var filter_contact_phone = $('input[name=\'filter_contact_phone\']').val();
	
	if (filter_contact_phone) {
		url += '&filter_contact_phone=' + encodeURIComponent(filter_contact_phone);
	}
	
	var filter_contact_email = $('input[name=\'filter_contact_email\']').val();
	
	if (filter_contact_email) {
		url += '&filter_contact_email=' + encodeURIComponent(filter_contact_email);
	}
	
	var filter_contact_message = $('input[name=\'filter_contact_message\']').val();
	
	if (filter_contact_message) {
		url += '&filter_contact_message=' + encodeURIComponent(filter_contact_message);
	}
	
	var filter_contact_date = $('input[name=\'filter_contact_date\']').val();
	
	if (filter_contact_date) {
		url += '&filter_contact_date=' + encodeURIComponent(filter_contact_date);
	}
	
	var filter_contact_status = $('select[name=\'filter_contact_status\']').val();
	
	if (filter_contact_status) {
		url += '&filter_contact_status=' + encodeURIComponent(filter_contact_status);
	}
	
	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_contact_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=contact_enquiry/contact_enquiry/autocomplete&token=<?php echo $token; ?>&filter_contact_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['contact_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_contact_name\']').val(item['label']);
	}	
});

$('input[name=\'filter_contact_phone\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=contact_enquiry/contact_enquiry/autocomplete&token=<?php echo $token; ?>&filter_contact_phone=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['phone'],
						value: item['contact_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_contact_phone\']').val(item['label']);
	}	
});

$('input[name=\'filter_contact_email\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=contact_enquiry/contact_enquiry/autocomplete&token=<?php echo $token; ?>&filter_contact_email=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['email'],
						value: item['contact_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_contact_email\']').val(item['label']);
	}	
});

$('.change_status').on("change",function(){
    var r = confirm("Are you sure want to change status!");
    if (r == true) {
        $.ajax({
                url: 'index.php?route=contact_enquiry/contact_enquiry/changeStatus&token=<?php echo $token; ?>&contact_status=' +  $(this).val() + '&contact_id=' + $(this).data('id'),
                dataType: 'json',
                success: function(json) {
                    if(json['status'] == 1){
                        alert("Update Successful");
                    }
                }
        });
    }
});

$('input[name=\'filter_contact_email\']').autocomplete({
});

//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?> 
