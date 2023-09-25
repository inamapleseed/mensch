<?php
class ControllerExtensionModuleCalendar extends Controller {
	private $error = array();

    // Add New Post by defining it here
    private $posts = array(
    	'date'		=>  '',
    	'time'		=>  '',
        'name'      =>  '',
        'contact'   =>  '',
        'email'     =>  '',
        'outlet'    =>  '',
        'message'   =>  ''  // This will always be the last and large box
    );

    // Add your post value to ignore in the email body content
    private $disallow_in_message_body = array(
        'event'	    =>  '',
    );

    public function __constructor(){
        $this->posts['name']        = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
        $this->posts['email']       = $this->customer->getEmail();
        $this->posts['contact']     = $this->customer->getTelephone();
    }

	public function index($setting) {

		$this->document->addStyle("catalog/view/javascript/fullcalendar/core/main.css");
        $this->document->addScript("catalog/view/javascript/fullcalendar/core/main.js");

		$this->document->addStyle("catalog/view/javascript/fullcalendar/daygrid/main.css");
        $this->document->addScript("catalog/view/javascript/fullcalendar/daygrid/main.js");

        $this->document->addScript("catalog/view/javascript/moment.js");

        $this->document->addStyle('catalog/view/javascript/slick/slick.css');
		$this->document->addScript('catalog/view/javascript/slick/slick-custom.min.js');

		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

        $data['module_id'] = $setting['module_id'];

        $this->load->language('extension/module/calendar');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_not_available'] = $this->language->get('text_not_available');

        $data['button_next'] = $this->language->get('button_next');


        $data['booking_title'] = $this->language->get('booking_title');
        $data['entry_event'] = $this->language->get('entry_event');
        $data['button_submit'] = $this->language->get('button_submit');

        // Captcha
        $data['captcha'] = '';
        if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
            $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
        }
        
        $this->load->model('localisation/location');
        
        $data['outlets'] = $this->model_localisation_location->getLocations();

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
        // $this->load->model('catalog/calendar');

        // $data['calendar_events'] = array();

        // foreach($setting['calendars'] as $calendar) {
        // 	$cevent_id = $calendar['cevent_id'];

        // 	$images = $this->model_catalog_calendar->getCalendarEventImage($cevent_id);

        // 	$events = $this->model_catalog_calendar->getCalendarEvent($cevent_id);

        // 	$data['calendar_events'][] = array(
        // 		'cevent_id' => isset($events['cevent_id']) ? $events['cevent_id'] : '',
        // 		'title' => $events['name'],
        // 		'description' => $events['description'],
        // 		'images' => $images 
        // 	);

        	
        // }

		return $this->load->view('extension/module/calendar', $data);
	}

	public function getCalendar() {
		$json = array();

		$this->load->model('extension/module');

		$data = $this->model_extension_module->getModule($this->request->post['module_id']);

		$events = array();

		$i = 0;
		
		$todays_date = date("Y-m-d", strtotime("today"));
		
		foreach ($data['calendars'] as $key => $value) {
			$start_date = date('Y-m-d', strtotime($value['start_date']));
			$end_date = date('Y-m-d', strtotime($value['end_date']));

			for($a = 0; $a < 9999; $a ++){

				if(strtotime($start_date) <= strtotime($end_date)){
					if(strtotime($start_date) >= strtotime($todays_date)) {
    				    $events[$i] = array(
    						'title'   => $value['title'],
    						'start'   => $start_date,
    						'end'     => !empty($value['end_date']) ? date('Y-m-d', strtotime($start_date . ' + 1 day')): '',
    						'id'      => $value['cevent_id'],
    					);
    					
					    $start_date = date('Y-m-d', strtotime($start_date." + 1 day"));
					    
					    $i++;
					} else {
					    $events[$i] = array(
    						'title'   => '',
    						'start'   => '',
    						'end'     => !empty($value['end_date']) ? '': '',
    						'id'      => '',
    					);
    					
					    $start_date = date('Y-m-d', strtotime($start_date." + 1 day"));
					
					    $i++;
					}
				} else {
					break;
				}
			}
			// $events[$key] = array(
			// 	'title'   => $value['title'],
			// 	'start'   => $value['start_date'],
			// 	'end'     => !empty($value['end_date']) ? date('Y-m-d', strtotime($value['end_date'] . ' + 1 day')): '',
			// 	'id'      => $value['cevent_id'],
			// );
		}
		
		$json['events'] = $events;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getCalendarDetail() {
		$json = array();

		$this->load->model('tool/image');

		$theme = $this->config->get('config_theme');

		$image_popup_width = $this->config->get( $theme . '_image_popup_width');
		$image_popup_height = $this->config->get( $theme . '_image_popup_height');

		$image_thumb_width = $this->config->get( $theme . '_image_thumb_width');
		$image_thumb_height = $this->config->get( $theme . '_image_thumb_height');

		$image_additional_width = $this->config->get( $theme . '_image_additional_width');
		$image_additional_height = $this->config->get( $theme . '_image_additional_height');

		$this->load->model('catalog/calendar');

    	$event_info = $this->model_catalog_calendar->getCalendarEvent($this->request->post['cevent_id']);
    	$event_images = $this->model_catalog_calendar->getCalendarEventImage($this->request->post['cevent_id']);
    	$event_timeslots = $this->model_catalog_calendar->getCalendarEventTimeSlots($this->request->post['cevent_id'], $this->request->post['selected_date']);
    	$event_special_timeslots = $this->model_catalog_calendar->getCalendarEventSpecialTimeSlots($this->request->post['cevent_id']);

    	$timeslots = array();

    	foreach ($event_timeslots as $event_timeslot) {
    		$timeslots[] = array(
    			'time' => $event_timeslot['time'],
    			'slot' => $event_timeslot['slot'],
    		);
    	}

    	sort($timeslots);

    	$special_timeslots = array();

    	foreach ($event_special_timeslots as $event_special_timeslot) {
    		$special_timeslots[] = array(
    			'type' => $event_special_timeslot['type'],
    			'date' => $event_special_timeslot['date'],
    			'time' => $event_special_timeslot['time'],
    			'slot' => $event_special_timeslot['slot'],
    		);
    	}

    	$images = array();

    	foreach ($event_images as $event_image) {
    		$images[] = array(
				'popup' => $this->model_tool_image->resize($event_image['image'], $image_popup_width, $image_popup_height),
				'thumb' => $this->model_tool_image->resize($event_image['image'], $image_additional_width, $image_additional_height)
			);
    	}

		$info = array(
			'cevent_id'   => $event_info['cevent_id'],
			'name'        => $event_info['name'],
			'price'		  => $event_info['price'],
			'duration'	  => $event_info['duration'],
			'description' => html_entity_decode($event_info['description']),
			'main_image'  => $this->model_tool_image->resize($event_info['image'], $image_thumb_width, $image_thumb_height),
			'images'      => $images,
			'timeslots'   => $timeslots,
			'special_timeslots' => $special_timeslots,
		);

		$json['info'] = $info;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function validate() {

        $this->load->language('extension/module/calendar');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
                $this->error['name'] = $this->language->get('error_name');
            }

            if ((int)$this->request->post['contact'] < 1) {
                $this->error['contact'] = $this->language->get('error_contact');
            }
            
            if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error['email'] = $this->language->get('error_email');
            }

            // if ((utf8_strlen($this->request->post['outlet']) == "")) {
            //     $this->error['outlet'] = $this->language->get('error_outlet');
            // }
            
            // if ((utf8_strlen($this->request->post['message']) < 10) || (utf8_strlen($this->request->post['message']) > 3000)) {
            //     $this->error['message'] = $this->language->get('error_message');
            // }
            
            // Captcha
            // if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
            //     $captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
                
            //     if ($captcha) {
            //         $this->error['captcha'] = $captcha;
            //     }
            // }

            $json['error'] = $this->error;

        }

        if(!$json['error']) {

        	$this->load->model('catalog/calendar');

        	$this->model_catalog_calendar->addAppointment($this->request->post);

        	$event = $this->model_catalog_calendar->getCalendarEvent($this->request->post['event_id']);

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            
            $recipients = array(
              $this->config->get('config_email'),
              $this->request->post['email'],
            );
            
            $mail->setTo(implode(',', $recipients));
            //$mail->setFrom($this->request->post['email']);
            $mail->setFrom($this->config->get('config_email'));

            $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode('[' . $this->language->get('email_subject') . '] - ' . $this->request->post['name'], ENT_QUOTES, 'UTF-8'));
            
            $message = "";
            
            $message .= $this->language->get('entry_event') . ":\n";
            $message .= $event['name'] ? $event['name'] : "";
            $message .= "\n\n";

            foreach ($this->posts as $post_var => $post_default_value){
                if( !in_array($post_var, $this->disallow_in_message_body) ){
                    $message .= $this->language->get('entry_' .$post_var) . ":\n";
                    //$message .= $this->request->post[$post_var]??"";
                    $message .= $this->request->post[$post_var] ? $this->request->post[$post_var] : "";
                    $message .= "\n\n";
                }
            }
            
            $mail->setText($message);
            $mail->send();
            
            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}