<?php
class ControllerExtensionModuleTmdFormBulider extends Controller {
	public function index($setting) {
		
		$this->load->language('extension/module/tmdformbulider');
		
	 	$chkstatus = $setting['showpro'];
		
	if(!empty($chkstatus)) {
	   $this->load->model('tmdform/form');
		$this->load->model('tool/image');	
		
		
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		
		 $data['forms_ids'] = $setting['showpro'];	
		 $forms_id = $setting['showpro'];	
		
		$url='';	
		$tmdforms_info = $this->model_tmdform_form->getForm($forms_id);		
	   	
	   	if(isset($tmdforms_info['status'])){
	   		$data['status'] = $tmdforms_info['status'];
	   	}  else {
	   		$data['status'] = '';
	   	}
	   	
		if (isset($this->request->get['form_id'])) {
			$data['form_id'] = $this->request->get['form_id'];
		} else {
			$data['form_id'] = 0;
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		
		if($tmdforms_info['display_type']=='onlycustomer' )
		{
			if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = $this->url->link('tmdform/form', 'form_id='.$forms_id, true);
				//$this->response->redirect($this->url->link('account/login', '', true));
			}
		}
		
		if($tmdforms_info['display_type']=='onlyguest')
		{
			if ($this->customer->isLogged()) {
				$this->response->redirect($this->url->link('common/home', '', true));
			}
		}	
		
		$data['heading_title'] 		= $this->language->get('heading_title');
		$data['text_yes'] 			= $this->language->get('text_yes');
		$data['text_no'] 			= $this->language->get('text_no');
		$data['text_select'] 		= $this->language->get('text_select');
		$data['text_none'] 			= $this->language->get('text_none');
		$data['text_loading'] 		= $this->language->get('text_loading');
		$data['text_option'] 		= $this->language->get('text_option');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['text_entercode'] = $this->language->get('text_entercode');
		
		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
		
		
		$data['customcss'] = $tmdforms_info['custome_style'];	
		$data['form_id'] = $tmdforms_info['form_id'];
		$data['title'] 	 = $this->document->setTitle($tmdforms_info['title']);
		$data['formtitle'] = $tmdforms_info['title'];
			
		$data['captchastatus'] = $tmdforms_info['captcha'];
		
		}
		
		if(!empty($tmdforms_info['top_description'])){
		$data['top_description']    = html_entity_decode($tmdforms_info['top_description']);
		} else {
		$data['top_description']='';
		}
		if(!empty($tmdforms_info['bottom_description'])){
		$data['bottom_description']    = html_entity_decode($tmdforms_info['bottom_description']);
		} else {
		$data['bottom_description']='';	
		}
		$data['button_name'] 	    = $tmdforms_info['button_name'];
		
		$data['form_fields'] = array();	
		
		foreach($this->model_tmdform_form->getFormFieldById($tmdforms_info['form_id']) as $option) {
			if($option['form_status'] == 1){	
				$form_field_option_data = array();

				foreach ($option['form_field_option'] as $option_value) {
					
						$form_field_option_data[] = array(
							'field_id' => $option_value['field_id'],
							'form_id'         => $option_value['form_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),						
							'sort_order'                    => $option_value['sort_order']
						);
					}
				
			
				$data['form_fields'][] = array(
					'field_id'          => $option['field_id'],
					'form_id'           => $option['form_id'],
					'form_field_option' => $form_field_option_data,
					'field_name'        => $option['field_name'],				
					'type'              => $option['type'],
					'required'          => $option['required'],
					'form_status'       => $option['form_status'],
					'help_text'         => $option['help_text'],
					'placeholder'       => $option['placeholder'],
					'placeholder'       => $option['placeholder'],
					'error_message'     => $option['error_message'],
				);
			}
		}
		
		if (isset($this->error['form_fields'])) {
			 $data['error_message'] = $this->error['form_fields'];
		} else {
			$data['error_message'] ='';
		}
		
		
		$data['producturl'] = $this->url->link('tmdform/success','form_id=' . $tmdforms_info['form_id']);
		
		
		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}
		
		$data['captchastatus'] = $tmdforms_info['captcha'];
		
		if ($tmdforms_info['captcha']==1) {
			
			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}
		
		
		}
		
		
		return $this->load->view('extension/module/tmdformbulider', $data);
		
	}
	
}
