<?php
class Xero {
	public function __construct($registry) {
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->config = $registry->get('config');
	}

	public function refreshToken()	{
		try {
			$post_data = 'grant_type=refresh_token&refresh_token=' . $this->config->get('module_opc_xero_refresh_token');

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://identity.xero.com/connect/token",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_SSL_VERIFYHOST => false,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_POSTFIELDS => $post_data,
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic " . base64_encode($this->config->get('module_opc_xero_client_id') . ':' . $this->config->get('module_opc_xero_client_secret')),
			    "Content-Type: application/x-www-form-urlencoded",
			  ),
			));

			$result = json_decode(curl_exec($curl), 1);
			$err = curl_error($curl);

			curl_close($curl);

			if (!$err) {
			  if (isset($result['access_token']) && $result['access_token']) {
			    $this->updateSetting('module_opc_xero_access_token', $result['access_token']);

			    $this->updateSetting('module_opc_xero_refresh_token', $result['refresh_token']);

					return 1;
			  } elseif (isset($result['error']) && $result['error'] == 'invalid_grant') {
			  	return 1;
			  }
			}

			return 0;
		} catch (Exception $e) {
			return 0;
		}
	}

	public function updateSetting($key = '', $value = '') {
	  $this->db->query("UPDATE " . DB_PREFIX . "setting SET value = '" . $this->db->escape($value) . "' WHERE `key` = '" . $key . "'");

	  $this->config->set($key, $value);
	}

	public function getTenantId()	{
	  try {
	    $curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => "https://api.xero.com/connections",
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_SSL_VERIFYHOST => false,
	      CURLOPT_SSL_VERIFYPEER => false,
	      CURLOPT_HTTPHEADER => array(
	        "Authorization: Bearer ". $this->config->get('module_opc_xero_access_token'),
	        "Accept: application/json",
	      ),
	    ));

	    $result = json_decode(curl_exec($curl), 1);
	    if(isset($result['status'])){
    	    if($result['status'] == "401"){
    	        $this->session->data['xero_error'] = $result['detail'];
    	    }else{
    	        $this->session->data['xero_error'] = "";
    	    }
	    }else{
	        $this->session->data['xero_error'] = "";
	    }
	    
	    $err = curl_error($curl);
	    
	    curl_close($curl);

	    if (!$err) {
	      if (isset($result[0]['tenantId']) && $result[0]['tenantId']) {
	        $this->session->data['tenantId'] = $result[0]['tenantId'];

	        return 1;
	      }
	    }

	    return 0;
	  } catch (Exception $e) {
	    return 0;
	  }
	}

	public function execute_curl($url = '', $method = '', $data = array()) {
	  if ($url && $method && $this->config->get('module_opc_xero_access_token') && isset($this->session->data['tenantId']) && $this->session->data['tenantId']) {
	    $curl = curl_init();

	    if ($data) {
	      curl_setopt_array($curl, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_CUSTOMREQUEST => $method,
	        CURLOPT_SSL_VERIFYHOST => false,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_POSTFIELDS =>  json_encode($data),
	        CURLOPT_HTTPHEADER => array(
	          "Authorization: Bearer ". $this->config->get('module_opc_xero_access_token'),
	          "Accept: application/json",
						"Xero-tenant-id: " . $this->session->data['tenantId'],
	        ),
	      ));
	    } else {
	      curl_setopt_array($curl, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_CUSTOMREQUEST => $method,
	        CURLOPT_SSL_VERIFYHOST => false,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_HTTPHEADER => array(
	          "Authorization: Bearer ". $this->config->get('module_opc_xero_access_token'),
	          "Accept: application/json",
						"Xero-tenant-id: " . $this->session->data['tenantId'],
	        ),
	      ));
	    }

	    $response = json_decode(curl_exec($curl), 1);
	    //debug($response);die;
	    $err = curl_error($curl);

	    curl_close($curl);

	    if (!$err) {
	      return $response;
	    } else {
	      return false;
	    }
	  }
	  return false;
	}

	public function syncCustomerToXero($customers = array()) {
		$count = 0;

		try {
			if ($this->refreshToken() && $this->getTenantId() && $customers) {
				foreach ($customers as $customer) {
					$this->session->data['xeromax_customer_id'] = $customer['customer_id'];

					$xero_customer = $this->getSyncCustomer($customer['customer_id']);

					$data = array(
						'Name' => $customer['firstname'] . ' ' . $customer['lastname'],
				    'ContactStatus' => 'ACTIVE',
				    'EmailAddress' => $customer['email'],
				    'FirstName' => $customer['firstname'],
				    'LastName' => $customer['lastname'],
				    'Addresses' => array(array(
				      'AddressType' => 'POBOX',
				      'AttentionTo' => $customer['firstname'] . ' ' . $customer['lastname'],
				      'AddressLine1' => $customer['address_1'],
				      'AddressLine2' => $customer['address_2'],
				      'City' => $customer['city'],
				      'Region' => $customer['zone_name'],
				      'PostalCode' => $customer['postcode'],
				      'Country' => $customer['country_name'],
				    )),
				    'Phones' => array(
				      array(
				        'PhoneType' => 'DEFAULT',
				        'PhoneNumber' => $customer['telephone'],
				      ),
				      array(
				        'PhoneType' => 'MOBILE',
				        'PhoneNumber' => $customer['telephone'],
				      ),
				    ),
				    'ContactPersons' => array(array(
				      'FirstName' => $customer['firstname'],
				      'LastName' => $customer['lastname'],
				      'EmailAddress' => $customer['email'],
				      'IncludeInEmails' => true,
				    )),
					);

					if (isset($xero_customer['xero_customer_id']) && $xero_customer['xero_customer_id']) {
					  $url = "https://api.xero.com/api.xro/2.0/Contacts/" . $xero_customer['xero_customer_id'];

						$data['ContactID'] = $xero_customer['xero_customer_id'];
					} else {
					  $url = "https://api.xero.com/api.xro/2.0/Contacts";
					}

					$method = "POST";

					$response = $this->execute_curl($url, $method, $data);
					//debug($response);die;
                    //$response = false;
					if ($response && isset($response['Contacts'][0]['ContactID']) && $response['Contacts'][0]['ContactID']) {
					  $this->saveSyncCustomer($customer['customer_id'], $response['Contacts'][0]['ContactID']);

					  $count++;
					}
				}
			}
		} catch (\Exception $e) {

		}

		return $count;
	}

	public function importCustomerFromXero() {
	  $count = 0;

	  try {
	    if ($this->refreshToken() && $this->getTenantId()) {
	      $page = 1;

	      while (1) {
					$response = $this->execute_curl('https://api.xero.com/api.xro/2.0/Contacts?page=' . $page, 'GET');

					if (isset($response['Contacts']) && $response['Contacts']) {
						foreach ($response['Contacts'] as $contact) {
							if (isset($contact['ContactID']) && $contact['ContactID'] && isset($contact['EmailAddress']) && $contact['EmailAddress']) {
							  if (!$this->db->query("SELECT * FROM " . DB_PREFIX . "xero_customer WHERE xero_customer_id = '" . $contact['ContactID'] . "'")->num_rows) {
							    $customer_details = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE email = '" . $contact['EmailAddress'] . "'")->row;

							    if ($customer_details) {
							      $this->saveSyncCustomer($customer_details['customer_id'], $contact['ContactID']);

							      $count++;
							    } else {

							      $data_address = array();

							      $fax = '';

							      $telephone = '';

							      foreach ($contact['Phones'] as $phone) {
							        if ($phone['PhoneType'] == 'FAX' && isset($phone['PhoneNumber']) && $phone['PhoneNumber']) {
							          $fax = $phone['PhoneNumber'];
							        } else {
							          if (!$telephone && isset($phone['PhoneNumber']) && $phone['PhoneNumber']) {
							            $telephone = $phone['PhoneNumber'];
							          }
							        }
							      }

							      foreach ($contact['Addresses'] as $address) {
							        if (isset($address['AddressLine1']) && $address['AddressLine1'] && isset($address['City']) && $address['City'] && isset($address['PostalCode']) && $address['PostalCode']) {
							          $data_address[] = array(
							            'company' => '',
							            'address_1' => $address['AddressLine1'],
							            'address_2' => isset($address['AddressLine1']) && $address['AddressLine1'] ? $address['AddressLine1'] : '',
							            'city' => $address['City'],
							            'postcode' => $address['PostalCode'],
							            'country_id' => 0,
							            'zone_id' => 0,
							            'default' => 1,
							          );
							        }
							      }

							      $data = array(
							        'firstname' => isset($contact['FirstName']) && $contact['FirstName'] ? $contact['FirstName'] : $contact['Name'],
							        'lastname' => isset($contact['LastName']) && $contact['LastName'] ? $contact['LastName'] : $contact['Name'],
							        'email' => $contact['EmailAddress'],
							        'telephone' => $telephone,
							        'fax' => $fax,
							        'password' => $contact['Name'],
							        'status' => 1,
							        'address' => $data_address,
							      );

							      $customer_id = $this->addCustomer($data);

							      //$this->saveSyncCustomer($customer_id, $contact['ContactID']);

							      $count++;
							    }
							  }
							}
						}
						$page++;
			    } else {
			    	break;
			    }
	      }
	    }
	  } catch (\Exception $e) {

	  }

	  return $count;
	}

	public function addCustomer($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '1', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '', newsletter = '0', salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', status = '" . (int)$data['status'] . "', approved = '1', safe = '1', date_added = NOW()");

		$customer_id = $this->db->getLastId();

		if (isset($data['address']) && $data['address']) {
			foreach ($data['address'] as $address) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "', custom_field = ''");

				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();

					$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
				}
			}
		}

		return $customer_id;
	}

	public function syncProductsToXero($products = array()) {
	  $count = 0;

		try {

			if (!$this->config->get('module_opc_xero_account')) {
				$accounts = $this->getAccounts();

				if ($accounts && isset($accounts[0]['id']) && $accounts[0]['id']) {
					$this->updateSetting('module_opc_xero_account', $accounts[0]['id']);
				}
			}
			
			if ($this->refreshToken() && $this->getTenantId() && $products && $this->config->get('module_opc_xero_account')) {
				foreach ($products as $product) {
					$this->session->data['xeromax_product_id'] = $product['product_id'];

					$code = '';

					if ($this->config->get('module_opc_xero_product_code') == 'sku') {
					  $code = $product['sku'];
					}

					if ($this->config->get('module_opc_xero_product_code') == 'model' || !$code) {
					  $code = $product['model'];
					}

					//$code .= '_' . $product['product_id'];

                    //$position = strrpos(substr($product['name'], 0, 50), ' ');
                    $position = $product['name'];
                    $position = str_replace("&","and",$position);
                    $position = str_replace("%","",$position);
                    
                    $desc = str_replace('&nbsp', ' ',preg_replace('/[^A-Za-z0-9]\-,"\'\\/\]/', '', strip_tags(html_entity_decode($product['description']))));
                    //$desc = '<Description></Description>';
					$data = array(
						'Code' => substr($code, 0, 30),
						'Name' => $position,
						'Description' => str_replace("&","and",$desc),
						'SalesDetails' => array(
						  'UnitPrice' => $product['price'],
						  'AccountCode' => $this->config->get('module_opc_xero_account'),
						),
					);

					$xero_product = $this->getSyncProduct($product['product_id']);

					if (isset($xero_product['xero_product_id']) && $xero_product['xero_product_id']) {
					  $url = "https://api.xero.com/api.xro/2.0/Items/" . $xero_product['xero_product_id'];

					  $method = "PUT";

						$data['ItemID'] = $xero_product['xero_product_id'];
					} else {
					  $url = "https://api.xero.com/api.xro/2.0/Items";

					  $method = "POST";
					}

					$response = $this->execute_curl($url, $method, $data);
					//$response = false;
					if ($response && isset($response['Items'][0]['ItemID']) && $response['Items'][0]['ItemID']) {
					    $this->saveSyncProduct($product['product_id'], $response['Items'][0]['ItemID']);
					    $count++;
					}
				}
			}
		} catch (\Exception $e) {

		}
	  return $count;
	}

	public function syncOrderToXero($orders = array()) {
	  $return_data = array();
	  $return_data['count'] = 0;
	  
	  //try {
	    if ($this->refreshToken() && $this->getTenantId() && $orders) {
	        foreach ($orders as $order) {
	                $xero_payments = $this->db->query("SELECT xero_payment_id FROM " . DB_PREFIX . "xero_payment WHERE order_id = " . $order['order_id'])->rows;
					if ($xero_payments) {
						foreach ($xero_payments as $xero_payment) {
						    $payment_data = array(
						        "Payments" => array(
						            "Payment" => array(
						                "PaymentID" => $xero_payment['xero_payment_id'],
						                "Status" => "DELETED"
						            ),
						        ),
						    );
						    
							$response = $this->execute_curl('https://api.xero.com/api.xro/2.0/Payments', 'POST', $payment_data);
							$this->db->query("DELETE FROM " . DB_PREFIX . "xero_payment WHERE xero_payment_id = '" . $xero_payment['xero_payment_id'] . "'");
						}
					}
					
					$this->session->data['xeromax_order_id'] = $order['order_id'];
					
					    $xero_customer_id = $this->config->get('module_opc_xero_guest_id');
                        if (isset($order['customer_id']) && $order['customer_id']) {
    					    $getSyncCustomer = $this->getSyncCustomer($order['customer_id']);
                            if ($getSyncCustomer && isset($getSyncCustomer['xero_customer_id']) && $getSyncCustomer['xero_customer_id']) {
    					        $xero_customer_id = $getSyncCustomer['xero_customer_id'];
    					    } else {
    					        $order_customer = $this->getCustomersToSync(array('customer_id' => $order['customer_id']));
    					        $this->syncCustomerToXero($order_customer);
    					        $getSyncCustomer = $this->getSyncCustomer($order['customer_id']);
    
    					        if ($getSyncCustomer && isset($getSyncCustomer['xero_customer_id']) && $getSyncCustomer['xero_customer_id']) {
    					            $xero_customer_id = $getSyncCustomer['xero_customer_id'];
    					        }
    					    }
                        }
                    
					    if ($xero_customer_id) {
					        $sub_total = 0;
						    $discount = 0;
						    $shipping = 0;
						    $tax = 0;
						    
						    if ($order['order_totals']) {
						        foreach ($order['order_totals'] as $key => $order_total) {
						            if ($order_total['code'] == 'shipping') {
						                $shipping += $order_total['value'];
						            } elseif ($order_total['code'] == 'total' || $order_total['code'] == 'gst') {
						                if($order_total['title'] == "GST Inclusive (7%)" || $order_total['code'] == "GST 7 % (inclusive)"){
						                    //$tax += $order_total['value'];
						                }
						            } elseif ($order_total['code'] == 'coupon' || $order_total['code'] == 'wkpos_discount' || $order_total['code'] == 'reward' || $order_total['code'] == 'voucher') {
						                $discount += $order_total['value'];
						            } elseif ($order_total['code'] == 'sub_total') {
						                $sub_total += $order_total['value'];
						            }
						        }
						    }
						    
						    if (!$this->config->get('module_opc_xero_account')) {
							    $accounts = $this->getAccounts();
							    if ($accounts && isset($accounts[0]['id']) && $accounts[0]['id']) {
							  	    $this->updateSetting('module_opc_xero_account', $accounts[0]['id']);
							    }
						 	}

							$line_array = array();

							if ($order['products'] && $this->config->get('module_opc_xero_account')) {
						        foreach ($order['products'] as $key => $order_product) {
						            $product = $this->db->query("SELECT sku FROM " . DB_PREFIX . "product WHERE product_id = " . $order_product['product_id'])->row;
						            $item_code = str_replace(" ","",$product['sku']);
						            $item_code = str_replace("\t","",$item_code);
						            $item_code = str_replace("\n","",$item_code);
						            $item_code = str_replace("\r","",$item_code);
						            $item_code = str_replace(" ","",$item_code);
						            $item_code = trim($item_code);
						            
						            //$item_code = trim(preg_replace('/\s+/', '', $order_product['sku']));
						            
						            //if ($this->config->get('module_opc_xero_product_code') == 'sku') {
						                //$product = $this->db->query("SELECT xero_item_code FROM " . DB_PREFIX . "product WHERE product_id = " . $order_product['product_id'])->row;
						                //if(isset($product['xero_item_code'])){
								            //$item_code = $product['xero_item_code'];
								        //}else{
								        //    $item_code = $order_product['sku'];
								        //}
						            //}

						            //if ($this->config->get('module_opc_xero_product_code') == 'model' || !$item_code) {
						              //  $item_code = $order_product['model'];
						            //}

						            //$item_code .= '_' . $order_product['product_id'];
                                    $name = str_replace("&","and",$order_product['name']);
                                    $name = str_replace("%","",$order_product['name']);
                                    
						            $line_array[] = array(
						                'ItemCode' => $item_code,
						                'Description' => $name,
						                'Quantity' => $order_product['quantity'],
						                'UnitAmount' => ($order_product['price']/107*100),
						                'LineAmount' => ($order_product['total']/107*100),
						                'TaxAmount' => ($order_product['total']/107*7),
						                'AccountCode' => $this->config->get('module_opc_xero_account'),
						            );
						            $tax += ($order_product['total']/107*7);
						        }
						    }
						    
							/*if ($tax) {
						        $line_array[] = array(
						            'Description' => 'Tax Amount',
						            'Quantity' => 1,
						            'UnitAmount' => round($tax/107*100, 4),
						            'LineAmount' => round($tax/107*100, 4),
						            'TaxAmount' => round($tax/107*7, 4),
						            'AccountCode' => $this->config->get('module_opc_xero_account'),
						        );
						    }*/

							if ($shipping) {
						        $line_array[] = array(
						            'Description' => 'Shipping Cost',
						            'Quantity' => 1,
						            'UnitAmount' => ($shipping/107*100),
						            'LineAmount' => ($shipping/107*100),
						            'TaxAmount' => ($shipping/107*7),
						            'AccountCode' => $this->config->get('module_opc_xero_account'),
						        );
						        $tax += ($shipping/107*7);
						    }

							if ($discount) {
						        $line_array[] = array(
						            'Description' => 'Discount Given',
						            'Quantity' => 1,
						            'UnitAmount' => ($discount/107*100),
						            'LineAmount' => ($discount/107*100),
						            'TaxAmount' => ($discount/107*7),
						            'AccountCode' => $this->config->get('module_opc_xero_account'),
						        );
						        $tax += ($discount/107*7);
						    }
						    if (isset($order['customer_id']) && $order['customer_id']) {
						        $cname = $order['firstname'] . ' ' . $order['lastname'];
						    }else{
						        $cname = 'Chloe Lee';
						    }
					    $data = array(
							'Type' => 'ACCREC',
							"Reference" => $order['email']." - ".$order['payment_method'],
						    'Contact' => array(
    						    'ContactID' => $xero_customer_id,
    						    'Name' => $cname,
    						    //'Name' => 'Opencart Customer - Zairyo Singapore',
    						    'ContactStatus' => 'ACTIVE',
    						    'EmailAddress' => $order['email'],
    						    'FirstName' => $order['firstname'],
    						    'LastName' => $order['lastname'],
    						    'Addresses' => array(
        						    array(
        						        'AddressType' => 'POBOX',
        						        'AttentionTo' => $order['shipping_firstname'] . ' ' . $order['shipping_lastname'],
        						        'AddressLine1' => $order['shipping_address_1'],
        						        'AddressLine2' => $order['shipping_address_2'],
        						        'City' => $order['shipping_city'],
        						        'Region' => $order['shipping_zone'],
        						        'PostalCode' => $order['shipping_postcode'],
        						        'Country' => $order['shipping_country'],
        						    ),
        						    array(
        						        'AddressType' => 'POBOX',
        						        'AttentionTo' => $order['payment_firstname'] . ' ' . $order['payment_lastname'],
        						        'AddressLine1' => $order['payment_address_1'],
        						        'AddressLine2' => $order['payment_address_2'],
        						        'City' => $order['payment_city'],
        						        'Region' => $order['payment_zone'],
        						        'PostalCode' => $order['payment_postcode'],
        						        'Country' => $order['payment_country'],
        						    ),
    						    ),
    						    'Phones' => array(
        						    array(
        						        'PhoneType' => 'DEFAULT',
        						        'PhoneNumber' => $order['telephone'],
        						    ),
    						        array(
    						            'PhoneType' => 'MOBILE',
    						            'PhoneNumber' => $order['telephone'],
    						        ),
    						    ),
    						    'ContactPersons' => array(
    						        array(
    						            'FirstName' => $order['firstname'],
    						            'LastName' => $order['lastname'],
    						            'EmailAddress' => $order['email'],
    						            'IncludeInEmails' => true,
    						        )),
    						    ),
    						    'Date' => $order['date_added'],
    						    'DueDate' => $order['date_modified'],
    						    'InvoiceNumber' => $order['order_id'],
    						    'CurrencyCode' => $order['currency_code'],
    						    'Status' => $this->config->get('module_opc_xero_invoice_status'),
    						    'LineAmountTypes' => 'Exclusive',
    						    'SubTotal' => $sub_total,
    						    'TotalTax' => round($tax,2),
    						    'Total' => $order['total'],
    						    'LineItems' => $line_array,
					    );
					    
						$xero_order = $this->getSyncOrder($order['order_id']);
						
					    if (isset($xero_order['xero_order_id']) && $xero_order['xero_order_id']) {
					        $url = "https://api.xero.com/api.xro/2.0/Invoices/" . $xero_order['xero_order_id'];
					        $method = "PUT";
							$data['InvoiceID'] = $xero_order['xero_order_id'];
					    }else{
					        $url = "https://api.xero.com/api.xro/2.0/Invoices";
    					    $method = "POST";
					    }
					    
					    $response = $this->execute_curl($url, $method, $data);
					    if ($response && isset($response['Invoices'][0]['InvoiceID']) && $response['Invoices'][0]['InvoiceID']) {
					        $this->saveSyncOrder($order['order_id'], $response['Invoices'][0]['InvoiceID']);
					        $return_data['count']++;
					      
					        $order_id = $response['Invoices'][0]['InvoiceNumber'];
							$payment_code = $this->db->query("SELECT payment_code FROM " . DB_PREFIX . "order WHERE order_id = " . $order_id)->row['payment_code'];
								
							if ($payment_code) {
							    if (isset($this->config->get('module_opc_xero_payment_account')[$payment_code]) && $this->config->get('module_opc_xero_payment_account')[$payment_code]) {
							        $code = $this->config->get('module_opc_xero_payment_account')[$payment_code];
							    }else{
							        $code = $this->config->get('module_opc_xero_account');
							    }
							    $add_payment = array(
							        //"Payments" => array(
							            "Invoice" => array(
							                "InvoiceID" => $response['Invoices'][0]['InvoiceID'],
							            ),
							            "Account" => array(
							                "AccountID" => $code
							            ),
							            "Date" => date('Y-m-d'),
							            "Amount" => $response['Invoices'][0]['Total'],
							        //),
							    );
								    
								$payment_response = $this->execute_curl('https://api.xero.com/api.xro/2.0/Payments', 'PUT', $add_payment);
								
							    if (isset($payment_response['Payments'])) {
							        foreach ($payment_response['Payments'] as $payment_response) {
							            $payment_response = (array)$payment_response;
							            if (isset($payment_response['PaymentID']) && $payment_response['PaymentID']) {
							                $this->db->query("INSERT INTO " . DB_PREFIX . "xero_payment SET xero_payment_id = '" . $payment_response['PaymentID'] . "', order_id = '" . $order_id . "'");
							            }
							        }
						        }
							}
					    }else{
					        $return_data['error_no'] = $response['ErrorNumber'];
					        $return_data['error_message'] = $response['Elements'][0]['ValidationErrors'][0]['Message'];
					        return $return_data;
					    }
				    }
	        }
	    }

	  return $return_data;
	}

	public function getSyncCustomer($customer_id = 0) {
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "xero_customer WHERE oc_customer_id = " . (int)$customer_id)->row;
	}

	public function getSyncProduct($product_id = 0) {
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "xero_product WHERE oc_product_id = " . (int)$product_id)->row;
	}

	public function getSyncOrder($order_id = 0) {
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "xero_order WHERE oc_order_id = " . (int)$order_id)->row;
	}

	public function saveSyncCustomer($customer_id = 0, $xero_customer_id = 0) {
		if ($xero_customer_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "xero_customer WHERE oc_customer_id = " . (int)$customer_id);

			$this->db->query("INSERT INTO " . DB_PREFIX . "xero_customer SET oc_customer_id = " . (int)$customer_id . ", xero_customer_id = '" . $this->db->escape($xero_customer_id) . "'");
		}
	}

	public function saveSyncProduct($product_id = 0, $xero_product_id = 0) {
	  if ($xero_product_id) {
	    $this->db->query("DELETE FROM " . DB_PREFIX . "xero_product WHERE oc_product_id = " . (int)$product_id);

	    $this->db->query("INSERT INTO " . DB_PREFIX . "xero_product SET oc_product_id = " . (int)$product_id . ", xero_product_id = '" . $this->db->escape($xero_product_id) . "'");
	  }
	}

	public function saveSyncOrder($order_id = 0, $xero_order_id = 0) {
	  if ($xero_order_id) {
	    $this->db->query("DELETE FROM " . DB_PREFIX . "xero_order WHERE oc_order_id = " . (int)$order_id);

	    $this->db->query("INSERT INTO " . DB_PREFIX . "xero_order SET oc_order_id = " . (int)$order_id . ", xero_order_id = '" . $this->db->escape($xero_order_id) . "'");
	  }
	}

	public function getCustomersToSync($data = array()) {
		$sql = "SELECT c.customer_id, c.firstname, c.lastname, c.email, c.telephone, c.status, c.fax, a.company, a.address_1, a.address_2, a.city, a.postcode, co.name as country_name, z.name as zone_name FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "address a ON (c.address_id = a.address_id) LEFT JOIN " . DB_PREFIX . "country co ON (a.country_id = co.country_id) LEFT JOIN " . DB_PREFIX . "zone z ON (a.zone_id = z.zone_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (isset($data['customer_id']) && $data['customer_id']) {
			$sql .= " AND c.customer_id = " . (int)$data['customer_id'];
		} else {
			if (isset($this->session->data['xeromax_customer_id']) && $this->session->data['xeromax_customer_id']) {
			  $sql .= " AND c.customer_id > " . $this->session->data['xeromax_customer_id'];
			}

			$sql .= " AND c.customer_id NOT IN (SELECT oc_customer_id FROM " . DB_PREFIX . "xero_customer)";
		}

		$sql .= " ORDER BY c.customer_id ASC ";

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

	public function getProductsToSync($data = array()) {
	    $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

	    if (isset($data['product_id']) && $data['product_id']) {
	        $sql .= " AND p.product_id = " . (int)$data['product_id'];
	    } else {
			if (isset($this->session->data['xeromax_product_id']) && $this->session->data['xeromax_product_id']) {
			  $sql .= " AND p.product_id > " . $this->session->data['xeromax_product_id'];
			}
	        $sql .= " AND p.product_id NOT IN (SELECT oc_product_id FROM " . DB_PREFIX . "xero_product)";
	    }

		$sql .= " ORDER BY p.product_id ASC ";

	    if (isset($data['start']) || isset($data['limit'])) {
	        if ($data['start'] < 0) {
	            $data['start'] = 0;
	        }

	        if ($data['limit'] < 1) {
	            $data['limit'] = 20;
	        }

	        //$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	        $sql .= " LIMIT " . (int)$data['start'] . ",1";
	    }

	    $query = $this->db->query($sql);
        return $query->rows;
	}

	public function getOrdersToSync($data = array()) {
	    $sql = "SELECT max(oc_order_id) as max FROM " . DB_PREFIX . "xero_order";
	    $this->session->data['xeromax_order_id'] = $this->db->query($sql)->row['max'];
	    
		$sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		if(!empty($data['filter_order_status'])) {
			$implode = array();

			foreach($data['filter_order_status'] as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		}else if(isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}else{
			$sql .= " WHERE o.order_status_id > '0'";
		}

	    if(isset($data['order_id']) && $data['order_id']) {
	        $sql .= " AND o.order_id = " . (int)$data['order_id'];
	    }else{
			if(isset($this->session->data['xeromax_order_id']) && $this->session->data['xeromax_order_id']) {
			  //$sql .= " AND o.order_id > " . $this->session->data['xeromax_order_id'];
			  //$sql .= " AND o.order_id = '1873'";
			}
	        $sql .= " AND o.order_id NOT IN (SELECT oc_order_id FROM " . DB_PREFIX . "xero_order)";
	    }

	    $sql .= " ORDER BY o.order_id ASC ";

	    if(isset($data['start']) || isset($data['limit'])) {
	        if($data['start'] < 0) {
	            $data['start'] = 0;
	        }

	        if($data['limit'] < 1) {
	            $data['limit'] = 20;
	        }

	        //$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	        $sql .= "LIMIT 50";
	    }
	    
	    $query = $this->db->query($sql);
	    return $query->rows;
	}

	public function getAccounts(){
		$data_accounts = array();

		if ($this->refreshToken() && $this->getTenantId()) {
			try {
				$response = $this->execute_curl('https://api.xero.com/api.xro/2.0/Accounts?where=Type=="REVENUE"', 'GET');
				
				if (isset($response['Accounts']) && $response['Accounts']) {
				  foreach ($response['Accounts'] as $account) {
						if (isset($account['Code']) && $account['Code'] && isset($account['Name']) && $account['Name']) {
							$data_accounts[] = array(
								'id' => $account['Code'],
								'name' => $account['Name'],
							);
						}
				    }
				}
			} catch (Exception $e) {
				return $data_accounts;
			}
		}
		return $data_accounts;
	}
	
	public function getPaymentAccounts(){
	    $data_accounts = array();
	    if ($this->refreshToken() && $this->getTenantId()) {
    	    try {
    	        //$response = $this->execute_curl('https://api.xero.com/api.xro/2.0/Accounts', 'GET');
    	        $response = $this->execute_curl('https://api.xero.com/api.xro/2.0/Accounts?where=Type=="BANK"', 'GET');
    	        //$response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Accounts', 'core'));
        	    if (isset($response['Accounts']) && $response['Accounts']) {
        	        foreach ($response['Accounts'] as $account) {
        	            //if (isset($account['Code']) && $account['Code'] && isset($account['Name']) && $account['Name']) {
							$data_accounts[] = array(
								'id' => $account['AccountID'],
								'name' => $account['Name'],
							);
						//}
				    }
        	    }
        	    /*if (isset($this->XeroOAuth->response['code']) && $this->XeroOAuth->response['code'] == 200) {
        	        $accounts = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
        	        if (isset($accounts->Accounts[0]) && count($accounts->Accounts[0]) > 0) {
        	            foreach ($accounts->Accounts[0] as $response) {
        	                $response = (array)$response;
        	                if (isset($response['Code']) && $response['Code'] && isset($response['Name']) && $response['Name']) {
        	                    $data_accounts[] = array(
        	                        'id' => $response['Code'],
        	                        'name' => $response['Name'],
        	                    );
        	                }
        	            }
        	        }
        	    } else {
        	        return $data_accounts;
        	    }*/
            } catch (Exception $e) {
        	    return $data_accounts;
        	}
    	 }
	     return $data_accounts;
	}
}
