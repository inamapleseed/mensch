<div style="width:860px;background: #f5f5f5;margin:0 auto;border:1px solid #ddd;padding: 15px 0;min-height: 415px;font-family: arial;">
  <div style="width:47%;padding: 0 15px;display: inline-block;float: left;">
	<div style="border: 1px solid #e8e8e8;margin-bottom: 17px;background-color: #fff;">
        <div style="padding:10px 15px;">
         <h3 style="font-size: 16px;margin:0;"><?php echo $text_detail; ?></h3>
		</div>
        <table style="width:100%">
          <tbody>
			<tr>
              <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"><?php echo $title; ?></a></td>
            </tr>
            <tr>
			  <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"><?php echo $sname; ?></a></td>
			</tr>
			<tr>
			  <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"><?php echo $lname; ?></a></td>
			</tr>
			<tr>
			  <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"> <?php echo $date_added; ?></a></td>
			</tr>
		  </tbody>
		</table>
      </div>
	</div>
    <div style="float: left;width:46%;padding: 0 15px;">
	<div style="border: 1px solid #e8e8e8;margin-bottom: 17px;background-color: #fff;">
        <div style="padding:10px 15px;">
         <h3 style="font-size: 16px;margin:0;"><?php echo $text_custdetail; ?></h3>
		</div>
        <table style="width:100%">
          <tbody>
			<tr>
              <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"><?php echo $customer_name; ?></a></td>
            </tr>
            <tr>
			  <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"><?php echo $ip; ?></a></td>
			</tr>
			<tr>
			  <td class="text-left" style="padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #ddd;"><a style="text-decoration: none;font-size: 12px;color: #333;"><?php echo $user_agent; ?>...</a></td>
			</tr>
		  </tbody>
		</table>
      </div>
	</div>
    <div style="clear:both;padding: 0 15px;">
      <div style="border: 1px solid #e8e8e8;margin-bottom: 17px;background-color: #fff;">
		<div style="padding: 10px 15px;">
          <h3 style="margin:0;font-size: 16px;color:#595959;"><?php echo $text_fields; ?></h3>
		</div>
		<div style="padding: 15px;">
		  <table style="border: 1px solid #dddddd;width: 100%;border-spacing: 0;">
            <thead>
			  <tr>
				<td style="width:25%;vertical-align: middle;border-right: 1px solid #ddd;padding: 8px;"><?php echo $entry_fieldname; ?></td>
				<td style="width:25%;vertical-align: middle;padding: 8px;"><?php echo $entry_fieldvalue; ?></td>
              </tr>
			 </thead>
			<?php foreach ($field_infos as $fieldinfo) { ?>
			<tbody>
			  <tr>
				<td style="width:25%;vertical-align: middle;border-top:1px solid #ddd;border-right: 1px solid #ddd;padding: 8px;line-height: 1.42857;padding: 8px;"><?php echo $fieldinfo['label'];?></td>
                    <td style="width:25%;vertical-align: middle;border-top:1px solid #ddd;padding: 8px;line-height: 1.42857;"><?php echo $fieldinfo['value'];?></td>
             </tr>
			</tbody>
		   <?php	} ?>
		</table>
	  </div>
	</div>		
  </div>
</div> 

				
	
		