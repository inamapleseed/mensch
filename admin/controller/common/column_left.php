<?php
	class ControllerCommonColumnLeft extends Controller {
		public function index() {
			if(!defined('IN_DEVELOPMENT')) define('IN_DEVELOPMENT', array());

			if (isset($this->request->get['token']) && isset($this->session->data['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
				$this->load->language('common/column_left');
				
				$this->load->model('user/user');
				
				$this->load->model('tool/image');
				
				$user_info = $this->model_user_user->getUser($this->user->getId());
				
				if ($user_info) {
					$data['firstname'] = $user_info['firstname'];
					$data['lastname'] = $user_info['lastname'];
					
					$data['user_group'] = $user_info['user_group'];
					
					if (is_file(DIR_IMAGE . $user_info['image'])) {
						$data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
						} else {
						$data['image'] = '';
					}
				} 
				else {
					$data['firstname'] = '';
					$data['lastname'] = '';
					$data['user_group'] = '';
					$data['image'] = '';
				}
				
				// Create a 3 level menu array
				// Level 2 can not have children
				
				// Menu
				$data['menus'][] = array(
					'id'       => 'menu-dashboard',
					'icon'	   => 'fa-dashboard',
					'name'	   => $this->language->get('text_dashboard'),
					'href'     => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);

				// Page
				if($this->user->hasPermission('access', 'page/page')){
					$data['menus'][] = array(
						'id'       => 'menu-page',
						'icon'	   => 'fa-columns',
						'name'	   => 'Page',
						'href'     => $this->url->link('page/page', 'token=' . $this->session->data['token'], true),
						'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'catalog/banner')) {
					$catalog[] = array(
					'name'	   => 'Page Banner',
					'href'     => $this->url->link('catalog/banner', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// Catalog
				$catalog = array();
				
				
				if ($this->user->hasPermission('access', 'catalog/category')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_category'),
					'href'     => $this->url->link('catalog/category', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}	
				/*
				if ($this->user->hasPermission('access', 'catalog/custom_product')) {
					$catalog[] = array(
					'name'	   => "Custom Product",
					'href'     => $this->url->link('catalog/custom_product', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				*/
				if ($this->user->hasPermission('access', 'catalog/product')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_product'),
					'href'     => $this->url->link('catalog/product', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
			/*	if ($this->user->hasPermission('access', 'catalog/recurring')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_recurring'),
					'href'     => $this->url->link('catalog/recurring', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}*/
				
				if ($this->user->hasPermission('access', 'catalog/filter')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_filter'),
					'href'     => $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// Attributes
				$attribute = array();
				
				if ($this->user->hasPermission('access', 'catalog/attribute')) {
					$attribute[] = array(
					'name'     => $this->language->get('text_attribute'),
					'href'     => $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'catalog/attribute_group')) {
					$attribute[] = array(
					'name'	   => $this->language->get('text_attribute_group'),
					'href'     => $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($attribute) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_attribute'),
					'href'     => '',
					'children' => $attribute
					);
				}
				
				if ($this->user->hasPermission('access', 'catalog/option')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_option'),
					'href'     => $this->url->link('catalog/option', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_manufacturer'),
					'href'     => $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				/*if ($this->user->hasPermission('access', 'catalog/download')) {
					$catalog[] = array(
					'name'	   => $this->language->get('text_download'),
					'href'     => $this->url->link('catalog/download', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}*/
				if ($this->user->hasPermission('access', 'catalog/calendar_event')) {		
					$catalog[] = array(
						'name'	   => $this->language->get('text_calendar_event'),
						'href'     => $this->url->link('catalog/calendar_event', 'token=' . $this->session->data['token'], true),
						'children' => array()		
					);					
				}
				if ($this->user->hasPermission('access', 'catalog/appointment')) {		
					$catalog[] = array(
						'name'	   => $this->language->get('text_appointment'),
						'href'     => $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'], true),
						'children' => array()		
					);					
				}

			
				if ($catalog) {
					if(count($catalog) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-catalog',
						'icon'	   => 'fa-tags',
						'name'	   => $this->language->get('text_catalog'),
						'href'     => '',
						'children' => $catalog
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-catalog',
						'icon'	   => 'fa-tags',
						'name'	   => $catalog[0]['name'],
						'href'     => $catalog[0]['href'],
						'children' => array(),
						);
					}
				}

				
				$review = array();
				if ($this->user->hasPermission('access', 'catalog/review')) {
					$review[] = array(
					'name'	   => $this->language->get('text_review'),
					'href'     => $this->url->link('catalog/review', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				if ($review) {
					$data['menus'][] = array(
						'id'       => 'menu-review',
						'icon'	   => 'fa-star',
						'name'	   => $review[0]['name'],
						'href'     => $review[0]['href'],
						'children' => array(),
					);
				}

				

				$services = array();
				if ($this->user->hasPermission('access', 'catalog/service')) {
					$services[] = array(
					'name'	   => $this->language->get('text_service'),
					'href'     => $this->url->link('catalog/service', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($services) {
					$data['menus'][] = array(
						'id'       => 'menu-services',
						'icon'	   => 'fa-list',
						'name'	   => $services[0]['name'],
						'href'     => $services[0]['href'],
						'children' => array(),
					);
				}
				
				$gallrey = array();
				if ($this->user->hasPermission('access', 'catalog/gallimage')) {
					$gallrey[] = array(
					'name'	   => 'Gallery Images',
					'href'     => $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($gallrey) {
					$data['menus'][] = array(
						'id'       => 'menu-gallery',
						'icon'	   => 'fa-picture-o',
						'name'	   => $gallrey[0]['name'],
						'href'     => $gallrey[0]['href'],
						'children' => array(),
					);
				}

				$information = array();
				
				if ($this->user->hasPermission('access', 'catalog/information')) {
					$information[] = array(
					'name'	   => $this->language->get('text_information'),
					'href'     => $this->url->link('catalog/information', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}

				
				if ($this->user->hasPermission('access', 'module/pro_email')) {
					$information[] = array(
					'name'     => $this->language->get('text_pro_email'),
					'href'     => $this->url->link('module/pro_email', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}

				if ($information) {
					if(count($information) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-catalog',
						'icon'	   => 'fa-columns',
						'name'	   => $this->language->get('text_content_management'),
						'href'     => '',
						'children' => $information
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-catalog',
						'icon'	   => 'fa-columns',
						'name'	   => $information[0]['name'],
						'href'     => $information[0]['href'],
						'children' => array(),
						);
					}
				}

				$testimonial = array();
				
				
				if ($this->user->hasPermission('access', 'testimonial/testimonial')) {
					$testimonial[] = array(
					'name'	   => $this->language->get('text_testimonial'),
					'href'     => $this->url->link('testimonial/testimonial', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				if ($testimonial) {
					if(count($testimonial) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-catalog',
						'icon'	   => 'fa-address-card-o',
						'name'	   => $this->language->get('text_content_management'),
						'href'     => '',
						'children' => $testimonial
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-catalog',
						'icon'	   => 'fa-address-card-o',
						'name'	   => $testimonial[0]['name'],
						'href'     => $testimonial[0]['href'],
						'children' => array(),
						);
					}
				}

				/* Form Builders */						
			$tmdformbuilder = array();
		
			
			if ($this->user->hasPermission('access', 'tmdform/form')) {		
				$tmdformbuilder[] = array(
					'name'	   => $this->language->get('entry_tmdcreateform'),
					'href'     => $this->url->link('tmdform/form', 'token=' . $this->session->data['token'], true),
					'children' => array()		
				);					
			}	
				
			if ($this->user->hasPermission('access', 'tmdform/record')) {		
				$tmdformbuilder[] = array(
					'name'	   => $this->language->get('entry_tmdformrecord'),
					'href'     => $this->url->link('tmdform/record', 'token=' . $this->session->data['token'], true),
					'children' => array()		
				);					
			}	
			
			/* Filed name */
			$this->load->model('tmdform/form');
			$form_infos = $this->model_tmdform_form->getHeaderlinks();
			
			if(isset($form_infos)) {
				foreach($form_infos as $form_info) {
				
			if ($this->user->hasPermission('access', 'tmdform/record')) {		
				$tmdformbuilder[] = array(
					'name'	   => $form_info['title'],
					'href'     => $this->url->link('tmdform/filedrecord', 'token=' . $this->session->data['token'] .'&form_id=' . $form_info['form_id'] .'&filter_title=' . $form_info['form_id'], true),
					'children' => array()		
				);	
			
			}
			}
			}
			/* Filed name */
			
			if ($tmdformbuilder) {					
				$data['menus'][] = array(
					'id'       => 'menu-tmdformbuilder',
					'icon'	   => 'fa fa-files-o', 
					'name'	   => $this->language->get('text_tmdform'),
					'href'     => '',
					'children' => $tmdformbuilder
				);		
			}
			
			/* Form Builders */
				
				// Extension
				$extension = array();
				/*
					if ($this->user->hasPermission('access', 'extension/store')) {
					$extension[] = array(
					'name'	   => $this->language->get('text_store'),
					'href'     => $this->url->link('extension/store', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
					}
					
					if ($this->user->hasPermission('access', 'extension/installer')) {
					$extension[] = array(
					'name'	   => $this->language->get('text_installer'),
					'href'     => $this->url->link('extension/installer', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
					}
				*/

				// Design
				$design = array();
				
				if ($this->user->hasPermission('access', 'design/layout')) {
					$design[] = array(
					'name'	   => $this->language->get('text_layout'),
					'href'     => $this->url->link('design/layout', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
			
				if ($this->user->hasPermission('access', 'design/banner')) {
					$design[] = array(
					'name'	   => $this->language->get('text_banner'),
					'href'     => $this->url->link('design/banner', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}

				if ($this->user->hasPermission('access', 'catalog/page_banner')) {
					$design[] = array(
					'name'	   => 'Page Banner',
					'href'     => $this->url->link('catalog/page_banner', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}	
				
				if ($this->user->hasPermission('access', 'catalog/menu')) {
					$design[] = array(
					'name'	   => "Menu",
					'href'     => $this->url->link('catalog/menu', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}	
				
				if ($design) {
					if(count($design) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-design',
						'icon'	   => 'fa-television',
						'name'	   => $this->language->get('text_design'),
						'href'     => '',
						'children' => $design
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-design',
						'icon'	   => 'fa-television',
						'name'	   => $design[0]['name'],
						'href'     => $design[0]['href'],
						'children' => array(),
						);
					}
					
				}
				
				// Sales
				$sale = array();
				
				if ($this->user->hasPermission('access', 'sale/order')) {
					$sale[] = array(
					'name'	   => $this->language->get('text_order'),
					'href'     => $this->url->link('sale/order', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}

				if ($this->user->hasPermission('access', 'sale/enquiry')) {
					$sale[] = array(
					'name'	   => $this->language->get('text_enquiry'),
					'href'     => $this->url->link('sale/enquiry', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// if ($this->user->hasPermission('access', 'sale/recurring')) {
				// 	$sale[] = array(
				// 	'name'	   => $this->language->get('text_recurring'),
				// 	'href'     => $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], true),
				// 	'children' => array()
				// 	);
				// }
				
				// if ($this->user->hasPermission('access', 'sale/return')) {
				// 	$sale[] = array(
				// 	'name'	   => $this->language->get('text_return'),
				// 	'href'     => $this->url->link('sale/return', 'token=' . $this->session->data['token'], true),
				// 	'children' => array()
				// 	);
				// }
				
				// Voucher
				$voucher = array();
				
				if ($this->user->hasPermission('access', 'sale/voucher')) {
					$voucher[] = array(
					'name'	   => $this->language->get('text_voucher'),
					'href'     => $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'sale/voucher_theme')) {
					$voucher[] = array(
					'name'	   => $this->language->get('text_voucher_theme'),
					'href'     => $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($voucher) {
					$sale[] = array(
					'name'	   => $this->language->get('text_voucher'),
					'href'     => '',
					'children' => $voucher
					);
				}
				
				if ($sale) {
					if(count($sale) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-sale',
						'icon'	   => 'fa-shopping-cart',
						'name'	   => $this->language->get('text_sale'),
						'href'     => '',
						'children' => $sale
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-sale',
						'icon'	   => 'fa-shopping-cart',
						'name'	   => $sale[0]['name'],
						'href'     => $sale[0]['href'],
						'children' => array(),
						);
					}
				}
				
				//Opencart Xero Integration
				$xero = $this->load->controller('extension/module/opc_xero/menu');
				
				if ($xero) {
					$data['menus'][] = $this->load->controller('extension/module/opc_xero/menu');
				}

				// Customer
				$customer = array();
				
				if ($this->user->hasPermission('access', 'customer/customer')) {
					$customer[] = array(
					'name'	   => $this->language->get('text_customer'),
					'href'     => $this->url->link('customer/customer', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'customer/customer_group')) {
					$customer[] = array(
					'name'	   => $this->language->get('text_customer_group'),
					'href'     => $this->url->link('customer/customer_group', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
			
				// if ($this->user->hasPermission('access', 'customer/custom_field')) {
				// 	$customer[] = array(
				// 	'name'	   => $this->language->get('text_custom_field'),
				// 	'href'     => $this->url->link('customer/custom_field', 'token=' . $this->session->data['token'], true),
				// 	'children' => array()
				// 	);
				// }
			
				if ($customer) {
					if(count($customer) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-customer',
						'icon'	   => 'fa-user',
						'name'	   => $this->language->get('text_customer'),
						'href'     => '',
						'children' => $customer
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-customer',
						'icon'	   => 'fa-user',
						'name'	   => $customer[0]['name'],
						'href'     => $customer[0]['href'],
						'children' => array(),
						);
					}
				}
				
				
				$mailchimp = array();
				/*** customer newsletter ***/
                if ($this->user->hasPermission('access', 'customer/customer_newsletter')) {
                    $mailchimp[] = array(
                    'name'     => 'Customer Newsletter',
                    'href'     => $this->url->link('customer/customer_newsletter', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                    );
                }
                /*** customer newsletter ***/

				if ($this->user->hasPermission('access', 'extension/module/newsletter_module')) {
					$mailchimp[] = array(
						'name'	   => $this->language->get('text_mailchimp_integration'),
						'href'     => $this->url->link('extension/module/newsletter_module', 'token=' . $this->session->data['token'], true),
						'children' => array()
						);
				}
				
				if ($mailchimp) {
					if(count($mailchimp) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-mailchimp',
						'icon'	   => 'fa-list',
						'name'	   => "Newsletter",
						'href'     => '',
						'children' => $mailchimp
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-mailchimp',
						'icon'	   => 'fa-list',
						'name'	   => $mailchimp[0]['name'],
						'href'     => $mailchimp[0]['href'],
						'children' => array(),
						);
					}
				}


				if ($this->user->hasPermission('access', 'contact_enquiry/contact_enquiry')) {
					$data['menus'][] = array(
					'id'       => 'menu-enquiry',
					'icon'	   => 'fa-envelope-o',
					'name'	   => "Contact Enquiry",
					'href'     => $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'], true),
					'children' => '',
					);
				}

				// Marketing
				$marketing = array();

				if ($this->user->hasPermission('access', 'extension/module/product_sort_orders')) {
					$marketing[] = array(
					'name'     => $this->language->get('text_product_sort_order'),
					'href'     => $this->url->link('extension/module/product_sort_orders', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}

				

				// Discounts
				$discounts = array();
				
				if ($this->user->hasPermission('access', 'catalog/discount_category')) {
					$discounts[] = array(
						'name'     => $this->language->get('text_category'),
						'href'     => $this->url->link('catalog/discount_category', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}
				
				if ($this->user->hasPermission('access', 'catalog/discount_customer_group')) {
					$discounts[] = array(
						'name'     => $this->language->get('text_customer_group'),
						'href'     => $this->url->link('catalog/discount_customer_group', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}
				
				/*if ($this->user->hasPermission('access', 'catalog/discount_product')) {
					$discounts[] = array(
						'name'     => $this->language->get('text_product'),
						'href'     => $this->url->link('catalog/discount_product', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}*/
				
				if ($this->user->hasPermission('access', 'catalog/discount_manufacturer')) {
					$discounts[] = array(
						'name'     => $this->language->get('text_manufacturer'),
						'href'     => $this->url->link('catalog/discount_manufacturer', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}
				
				// if ($this->user->hasPermission('access', 'catalog/discount_ordertotal')) {
				// 	$discounts[] = array(
				// 		'name'     => $this->language->get('text_ordertotal'),
				// 		'href'     => $this->url->link('catalog/discount_ordertotal', 'token=' . $this->session->data['token'], true),
				// 		'children' => array()	
				// 	);
				// }
				
				// if ($this->user->hasPermission('access', 'catalog/discount_volume')) {
				// 	$discounts[] = array(
				// 		'name'     => $this->language->get('text_volume'),
				// 		'href'     => $this->url->link('catalog/discount_volume', 'token=' . $this->session->data['token'], true),
				// 		'children' => array()	
				// 	);
				// }
				
				// if ($this->user->hasPermission('access', 'catalog/discount_loyalty')) {
				// 	$discounts[] = array(
				// 		'name'     => $this->language->get('text_loyalty'),
				// 		'href'     => $this->url->link('catalog/discount_loyalty', 'token=' . $this->session->data['token'], true),
				// 		'children' => array()	
				// 	);
				// }
				
				if ($this->user->hasPermission('access', 'extension/module/discounts') && $this->config->get('discounts_status')) {		
					$marketing[] = array(
						'name'	   => $this->language->get('tab_discount'),
						'href'     => '',
						'children' => $discounts		
					);
				}

				$combo = array();	

				if ($this->user->hasPermission('access', 'catalog/salescombopge')) {
					$combo[] = array(
						'name'     => $this->language->get('text_salescombopge'),
						'href'     => $this->url->link('catalog/salescombopge', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}

				if ($this->user->hasPermission('access', 'extension/module/cartbindercombo1a')) {
					$combo[] = array(
						'name'     => $this->language->get('text_combo_1a'),
						'href'     => $this->url->link('extension/module/cartbindercombo1a', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}

				if ($this->user->hasPermission('access', 'extension/module/cartbindercombo1')) {
					$combo[] = array(
						'name'     => $this->language->get('text_combo_1'),
						'href'     => $this->url->link('extension/module/cartbindercombo1', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}

				if ($this->user->hasPermission('access', 'extension/module/cartbindercombo1b')) {
					$combo[] = array(
						'name'     => $this->language->get('text_combo_1b'),
						'href'     => $this->url->link('extension/module/cartbindercombo1b', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}

				if ($this->user->hasPermission('access', 'extension/module/cartbindercombo1c')) {
					$combo[] = array(
						'name'     => $this->language->get('text_combo_1c'),
						'href'     => $this->url->link('extension/module/cartbindercombo1c', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}

				if ($this->user->hasPermission('access', 'extension/module/cartbindercombo2a')) {
					$combo[] = array(
						'name'     => $this->language->get('text_combo_2a'),
						'href'     => $this->url->link('extension/module/cartbindercombo2a', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}

				if ($this->user->hasPermission('access', 'extension/module/cartbindercombo2')) {
					$combo[] = array(
						'name'     => $this->language->get('text_combo_2'),
						'href'     => $this->url->link('extension/module/cartbindercombo2', 'token=' . $this->session->data['token'], true),
						'children' => array()	
					);
				}


				if ($combo) {
					if(count($combo) > 1){
						$marketing[] = array(
						'name'	   => $this->language->get('tab_combo'),
						'href'     => '',
						'children' => $combo
						);
					}
					else{
						$marketing[] = array(
						'name'	   => $combo[0]['name'],
						'href'     => $combo[0]['href'],
						'children' => array()
						);
					}
				}


				if ($this->user->hasPermission('access', 'marketing/coupon')) {
					$marketing[] = array(
					'name'	   => $this->language->get('text_coupon_code'),
					'href'     => $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				/*if ($this->user->hasPermission('access', 'marketing/marketing')) {
					$marketing[] = array(
					'name'	   => $this->language->get('text_campaign_url'),
					'href'     => $this->url->link('marketing/marketing', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}*/
				
				/*if ($this->user->hasPermission('access', 'marketing/affiliate')) {
					$marketing[] = array(
					'name'	   => $this->language->get('text_referral'),
					'href'     => $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}*/
				
				/*
					if ($this->user->hasPermission('access', 'marketing/contact')) {
					$marketing[] = array(
					'name'	   => $this->language->get('text_contact'),
					'href'     => $this->url->link('marketing/contact', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
					}
				*/
				
				if ($marketing) {
					if(count($marketing) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-marketing',
						'icon'	   => 'fa-share-alt',
						'name'	   => $this->language->get('text_marketing'),
						'href'     => '',
						'children' => $marketing
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-marketing',
						'icon'	   => 'fa-share-alt',
						'name'	   => $marketing[0]['name'],
						'href'     => $marketing[0]['href'],
						'children' => array()
						);
					}
				}

				
				if ($this->user->hasPermission('access', 'extension/extension')) {
					$extension[] = array(
					'name'	   => $this->language->get('text_extension'),
					'href'     => $this->url->link('extension/extension&type=module', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// if ($this->user->hasPermission('access', 'facebook/facebookadsextension')) {
				// 	/*
				// 	$data['menus'][] = array(
				// 		'id'       => 'menu-facebook-ads-extension',
				// 		'icon'     => 'fa-facebook-square',
				// 	*/
				// 	$extension[] = array(
				// 		'name'     => 'Facebook Ads Extension',
				// 		'href'     => $this->url->link('facebook/facebookadsextension', 'token=' . $this->session->data['token'], true),
				// 		'children' => array()
				// 	);
				// }

				
				/*
					// Enhanced CKEditor
					if ($this->user->hasPermission('access', 'enhancement/enhanced_ckeditor')) {
					$extension[] = array(
					'name'	   => $this->language->get('text_ea_ckeditor'),
					'href'     => $this->url->link('enhancement/enhanced_ckeditor', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
					}
					// Enhanced CKEditor
					
					if ($this->user->hasPermission('access', 'extension/event')) {
					$extension[] = array(
					'name'	   => $this->language->get('text_event'),
					'href'     => $this->url->link('extension/event', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
					}
				*/
				if ($extension) {
					if(count($extension) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-extension',
						'icon'	   => 'fa-puzzle-piece',
						'name'	   => $this->language->get('text_extension'),
						'href'     => '',
						'children' => $extension
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-extension',
						'icon'	   => 'fa-puzzle-piece',
						'name'	   => $extension[0]['name'],
						'href'     => $extension[0]['href'],
						'children' => array()
						);
					}
				}
				
				// System
				$system = array();
				/*
				if ($this->user->hasPermission('access', 'setting/qourier')) {
					$system[] = array(
					'name'	   => $this->language->get('text_qourier'),
					'href'     => $this->url->link('setting/qourier', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				*/
				if ($this->user->hasPermission('access', 'setting/setting')) {
					$system[] = array(
					'name'	   => $this->language->get('text_setting'),
					'href'     => $this->url->link('setting/store', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// Seo url
				if ($this->user->hasPermission('access', 'setting/seo_url')) {
					$system[] = array(
					'name'	   => "SEO URL",
					'href'     => $this->url->link('setting/seo_url', 'token=' . $this->session->data['token'], true),
					'children' => array()		
					);	
				}
				
				// Users
				$user = array();
				
				if ($this->user->hasPermission('access', 'user/user')) {
					$user[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => $this->url->link('user/user', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'user/user_permission')) {
					$user[] = array(
					'name'	   => $this->language->get('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'user/api')) {
					$user[] = array(
					'name'	   => $this->language->get('text_api'),
					'href'     => $this->url->link('user/api', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($user) {
					if(count($user) > 1){
						$system[] = array(
						'name'	   => $this->language->get('text_users'),
						'href'     => '',
						'children' => $user
						);
					}
					else{
						$system[] = array(
						'name'	   => $user[0]['name'],
						'href'     => $user[0]['href'],
						'children' => array()
						);
					}
					
				}
				
				// Localisation
				$localisation = array();
				
				if ($this->user->hasPermission('access', 'localisation/location')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_location'),
					'href'     => $this->url->link('localisation/location', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/language')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_language'),
					'href'     => $this->url->link('localisation/language', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/currency')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_currency'),
					'href'     => $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/stock_status')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_stock_status'),
					'href'     => $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/order_status')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_order_status'),
					'href'     => $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// Returns
				$return = array();
				
				if ($this->user->hasPermission('access', 'localisation/return_status')) {
					$return[] = array(
					'name'	   => $this->language->get('text_return_status'),
					'href'     => $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/return_action')) {
					$return[] = array(
					'name'	   => $this->language->get('text_return_action'),
					'href'     => $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/return_reason')) {
					$return[] = array(
					'name'	   => $this->language->get('text_return_reason'),
					'href'     => $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// if ($return) {
				// 	$localisation[] = array(
				// 	'name'	   => $this->language->get('text_return'),
				// 	'href'     => '',
				// 	'children' => $return
				// 	);
				// }
				
				if ($this->user->hasPermission('access', 'localisation/country')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_country'),
					'href'     => $this->url->link('localisation/country', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/zone')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_zone'),
					'href'     => $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/geo_zone')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_geo_zone'),
					'href'     => $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// Tax
				$tax = array();
				
				if ($this->user->hasPermission('access', 'localisation/tax_class')) {
					$tax[] = array(
					'name'	   => $this->language->get('text_tax_class'),
					'href'     => $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/tax_rate')) {
					$tax[] = array(
					'name'	   => $this->language->get('text_tax_rate'),
					'href'     => $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($tax) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_tax'),
					'href'     => '',
					'children' => $tax
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/length_class')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_length_class'),
					'href'     => $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'localisation/weight_class')) {
					$localisation[] = array(
					'name'	   => $this->language->get('text_weight_class'),
					'href'     => $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($localisation) {
					$system[] = array(
					'name'	   => $this->language->get('text_localisation'),
					'href'     => '',
					'children' => $localisation
					);
				}
				
				// Tools
				/*$tool = array();
				
				if ($this->user->hasPermission('access', 'tool/upload')) {
					$tool[] = array(
					'name'	   => $this->language->get('text_upload'),
					'href'     => $this->url->link('tool/upload', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'tool/backup')) {
					$tool[] = array(
					'name'	   => $this->language->get('text_backup'),
					'href'     => $this->url->link('tool/backup', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'tool/log')) {
					$tool[] = array(
					'name'	   => $this->language->get('text_log'),
					'href'     => $this->url->link('tool/log', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($tool) {
					if(count($tool) > 1){
						$data['menus'][] = array(
						'id'       => 'menu-system',
						'icon'	   => 'fa-wrench',
						'name'	   => $this->language->get('text_tools'),
						'href'     => '',
						'children' => $tool
						);
					}
					else{
						$data['menus'][] = array(
						'id'       => 'menu-system',
						'icon'	   => 'fa-wrench',
						'name'	   => $tool[0]['name'],
						'href'     => $tool[0]['href'],
						'children' => array(),
						);
					}
					
				}*/
				
				/* AbandonedCarts - Begin */
				$this->load->model('setting/setting');
				$abandonedCartsSettings = $this->model_setting_setting->getSetting('abandonedcarts', $this->config->get('store_id'));
				
				if (isset($abandonedCartsSettings['abandonedcarts']['Enabled']) && $abandonedCartsSettings['abandonedcarts']['Enabled']=='yes' && isset($abandonedCartsSettings['abandonedcarts']['MenuWidget']) && $abandonedCartsSettings['abandonedcarts']['MenuWidget']=='yes') { 
					$AB_count = $this->db->query("SELECT count(*) as total FROM `" . DB_PREFIX . "abandonedcarts` WHERE `notified`=0");
					
					$data['menus'][] = array(
                    'id'       => 'menu-abandonedcarts',
                    'icon'	   => 'fa fa-shopping-cart fa-fw', 
                    'name'	   => 'Abandoned Carts <span class="label label-danger">'. $AB_count->row['total'] . '</span>',
                    'href'     => $this->url->link('extension/module/abandonedcarts', 'token=' . $this->session->data['token'], true),
                    'children' => array()
					);	
				}
				/* AbandonedCarts - End */
				
				if ($system) {
					$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_system'),
					'href'     => '',
					'children' => $system
					);
				}

				// Report
				$report = array();
				
				// Report Sales
				$report_sale = array();
				
				if ($this->user->hasPermission('access', 'report/sale_order')) {
					$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_order'),
					'href'     => $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/sale_tax')) {
					$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_tax'),
					'href'     => $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/sale_shipping')) {
					$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_shipping'),
					'href'     => $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				// if ($this->user->hasPermission('access', 'report/sale_return')) {
				// 	$report_sale[] = array(
				// 	'name'	   => $this->language->get('text_report_sale_return'),
				// 	'href'     => $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], true),
				// 	'children' => array()
				// 	);
				// }
				
				if ($this->user->hasPermission('access', 'report/sale_coupon')) {
					$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_coupon'),
					'href'     => $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($report_sale) {
					$report[] = array(
					'name'	   => $this->language->get('text_report_sale'),
					'href'     => '',
					'children' => $report_sale
					);
				}
				
				// Report Products
				$report_product = array();
				
				if ($this->user->hasPermission('access', 'report/product_viewed')) {
					$report_product[] = array(
					'name'	   => $this->language->get('text_report_product_viewed'),
					'href'     => $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/product_purchased')) {
					$report_product[] = array(
					'name'	   => $this->language->get('text_report_product_purchased'),
					'href'     => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}

				if ($this->user->hasPermission('access', 'report/product_option_purchased')) {
					$report_product[] = array(
					'name'	   => $this->language->get('text_report_product_option_purchased'),
					'href'     => $this->url->link('report/product_option_purchased', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($report_product) {
					$report[] = array(
					'name'	   => $this->language->get('text_report_product'),
					'href'     => '',
					'children' => $report_product
					);
				}
				
				// Report Customers
				$report_customer = array();
				
				if ($this->user->hasPermission('access', 'report/customer_online')) {
					$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_online'),
					'href'     => $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/customer_engagement')) {
					$report_customer[] = array(
						'name'	   => $this->language->get('text_report_customer_engagement'),
						'href'     => $this->url->link('report/customer_engagement', 'token=' . $this->session->data['token'], true),
						'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/customer_activity')) {
					$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_activity'),
					'href'     => $this->url->link('report/customer_activity', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/customer_search')) {
					$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_search'),
					'href'     => $this->url->link('report/customer_search', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/customer_order')) {
					$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_order'),
					'href'     => $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/customer_reward')) {
					$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_reward'),
					'href'     => $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/customer_credit')) {
					$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_credit'),
					'href'     => $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($report_customer) {
					$report[] = array(
					'name'	   => $this->language->get('text_report_customer'),
					'href'     => '',
					'children' => $report_customer
					);
				}
				
				// Report Marketing
				$report_marketing = array();
				
				if ($this->user->hasPermission('access', 'report/marketing')) {
					$report_marketing[] = array(
					'name'	   => $this->language->get('text_report_marketing'),
					'href'     => $this->url->link('report/marketing', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/affiliate')) {
					$report_marketing[] = array(
					'name'	   => $this->language->get('text_report_affiliate'),
					'href'     => $this->url->link('report/affiliate', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($this->user->hasPermission('access', 'report/affiliate_activity')) {
					$report_marketing[] = array(
					'name'	   => $this->language->get('text_report_affiliate_activity'),
					'href'     => $this->url->link('report/affiliate_activity', 'token=' . $this->session->data['token'], true),
					'children' => array()
					);
				}
				
				if ($report_marketing) {
					$report[] = array(
					'name'	   => $this->language->get('text_report_marketing'),
					'href'     => '',
					'children' => $report_marketing
					);
				}
				
				if ($report) {
					$data['menus'][] = array(
					'id'       => 'menu-report',
					'icon'	   => 'fa-bar-chart-o',
					'name'	   => $this->language->get('text_reports'),
					'href'     => '',
					'children' => $report
					);
				}

				/** advanced reports **/
				$adv_report = array();
				$this->language->load('module/ecadvancedreports');
				/*
				$this->load->model('setting/extension');
				$extensions = $this->model_setting_extension->getInstalled('module');
				$data['ecadvancedreports_installed'] = false;
				if(in_array("ecadvancedreports", $extensions)){
					$data['ecadvancedreports_installed'] = true;
				}*/

				$data['text_ecadvancedreports_reports'] = $this->language->get('text_ecadvancedreports_advanced_reports');
				$data['text_sales_by_customer_group'] = $this->language->get("text_sales_by_customer_group");
				$data['text_sales_by_customer_company'] = $this->language->get("text_sales_by_customer_company");
				$data['text_report_sale_order'] = $this->language->get("text_report_sale_order");
				$data['text_sales_by_product'] = $this->language->get("text_sales_by_product");
				$data['text_advanced'] = $this->language->get("text_advanced");
				$data['text_report_sale_tax'] = $this->language->get("text_report_sale_tax");
				$data['text_report_sale_shipping'] = $this->language->get("text_report_sale_shipping");
				$data['text_report_sale_return'] = $this->language->get("text_report_sale_return");
				$data['text_report_sale_coupon'] = $this->language->get("text_report_sale_coupon");
				$data['text_product'] = $this->language->get("text_product");
				$data['text_report_product_viewed'] = $this->language->get("text_report_product_viewed");
				$data['text_report_product_purchased'] = $this->language->get("text_report_product_purchased");
				$data['text_customer'] = $this->language->get("text_customer");
				$data['text_report_customer_online'] = $this->language->get("text_report_customer_online");
				$data['text_report_customer_order'] = $this->language->get("text_report_customer_order");
				$data['text_report_customer_reward'] = $this->language->get("text_report_customer_reward");
				$data['text_report_customer_credit'] = $this->language->get("text_report_customer_credit");
				$data['text_report_affiliate_commission'] = $this->language->get("text_report_affiliate_commission");
				$data['text_affiliate'] = $this->language->get("text_affiliate");
				$data['text_report_sale_product_per_country'] = $this->language->get("text_report_sale_product_per_country");
				$data['text_report_sale_by_country'] = $this->language->get("text_report_sale_by_country");
				$data['text_report_customer_by_city'] = $this->language->get("heading_title_customer_city");
				$data['text_report_customer_by_country'] = $this->language->get("heading_title_customer_country");
				$data['text_report_sale_by_hour'] = $this->language->get("text_report_sale_by_hour");
				$data['text_report_sale_by_day_of_week'] = $this->language->get("text_report_sale_by_day_of_week");
				$data['text_report_sale_by_product'] = $this->language->get("text_report_sale_by_product");
				$data['text_report_sale_by_manufacturer'] = $this->language->get("text_report_sale_by_manufacturer");
				$data['text_report_sale_statistic'] = $this->language->get("text_report_sale_statistic");
				$data['text_report_sale_by_coupon_code'] = $this->language->get("text_report_sale_by_coupon_code");
				$data['text_report_sale_by_payment_type'] = $this->language->get("text_report_sale_by_payment_type");
				$data['text_report_sale_by_zip_code'] = $this->language->get("text_report_sale_by_zip_code");
				$data['text_report_sale_by_state'] = $this->language->get("text_report_sale_by_state");
				$data['text_report_sale_report'] = $this->language->get("text_report_sale_report");
				$data['text_report_product_bestseller'] = $this->language->get("text_report_product_bestseller");
				$data['text_report_sale_category'] = $this->language->get("text_report_sale_category");
				$data['text_report_sale_by_profit'] = $this->language->get("text_report_sale_by_profit");
				$data['text_report_product_profit'] = $this->language->get("text_report_product_profit");
				$data['text_report_user_activity'] = $this->language->get("text_report_user_activity");
				$data['text_report_customer_purchase'] = $this->language->get("text_report_customer_purchase");
				$data['text_report_product'] = $this->language->get("text_report_product");
				$data['text_report_product_notsold'] = $this->language->get("text_report_product_notsold");
				$data['text_report_top_customer'] = $this->language->get("text_report_top_customer");
				$data['text_report_product_inventory'] = $this->language->get("text_report_product_inventory");
				$data['text_report_customer'] = $this->language->get("text_report_customer");
				$data['text_report_customer_notorder'] = $this->language->get("text_report_customer_notorder");
				$data['text_earnings'] = $this->language->get("text_earnings");
				$data['text_product_list'] = $this->language->get("text_product_list");
				$data['text_order'] = $this->language->get("text_order");
				$data['text_report_order'] = $this->language->get("text_report_order");

				/*Links to report pages*/
				$data['link_report_earnings'] = $this->url->link('ecadvancedreports/earnings', 'current=1&token=' . $this->session->data['token'], 'SSL');
				$data['link_to_sales_by_customer_group'] = $this->url->link('ecadvancedreports/customer_group', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_to_sales_by_product'] = $this->url->link('ecadvancedreports/product', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_bestseller'] = $this->url->link('ecadvancedreports/product_bestseller', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_by_country'] = $this->url->link('ecadvancedreports/sale_country', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_coupon'] = $this->url->link('ecadvancedreports/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_statistic'] = $this->url->link('ecadvancedreports/sale_statistics', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_zip_code'] = $this->url->link('ecadvancedreports/sale_zipcode', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_state'] = $this->url->link('ecadvancedreports/sale_state', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_payment_type'] = $this->url->link('ecadvancedreports/sale_payment', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_customer_by_city'] = $this->url->link('ecadvancedreports/customer_city', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_product_per_country'] = $this->url->link('ecadvancedreports/sale_product_country', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_customer_by_country'] = $this->url->link('ecadvancedreports/customer_country', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_order'] = $this->url->link('ecadvancedreports/sale_order', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_by_manufacturer'] = $this->url->link('ecadvancedreports/sale_manufacturer', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_by_category'] = $this->url->link('ecadvancedreports/category', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_by_hour'] = $this->url->link('ecadvancedreports/sale_hour', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_by_day_week'] = $this->url->link('ecadvancedreports/sale_day_week', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_to_sales_by_profit'] = $this->url->link('ecadvancedreports/sale_profit', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_customer_purchase'] = $this->url->link('ecadvancedreports/customer_purchase', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_sale_report'] = $this->url->link('ecadvancedreports/sale_report', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_user_activity'] = $this->url->link('ecadvancedreports/user_activity', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_product'] = $this->url->link('ecadvancedreports/report_product', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_top_customer'] = $this->url->link('ecadvancedreports/top_customer', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_customer'] = $this->url->link('ecadvancedreports/customer', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_customer_notorder'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_product_inventory'] = $this->url->link('ecadvancedreports/product_inventory', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_to_sales_by_customer_company'] = $this->url->link('ecadvancedreports/customer_company', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_product_notsold'] = $this->url->link('ecadvancedreports/product_notsold', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_product_list'] = $this->url->link('ecadvancedreports/product_list', 'token=' . $this->session->data['token'], 'SSL');
				$data['link_report_order'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'], 'SSL');
				/*Links to report pages*/

				$data['menus'][] = array(
				'id'       => 'menu-adv-report',
				'icon'	   => 'fa-bar-chart-o',
				'name'	   => 'Advanced Reports',
				'href'     => $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'], 'SSL'),
				'children' => array()
				);

				/** advanced reports **/

				// Stats
				$data['text_complete_status'] = $this->language->get('text_complete_status');
				$data['text_processing_status'] = $this->language->get('text_processing_status');
				$data['text_other_status'] = $this->language->get('text_other_status');
				
				$this->load->model('sale/order');
				
				$order_total = $this->model_sale_order->getTotalOrders();
				
				$complete_total = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_complete_status'))));
				
				if ($complete_total) {
					$data['complete_status'] = round(($complete_total / $order_total) * 100);
					} else {
					$data['complete_status'] = 0;
				}
				
				$processing_total = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_processing_status'))));
				
				if ($processing_total) {
					$data['processing_status'] = round(($processing_total / $order_total) * 100);
					} else {
					$data['processing_status'] = 0;
				}
				
				$this->load->model('localisation/order_status');
				
				$order_status_data = array();
				
				$results = $this->model_localisation_order_status->getOrderStatuses();
				
				foreach ($results as $result) {
					if (!in_array($result['order_status_id'], array_merge($this->config->get('config_complete_status'), $this->config->get('config_processing_status')))) {
						$order_status_data[] = $result['order_status_id'];
					}
				}
				
				$other_total = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $order_status_data)));
				
				if ($other_total) {
					$data['other_status'] = round(($other_total / $order_total) * 100);
					} else {
					$data['other_status'] = 0;
				}
				
				return $this->load->view('common/column_left', $data);
			}
		}
	}
	
