<?php
class ControllerTmdformTmdEmailTemplate extends Controller {
	
	public function index() {
		$this->load->language('tmdform/tmdemailtemplate');

		
		$this->load->model('tmdform/form');
		
		 if (isset($this->session->data['form_id'])) {
			$forms_id = $this->session->data['form_id'];
		} else {
			$forms_id = 0;
		} 
		
		
		
		$data['text_detail'] = $this->language->get('text_detail');
		$data['text_custdetail'] = $this->language->get('text_custdetail');
		$data['text_fields'] = $this->language->get('text_fields');
		$data['entry_fieldname'] = $this->language->get('entry_fieldname');
		$data['entry_fieldvalue'] = $this->language->get('entry_fieldvalue');

		$tmdrecord_info = $this->model_tmdform_form->getTmdRecord($forms_id);
		
		if(isset($tmdrecord_info['language_id'])){
			$language_info = $this->model_localisation_language->getLanguage($tmdrecord_info['language_id']);
		}
		
		if(isset($language_info['name'])){
			$lname = $language_info['name'];
		} else {
			$lname ='';
		}
		
		$store_info = $this->model_tmdform_form->getStore($tmdrecord_info['store_id']);
		
		if(isset($store_info['name'])){
			$sname = $store_info['name'];
		} else {
			$sname ='Default';
		}
		
		$data['sname'] 		= $sname;
		$data['lname'] 		= $lname;
		if(!empty($tmdrecord_info['customer_id'])) {
			$data['customer_name']= $tmdrecord_info['customer_name'];
		} else {
			$data['customer_name']= 'Guest';
		}
		$data['title'] 		= $tmdrecord_info['title'];
		$data['ip'] 		= $tmdrecord_info['ip'];
		$data['user_agent'] = (substr($tmdrecord_info['user_agent'], 0, 45));
		$data['date_added'] = $tmdrecord_info['date_added'];
		
		
		$data['field_infos'] = array();
		$filter_data=array(
			'fs_id'=>$tmdrecord_info['fs_id']
		);
			
		$field_infos = $this->model_tmdform_form->getTmdFieldRecord($filter_data);
		
		foreach($field_infos as $fieldinfo){			
			if($fieldinfo['serialize']){
				$fieldinfos=unserialize($fieldinfo['value']);			
						
				$value='';
				foreach($fieldinfos as $field){
				
				
					$value .=$field.',';
				}
				$fieldinfo['value']=$value;
			}
		
				$this->load->model('tool/upload');
				$type = $this->model_tmdform_form->getfieldtype($fieldinfo['field_id']);
				
				if($type=='file') {
				 $upload_info = $this->model_tool_upload->getUploadByCode($fieldinfo['value']);
					//$fieldinfo['value']='<a style="color:#1e91cf" href="'.$this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true).'">'.$upload_info['name'].'</a>'; 
					
					if(isset($upload_info['name'])) {
						$fieldinfo['value']=$upload_info['name'];
						copy(DIR_UPLOAD.$upload_info['filename'], DIR_UPLOAD.$upload_info['name']);
						$this->session->data['emailfiles'][]=DIR_UPLOAD.$upload_info['name'];
					}
				}
			
			
			$data['field_infos'][] = array(				
				'label'     =>$fieldinfo['label'],
				'value'     =>$fieldinfo['value']				
			);
			
		}
		
		return $this->load->view('tmdform/tmdemailtemplate', $data);
		
		//$this->response->setOutput($this->load->view('tmdform/tmdemailtemplate',$data));
	}
	
}
