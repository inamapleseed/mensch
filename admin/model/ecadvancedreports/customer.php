<?php
class ModelEcadvancedreportsCustomer extends Model {
	public function getReport($data = array()) {
		$sql = "SELECT tmp.customer_group_id, tmp.customer_group, tmp.status, SUM(tmp.total_orders) AS orders,  SUM(tmp.customer_order_total) AS total FROM (SELECT COUNT(o.order_id) total_orders, o.customer_id, cgd.customer_group_id, cgd.name AS customer_group, c.status, SUM(o.total) customer_order_total FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "customer` c ON (o.customer_id = c.customer_id) LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE o.customer_id > 0 AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " AND o.store_id = '0'";
		}

	
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " GROUP BY o.customer_id) tmp GROUP BY tmp.customer_group_id ORDER BY total DESC";
		

		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getCustomersNotOrder($data = array()) {
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}

		if (!empty($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sql .= " AND c.customer_id NOT IN (SELECT customer_id FROM `" . DB_PREFIX . "order`)";

		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.approved',
			'c.ip',
			'c.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if(!isset($data['all']) || !$data['all']) {
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		}
		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getTotalCustomersNotOrder($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}

		if (!empty($data['filter_ip'])) {
			$implode[] = "customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}


		if ($implode) {
			$implode[] = "customer_id NOT IN (SELECT customer_id FROM `" . DB_PREFIX . "order`)";
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	public function getReportByCompany($data = array()) {
		$sql = "SELECT tmp.customer_company, SUM(tmp.total_orders) AS orders,  SUM(tmp.customer_order_total) AS total FROM (SELECT COUNT(o.order_id) total_orders, o.customer_id, o.payment_company AS customer_company,SUM(o.total) customer_order_total FROM `" . DB_PREFIX . "order` o WHERE o.customer_id > 0 ";
		

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " AND o.store_id = '0'";
		}

	
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " GROUP BY o.customer_id) tmp GROUP BY tmp.customer_company ORDER BY total DESC";
		

		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	public function getTopCustomer($data = array()) {
		$limit = isset($data['limit'])?$data['limit']:10;

		$sql = "SELECT o.customer_id, o.payment_company as customer_company, CONCAT(c.firstname,' ',c.lastname) customer_name, c.email, IFNULL(SUM(o.total) ,0) subtotal, COUNT(*) AS total_sale, o.store_id, o.date_added FROM `" . DB_PREFIX . "order` o 
			LEFT JOIN `".DB_PREFIX."customer` c ON c.customer_id = o.customer_id";

		$sql .= " WHERE 1 AND o.customer_id > 0 ";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " GROUP BY o.customer_id";
		$sql .= " ORDER BY subtotal DESC, total_sale DESC ";
		if(!isset($data['all']) || !$data['all']) {
			$sql .= " LIMIT " . (int)$limit;
		}
		

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalCustomerReport( $data = array() ) {
		$where = "1 ";
		$filter_country = isset($data['filter_country'])?$data['filter_country']:"";

		$sql = "SELECT COUNT(o.customer_id) AS `total`, o.customer_id FROM `" . DB_PREFIX . "order` o 
			LEFT JOIN `".DB_PREFIX."customer` c ON c.customer_id = o.customer_id";

		$sql .= " WHERE 1 AND o.customer_id > 0 ";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " GROUP BY o.customer_id";

		$query = $this->db->query($sql);

		return isset($query->row['total'])?$query->row['total']:0;
	}

	public function getCustomerReport($data = array()) {
		$limit = isset($data['limit'])?$data['limit']:10;

		$sql = "SELECT o.customer_id, o.payment_company as `company`, c.firstname, c.lastname, o.shipping_city, o.shipping_postcode, CONCAT(c.firstname,' ',c.lastname) customer_name, c.email, IFNULL(SUM(o.total) ,0) subtotal, COUNT(*) AS number_order, o.store_id FROM `" . DB_PREFIX . "order` o 
			LEFT JOIN `".DB_PREFIX."customer` c ON c.customer_id = o.customer_id";

		$sql .= " WHERE 1 AND o.customer_id > 0 ";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " GROUP BY o.customer_id";
		$sql .= " ORDER BY c.firstname ASC, c.lastname ASC ";

		if(!isset($data['all']) || !$data['all']) {
			$sql .= " LIMIT " . (int)$limit;
		}
		


		$query = $this->db->query($sql);

		$reports = array();

		if($query->num_rows > 0) {
			$orders = $query->rows;

			foreach($orders as $key=>$row) {

				/*Get number order*/
				$query_order = $this->db->query("SELECT COUNT(*) AS number_order
				FROM `" . DB_PREFIX . "order` o WHERE o.customer_id = ".$row['customer_id']);

				$row['number_order'] = 0;
				if($query_order->num_rows > 0) {
					$row['number_order'] = $query_order->row['number_order'];
				}

				/*Get number products*/
				$query_total = $this->db->query("SELECT SUM(ot.value) AS `total`
				 FROM `".DB_PREFIX."order` o LEFT JOIN `".DB_PREFIX."order_total` ot ON o.order_id = ot.order_id WHERE o.customer_id = ".$row['customer_id']." AND ot.code = 'total'");

				$row['total'] = 0;
				if($query_total->num_rows > 0) {
					$row['total'] = $query_total->row['total'];
				}



				$query_total = $this->db->query("SELECT SUM(ot.value) AS `subtotal`
				 FROM `".DB_PREFIX."order` o LEFT JOIN `".DB_PREFIX."order_total` ot ON o.order_id = ot.order_id WHERE o.customer_id = ".$row['customer_id']." AND ot.code = 'sub_total'");

				$row['subtotal'] = 0;
				if($query_total->num_rows > 0) {
					$row['subtotal'] = $query_total->row['subtotal'];
				}



				/*Get total tax*/
				$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order` o LEFT JOIN `".DB_PREFIX."order_total` ot ON ot.order_id = o.order_id WHERE o.customer_id = ".$row['customer_id']."  AND ot.code = 'tax'");
				$row['tax'] = 0;
				if($query_tax->num_rows > 0) {
					$row['tax'] = $query_tax->row['tax'];
				}

				/*Get total shipping*/
				$row['shipping'] = 0;
				$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order` o LEFT JOIN `".DB_PREFIX."order_total` ot ON ot.order_id = o.order_id WHERE o.customer_id = ".$row['customer_id']." AND ot.code = 'shipping'");
				if($query_shipping->num_rows > 0) {
					$row['shipping'] = $query_shipping->row['shipping'];
				}

				/*Get total shipping*/
				$row['discount'] = 0;
				$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order` o LEFT JOIN `".DB_PREFIX."order_total` ot ON ot.order_id = o.order_id WHERE o.customer_id = ".$row['customer_id']." AND ot.code = 'coupon'");

				if($query_discount->num_rows > 0) {
					$row['discount'] = $query_discount->row['discount'];
				}

				$reports[] = $row;
			}
		}
		return $reports;
	}

	public function getCustomerByCountry($data = array()) {
		$where = "1 ";
		$filter_city = isset($data['filter_city'])?$data['filter_city']:"";

		$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
		$sql1 = "SELECT o.order_id, o.customer_id, o.payment_country as `country_name`, o.total, o.date_added FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$sql1 .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql1 .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql1 .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql1 .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql1 .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql1 .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if(!empty($filter_city)) {
			$sql1 .= " AND o.payment_country LIKE '%".$filter_city."%'";
		}

		$sql1 .= " ORDER BY country_name ASC";

		if(!isset($data['all']) || !$data['all']) {
			if (isset($data['start']) || isset($data['limit'])) {
				if (!isset($data['start']) || $data['start'] < 0) {
					$data['start'] = 0;
				}			

				if (!isset($data['limit']) || $data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$sql1 .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		}
		$query = $this->db->query($sql1);
		$reports = array();

		if($query->num_rows > 0) {
			$orders = $query->rows;
			$city = array();

			foreach($orders as $key=>$row) {
				$row['country_name'] = trim($row['country_name']);

				if(!isset($city[$row['country_name']])) {
					$city[$row['country_name']] = array();
				}
				$row['products'] = $row['product_total'] = $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

				/*Get number products*/
				$query_products = $this->db->query("SELECT SUM(op.quantity) as `products`, SUM(op.total) as `product_total`
				 FROM `".DB_PREFIX."order_product` op WHERE op.order_id = ".$row['order_id']." GROUP BY op.order_id");
				if($query_products->num_rows > 0) {
					$row['products'] = $query_products->row['products'];
					$row['product_total'] = $query_products->row['product_total'];
				}

				/*Get total tax*/
				$row['tax'] = 0;
				$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot WHERE ot.order_id = ".$row['order_id']." AND ot.code = 'tax' GROUP BY ot.order_id");
				if($query_tax->num_rows > 0) {
					$row['tax'] = $query_tax->row['tax'];
				}

				/*Get total shipping*/
				$row['shipping'] = 0;
				$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot WHERE ot.order_id = ".$row['order_id']." AND ot.code = 'shipping' GROUP BY ot.order_id");
				if($query_shipping->num_rows > 0) {
					$row['shipping'] = $query_shipping->row['shipping'];
				}

				/*Get total discount*/
				$row['discount'] = 0;
				$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot WHERE ot.order_id = ".$row['order_id']." AND ot.code = 'coupon' GROUP BY ot.order_id");
				if($query_discount->num_rows > 0) {
					$row['discount'] = $query_discount->row['discount'];
				}

				/*Get total refunded*/
				$row['refunded'] = 0;
				$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
					FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
					WHERE r.return_status_id = ".(int)$return_status_id." AND r.order_id = ".$row['order_id']."
					GROUP BY DATE(r.date_ordered)");
				if($query_refunded->num_rows > 0) {
					$row['refunded'] = $query_refunded->row['refunded'];
				}

				$city[$row['country_name']][] = $row;

			}

			if($city) {
				foreach($city as $key=>$val) {
					$tmp = array();
					$tmp['number_orders'] = count($val);
					$tmp['items_ordered'] = $tmp['subtotal'] = $tmp['tax'] = $tmp['shipping'] = $tmp['discount'] = $tmp['total'] = $tmp['refunded'] = $tmp['customers'] = 0;
					$tmp['country_name'] = $key;
					if($val) {
						$tmp2 = array();
						foreach($val as $k=>$v) {
							if(!in_array((int)$v['customer_id'], $tmp2))
								$tmp['customers'] +=1;
							$tmp['items_ordered'] += (int)$v['products'];
							$tmp['subtotal'] += (float)$v['total'];
							$tmp['total'] += (float)$v['product_total'];
							$tmp['tax'] += (float)$v['tax'];
							$tmp['shipping'] += (float)$v['shipping'];
							$tmp['discount'] += (float)$v['discount'];
							$tmp['refunded'] += (float)$v['refunded'];
						}
						unset($tmp2);
					}
					$reports[] = $tmp;
					unset($tmp);
				}
				
			}
		
		}
		return $reports;
	}

	public function getTotalCustomerCountry( $data = array() ) {
		$where = "1 ";
		$filter_country = isset($data['filter_country'])?$data['filter_country']:"";

		$sql1 = "SELECT COUNT(o.order_id) AS `total`, o.payment_country AS `country_name` FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$sql1 .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql1 .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql1 .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql1 .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql1 .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql1 .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if(!empty($filter_country)) {
			$sql1 .= " AND `payment_country` LIKE '%".$filter_country."%'";
		}

		$query = $this->db->query($sql1);

		return isset($query->row['total'])?$query->row['total']:0;
	}

	public function getCustomerByCity($data = array()) {
		$where = "1 ";
		$filter_city = isset($data['filter_city'])?$data['filter_city']:"";

		$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
		$sql1 = "SELECT o.order_id, o.customer_id, CONCAT(o.payment_city, ', ', o.payment_country) as city_name, o.total, o.date_added FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$sql1 .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql1 .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql1 .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql1 .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql1 .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql1 .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if(!empty($filter_city)) {
			$sql1 .= " AND CONCAT(o.payment_city, ', ', o.payment_country) LIKE '%".$filter_city."%'";
		}

		$sql1 .= " ORDER BY city_name ASC";
		if(!isset($data['all']) || !$data['all']) {

			if (isset($data['start']) || isset($data['limit'])) {
				if (!isset($data['start']) || $data['start'] < 0) {
					$data['start'] = 0;
				}			

				if (!isset($data['limit']) || $data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$sql1 .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		}
		$query = $this->db->query($sql1);
		$reports = array();

		if($query->num_rows > 0) {
			$orders = $query->rows;
			$city = array();

			foreach($orders as $key=>$row) {
				$row['city_name'] = trim($row['city_name']);

				if(!isset($city[$row['city_name']])) {
					$city[$row['city_name']] = array();
				}
				$row['products'] = $row['product_total'] = $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

				/*Get number products*/
				$query_products = $this->db->query("SELECT SUM(op.quantity) as `products`, SUM(op.total) as `product_total`
				 FROM `".DB_PREFIX."order_product` op WHERE op.order_id = ".$row['order_id']." GROUP BY op.order_id");
				if($query_products->num_rows > 0) {
					$row['products'] = $query_products->row['products'];
					$row['product_total'] = $query_products->row['product_total'];
				}

				/*Get total products*/
				$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot WHERE ot.order_id = ".$row['order_id']." AND ot.code = 'tax' GROUP BY ot.order_id");
				if($query_tax->num_rows > 0) {
					$row['tax'] = $query_tax->row['tax'];
				}

				/*Get total products*/
				$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot WHERE ot.order_id = ".$row['order_id']." AND ot.code = 'shipping' GROUP BY ot.order_id");
				if($query_shipping->num_rows > 0) {
					$row['shipping'] = $query_shipping->row['shipping'];
				}

				/*Get total products*/
				$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot WHERE ot.order_id = ".$row['order_id']." AND ot.code = 'coupon' GROUP BY ot.order_id");
				if($query_discount->num_rows > 0) {
					$row['discount'] = $query_discount->row['discount'];
				}

				/*Get total products*/
				$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
					FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
					WHERE r.return_status_id = ".(int)$return_status_id." AND r.order_id = ".$row['order_id']."
					GROUP BY DATE(r.date_ordered)");
				if($query_refunded->num_rows > 0) {
					$row['refunded'] = $query_refunded->row['refunded'];
				}

				$city[$row['city_name']][] = $row;

			}

			if($city) {
				foreach($city as $key=>$val) {
					$tmp = array();
					$tmp['number_orders'] = count($val);
					$tmp['items_ordered'] = $tmp['subtotal'] = $tmp['tax'] = $tmp['shipping'] = $tmp['discount'] = $tmp['total'] = $tmp['refunded'] = $tmp['customers'] = 0;
					$tmp['city_name'] = $key;
					if($val) {
						$tmp2 = array();
						foreach($val as $k=>$v) {
							if(!in_array((int)$v['customer_id'], $tmp2))
								$tmp['customers'] +=1;
							$tmp['items_ordered'] += (int)$v['products'];
							$tmp['subtotal'] += (float)$v['total'];
							$tmp['total'] += (float)$v['product_total'];
							$tmp['tax'] += (float)$v['tax'];
							$tmp['shipping'] += (float)$v['shipping'];
							$tmp['discount'] += (float)$v['discount'];
							$tmp['refunded'] += (float)$v['refunded'];
						}
						unset($tmp2);
					}
					$reports[] = $tmp;
					unset($tmp);
				}
				
			}
		
		}
		return $reports;
	}
	public function getTotalCustomerCity( $data = array() ) {
		$where = "1 ";
		$filter_city = isset($data['filter_city'])?$data['filter_city']:"";

		$sql1 = "SELECT COUNT(o.order_id) AS `total`, CONCAT(o.payment_city, ', ', o.payment_country) as city_name FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$sql1 .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql1 .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql1 .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql1 .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql1 .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql1 .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if(!empty($filter_city)) {
			$sql1 .= " AND CONCAT(o.payment_city, ', ', o.payment_country) LIKE '%".$filter_city."%'";
		}

		$query = $this->db->query($sql1);

		return isset($query->row['total'])?$query->row['total']:0;
	}
	public function getUserActivity( $data = array()) {
		$where = "";
		$report_period = isset($data['report_period'])?$data['report_period']:'month';
		$select_datefield = ' CONCAT(MONTH(tmp.date_added),"/",YEAR(tmp.date_added)) AS datefield';
		switch ($report_period) {
			case 'day':
				$select_datefield = 'DATE(tmp.date_added) AS datefield';
				break;
			case 'week':
				$select_datefield = 'CONCAT(YEAR(tmp.date_added),"",WEEK(tmp.date_added)) AS datefield';
				break;
			case 'quarter':
				$select_datefield = 'CONCAT(QUARTER(tmp.date_added),"/",YEAR(tmp.date_added)) AS datefield';
				break;
			case 'year':
				$select_datefield = 'YEAR(tmp.date_added) AS datefield';
				break;
		}
		$sql = "";
		$sql .= "SELECT ".$select_datefield .", SUM(tmp.order_id) number_orders, SUM(tmp.customer_id) number_customers, SUM(tmp.review_id) number_reviews
			FROM ( ";

		$sql .= " SELECT 1 AS order_id, 0 AS customer_id, 0 AS review_id, date_added FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id IN ( " . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " UNION ";

		$sql .= " SELECT 0 AS order_id, 1 AS customer_id, 0 AS review_id, date_added FROM `".DB_PREFIX."customer` c ";


		if (!empty($data['filter_store_id'])) {
			$sql .= " WHERE c.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " WHERE c.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(c.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(c.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " UNION ";

		$sql .= " SELECT 0 AS order_id, 0 AS customer_id, 1 AS review_id, date_added FROM `".DB_PREFIX."review` r ";
		$sql .= " LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON p2s.product_id = r.product_id ";

		if (!empty($data['filter_store_id'])) {
			$sql .= " WHERE p2s.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$sql .= " WHERE p2s.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(r.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(r.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= ") tmp
			GROUP BY datefield ORDER BY datefield ";

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
?>