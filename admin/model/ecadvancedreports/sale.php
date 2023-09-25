<?php
class ModelEcadvancedreportsSale extends Model {

	public function getSaleByCountry($data = array()) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.country.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {
			$sql = "SELECT COUNT(o.order_id) order_quantity, o.payment_country `country_name`, c.iso_code_2 `country_code`, o.payment_country_id `country_id`, o.order_status_id, 
					IFNULL(SUM(o.total),0) AS order_total
					FROM `".DB_PREFIX."order` o
					LEFT JOIN `".DB_PREFIX."country` c ON (o.payment_country_id = c.country_id) 
					WHERE 1";
			

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
			
			$sql .= " GROUP BY o.payment_country ORDER BY order_total DESC";
			
			$query = $this->db->query($sql);
			
			$reports = $query->rows;

			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleProductPerCountry($data = array()) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.product.country.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {
			$sql = "SELECT COUNT(op.order_product_id) AS total_product,IFNULL(SUM(op.quantity),0) AS total_qty_product, o.payment_country AS `country_name`, c.iso_code_2 AS `country_code`, o.payment_country_id AS `country_id`, o.order_status_id, 
					IFNULL(SUM(o.total),0) AS order_total
					FROM `".DB_PREFIX."order` o
					LEFT JOIN `".DB_PREFIX."order_product` op ON (o.order_id = op.order_id) 
					LEFT JOIN `".DB_PREFIX."country` c ON (o.payment_country_id = c.country_id) 
					WHERE 1";
			

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
			
			$sql .= " GROUP BY o.payment_country ORDER BY order_total DESC";
			
			$query = $this->db->query($sql);
			
			$reports = $query->rows;

			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleByHour( $data = array() ) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.hour.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {
			$sql = "SELECT date_format(o.date_added, '%H:00') as the_hour, 
					COUNT(o.order_id) AS `quantity`, SUM(o.total) AS total
					FROM `".DB_PREFIX."order` o";

			$sql .= " WHERE 1 ";
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
			
			$sql .= " GROUP BY the_hour ORDER BY the_hour";

			$query = $this->db->query($sql);
			
			$reports = $query->rows;
			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleByDayWeek( $data = array() ) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.dayweek.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {
			$sql = "SELECT WEEKDAY(o.date_added) AS week_day, 
				COUNT(o.order_id) AS `quantity`, SUM(o.total) AS total
				FROM `".DB_PREFIX."order` o";

			$sql .= " WHERE 1 ";
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
			
			$sql .= " GROUP BY week_day ORDER BY week_day";

			$query = $this->db->query($sql);
			$reports = $query->rows;
			$this->cache->set($cache_name, $reports);
		}
		
		
		return $reports;
	}


	public function getSaleByPayment( $data = array()) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.payment.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);
		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) { 
			$where = "";
			$base_where = "";
			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;

			$sql1 = "SELECT o.order_id, COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `subtotal`, o.date_added, TRIM(o.payment_method) as `payment_method`, o.payment_code FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			if (!empty($data['filter_date_start'])) {
				$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}

			if (!empty($data['filter_date_end'])) {
				$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}

			$sql1 .= $where;

			$sql1 .= " GROUP BY `payment_code` ORDER BY `payment_code`";

			$query = $this->db->query($sql1);

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				foreach($orders as $key=>$row) {
					$row['payment_code'] = trim($row['payment_code']);
					if(!$row['payment_code']){
						continue;
					}
						
					$row['items_ordered'] = $row['total'] = $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE TRIM(o.payment_code) = '".$row['payment_code']."'".$base_where);

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
						$row['total'] = $query_products->row['total'];
					}

					/*Get total tax*/
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot  
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.payment_code) = '".$row['payment_code']."' AND ot.code = 'tax'".$base_where);
					if($query_tax->num_rows > 0) {
						$row['tax'] = $query_tax->row['tax'];
					}

					/*Get total shipping*/
					$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.payment_code) = '".$row['payment_code']."' AND ot.code = 'shipping'".$base_where);
					if($query_shipping->num_rows > 0) {
						$row['shipping'] = $query_shipping->row['shipping'];
					}

					/*Get total discount*/
					$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot  LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.payment_code) = '".$row['payment_code']."' AND ot.code = 'coupon'".$base_where);
					if($query_discount->num_rows > 0) {
						$row['discount'] = $query_discount->row['discount'];
					}

					/*Get total refunded*/
					$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
						FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = r.order_id
					 	WHERE TRIM(o.payment_code) = '".$row['payment_code']."' AND r.return_status_id = ".(int)$return_status_id."
						".$base_where);

					if($query_refunded->num_rows > 0) {
						$row['refunded'] = $query_refunded->row['refunded'];
					}

					$reports[$row['payment_code']] = $row;

				}
			
			}
			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleByCoupon( $data = array()) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.coupon.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {
				$where = "";
				$base_where = "";
				$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;

				$sql1 = "SELECT o.order_id, COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `subtotal`, o.date_added, SUM(ot.value) as `discount`, ot.title as coupon_code FROM `".DB_PREFIX."order` o ";
				$sql1 .= "LEFT JOIN `".DB_PREFIX."order_total` ot ON (ot.order_id = o.order_id )";

				if (!empty($data['filter_order_status_id'])) {
					$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
					$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				} else {
					$where .= " WHERE o.order_status_id > '0'";
					$base_where .= " AND o.order_status_id > '0'";
				}

				if (!empty($data['filter_store_id'])) {
					$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
					$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				} else {
					$where .= " AND o.store_id = '0'";
					$base_where .= " AND o.store_id = '0'";
				}

				if (!empty($data['filter_date_start'])) {
					$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
				}

				if (!empty($data['filter_date_end'])) {
					$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
				}

				$where .= " AND ot.code = 'coupon'";

				$sql1 .= $where;

				$sql1 .= " GROUP BY `coupon_code` ORDER BY `coupon_code`";

				$query = $this->db->query($sql1);

				if($query->num_rows > 0) {
					/*query get order info*/
					$orders = $query->rows;
					foreach($orders as $key=>$row) {
						$row['coupon_code'] = trim($row['coupon_code']);
						if(!$row['coupon_code']){
							continue;
						}
						
						$row['items_ordered'] = $row['total'] = $row['tax'] = $row['shipping'] = $row['refunded'] = 0;

						/*Get number products*/
						$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
						 FROM `".DB_PREFIX."order_product` op 
						 LEFT JOIN `".DB_PREFIX."order_total` ot ON (ot.order_id = op.order_id) 
						 WHERE ot.title = '".$row['coupon_code']."'");

						if($query_products->num_rows > 0) {
							$row['items_ordered'] = $query_products->row['items_ordered'];
							$row['total'] = $query_products->row['total'];
						}
						

						/*Get total tax*/
						$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot  
							LEFT JOIN `".DB_PREFIX."order_total` ot2 ON (ot2.order_id = ot.order_id) 
						 WHERE ot2.title = '".$row['coupon_code']."' AND ot.code = 'tax'");
						if($query_tax->num_rows > 0) {
							$row['tax'] = $query_tax->row['tax'];
						}

						/*Get total shipping*/
						$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
						 LEFT JOIN `".DB_PREFIX."order_total` ot2 ON (ot2.order_id = ot.order_id) 
						 WHERE ot2.title = '".$row['coupon_code']."' AND ot.code = 'shipping'");
						if($query_shipping->num_rows > 0) {
							$row['shipping'] = $query_shipping->row['shipping'];
						}

						/*Get total refunded*/
						$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
							FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
							 LEFT JOIN `".DB_PREFIX."order_total` ot ON (ot.order_id = r.order_id) 
						 WHERE ot.title = '".$row['coupon_code']."' AND r.return_status_id = ".(int)$return_status_id."
							");

						if($query_refunded->num_rows > 0) {
							$row['refunded'] = $query_refunded->row['refunded'];
						}
						$coupon_code = str_replace(array("Coupon(",")"), "", $row['coupon_code']);
						//$coupon_code = trim($coupon_code);
						$row['coupon_code'] = $coupon_code;
						$reports[$coupon_code] = $row;

					}
					
				
				}
			$this->cache->set($cache_name, $reports);
		}
		return $reports;

	}

	public function getTotalSaleZipcode( $data = array() ) {
		$sql1 = "SELECT COUNT(o.order_id) AS `total` FROM `".DB_PREFIX."order` o ";

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

		$query = $this->db->query($sql1);

		return $query->row['total'];
	}

	public function getSaleByZipcode( $data = array()) {
		$start = 0;
		$limit = 20;
		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}			

			if (!isset($data['limit']) || $data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$start = (int)$data['start'];
			$limit = (int)$data['limit'];
			
		}

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;

		$cache_name = "ecreport.sale.zipcode.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']).".".$start.".".$limit;

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$where = "";
			$base_where = "";
			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;

			$sql1 = "SELECT o.order_id, COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `subtotal`, o.date_added, TRIM(o.payment_postcode) as `zipcode` FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			if (!empty($data['filter_date_start'])) {
				$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}

			if (!empty($data['filter_date_end'])) {
				$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}

			$sql1 .= $where;

			$sql1 .= " GROUP BY `zipcode` ORDER BY `zipcode`";

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

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				foreach($orders as $key=>$row) {
					$row['zipcode'] = trim($row['zipcode']);
					if(!$row['zipcode']){
						continue;
					}
						
					$row['total'] = $row['items_ordered'] = $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE TRIM(o.payment_postcode) = '".$row['zipcode']."'".$base_where);

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
						$row['total'] = $query_products->row['total'];
					}

					/*Get total tax*/
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot  
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.payment_postcode) = '".$row['zipcode']."' AND ot.code = 'tax'".$base_where);
					if($query_tax->num_rows > 0) {
						$row['tax'] = $query_tax->row['tax'];
					}

					/*Get total shipping*/
					$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.payment_postcode) = '".$row['zipcode']."' AND ot.code = 'shipping'".$base_where);
					if($query_shipping->num_rows > 0) {
						$row['shipping'] = $query_shipping->row['shipping'];
					}

					/*Get total discount*/
					$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot  LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.payment_postcode) = '".$row['zipcode']."' AND ot.code = 'coupon'".$base_where);
					if($query_discount->num_rows > 0) {
						$row['discount'] = $query_discount->row['discount'];
					}

					/*Get total refunded*/
					$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
						FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = r.order_id
					 	WHERE TRIM(o.payment_postcode) = '".$row['zipcode']."' AND r.return_status_id = ".(int)$return_status_id."
						".$base_where);

					if($query_refunded->num_rows > 0) {
						$row['refunded'] = $query_refunded->row['refunded'];
					}

					$reports[$row['zipcode']] = $row;

				}
			
			}
			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleByZipcodeArea($data){
		$where = "";
		$base_where = "";

		$sql1 = "SELECT COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `total` FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$where .= " WHERE o.order_status_id > '0'";
			$base_where .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$where .= " AND o.store_id = '0'";
			$base_where .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			$base_where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			$base_where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if(!empty($data['filter_postal_code'])){
			$implode = array();
			$postal_codes = explode(',', $data['filter_postal_code']);

			foreach ($postal_codes as $postal_code) {
				$implode[] = "TRIM(o.payment_postcode) LIKE '" . $postal_code . "%'";
			}

			if ($implode) {
				$where .= " AND (" . implode(" OR ", $implode) . ")";
				$base_where .= " AND (" . implode(" OR ", $implode) . ")";
			}
		}

		$sql1 .= $where;

		$query = $this->db->query($sql1);

		$row = $query->row;

		/*Get number products*/
		$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
		 FROM `".DB_PREFIX."order_product` op 
		 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
		 WHERE 1=1 ".$base_where);

		if($query_products->num_rows > 0) {
			$row['items_ordered'] = $query_products->row['items_ordered'];
		}

		return $row;
	}

	public function getSaleByZipcodeAreaManpower($data){
		$first_day_of_previous_month = date("Y-m-d", strtotime("first day of previous month"));
		$last_day_of_previous_month = date("Y-m-d", strtotime("last day of previous month"));
		$first_day_of_past_2_months = date("Y-m-d", strtotime("-1 months", strtotime($first_day_of_previous_month)));
		$last_day_of_past_2_months = date("Y-m-t", strtotime($first_day_of_past_2_months));

		$where = "";

		$sql1 = $sql2 = "SELECT COUNT(o.order_id) `number_orders` FROM `".DB_PREFIX."order` o ";

		if (!empty($data['filter_order_status_id'])) {
			$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$where .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$where .= " AND o.store_id = '0'";
		}

		if(!empty($data['filter_postal_code'])){
			$implode = array();
			$postal_codes = explode(',', $data['filter_postal_code']);

			foreach ($postal_codes as $postal_code) {
				$implode[] = "TRIM(o.payment_postcode) LIKE '" . $postal_code . "%'";
			}

			if ($implode) {
				$where .= " AND (" . implode(" OR ", $implode) . ")";
			}
		}

		$sql1 .= $where." AND DATE(o.date_added) >= '" . $this->db->escape($first_day_of_previous_month) . "' AND DATE(o.date_added) <= '" . $this->db->escape($last_day_of_previous_month) . "'";
		$sql2 .= $where." AND DATE(o.date_added) >= '" . $this->db->escape($first_day_of_past_2_months) . "' AND DATE(o.date_added) <= '" . $this->db->escape($last_day_of_past_2_months) . "'";

		$query = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);

		$past_month_orders = !empty($query->row['number_orders'])?$query->row['number_orders']:0;
		$past_2month_orders = !empty($query2->row['number_orders'])?$query2->row['number_orders']:0;

		$percentage['current_month'] = 0;
		$percentage['next_month'] = 0;
		$percentage['next_2month'] = 0;
		$percentage['next_3month'] = 0;
		if(!empty($past_2month_orders)){
			$percentage['current_month'] = round(($past_month_orders-$past_2month_orders)/$past_2month_orders*100);
		}

		if($percentage['current_month'] < 0){
			$current_month_order = round(($past_month_orders*(100-abs($percentage['current_month'])))/100);	
		}else{
			$current_month_order = round(($past_month_orders*(100+$percentage['current_month']))/100);	
		}

		if(!empty($past_month_orders)){
			$percentage['next_month'] = round(($current_month_order-$past_month_orders)/$past_month_orders*100);
		}
		/* End */

		if($percentage['next_month'] < 0){
			$next_month_order = round(($current_month_order*(100-abs($percentage['next_month'])))/100);	
		}else{
			$next_month_order = round(($current_month_order*(100+$percentage['next_month']))/100);	
		}
		
		if(!empty($current_month_order)){
			$percentage['next_2month'] = round(($next_month_order-$current_month_order)/$current_month_order*100);
		}
		/* End */

		if($percentage['next_2month'] < 0){
			$next_month2_order = round(($next_month_order*(100-abs($percentage['next_2month'])))/100);	
		}else{
			$next_month2_order = round(($next_month_order*(100+$percentage['next_2month']))/100);	
		}
		
		if(!empty($next_month_order)){
			$percentage['next_3month'] = round(($next_month2_order-$next_month_order)/$next_month_order*100);
		}
		/* End */

		return $percentage;
	}

	public function getTotalSaleStateDetail( $data = array() ) {
		$sql1 = "SELECT COUNT(o.order_id) AS `total` FROM `".DB_PREFIX."order` o ";

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

		if (!empty($data['filter_zone_id'])) {
			$sql1 .= " AND o.shipping_zone_id = '" . (int)$data['filter_zone_id'] . "'";
			
		} else {
			if (!empty($data['filter_zone_name'])) {
				$sql1 .= " AND o.shipping_zone = '" . $data['filter_zone_name'] . "'";
			
			} else {
				$sql1 .= " AND o.shipping_zone = ''";
			}
		
		}

		

		if (!empty($data['filter_date_start'])) {
			$sql1 .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql1 .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql1);

		return isset($query->row['total'])?$query->row['total']:0;
	}

	public function getSaleByStateDetail( $data = array()) {
		$start = 0;
		$limit = 20;
		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}			

			if (!isset($data['limit']) || $data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$start = (int)$data['start'];
			$limit = (int)$data['limit'];
			
		}

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.state.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".(int)$data['filter_zone_id'].".".urlencode($data['filter_zone_name']).".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']).".".$start.".".$limit;

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$where = "";
			$base_where = "";
			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;

			$sql1 = "SELECT o.order_id, o.customer_id, CONCAT(o.firstname, ' ', o.lastname) AS customer_name, o.total, o.date_added, o.shipping_zone as `zone_name`, TRIM(o.shipping_zone_id) as `zone_id` FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_zone_id'])) {
				$where .= " AND o.shipping_zone_id = '" . (int)$data['filter_zone_id'] . "'";
				$base_where .= " AND o.shipping_zone_id = '" . (int)$data['filter_zone_id'] . "'";	
			} else {
				if (!empty($data['filter_zone_name'])) {
					$where .= " AND o.shipping_zone = '" . $data['filter_zone_name'] . "'";
					$base_where .= " AND o.shipping_zone = '" . $data['filter_zone_name'] . "'";
				} else {
					$where .= " AND o.shipping_zone = ''";
					$base_where .= " AND o.shipping_zone = ''";
				}
			
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			if (!empty($data['filter_date_start'])) {
				$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}

			if (!empty($data['filter_date_end'])) {
				$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}

			$sql1 .= $where;

			$sql1 .= " ORDER BY `order_id`";
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

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				//echo "<pre>"; print_r($orders);die();
				foreach($orders as $key=>$row) {
					$row['zone_id'] = trim($row['zone_id']);
					if(!$row['zone_id']){
						continue;
					}
						
					$row['subtotal'] = $row['tax'] = $row['items_ordered'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
					 FROM `".DB_PREFIX."order_product` op 
					 WHERE op.order_id = '".$row['order_id']."'");

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
						$row['subtotal'] = $query_products->row['total'];
					}

					/*Get total tax*/
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot 
					 WHERE  ot.order_id = '".$row['order_id']."' AND ot.code = 'tax'");
					if($query_tax->num_rows > 0) {
						$row['tax'] = $query_tax->row['tax'];
					}

					/*Get total shipping*/
					$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
					 WHERE ot.order_id = '".$row['order_id']."' AND ot.code = 'shipping'");
					if($query_shipping->num_rows > 0) {
						$row['shipping'] = $query_shipping->row['shipping'];
					}

					/*Get total discount*/
					$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot 
					 WHERE ot.order_id = '".$row['order_id']."' AND ot.code = 'coupon'");
					if($query_discount->num_rows > 0) {
						$row['discount'] = $query_discount->row['discount'];
					}

					/*Get total refunded*/
					$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
						FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)

					 	WHERE op.order_id = '".$row['order_id']."' AND r.return_status_id = ".(int)$return_status_id."
						");

					if($query_refunded->num_rows > 0) {
						$row['refunded'] = $query_refunded->row['refunded'];
					}

					$reports[$row['order_id']] = $row;

				}
			
			}
			//echo "<pre>";print_r($reports);die();
			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getTotalSaleState( $data = array() ) {
		$sql1 = "SELECT COUNT(o.order_id) AS `total` FROM `".DB_PREFIX."order` o ";

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

		$query = $this->db->query($sql1);

		return isset($query->row['total'])?$query->row['total']:0;
	}

	public function getSaleByState( $data = array()) {
		$start = 0;
		$limit = 20;
		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}			

			if (!isset($data['limit']) || $data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$start = (int)$data['start'];
			$limit = (int)$data['limit'];
			
		}

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.state.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']).".".$start.".".$limit;

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$where = "";
			$base_where = "";
			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;

			$sql1 = "SELECT o.order_id, COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `subtotal`, o.date_added,o.shipping_zone as `zone_name`, TRIM(o.shipping_zone_id) as `zone_id` FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			if (!empty($data['filter_date_start'])) {
				$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}

			if (!empty($data['filter_date_end'])) {
				$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}

			$sql1 .= $where;

			$sql1 .= " GROUP BY `zone_id` ORDER BY `zone_name`";
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

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				foreach($orders as $key=>$row) {
					$row['zone_id'] = trim($row['zone_id']);
					if(!$row['zone_id']){
						continue;
					}
						
					$row['total'] = $row['items_ordered'] = $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE TRIM(o.shipping_zone_id) = '".$row['zone_id']."'".$base_where);

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
						$row['total'] = $query_products->row['total'];
					}

					/*Get total tax*/
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot  
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.shipping_zone_id) = '".$row['zone_id']."' AND ot.code = 'tax'".$base_where);
					if($query_tax->num_rows > 0) {
						$row['tax'] = $query_tax->row['tax'];
					}

					/*Get total shipping*/
					$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.shipping_zone_id) = '".$row['zone_id']."' AND ot.code = 'shipping'".$base_where);
					if($query_shipping->num_rows > 0) {
						$row['shipping'] = $query_shipping->row['shipping'];
					}

					/*Get total discount*/
					$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot  LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE TRIM(o.shipping_zone_id) = '".$row['zone_id']."' AND ot.code = 'coupon'".$base_where);
					if($query_discount->num_rows > 0) {
						$row['discount'] = $query_discount->row['discount'];
					}

					/*Get total refunded*/
					$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
						FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = r.order_id
					 	WHERE TRIM(o.shipping_zone_id) = '".$row['zone_id']."' AND r.return_status_id = ".(int)$return_status_id."
						".$base_where);

					if($query_refunded->num_rows > 0) {
						$row['refunded'] = $query_refunded->row['refunded'];
					}

					$reports[$row['zone_id']] = $row;

				}
			
			}

			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleByCategory( $data = array()) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.category.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$where = "1 ";
			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
			$order = isset($data['order'])?$data['order']:'category_name';
			$sort = isset($data['sort'])?$data['sort']:'ASC';
			$sql = "
			SELECT tmp.category_name, tmp.category_id, count(tmp.order_id) number_orders,  SUM( tmp.tax ) tax,
				sum(tmp.quantity) items_ordered, sum(tmp.total) total, 
				SUM(tmp.refunded) refunded
				FROM ( SELECT cd.name category_name, cd.category_id, op.order_id,  count(op.product_id) items_ordered, SUM( op.tax ) tax,
				sum(op.quantity) quantity, sum(op.total) total, 
				IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) refunded 
				FROM `".DB_PREFIX."product_to_category` pc
				LEFT JOIN `".DB_PREFIX."category_description` cd ON cd.category_id = pc.category_id
				LEFT JOIN `".DB_PREFIX."order_product` op on op.product_id = pc.product_id 
				LEFT JOIN `".DB_PREFIX."order` o on o.order_id = op.order_id 
				LEFT JOIN `".DB_PREFIX."return` r on (r.product_id = op.product_id AND r.order_id = op.order_id)

				WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
			";

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

			$sql .= "  GROUP BY category_name, order_id ) tmp
				GROUP BY category_name ORDER BY ".$order." ".$sort;
			
			$query = $this->db->query($sql);

			$reports = $query->rows;
			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleByManufacturer( $data = array()) {
		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.manufacturer.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']);

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$where = "1 ";
			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
			$order = isset($data['order'])?$data['order']:'manufacturer';
			$sort = isset($data['sort'])?$data['sort']:'ASC';
			$sql = "
			SELECT m.name manufacturer, COUNT(op.order_id) number_orders, SUM(op.tax) tax, SUM(op.quantity) items_ordered, SUM(op.total) total, IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0)  refunded
				FROM `".DB_PREFIX."manufacturer` m 
				LEFT JOIN `".DB_PREFIX."product` p on p.manufacturer_id = m.manufacturer_id
				LEFT JOIN `".DB_PREFIX."order_product` op on op.product_id = p.product_id
				LEFT JOIN `".DB_PREFIX."order` o on o.order_id = op.order_id
				LEFT JOIN `".DB_PREFIX."return` r on (r.product_id = op.product_id AND r.order_id = op.order_id)
				WHERE p.manufacturer_id > 0
			";

			if (!empty($data['filter_order_status_id'])) {
				$sql .= " AND o.order_status_id IN(" . $data['filter_order_status_id'] . ")";
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

			$sql .= " 
				GROUP BY manufacturer ORDER BY ".$order." ".$sort;


			$query = $this->db->query($sql);

			$reports = $query->rows;
			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getSaleReport( $data = array() ) {
		$where = "1 ";
		$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
		$report_period = isset($data['report_period'])?$data['report_period']:'month';

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.salereport.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']).".".$report_period;

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$select_datefield = ' CONCAT(MONTH(o.date_added),"/",YEAR(o.date_added)) AS datefield';
			switch ($report_period) {
				case 'day':
					$select_datefield = 'DATE(o.date_added) AS datefield';
					break;
				case 'week':
					$select_datefield = 'CONCAT(YEAR(o.date_added),"",WEEK(o.date_added)) AS datefield';
					break;
				case 'quarter':
					$select_datefield = 'CONCAT(QUARTER(o.date_added),"/",YEAR(o.date_added)) AS datefield';
					break;
				case 'year':
					$select_datefield = 'YEAR(o.date_added) AS datefield';
					break;
			}

			$sql = "
			SELECT ".$select_datefield.", op.order_product_id, CONCAT(op.order_id,'_',op.product_id) AS order_product_id2, CONCAT(o.firstname,' ',o.lastname) AS customer_name, o.order_id, o.date_added AS order_date, o.email as customer_email, o.customer_id, o.payment_company as `customer_company`, o.payment_country as `country`, o.payment_zone `region`, o.payment_city `city`, o.payment_postcode `zipcode`, CONCAT(o.invoice_prefix,'',o.invoice_no) AS invoice_no,
					op.model, op.name AS product_name, op.quantity, op.price, op.total AS subtotal, IFNULL((op.price * op.quantity), 0) `total`, IFNULL((op.total + (op.quantity * op.tax) ), 0) `total_include_tax`,  op.tax, op.reward, op.product_id,
				p.price as original_price,
				cgd.name as custom_group_name,
				m.name as `manufacturer`,
				r.quantity as refunded_quantity, IFNULL((op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) refunded
				
				FROM `".DB_PREFIX."order_product` op 
				LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
				LEFT JOIN `".DB_PREFIX."customer_group_description` cgd ON cgd.customer_group_id = o.customer_group_id
				LEFT JOIN `".DB_PREFIX."return` r on (r.product_id = op.product_id AND r.order_id = op.order_id AND r.return_status_id =  ".(int)$return_status_id.")
				LEFT JOIN `".DB_PREFIX."product` p ON p.product_id = op.product_id
				LEFT JOIN `".DB_PREFIX."manufacturer` m ON m.manufacturer_id = p.manufacturer_id
			";

			if (!empty($data['filter_order_status_id'])) {
				$sql .= " WHERE o.order_status_id IN(" . $data['filter_order_status_id'] . ")";
			} else {
				$sql .= " WHERE o.order_status_id > '0'";
			}

			$sql .= " AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

			if (!empty($data['filter_model'])) {
				$sql .= " AND op.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
			}

			if (!empty($data['filter_customer_name'])) {
				$sql .= " AND CONCAT(o.firstname,' ',o.lastname) LIKE '%" . $this->db->escape($data['filter_customer_name']) . "%'";
			}
			if (!empty($data['filter_customer_email'])) {
				$sql .= " AND o.email LIKE '%" . $this->db->escape($data['filter_customer_email']) . "%'";
			}

			if (!empty($data['filter_customer_company'])) {
				$sql .= " AND o.payment_company LIKE '%" . $this->db->escape($data['filter_customer_company']) . "%'";
			}

			if (!empty($data['filter_country'])) {
				$sql .= " AND LOWER(o.payment_country) LIKE '%" . $this->db->escape($data['filter_country']) . "%'";
			}

			if (!empty($data['filter_region'])) {
				$sql .= " AND o.payment_postcode = '" . $this->db->escape($data['filter_region']) . "'";
			}

			if (!empty($data['filter_city'])) {
				$sql .= " AND o.payment_city = '" . $this->db->escape($data['filter_city']) . "'";
			}

			if (!empty($data['filter_zipcode'])) {
				$sql .= " AND o.payment_postcode = '" . $this->db->escape($data['filter_zipcode']) . "'";
			}

			if (!empty($data['filter_product_name'])) {
				$sql .= " AND op.name = '" . $this->db->escape($data['filter_product_name']) . "'";
			}

			if (!empty($data['filter_manufacturer'])) {
				$sql .= " AND m.name LIKE '%" . $this->db->escape($data['filter_manufacturer']) . "%'";
			}

			$sql .= " GROUP BY order_product_id2";
			$query = $this->db->query($sql);

			$reports = $query->rows;

			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getEarningsReport( $data = array()) {
		$where = "";
		$base_where = "";
		$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
		$filter_year = isset($data['filter_year'])?$data['filter_year']: "";
		$filter_month = isset($data['filter_month'])?$data['filter_month']: "";
		$filter_day = isset($data['filter_day'])?$data['filter_day']: "";

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.earnings.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".$filter_year.".".$filter_month.".".$filter_day;

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports ) {
			$select_datefield_year = $filter_datefield_year = $select_datefield_month = $filter_datefield_month = $select_datefield_date = $filter_datefield_date = "";

			$group = "datefield";
			$order = "datefield";

			if($filter_year) {
				$select_datefield = ', MONTH(o.date_added) AS `datefield`';
				$filter_datefield_year = " AND YEAR(o.date_added) = '".$filter_year."'";
				$filter_datefield = ' MONTH(o.date_added) ';
			} else {
				$select_datefield = ', YEAR(o.date_added) AS `datefield`';
				$filter_datefield = ' YEAR(o.date_added) ';
			}

			if($filter_month) {
				$select_datefield = ', DAY(o.date_added) AS `datefield`';
				$filter_datefield_month = " AND MONTH(o.date_added) ='".$filter_month."'";
				$filter_datefield = ' DAY(o.date_added) ';
			}

			if($filter_day) {
				$select_datefield = ', HOUR(o.date_added) `datefield`';
				$filter_datefield_date = " AND DAY(o.date_added) = '".$filter_day."'";
				$filter_datefield = ' HOUR(o.date_added) ';
			}
			
			
			$sql1 = "SELECT COUNT(o.order_id) `number_orders`, SUM(o.total) as `subtotal`, o.date_added".$select_datefield." FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			$where .= $filter_datefield_year.$filter_datefield_month.$filter_datefield_date;
			$base_where .= $filter_datefield_year.$filter_datefield_month.$filter_datefield_date;

			$sql1 .= $where;

			$sql1 .= " GROUP BY ".$group." ORDER BY ".$order;

			$query = $this->db->query($sql1);

			$reports = array();

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				foreach($orders as $key=>$row) {

					$row['items_ordered'] = 0;

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE ".$filter_datefield."='".$row['datefield']."'".$base_where);

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
					}

					$reports[$row['datefield']] = $row;

				}
			}

			$this->cache->set($cache_name, $reports);
		}

		return $reports;

	}
	public function getTotalSales($store_id = 0, $filter_order_status_id = 5) {
		$sql1 = "SELECT SUM(o.total) as `subtotal` FROM `".DB_PREFIX."order` o ";
		if (!empty($store_id)) {
			$sql1 .= " WHERE o.store_id = '" . (int)$store_id . "'";
		} else {
			$sql1 .= " WHERE o.store_id = '0'";
		}
		if (!empty($filter_order_status_id)) {
			$sql1 .= " AND o.order_status_id IN (" . $filter_order_status_id . ")";
		} else {
			$sql1 .= " AND o.order_status_id > '0'";
		}
		$query = $this->db->query($sql1);

		return isset($query->row['subtotal'])?$query->row['subtotal']:0;
	}

	public function getCurrentMonthReport($store_id = 0, $filter_order_status_id = 5) {
		$current_year = date("Y");
		$current_month = date("m");

		$sql1 = "SELECT COUNT(distinct o.order_id) `number_orders`, SUM(o.total) as `subtotal`, o.date_added, CONCAT(YEAR(o.date_added),'/',MONTH(o.date_added)) AS datefield, DATE_FORMAT(o.date_added, '%c/%Y') AS datefield2 FROM `".DB_PREFIX."order` o WHERE DATE_FORMAT(o.date_added, '%c/%Y') = '".(int)$current_month."/".$current_year."'";

		if (!empty($store_id)) {
			$sql1 .= " AND o.store_id = '" . (int)$store_id . "'";
		} else {
			$sql1 .= " AND o.store_id = '0'";
		}

		if (!empty($filter_order_status_id)) {
			$sql1 .= " AND o.order_status_id IN (" . $filter_order_status_id . ")";
		} else {
			$sql1 .= " AND o.order_status_id > '0'";
		}

		$query = $this->db->query($sql1);

		return $query->row;
	}

	public function getOrderReport( $data = array()) {
		$where = "";
		$base_where = "";
		$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
		$report_period = isset($data['report_period'])?$data['report_period']:'month';

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.orderreport.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']).".".$report_period;

		$reports = array();
// 		if($enable_cache) {
// 			$reports = $this->cache->get($cache_name);
// 		}
		if(!$reports) {

			
			$select_datefield = ' CONCAT(MONTH(o.date_added),"/",YEAR(o.date_added)) AS datefield';
			$filter_datefield = ' CONCAT(MONTH(o.date_added),"/",YEAR(o.date_added)) ';
			switch ($report_period) {
				case 'day':
					$select_datefield = 'DATE(o.date_added) AS datefield';
					$filter_datefield = ' DATE(o.date_added) ';
					break;
				case 'week':
					$select_datefield = 'CONCAT(YEAR(o.date_added),"",WEEK(o.date_added)) AS datefield';
					$filter_datefield = ' CONCAT(YEAR(o.date_added),"",WEEK(o.date_added)) ';
					break;
				case 'quarter':
					$select_datefield = 'CONCAT(QUARTER(o.date_added),"/",YEAR(o.date_added)) AS datefield';
					$filter_datefield = ' CONCAT(QUARTER(o.date_added),"/",YEAR(o.date_added)) ';
					break;
				case 'year':
					$select_datefield = 'YEAR(o.date_added) AS datefield';
					$filter_datefield = ' YEAR(o.date_added) ';
					break;
			}

			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
			$sql1 = "SELECT COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `subtotal`, o.date_added, ".$select_datefield." FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			if (!empty($data['filter_date_start'])) {
				$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
				$base_where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}

			if (!empty($data['filter_date_end'])) {
				$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
				$base_where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}

			$sql1 .= $where;

			$sql1 .= " GROUP BY datefield ORDER BY datefield";

			$query = $this->db->query($sql1);
			//debug($data);
			//debug($sql1);

			$reports = array();

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				foreach($orders as $key=>$row) {

					$row['total'] = $row['items_ordered'] = $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;
					
					/*Get number order by guest*/
					$query_orders1 = $this->db->query("SELECT COUNT(o.order_id) as `number_ordered_by_guest`, SUM(o.total) as `number_ordered_by_guest_total`, SUM(op.quantity) as `items_ordered_by_guest`
					  FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id = '0'");

					if($query_orders1->num_rows > 0) {
						$row['items_ordered_by_guest'] = $query_orders1->row['items_ordered_by_guest'];
					}
					
					$query_orders1 = $this->db->query("SELECT COUNT(o.order_id) as `number_ordered_by_guest`, SUM(o.total) as `number_ordered_by_guest_total`
					  FROM `".DB_PREFIX."order` o
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id = '0'");

					if($query_orders1->num_rows > 0) {
						$row['number_ordered_by_guest'] = $query_orders1->row['number_ordered_by_guest'];
						$row['number_ordered_by_guest_total'] = $query_orders1->row['number_ordered_by_guest_total'];
					}
					
						/*Get number order by customer 1st time order*/
					$query_orders2 = $this->db->query("SELECT SUM(a.total) as `number_ordered_by_first_order`, a.total_order AS `number_ordered_by_first_order_total`, a.items_ordered AS `items_ordered_by_first_order` FROM (SELECT COUNT(*) AS total, SUM(o.total) AS total_order, SUM(op.quantity) as `items_ordered`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id > 0 HAVING total = 1) a");
					 
				// 	 debug("SELECT SUM(a.total) as `number_ordered_by_first_order`, a.total_order AS `number_ordered_by_first_order_total`, a.items_ordered AS `items_ordered_by_first_order` FROM (SELECT COUNT(*) AS total, SUM(o.total) AS total_order, SUM(op.quantity) as `items_ordered`
				// 	 FROM `".DB_PREFIX."order_product` op 
				// 	 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
				// 	 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id > 0 HAVING total = 1) a");

					if($query_orders2->num_rows > 0) {
						$row['items_ordered_by_first_order'] = $query_orders2->row['items_ordered_by_first_order'];
					}
					
						$query_orders3 = $this->db->query("SELECT SUM(a.total) as `number_ordered_by_first_order`, a.total_order AS `number_ordered_by_first_order_total` FROM (SELECT COUNT(*) AS total, SUM(o.total) AS total_order
					 FROM `".DB_PREFIX."order` o
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id > 0 HAVING total = 1) a");

					if($query_orders3->num_rows > 0) {
						$row['number_ordered_by_first_order'] = $query_orders3->row['number_ordered_by_first_order'];
						$row['number_ordered_by_first_order_total'] = $query_orders3->row['number_ordered_by_first_order_total'];
					}
					
					
					/*Get number order by customer 2nd time and onwards order*/
					$query_orders2 = $this->db->query("SELECT SUM(a.total) as `number_ordered_by_second_order`, a.total_order AS `number_ordered_by_second_order_total`, a.items_ordered AS `items_ordered_by_second_order` FROM (SELECT COUNT(*) AS total, SUM(o.total) AS total_order, SUM(op.quantity) as `items_ordered`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id > 0 HAVING total > 1) a");

					if($query_orders2->num_rows > 0) {
						$row['items_ordered_by_second_order'] = $query_orders2->row['items_ordered_by_second_order'];
					}
					
					$query_orders3 = $this->db->query("SELECT SUM(a.total) as `number_ordered_by_second_order`, a.total_order AS `number_ordered_by_second_order_total` FROM (SELECT COUNT(*) AS total, SUM(o.total) AS total_order
					 FROM `".DB_PREFIX."order` o
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where . " AND o.customer_id > 0 HAVING total > 1) a");

                    if($query_orders3->num_rows > 0) {
						$row['number_ordered_by_second_order'] = $query_orders3->row['number_ordered_by_second_order'];
						$row['number_ordered_by_second_order_total'] = $query_orders3->row['number_ordered_by_second_order_total'];
					}

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where);

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
						$row['total'] = $query_products->row['total'];
					}

					/*Get total products*/
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot  
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'tax'".$base_where);
					if($query_tax->num_rows > 0) {
						$row['tax'] = $query_tax->row['tax'];
					}
					
					
					
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax_1` FROM `".DB_PREFIX."order_total` ot  
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'tax'".$base_where ." AND o.customer_id = '0'");
					if($query_tax->num_rows > 0) {
						$row['tax_1'] = $query_tax->row['tax_1'];
					}

					$query_tax = $this->db->query("SELECT a.tax_2 AS `tax_2` FROM (SELECT COUNT(*) AS total, SUM(ot.value) as `tax_2`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 LEFT JOIN `".DB_PREFIX."order_total` ot ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'tax'".$base_where ." AND o.customer_id > 0 HAVING total = 1) a");
					if($query_tax->num_rows > 0) {
						$row['tax_2'] = $query_tax->row['tax_2'];
					}
					
					

					/*Get total products*/
					$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'shipping'".$base_where);
					if($query_shipping->num_rows > 0) {
						$row['shipping'] = $query_shipping->row['shipping'];
					}
					
					

					/*Get total products*/
					$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot  LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'coupon'".$base_where);
					if($query_discount->num_rows > 0) {
						$row['discount'] = $query_discount->row['discount'];
					}
					
					

					/*Get total products*/
					$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
						FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = r.order_id
					 	WHERE ".$filter_datefield." = '".$row['datefield']."' AND r.return_status_id = ".(int)$return_status_id."
						".$base_where);

					if($query_refunded->num_rows > 0) {
						$row['refunded'] = $query_refunded->row['refunded'];
					}

					$reports[$row['datefield']] = $row;

				}
			
			}

			$this->cache->set($cache_name, $reports);
		}

		return $reports;

	}

	public function getTotalSaleOrder( $data = array() ) {
		$where = "1 ";

		$report_period = isset($data['report_period'])?$data['report_period']:'month';
		$select_datefield = ' CONCAT(MONTH(o.date_added),"/",YEAR(o.date_added)) AS datefield';
		switch ($report_period) {
			case 'day':
				$select_datefield = 'DATE(o.date_added) AS datefield';
				break;
			case 'week':
				$select_datefield = 'CONCAT(YEAR(o.date_added),"",WEEK(o.date_added)) AS datefield';
				break;
			case 'quarter':
				$select_datefield = 'CONCAT(QUARTER(o.date_added),"/",YEAR(o.date_added)) AS datefield';
				break;
			case 'year':
				$select_datefield = 'YEAR(o.date_added) AS datefield';
				break;
		}

		$sql1 = "SELECT COUNT(o.order_id) AS `total` FROM `".DB_PREFIX."order` o ";

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

		$query = $this->db->query($sql1);
		
		return isset($query->row['total'])?$query->row['total']:0;
	}
	public function getSaleStatistics( $data = array()) {

		$where = "";
		$base_where = "";
		$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
		$report_period = isset($data['report_period'])?$data['report_period']:'month';

		$enable_cache = $this->config->get('ecadvancedreports_enable_caching');
		$enable_cache = $enable_cache?$enable_cache:0;
		$cache_name = "ecreport.sale.salestatistics.".(int)$data['filter_store_id'].".".(int)$data['filter_order_status_id'].".".strtotime($data['filter_date_start']).".".strtotime($data['filter_date_end']).".".$report_period;

		$reports = array();
		if($enable_cache) {
			$reports = $this->cache->get($cache_name);
		}
		if(!$reports) {

			$select_datefield = ' CONCAT(MONTH(o.date_added),"/",YEAR(o.date_added)) AS datefield';
			$filter_datefield = ' CONCAT(MONTH(o.date_added),"/",YEAR(o.date_added)) ';
			switch ($report_period) {
				case 'day':
					$select_datefield = 'DATE(o.date_added) AS datefield';
					$filter_datefield = ' DATE(o.date_added) ';
					break;
				case 'week':
					$select_datefield = 'CONCAT(YEAR(o.date_added),"",WEEK(o.date_added)) AS datefield';
					$filter_datefield = ' CONCAT(YEAR(o.date_added),"",WEEK(o.date_added)) ';
					break;
				case 'quarter':
					$select_datefield = 'CONCAT(QUARTER(o.date_added),"/",YEAR(o.date_added)) AS datefield';
					$filter_datefield = ' CONCAT(QUARTER(o.date_added),"/",YEAR(o.date_added)) ';
					break;
				case 'year':
					$select_datefield = 'YEAR(o.date_added) AS datefield';
					$filter_datefield = ' YEAR(o.date_added) ';
					break;
			}

			$return_status_id = isset($data['return_status_id'])?$data['return_status_id']: 3;
			$sql1 = "SELECT COUNT(o.order_id) `number_orders`, COUNT(DISTINCT o.customer_id) `customers`, SUM(o.total) as `subtotal`, o.date_added, AVG(o.total) total_avg, ".$select_datefield." FROM `".DB_PREFIX."order` o ";

			if (!empty($data['filter_order_status_id'])) {
				$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
				$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			} else {
				$where .= " WHERE o.order_status_id > '0'";
				$base_where .= " AND o.order_status_id > '0'";
			}

			if (!empty($data['filter_store_id'])) {
				$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			} else {
				$where .= " AND o.store_id = '0'";
				$base_where .= " AND o.store_id = '0'";
			}

			if (!empty($data['filter_date_start'])) {
				$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}

			if (!empty($data['filter_date_end'])) {
				$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}

			$sql1 .= $where;

			$sql1 .= " GROUP BY datefield ORDER BY datefield";

			$query = $this->db->query($sql1);

			$reports = array();

			if($query->num_rows > 0) {
				/*query get order info*/
				$orders = $query->rows;
				foreach($orders as $key=>$row) {

					$row['product_total_avg'] = $row['total'] =  $row['tax'] = $row['shipping'] = $row['discount'] = $row['refunded'] = 0;

					/*Get number products*/
					$query_products = $this->db->query("SELECT SUM(op.quantity) as `items_ordered`, SUM(op.total) as `total`, AVG(op.total) as `product_total_avg`
					 FROM `".DB_PREFIX."order_product` op 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = op.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."'".$base_where);

					if($query_products->num_rows > 0) {
						$row['items_ordered'] = $query_products->row['items_ordered'];
						$row['product_total_avg'] = $query_products->row['product_total_avg'];
						$row['total'] = $query_products->row['total'];
					}

					/*Get total tax*/
					$query_tax = $this->db->query("SELECT SUM(ot.value) as `tax` FROM `".DB_PREFIX."order_total` ot  
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'tax'".$base_where);
					if($query_tax->num_rows > 0) {
						$row['tax'] = $query_tax->row['tax'];
					}

					/*Get total shipping*/
					$query_shipping = $this->db->query("SELECT SUM(ot.value) as `shipping` FROM `".DB_PREFIX."order_total` ot 
					 LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'shipping'".$base_where);
					if($query_shipping->num_rows > 0) {
						$row['shipping'] = $query_shipping->row['shipping'];
					}

					/*Get total discount*/
					$query_discount = $this->db->query("SELECT SUM(ot.value) as `discount` FROM `".DB_PREFIX."order_total` ot  LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = ot.order_id
					 WHERE ".$filter_datefield." = '".$row['datefield']."' AND ot.code = 'coupon'".$base_where);
					if($query_discount->num_rows > 0) {
						$row['discount'] = $query_discount->row['discount'];
					}

					/*Get total refunded*/
					$query_refunded = $this->db->query("SELECT IFNULL(SUM(op.price * r.quantity + op.price * r.quantity * op.tax / 100), 0) as `refunded`
						FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."return` r ON (r.product_id = op.product_id AND r.order_id = op.order_id)
						LEFT JOIN `".DB_PREFIX."order` o ON o.order_id = r.order_id
					 	WHERE ".$filter_datefield." = '".$row['datefield']."' AND r.return_status_id = ".(int)$return_status_id."
						".$base_where);

					if($query_refunded->num_rows > 0) {
						$row['refunded'] = $query_refunded->row['refunded'];
					}

					$reports[$row['datefield']] = $row;

				}
			
			}

			$this->cache->set($cache_name, $reports);
		}
		return $reports;
	}

	public function getOrders($data = array()) {
		$sql = "SELECT MIN(tmp.date_added) AS date_start, MAX(tmp.date_added) AS date_end, COUNT(tmp.order_id) AS `orders`, SUM(tmp.products) AS products, SUM(tmp.tax) AS tax, SUM(tmp.total) AS total FROM (SELECT o.order_id, (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id) AS products, (SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id) AS tax, o.total, o.date_added FROM `" . DB_PREFIX . "order` o"; 

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " GROUP BY o.order_id) tmp";
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY DAY(tmp.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY WEEK(tmp.date_added)";
				break;	
			case 'month':
				$sql .= " GROUP BY MONTH(tmp.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(tmp.date_added)";
				break;									
		}
		
		$sql .= " ORDER BY tmp.date_added DESC";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getTotalOrderSummaryReport($data = array()) {
		$where = "";

		if (!empty($data['filter_order_status_id'])) {
			$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$where .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$where .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql = "SELECT count(o.order_id) as total FROM `".DB_PREFIX."order` o";
		$sql .= $where;
		
		$query = $this->db->query($sql);

		return isset($query->row['total'])?$query->row['total']:0;
	}
	public function getOrderSummaryReport($data = array()) {
		$where = "";
		$base_where = "";

		$margin_profit = isset($data['margin_profit'])?(int)$data['margin_profit']:0;

		if (!empty($data['filter_order_status_id'])) {
			$where .= " WHERE o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
			$base_where .= " AND o.order_status_id IN (" . $data['filter_order_status_id'] . ")";
		} else {
			$where .= " WHERE o.order_status_id > '0'";
			$base_where .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_store_id'])) {
			$where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			$base_where .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
		} else {
			$where .= " AND o.store_id = '0'";
			$base_where .= " AND o.store_id = '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			$base_where .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			$base_where .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}


		$sql = "SELECT o.order_id, o.order_status_id as status, CONCAT(o.invoice_prefix,'',o.invoice_no) AS invoice_no, o.total, o.date_added, (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id) AS quantity, (SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id) AS tax, (SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id) AS discount,opt.total_cost, (o.total - opt.total_cost) AS gross_profits, ((o.total - opt.total_cost) - ".$margin_profit.") AS net_profits FROM `".DB_PREFIX."order` o 
			LEFT JOIN (SELECT op.order_id, SUM(p.cost * op.quantity) AS total_cost 
					 FROM `" . DB_PREFIX . "product` p 
				        LEFT JOIN `" . DB_PREFIX . "order_product` op ON op.product_id = p.product_id 
				        LEFT JOIN `" . DB_PREFIX . "order` o ON op.order_id = o.order_id
				        ".$where."
						GROUP BY op.order_id
			 ) opt ON o.order_id = opt.order_id
			";

		$sql .= $where;

		if (isset($data['sort']) && $data['sort']) {

			if (!isset($data['order']) || !$data['order']) {
				$data['order'] = 'ASC';
			}

			$sql .= " ORDER BY  " . $this->db->escape($data['sort']) . " " . $data['order'];
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 100;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
?>