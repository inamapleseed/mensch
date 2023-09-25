<?= $header; ?>
<div class="container">
  <?= $content_top; ?>
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success">
  <button type="button" class="close pull-right" data-dismiss="alert">&times;</button>
  <i class="fa fa-check-circle"></i> <?= $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger">
  <button type="button" class="close pull-right" data-dismiss="alert">&times;</button>
  <i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?></div>
  <?php } ?>
  <div class="row">
    <div id="content" class="col-sm-12">
      <h2><?= $heading_title; ?></h2>
      <div class="login-container">
        <div class="login-header flex">
          <div class="flex-1 text-uppercase">
            <a href="<?=$register;?>" class="btn register-button btn-theme-color">
              <?=$text_new_customer;?>
            </a>
         </div>
          <div class="login-button flex-1 text-uppercase">
            <a href="<?=$action;?>" class="btn <?=$login_page?'active':''?> register-button btn-theme-color">
             <?=$text_login;?>
            </a>
          </div>
        </div>
 
        <div class="login-form-wrapper">
          <div class="m-b text-center">
            <h4><?=$text_sign_in_with_email;?></h4>
          </div>
          <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
              <label class="control-label"><strong><?= $entry_email; ?></strong>:</label>
              <input type="text" name="email" value="<?= $email; ?>" placeholder="" id="input-email" class="form-control" />
            </div>
  
            <div class="form-group">
              <label class="control-label"><strong><?= $entry_password; ?></strong>:</label>
              <input type="password" name="password" value="<?= $password; ?>" placeholder="" id="input-password" class="form-control" />
              <div class="login-forgotten text-center" >
                <?= $forgotten; ?><br>
                <?= $text_no_account; ?> <?=$text_register_now?>
              </div>
            </div>
            <div class='text-center'>
              <input type="submit" value="<?= $button_login; ?>" class="fullwidth-btn btn btn-primary" />
            </div>
              <?php if ($redirect) { ?>
                <input type="hidden" name="redirect" value="<?= $redirect; ?>" />
              <?php } ?>
          </form>
          <?= $column_left; ?>
        </div>

      </div>
    </div>
    <?= $column_right; ?></div>
    <?= $content_bottom; ?>
</div>
<?= $footer; ?>