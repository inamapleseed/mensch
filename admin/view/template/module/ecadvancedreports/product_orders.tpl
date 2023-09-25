<div id="tab-product-orders" class="tab-pane">
    <div class="table-responsive">
        <table class="list list-reports table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-left"><?php echo $column_order; ?></td>
                <td class="text-center"><?php echo $column_purchase_on; ?></td>
                <td class="text-right"><?php echo $column_order_status; ?></td>
                <td class="text-right"><?php echo $column_bill_to_name; ?></td>
                <td class="text-right"><?php echo $column_ship_to_name; ?></td>
                <td class="text-right"><?php echo $column_quantity; ?></td>
                <td class="text-right"><?php echo $column_total; ?></td>
                <td class="text-right"><?php echo $column_reward; ?></td>
            </tr>
            </thead>
            <tfoot>
                <?php foreach ($reports as $report) { ?>
                <tr>
                    <td class="text-left"><a href="<?php echo $report['order_link'];?>" target="_BLANK">#<?php echo $report['order_id']; ?></a></td>
                    <td class="text-left"><?php echo $report['date_added']; ?></td>
                    <td class="text-center"><?php echo $report['order_status']; ?></td>
                    <td class="text-left"><?php echo $report['payment_name']; ?></td>
                    <td class="left"><?php echo $report['shipping_name']; ?></td>
                    <td class="text-right"><?php echo $report['quantity']; ?></td>
                    <td class="text-right"><?php echo $report['total']; ?></td>
                    <td class="text-right"><?php echo $report['reward']; ?></td>
                <?php } ?>
            </tfoot>
        </table>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
</div>