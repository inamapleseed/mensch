<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-advancedreports" title="" class="btn btn-primary"><?php echo $button_save; ?></button>
        <a onclick="$('#action').val('save_stay');$('#form-advancedreports').submit();" title="" class="btn btn-info"><?php echo $button_save_stay; ?></a>
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
    <div class="slidebar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
     <?php if (isset($error_warning) && $error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
     <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-th-large"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-advancedreports" class="form-horizontal">
        <input type="hidden" name="action" id="action" value=""/>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-chart_width"><span data-toggle="tooltip" title="<?php echo $language->get("entry_margin_profit_help"); ?>"><?php echo $language->get("entry_margin_profit"); ?></span></label>
            <div class="col-sm-10">
              <input type="text" size="20" name="ecadvancedreports_margin_profit" value="<?php echo isset($ecadvancedreports_margin_profit)?$ecadvancedreports_margin_profit:0;?>" id="input-chart_width" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-chart_width"><span data-toggle="tooltip" title="<?php echo $language->get("entry_chart_width_help"); ?>"><?php echo $language->get("entry_chart_width"); ?></span></label>
            <div class="col-sm-10">
              <input type="text" size="20" name="ecadvancedreports_chart_width" value="<?php echo isset($ecadvancedreports_chart_width)?$ecadvancedreports_chart_width:600;?>" id="input-chart_width" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-chart_height"><span data-toggle="tooltip" title="<?php echo $language->get("entry_chart_height_help"); ?>"><?php echo $language->get("entry_chart_height"); ?></span></label>
            <div class="col-sm-10">
              <input type="text" size="20" name="ecadvancedreports_chart_height" value="<?php echo isset($ecadvancedreports_chart_height)?$ecadvancedreports_chart_height:400;?>" id="input-chart_height" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-chart_color"><span data-toggle="tooltip" title="<?php echo $language->get("entry_chart_color_help"); ?>"><?php echo $language->get("entry_chart_color"); ?></span></label>
            <div class="col-sm-10">
              <input type="text" size="20" class="color" name="ecadvancedreports_chart_color" value="<?php echo isset($ecadvancedreports_chart_color)?$ecadvancedreports_chart_color:'f39c12';?>" id="input-chart_color" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><span data-toggle="tooltip" title="<?php echo $language->get("entry_report_limit_help"); ?>"><?php echo $language->get("entry_report_limit"); ?></span></label>
            <div class="col-sm-10">
              <input type="text" size="20" name="ecadvancedreports_limit" value="<?php echo isset($ecadvancedreports_limit)?$ecadvancedreports_limit:100;?>" id="input-limit" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-number_lowstock"><span data-toggle="tooltip" title="<?php echo $language->get("entry_number_lowstock_help"); ?>"><?php echo $language->get("entry_number_lowstock"); ?></span></label>
            <div class="col-sm-10">
              <input type="text" size="20" name="ecadvancedreports_number_lowstock" value="<?php echo isset($ecadvancedreports_number_lowstock)?$ecadvancedreports_number_lowstock:10;?>" id="input-number_lowstock" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-paper"><span data-toggle="tooltip" title="<?php echo $language->get("entry_export_pdf_paper_help"); ?>"><?php echo $language->get("entry_export_pdf_paper"); ?></span></label>
            <div class="col-sm-10">
              <select name="ecadvancedreports_paper" id="input-paper" class="form-control">
                    <?php
                      if(!empty($papers)){
                        foreach($papers as $key=>$val){
                          if(isset($ecadvancedreports_paper) && $key == $ecadvancedreports_paper){
                          ?>
                          <option value="<?php echo $key; ?>" selected="selected"><?php echo $val;?></option>
                          <?php
                          }else{
                             ?>
                          <option value="<?php echo $key; ?>"><?php echo $val;?></option>
                          <?php
                          }
                        }
                      }
                    ?>
                  </select>
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-orientation"><span data-toggle="tooltip" title="<?php echo $language->get("entry_export_pdf_orientation_help"); ?>"><?php echo $language->get("entry_export_pdf_orientation"); ?></span></label>
            <div class="col-sm-10">
              <select name="ecadvancedreports_orientation" id="input-orientation" class="form-control">
                    <?php
                      if(!empty($orientations)){
                        foreach($orientations as $key=>$val){
                          if(isset($ecadvancedreports_orientation) && $key == $ecadvancedreports_orientation){
                          ?>
                          <option value="<?php echo $key; ?>" selected="selected"><?php echo $val;?></option>
                          <?php
                          }else{
                             ?>
                          <option value="<?php echo $key; ?>"><?php echo $val;?></option>
                          <?php
                          }
                        }
                      }
                    ?>
                  </select>
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-enable_sales_tab"><span data-toggle="tooltip" title="<?php echo $language->get("entry_enable_product_sales_tab_help"); ?>"><?php echo $language->get("entry_enable_product_sales_tab"); ?></span></label>
            <div class="col-sm-10">
              <select name="ecadvancedreports_enable_sales_tab" id="input-enable_sales_tab" class="form-control">
                     <?php
                      if(!empty($yesno)){
                        foreach($yesno as $key=>$val){
                          if(isset($ecadvancedreports_enable_sales_tab) && $key == $ecadvancedreports_enable_sales_tab){
                          ?>
                          <option value="<?php echo $key; ?>" selected="selected"><?php echo $val;?></option>
                          <?php
                          }else{
                             ?>
                          <option value="<?php echo $key; ?>"><?php echo $val;?></option>
                          <?php
                          }
                        }
                      }
                    ?>
                  </select>
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-export_all"><span data-toggle="tooltip" title="<?php echo $language->get("entry_export_all_help"); ?>"><?php echo $language->get("entry_export_all"); ?></span></label>
            <div class="col-sm-10">
              <select name="ecadvancedreports_export_all" id="input-export_all" class="form-control">
                     <?php
                      if(!empty($yesno)){
                        foreach($yesno as $key=>$val){
                          if(isset($ecadvancedreports_export_all) && $key == $ecadvancedreports_export_all){
                          ?>
                          <option value="<?php echo $key; ?>" selected="selected"><?php echo $val;?></option>
                          <?php
                          }else{
                             ?>
                          <option value="<?php echo $key; ?>"><?php echo $val;?></option>
                          <?php
                          }
                        }
                      }
                    ?>
                  </select>
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-enable_caching"><span data-toggle="tooltip" title="<?php echo $language->get("entry_enable_caching_help"); ?>"><?php echo $language->get("entry_enable_caching"); ?></span></label>
            <div class="col-sm-10">
              <select name="ecadvancedreports_enable_caching" id="input-enable_caching" class="form-control">
                    <?php
                    if(!empty($yesno)){
                      foreach($yesno as $key=>$val){
                        if(isset($ecadvancedreports_enable_caching) && $key == $ecadvancedreports_enable_caching){
                        ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $val;?></option>
                        <?php
                        }else{
                           ?>
                        <option value="<?php echo $key; ?>"><?php echo $val;?></option>
                        <?php
                        }
                      }
                    }
                  ?>
                  </select>
              
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2 control-label"></div>
            <div class="col-sm-10">
             <a href="<?php echo $clean_cache_link; ?>" class="button btn btn-danger clean_cache"><i class="fa fa-minus-circle"></i>&nbsp;<?php echo $language->get("button_clean_cache");?></a>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript"><!--
jscolor.install(true);
//--></script> 
<?php echo $footer; ?>