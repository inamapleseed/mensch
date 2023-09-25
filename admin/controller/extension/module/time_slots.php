<?php
class ControllerExtensionModuleTimeSlots extends Controller {
	public function index() {
        // Do note that below are the sample for using module helper, you may use it in other modules

        
        // Shipping
        $files = glob(DIR_APPLICATION . 'controller/extension/shipping/*.php');
        
        $shippings = array();
        $l = 0;
        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');
                
                if ($this->config->get($extension . '_status')) {
                    $this->load->language('extension/shipping/' . $extension);

                    $name = $this->language->get('heading_title');
                    $result = array();
                    
                    if($extension == "flat_cost"){
                        $shipping_row = $this->db->query("SELECT * FROM ".DB_PREFIX."setting WHERE `code` = '" . $extension . "' AND `key` = 'flat_cost'");
                        $result[] = $name." ".$shipping_row->row['shipping_row'];
                    }else if($extension == "category_product_based"){
                        $shipping_row = $this->db->query("SELECT * FROM ".DB_PREFIX."setting WHERE code = '" . $extension . "' AND `key` LIKE '%category_product_based_charge_%' AND `key` LIKE '%_title_admin%'");
                        foreach($shipping_row->rows as $row){
                            $result[] = $row['value'];
                        }
                    }else if($extension == "formula_based"){
                        $shipping_row = $this->db->query("SELECT * FROM ".DB_PREFIX."setting WHERE `code` = 'complex' AND `key` LIKE '%complex_charge_%' AND `key` LIKE '%_title_admin%'");
                        foreach($shipping_row->rows as $row){
                            $result[] = $row['value'];
                        }
                    }else{
                        $result[] = $name;
                    }

                    $shippings[$l]['extension'] = $extension;
                    $shippings[$l]['title'] = $name;
                    $shippings[$l]['result'] = $result;
                    $l++;
                }
            }
        }

        $language_id = $this->config->get('config_language_id');
        
        $module_field = array();
        //$module_field[] = array('type' => 'text', 'label' => 'Min Days', 'name' => 'min_advance');
        //$module_field[] = array('type' => 'text', 'label' => 'Maximun Advance Days', 'name' => 'max_advance');



        //Field Setting and disabled setting
        $disabled_method = array();
        $disabled_method[] = array("value" => "all", 'label' => "All");

        foreach($shippings as $shipping){
            if($shipping['extension'] != "lalamove"){
                foreach($shipping['result'] as $method){
                    //$disabled_method[] = array('value' => $method, 'label' => $method);
                    if($method == "Pickup From Store"){
                        $disabled_method[] = array('value' => "pickup.pickup", 'label' => $method);
                    }else if($method == "Flat Rate"){
                        $disabled_method[] = array('value' => "flat.flat", 'label' => $method); 
                    }else if($method == "Ninja Van Shipping"){
                        $disabled_method[] = array('value' => "ninja_van.ninja_van", 'label' => $method); 
                    }else{
                        $disabled_method[] = array('value' => $method, 'label' => $method);
                    }
                }
            }
        }

        $select_option = array();
        $select_option[] = array("value" => "1", 'label' => "Enabled");
        $select_option[] = array("value" => "2", 'label' => "Disabled");
        $module_field[] = array('type' => 'repeater', 'label' => "Field Validate Setting", 'name' => "date_setting", 
            'fields' => array(
                array('type' => 'dropdown', 'label' => 'Methods', 'name' => 'method','choices' => $disabled_method),
                array('type' => 'dropdown', 'label' => 'Delivery Date', 'name' => 'delivery_date', 'choices' => $select_option),
                array('type' => 'dropdown', 'label' => 'Date Required', 'name' => 'delivery_date_required', 'choices' => $select_option),
                array('type' => 'dropdown', 'label' => 'Delivery Time', 'name' => 'delivery_time', 'choices' => $select_option),
                array('type' => 'dropdown', 'label' => 'Time Required', 'name' => 'delivery_time_required', 'choices' => $select_option),
            ),
        );


        //shipping method date setting
        foreach($shippings as $shipping){
            if($shipping['extension'] != "lalamove"){
                $methods = array();
                foreach($shipping['result'] as $method){
                    //debug($shipping);
                    if($method == "Pickup From Store"){
                        $methods[] = array('value' => "pickup.pickup", 'label' => $method);
                    }else if($method == "Flat Rate"){
                        $methods[] = array('value' => "flat.flat", 'label' => $method); 
                    }else if($method == "Ninja Van Shipping"){
                        $methods[] = array('value' => "ninja_van.ninja_van", 'label' => $method); 
                    }else{
                        $methods[] = array('value' => $method, 'label' => $method);
                    }
                }
                
                $module_field[] = array('type' => 'repeater', 'label' => $shipping['title'], 'name' => $shipping['extension'], 
                    'fields' => array(
                        array('type' => 'dropdown', 'label' => 'Methods', 'name' => 'method','choices' => $methods),
                        array('type' => 'text', 'label' => 'Delivery Times', 'name' => 'delivery_times'),
                        array('type' => 'text', 'label' => 'Cut off time (eg:12:00:00)', 'name' => 'cut_off_time'),
                        array('type' => 'text', 'label' => 'Sort Order', 'name' => 'sort_order'),
                        array('type' => 'text', 'label' => 'Surcharge (eg:5)', 'name' => 'surcharge'),
                        array('type' => 'text', 'label' => 'Block Day (0,6)', 'name' => 'block_day'),
                        array('type' => 'text', 'label' => 'Minimum Advance Day', 'name' => 'min_advance'),
                        array('type' => 'text', 'label' => 'Maximan Advance Day', 'name' => 'max_advance'),
                        array('type' => 'text', 'label' => 'Slot', 'name' => 'slot'),
                    ),
                );
            }
        }

        $module_field[] = array('type' => 'repeater', 'label' => "Disabled Date", 'name' => "disabled_date", 
            'fields' => array(
                array('type' => 'dropdown', 'label' => 'Methods', 'name' => 'method','choices' => $disabled_method),
                array('type' => 'date', 'label' => 'Date', 'name' => 'date'),
            ),
        );
        
        $array = array(
            'oc' => $this,
            'heading_title' => 'Time Slots',
            'modulename' => 'time_slots',
            'fields' => $module_field,
        );

        $this->modulehelper->init($array);
	}
}
