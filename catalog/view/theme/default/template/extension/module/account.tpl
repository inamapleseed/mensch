
<div class="account-container col-sm-4">
  <button id="account_tigger_close" class="btn btn-danger fixed position-right-top visible-sm visible-xs" onclick="$('.account-container').removeClass('open');">
    <i class="fa fa-times"></i>
  </button>
  <div class="user_info">
    <span>Hi,</span>
    <h4 class="account-sub-heading" ><?= $customer_firstname." ".$customer_lastname; ?></h4>
    
    <span class="icon-font icon-profile"><?= substr($customer_firstname,0,1)." ".mb_substr($customer_lastname,0,1); ?></span>
  </div>

  <a class="profile <?php if($route == "account/edit"){echo "active"; } ?>"  href="<?php echo $edit; ?>">
    <h4 class="account-sub-heading" ><?= $update_my_profile; ?></h4>
    <p><?= $access_your_account_details; ?></p>
    <span class="icon-font icon-profile"></span>
  </a>
  <a class="password <?php if($route == "account/password"){echo "active"; } ?>" href="<?php echo $password; ?>">
    <h4 class="account-sub-heading" ><?= $update_my_password; ?></h4>
    <p><?= $keeps_your_security_accesses_in_check; ?></p>
    <span class="icon-font icon-updatePassword"></span>
  </a>
  <a class="order <?php if($route == "account/order" || $route == "account/order/info"){echo "active"; } ?>" href="<?php echo $order; ?>">
    <h4 class="account-sub-heading" ><?= $my_order_history; ?></h4>
    <p><?= $keeps_track_of_your_orders; ?></p>
    <span class="icon-font icon-history"></span>
  </a>
  <?php /* ?>
  <a class="enquiry"  href="<?php echo $enquiry; ?>">
    <h4 class="account-sub-heading" ><?= $my_enquiry_history; ?></h4>
    <p><?= $keeps_track_of_your_enqueries; ?></p>
    <span class="icon-font icon-history"></span>
  </a>
  <?php */ ?>
  <a class="address <?php if($route == "account/address" || $route == "account/address/edit"){echo "active"; } ?>" href="<?php echo $address; ?>">
    <h4 class="account-sub-heading" ><?= $my_address_book; ?></h4>
    <p><?= $keeps_track_of_your_addresses; ?></p>
    <span class="icon-font icon-addressbook"></span>
  </a>
  <?php if($reward) { ?>
  <a class="reward <?php if($route == "account/reward"){echo "active"; } ?>" href="<?php echo $reward; ?>">
    <h4 class="account-sub-heading" ><?= $my_reward_points; ?></h4>
    <p><?= $keeps_track_of_your_reward_points; ?></p>
    <span class="icon-font icon-history"></span>
  </a>
  <?php } ?>

  <?php // for omise cc ?>
  <?php if($omise) { ?>
  <a class="omise <?php if($route == "account/omise"){echo "active"; } ?>" href="<?php echo $omise; ?>">
    <h4 class="account-sub-heading" ><?= $my_credit_card; ?></h4>
    <p><?= $keeps_track_of_credit_card; ?></p>
    <span class="icon-font icon-history"></span>
  </a>
  <?php } ?>
  <?php // for omise cc ?>

  
  <?php /* completecombo */ ?>
  <?php if(isset($salescombopge_info) && !empty($salescombopge_info)) { ?>
    <h2><?php echo $text_salescombopge_heading; ?></h2>
    <ul class="list-unstyled">
    <?php foreach ($salescombopge_info as $key => $value) { ?>
      <li><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a></li>
    <?php } ?>
    </ul>
  <?php } ?>
  <?php /* completecombo */ ?>
  
  <?php if($membership) { ?>
  <a class="membership <?php if($route == "account/password"){echo "active"; } ?>" href="<?php echo $membership; ?>">
    <h3 class="account-sub-heading" ><?= $my_membership_records; ?></h3>
    <p><?= $keeps_track_of_your_membership_records; ?></p>
    <span class="icon-font icon-history"></span>
  </a>
  <?php } ?>
</div>
<button id="account_tigger_open" class="btn btn-primary" onclick="$('.account-container').addClass('open');">Account</button>