<?php
class ModelEcadvancedreportsReport extends Model {

	var $_VERSION = "2.0.0";

	public function initInstall(){
		return true;
		$this->load->model('user/user');
		$user = $this->model_user_user->getUser($this->user->getId());
		$user_group_id = isset($user['user_group_id'])?$user['user_group_id']:0;

		$links = $this->getAccessLinks();

		if($user_group_id) {
			$query = $this->db->query("SELECT `permission` FROM `".DB_PREFIX."user_group` WHERE `user_group_id`=".(int)$user_group_id);
			if($query->num_rows > 0) {
				try{
					$permission = unserialize($query->row['permission']);

					$access_links = $links;
					$modify_links = $links;
					if(is_array($permission['modify']) && $permission['modify']) {
						$permission['modify'] = array_merge($permission['modify'], $links);
					}
					if(is_array($permission['access']) && $permission['access']) {
						$permission['access'] = array_merge($permission['access'], $links);
					}

					$permission = serialize($permission);
					$query = $this->db->query("UPDATE `".DB_PREFIX."user_group` SET `permission` = '".$permission."' WHERE `user_group_id`=".(int)$user_group_id);
				} catch( Exception $exception ) {
					
				}
			}
		}
		/**/
		$this->runInstallModification();
	}

	public function getAccessLinks() {
		return array( "ecadvancedreports/customer_city",
            "ecadvancedreports/customer_country",
            "ecadvancedreports/customer_group",
            "ecadvancedreports/product",
            "ecadvancedreports/product_bestseller",
            "ecadvancedreports/product_inventory",
            "ecadvancedreports/sale_category",
            "ecadvancedreports/category",
            "ecadvancedreports/sale_country",
            "ecadvancedreports/sale_coupon",
            "ecadvancedreports/sale_day_week",
            "ecadvancedreports/report_product",
            "ecadvancedreports/report_revenue",
            "ecadvancedreports/sale_hour",
            "ecadvancedreports/sale_manufacturer",
            "ecadvancedreports/sale_order",
            "ecadvancedreports/sale_payment",
            "ecadvancedreports/sale_report",
            "ecadvancedreports/sale_statistics",
            "ecadvancedreports/top_customer",
            "ecadvancedreports/sale_zipcode",
            "ecadvancedreports/user_activity");
	}

	public function runInstallModification() {
		try{
			$query = $this->db->query("SELECT `version` FROM `".DB_PREFIX."modification` WHERE `version` ='".$this->_VERSION."' AND `code`='ec_advanced_reports'");

			$modify =  DIR_SYSTEM . 'ecadvancedreports/ocmod/modification-'.$this->_VERSION.'.ocmod.xml';
			//If current version are not exists

			if($query->num_rows == 0 && file_exists($modify)) {

				$query = $this->db->query("DELETE FROM `".DB_PREFIX."modification` WHERE `code`='ec_advanced_reports'");

				$content = file_get_contents( $modify  );
				$dom = new DOMDocument('1.0', 'UTF-8');
				$dom->preserveWhiteSpace = false;
				$dom->loadXml($content );

				$name = $dom->getElementsByTagName('name')->item(0)->textContent; 
				$code = $dom->getElementsByTagName('code')->item(0)->textContent;
				$author = $dom->getElementsByTagName('author')->item(0)->textContent;
				$version = $dom->getElementsByTagName('version')->item(0)->textContent;
				$link = $dom->getElementsByTagName('link')->item(0)->textContent;

				$data = array(
					'name' => $name,
					'author' => $author,
					'version' => $this->_VERSION,
					'link'	  => $link,
					'code'	  => $code,
					'status'  => 1,
					'xml'	=> $content,
					'date_added' => date('Y-m-d')
				);

			
				$this->load->model('extension/modification');
				$this->model_extension_modification->addModification( $data  );
				
			}

		} catch( Exception $exception ) {
					
		}
	}
	
}