<?php
class ControllerExtensionModuleContactFormWithMap extends Controller {
		// Add New Post by defining it here
		private $posts = array(
			'name'		=>	'',
			'subject'	=>	'',
			'email'		=>	'',
			'telephone'	=>	'',
			'enquiry'	=>	''	// This will always be the last and large box
		);
	public function index() {

		$this->load->language('information/contact');
			
		$language_id = $this->config->get('config_language_id');
		$modulename  = 'contact_form_with_map';
		
		$data['title'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'title');
		$data['form_title'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'form_title');
		$data['background_color'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'background_color');
		$data['background_image'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'background_image');
		$data['map_iframe'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'map_iframe');
		$data['contact_details'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'contact_details');
		$data['map_position'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'map_position');


		$data['heading_title'] = $this->language->get('heading_title');
			
		$data['text_location'] = $this->language->get('text_location');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_contact_email'] = $this->language->get('text_contact_email');
		$data['text_whatsapp'] = $this->language->get('text_whatsapp');
		$data['text_open'] = $this->language->get('text_open');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_contact_info'] = $this->language->get('text_contact_info');

		$data['error_title1'] = $this->language->get('error_title1');
		$data['error_text1'] = $this->language->get('error_text1');
		
		$data['button_map'] = $this->language->get('button_map');
		
		$data['button_submit'] = $this->language->get('button_submit');
		
		//$data['action'] = $this->url->link('information/contact', '', true);
		$data['action'] = HTTPS_SERVER.'index.php?route=information/contact';

		// Captcha
		$data['captcha'] = '';
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		}


		foreach ($this->posts as $post_var => $post_default_value){
			$data[$post_var] = $post_default_value;
			$data['error_' . $post_var] = '';

			// Label Value
			$data['entry_' . $post_var] = $this->language->get('entry_' . $post_var);

			// Post Value
			if( isset($this->request->post[$post_var]) ) {
				$data[$post_var] = $this->request->post[$post_var];
			}

			// Error Value
			if( isset($this->error[$post_var]) ) {
				$data['error_' . $post_var] = $this->error[$post_var];
			}
		}

		return $this->load->view('extension/module/contact_form_with_map', $data);
			
	}
}