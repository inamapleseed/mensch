<?php
class ControllerExtensionModuleXBundle extends Controller {
    use OCM\Traits\Front\Cart;
    use OCM\Traits\Front\Product_options;
    private $ext_path;
    private $mtype;
    public function __construct($registry) {
        parent::__construct($registry);
        $this->registry = $registry;
        $this->ocm = ($ocm = $this->registry->get('ocm_front')) ? $ocm : new OCM\Front($this->registry);
        $this->mtype = 'module';
        $this->ext_path = 'extension/module/xbundle';
    }
    /* load via module */
    public function index() {
        $this->load->model($this->ext_path);
        return $this->model_extension_module_xbundle->getScript(true);
    }
    public function fetch() {
        $this->load->model($this->ext_path);
        $ext_lang = $this->load->language($this->ext_path);
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $language_id = $this->config->get('config_language_id');
        
        $xbundle_box = $this->ocm->getConfig('xbundle_box', $this->mtype);
        $bundle_image_width = isset($xbundle_box['width']) ? $xbundle_box['width'] : 100;
        $bundle_image_height = isset($xbundle_box['height']) ? $xbundle_box['height'] : 100;
        $bundle_box_width = !empty($xbundle_box['size']) ? $xbundle_box['size'] : 170;

        $product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0;
        $product_info =  $this->model_catalog_product->getProduct($product_id);
        $data = array();
        $data = array_merge($data, $ext_lang);
        $data['product_id'] = $product_id;
        $data['pre_selected'] = !$this->isValidateCart($product_id);
        $data['name'] = $product_info['name'];
        $data['href'] = $this->url->link('product/product', 'product_id=' . $product_id);
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            if ((float)$product_info['special']) {
                $data['price'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            }
        } else {
            $data['price'] = false;
        }

        if ($product_info['image']) {
            $data['thumb'] = $this->model_tool_image->resize($product_info['image'], $bundle_image_width, $bundle_image_height );
        } else {
            $data['thumb'] = $this->model_tool_image->resize('placeholder.png', $bundle_image_width, $bundle_image_height);
        }

        $data['stock'] = '';
        if ($product_info['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
            $data['stock'] = $product_info['stock_status'];
        }

        $data['products'] = array();
        $results = $this->model_extension_module_xbundle->getBundles($product_id);
        foreach ($results as $result) {
            $product_info =  $this->model_catalog_product->getProduct($result['bundle_id']);
            if (!$product_info['status']) {
                continue;
            }
            $original_price = isset($product_info['ocm_price']) ? (float)$product_info['ocm_price'] : (float)$product_info['price'];
            // only consider OC special price for bundled product NOT from other mods
            $product_special = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$result['bundle_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1")->row;
            $original_price = $product_special ? (float)$product_special['price'] : $original_price;
            
            /* latency version -will remove in future  */
            if (!$result['discount'] && !empty($result['price'])) {
                $result['discount'] = (float)$original_price - (float)$result['price'];
            }
            /* end of latency */
            $bundle_price = $this->model_extension_module_xbundle->getDiscountedPrice($result['discount'], $original_price);
            //$bundle_price = !empty($discount_price) ? $discount_price : $original_price;
            

            if ($product_info['image']) {
                $image = $this->model_tool_image->resize($product_info['image'], $bundle_image_width, $bundle_image_height);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $bundle_image_width, $bundle_image_height);
            }

            $original_price = $this->currency->format($this->tax->calculate($original_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $bundle_price = $this->currency->format($this->tax->calculate($bundle_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $bundle_price = false;
            }
            $stock = '';
            if ($product_info['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
                $stock = $product_info['stock_status'];
            }
            $data['products'][] = array(
                'product_id'  => $product_info['product_id'],
                'name'        => $product_info['name'],
                'thumb'       => $image,
                'price'       => $bundle_price,
                'old_price'   => $original_price,
                'stock'       => $stock,
                'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
            );
        }

        $xbundle_title = $this->ocm->getConfig('xbundle_title', $this->mtype);
        if (!isset($xbundle_title[$language_id])) {
            $data['box_title'] = $this->language->get('defualt_title');
        } else {
            $data['box_title'] = $xbundle_title[$language_id];
        }

        $data['count'] = sprintf($this->language->get('text_bundle_total_selected'), 0);
        $data['org_total_tax'] = $this->currency->format(0, $this->session->data['currency']);
        $data['total_tax'] = $this->currency->format(0, $this->session->data['currency']);
        $data['save'] = $this->currency->format(0, $this->session->data['currency']);
        $data['box_width'] = $bundle_box_width;
        $this->response->setOutput($this->ocm->view($this->ext_path, $data));
    }
    public function addBundle() {
        $json = array(); 
        $this->load->language('checkout/cart');
        $this->load->language($this->ext_path);
        $this->load->model($this->ext_path);
        $cart = isset($this->request->post['cart']) ? $this->request->post['cart'] : array();
        $_product_id = isset($this->request->post['_product_id']) ? $this->request->post['_product_id'] : 0;
        $is_exist = $this->xbundle->isBundleExist($_product_id);
        foreach ($cart as $product) {
            $recurring_id = isset($product['recurring_id']) ? $product['recurring_id'] : 0;
            $option = isset($product['option']) ? $product['option'] : array();
            $option['xbundle'] = $_product_id;
            if ($is_exist) {
                if ($_product_id == $product['product_id']) {
                    if ($is_exist['option'] != $option) {
                       $this->xbundle->updateCartOption($is_exist['cart_id'], $option);
                    }
                } else {
                   $self_status = $this->xbundle->isBundleProductExist($product['product_id'],$_product_id);
                    if ($self_status === false) {
                        $this->cart->add($product['product_id'], 1, $option, $recurring_id);
                    } else if ($self_status['option'] != $option) {
                        $this->xbundle->updateCartOption($self_status['cart_id'], $option);
                    }
                }
            } else {
                $cart_id = $this->cart->add($product['product_id'], 1, $option, $recurring_id);
            }
        }
        $json = $this->refreshCart();
        $json['success'] = sprintf($this->language->get('success_add_to_cart'), $this->url->link('checkout/cart'));
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json)); 
    }
    public function getBundlePrice() {
        $this->load->language($this->ext_path);
        $this->load->model($this->ext_path);

        $json = array();
        $cart = isset($this->request->post['cart']) ? $this->request->post['cart'] : array();
        $_product_id = isset($this->request->post['_product_id']) ? $this->request->post['_product_id'] : 0;
        $bundle_id = isset($this->request->post['bundle_id']) ? $this->request->post['bundle_id'] : 0;
        $option = isset($this->request->post['option']) ? array_filter($this->request->post['option']) : array();
        $recurring_id = isset($this->request->post['recurring_id']) ? $this->request->post['recurring_id'] : 0;

        if ($bundle_id) {
            $json = $this->isValidateCart($bundle_id, $option, $recurring_id);
            if (!$json) {
                if ($bundle_id != $_product_id) {
                    $bundle_info = $this->model_extension_module_xbundle->getBundleProduct($_product_id, $bundle_id);
                    if (!$bundle_info) {
                        $json['error'] = $this->language->get('error_invalid_bundle_product');
                    }
                }
                if (!$json) {
                    $cart_product = array(
                        'product_id' => $bundle_id,
                        'recurring_id' => $recurring_id,
                        'option'     => $option
                    );
                    array_push($cart, $cart_product);
                }
            }
        } 
        if (!$json) {
            $json = $this->getBundleStats($_product_id, $cart);
            $json['cart'] = $cart;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json)); 
    }
    private function getBundleStats($_product_id, $cart) {
        $this->load->model('catalog/product');
        $return = array();
        $return['count'] = sprintf($this->language->get('text_bundle_total_selected'), count($cart));
        $original_cost = 0;
        $original_cost_tax = 0;
        $bundle_cost = 0;
        $bundle_cost_tax = 0;
        foreach ($cart as $product) {
            $product_info = $this->model_catalog_product->getProduct($product['product_id']);
            $bundle_info = $this->model_extension_module_xbundle->getBundleProduct($_product_id, $product['product_id']);
            if ($bundle_info) {
                $original_price = isset($product_info['ocm_price']) ? (float)$product_info['ocm_price'] : (float)$product_info['price'];
                // only consider OC special price for bundled product NOT from other mods
                $product_special = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1")->row;
                $original_price = $product_special ? (float)$product_special['price'] : $original_price;
                $bundle_price = $this->model_extension_module_xbundle->getDiscountedPrice($bundle_info['discount'], $original_price);
            } else {
                $original_price = $product_info['special'] ? (float)$product_info['special'] : (float)$product_info['price'];
                $bundle_price = $original_price;
            }
            //$bundle_price = !empty($discount_price) ? $discount_price : $original_price;
            $option_price = 0;
            if (isset($product['option']) && is_array($product['option'])) {
                foreach ($product['option'] as $product_option_id => $product_option_value_ids) {
                    if ($product_option_value_ids) {
                        if (!is_array($product_option_value_ids)) {
                            $product_option_value_ids = array($product_option_value_ids);
                        }
                        foreach($product_option_value_ids as $product_option_value_id) {
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value_id . "'");
                            if ($query->row) {
                              if ($query->row['price_prefix']=='+') $option_price += (float)$query->row['price'];
                              if ($query->row['price_prefix']=='-') $option_price -= (float)$query->row['price'];
                            }
                        }
                    }
                }
            }
            $original_price = $original_price + $option_price;
            $original_price_with_tax = $this->tax->calculate($original_price, $product_info['tax_class_id'], $this->config->get('config_tax'));
            $bundle_price   = $bundle_price + $option_price;
            $bundle_price_with_tax = $this->tax->calculate($bundle_price, $product_info['tax_class_id'], $this->config->get('config_tax'));

            $original_cost     += $original_price;
            $original_cost_tax += $original_price_with_tax;
            $bundle_cost       += $bundle_price;
            $bundle_cost_tax   += $bundle_price_with_tax;
        }

        $total_save          = $original_cost - $bundle_cost;
        $total_save_tax      = $original_cost_tax - $bundle_cost_tax;
        $return['org_total'] = $this->currency->format($original_cost, $this->session->data['currency']);
        $return['org_total_tax'] = $this->currency->format($original_cost_tax, $this->session->data['currency']);
        $return['total']     = $this->currency->format($bundle_cost, $this->session->data['currency']);
        $return['total_tax'] = $this->currency->format($bundle_cost_tax, $this->session->data['currency']);
        $return['save']      = $this->currency->format($total_save, $this->session->data['currency']);
        $return['save_tax']  = $this->currency->format($total_save_tax, $this->session->data['currency']);
        return $return;
    }
 }