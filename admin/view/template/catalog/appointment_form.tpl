<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" onclick="$('#form-appointment').submit();"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-appointment" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-event"><?php echo $entry_event; ?></label>
            <div class="col-sm-10">
              <select name="event" id="input-event" class="form-control">
                <option value=""><?= $text_event; ?></option>
                <?php foreach($calendar_events as $calendar_event) { ?>
                  <?php if ($calendar_event['cevent_id'] == $event) { ?>
                    <option value="<?= $calendar_event['cevent_id']; ?>" selected="selected"><?= $calendar_event['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?= $calendar_event['cevent_id']; ?>"><?= $calendar_event['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_event) { ?>
                <div class="text-danger"><?php echo $error_event; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-date"><?php echo $entry_date; ?></label>
            <div class="col-sm-10">
              <div class="input-group date">
                <input type="text" name="date" value="<?php echo $date; ?>" data-date-format="YYYY-MM-DD" placeholder="<?php echo $entry_date; ?>" class="form-control" />
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
              <?php if ($error_date) { ?>
                <div class="text-danger"><?php echo $error_date; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-time"><?php echo $entry_time; ?></label>
            <div class="col-sm-10">
              <div class="input-group time">
                <input type="text" name="time" value="<?php echo $time; ?>" data-date-format="HH:00" placeholder="<?php echo $entry_time; ?>" class="form-control" />
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
              <?php if ($error_time) { ?>
                <div class="text-danger"><?php echo $error_time; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-contact"><?php echo $entry_contact; ?></label>
            <div class="col-sm-10">
              <input type="text" name="contact" value="<?php echo $contact; ?>" placeholder="<?php echo $entry_contact; ?>" id="input-contact" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-outlet"><?php echo $entry_outlet; ?></label>
            <div class="col-sm-10">
              <input type="text" name="outlet" value="<?php echo $outlet; ?>" placeholder="<?php echo $entry_outlet; ?>" id="input-outlet" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
            <div class="col-sm-10">
              <textarea type="text" name="message" placeholder="<?php echo $entry_message; ?>" id="input-message" rows="5" class="form-control"><?php echo $message; ?></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.date').datetimepicker({
    language: 'en-gb',
    pickTime: false,
    pickDate: true,
  });
  $('.time').datetimepicker({
    language: 'en-gb',
    pickTime: true,
    pickDate: false,
  });
</script>
<?php echo $footer; ?>