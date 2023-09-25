<?php 
final class Ocmprice {
    private $registry;
    private $xbundle = false;
    private $xgift = false;
    private $xdiscount = false;
    private $xlevel = false;
    private $_xproducts_flag = true;
    private $_on_carts_flag = true;
    private $_xproducts = array();
    private $_sp_products_cache = array(); /* Cache speical price 1. Performace issue 2. Loop invoking issue */
    private $_cart_cache = array(
        'xdiscount' => array(),
        'xlevel'    => array()
    );
    public function __construct($registry) {
        $this->registry = $registry;
        $prefix = VERSION >= '3.0.0.0' ? 'module_' : '';
        if ($this->config->get($prefix . 'xbundle_status')) {
            $this->xbundle = new \Xbundle($registry);
            $registry->set('xbundle', $this->xbundle);
        }
        if ($this->config->get($prefix . 'xgift_status')) {
            $this->xgift = new \Xgift($registry);
            $registry->set('xgift', $this->xgift);
        }
        if ($this->config->get($prefix . 'xdiscount_status')) {
            $this->xdiscount = new \Xdiscount($registry);
            $registry->set('xdiscount', $this->xdiscount);
        }
        if ($this->config->get($prefix . 'xlevel_status')) {
            $this->xlevel = new \Xlevel($registry);
            $registry->set('xlevel', $this->xlevel);
        }
        if ($this->config->get($prefix . 'bulkprice_status')) {
            $this->bulkprice = new \Bulkprice($registry);
            $registry->set('bulkprice', $this->bulkprice);
        }
        if ($this->config->get($prefix . 'xcombination_status')) {
            $this->xcombination = new \Xcombination($registry);
            $registry->set('xcombination', $this->xcombination);
        }
    }

    public function __get($name) {
       return $this->registry->get($name);
    }
    /* price prefix for OC 2.1.x */
    public function trigger($data) {
        if ($this->xlevel && $price_prefix = $this->xlevel->getPricePrefix()) {
            $path = (VERSION >= '2.3.0.0') ? 'extension/module/' : 'module/';
            $key = 'model_' . str_replace('/', '_', $path) . 'xlevel';
            $this->load->model($path . 'xlevel');
            $data = $this->{$key}->applyPricePrefix($data, $price_prefix);
        }
        return $data;
    }
    public function onCartOperation($cart_id, $fn) {
        $return = false;
        $modules = array('xgift', 'xbundle', 'xcombination');
        $method = 'onCart' . ucfirst($fn);
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, $method)) {
                $_return = $this->{$key}->{$method}($cart_id);
                if ($_return) {
                    $return = $_return;
                }
            }
        }
        return $return;
    }
    public function onCartProducts() {
        if (!$this->_on_carts_flag) return false;
        $modules = array('xgift', 'xbundle', 'xcombination');
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, 'onCartProducts')) {
                $this->{$key}->{'onCartProducts'}();
            }
        }
        $this->_on_carts_flag = false;
    }
    public function applyCartPrice($data) {
        if (VERSION >= '2.1.0.0') {
            $data['cart']['option'] = json_decode($data['cart']['option'], true);
        }
        if (!isset($data['cart']['option']) || !is_array($data['cart']['option'])) {
            $data['cart']['option'] = array();
        }
        $is_xpriced = isset($data['cart']['option']['xgift']) || isset($data['cart']['option']['xbundle']) || isset($data['cart']['option']['xcombination']);
        if ($data['special'] && !$is_xpriced) {
            $this->_sp_products_cache[$data['product']['product_id']] = $data['special'] + $data['option_price'];
        }
        // sync stock if same product is added in cart for xbundle and xgift i.e option based modification
        // TODO - OC < 2.1.x
        if ($this->_xproducts_flag) {
            $this->setXProductStock($data['carts']);
            $this->_xproducts_flag = false;
        }
        if (!$is_xpriced && isset($this->_xproducts[$data['cart']['product_id']])) {
            $data['product']['quantity'] -= $this->_xproducts[$data['cart']['product_id']];
            //$this->_xproducts[$data['cart']['product_id']] = 0;
        }
        // end of stock sync
        $data['product']['special'] = $data['special'];
        $data['product']['discount'] = $data['discount'];

        $modules = array('bulkprice', 'xcombination', 'xgift', 'xbundle', 'xlevel', 'xdiscount');
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, 'applyCartPrice')) {
                $_return = $this->{$key}->{'applyCartPrice'}($data);
                if ($_return !== false) {
                    // don't apply on cart if it is order-total-type module
                    if (isset($this->_cart_cache[$key]) && isset($_return['on_total'])) {
                        $applied = array(
                            'amount'       => $_return['amount'] * $data['cart']['quantity'],
                            'tax_class_id' => $data['product']['tax_class_id'],
                            'product_id'   => $data['product']['product_id']
                        );
                        if (isset($_return['option_amount'])) {
                            $applied['amount'] += $_return['option_amount'] * $data['cart']['quantity'];
                        }
                        if (isset($_return['type'])) {
                            $applied['type'] = $_return['type'];
                        }
                        $data['price'] = $data['product']['price']; // reset to original price
                        /* when it shows as `Order Total `, it will create disparity so let set special price as the main price */
                        if ($key == 'xlevel' && !empty($data['product']['special'])) {
                            $data['price'] = $data['product']['special']; 
                        }
                        $cache_key = $data['product']['product_id'] . '_' . json_encode($data['cart']['option']);
                        $this->_cart_cache[$key][$cache_key] = $applied;
                        return;
                    }
                    if (isset($_return['price'])) {
                        $data['price'] = $_return['price'];
                        if (isset($_return['type']) && $_return['type'] == 'overwrite') {
                            $data['product']['price'] = $_return['price'];
                        }
                    }
                    if (isset($_return['option_price'])) {
                        $data['option_price'] = $_return['option_price'];
                    }
                    if (isset($_return['option_data'])) {
                        $data['option_data'] = $_return['option_data'];
                    }
                    // finish process if no_return is set
                    if (!isset($_return['no_return'])) {
                        return;
                    }
                }
            }
        }
    }
    public function getDiscountedProduct($data) {
        $modules = array('bulkprice', 'xlevel', 'xdiscount');
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, 'getDiscountedProduct')) {
                $_return = $this->{$key}->{'getDiscountedProduct'}($data['product']);
                if ($_return !== false) {
                    if ($_return['type'] == 'overwrite') {
                        if (isset($_return['price'])) {
                            $data['product']['price'] = $_return['price'];
                        }
                        if (isset($_return['reset']) && $_return['reset']) {
                            $data['product']['discount'] = 0;
                            $data['product']['special'] = 0;
                        }
                        if (isset($data['product']['ocm_price']) && isset($_return['price'])) {
                            $data['product']['ocm_price'] = $_return['price'];
                        }
                        if (isset($_return['special'])) {
                            $data['product']['special'] = $_return['special'];
                        }
                        if (isset($_return['discount'])) {
                            $data['product']['discount'] = $_return['discount'];
                        }
                    }
                    else if ($_return['type'] == 'special') {
                        $data['product']['special'] = $_return['price'];
                        if (isset($_return['reset']) && $_return['reset']) {
                            $data['product']['discount'] = 0;
                        }
                    }
                    else if ($_return['type'] == 'discount') {
                        $data['product']['discount'] = $_return['price'];
                        $data['product']['price'] = $_return['price']; // overwrite as using after event
                        if (isset($_return['reset']) && $_return['reset']) {
                            $data['product']['special'] = 0;
                        }
                    }
                    // finish process if no_return is set
                    if (!isset($_return['no_return'])) {
                        return;
                    }
                }
            }
        }
    }
    public function getDiscountedOption($data) {
        $modules = array('bulkprice', 'xlevel', 'xdiscount');
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, 'getOptionPrice')) {
                $_return = $this->{$key}->{'getOptionPrice'}($data['option_price'], $data['product_id'], $data['price_prefix']);
                if ($_return !== false) {
                    $old_price = '';
                    if ($data['type'] !== 'select' && !isset($_return['no_return']) && !isset($_return['no_line'])) {
                        $old_price = '<span class="xprice-option-line" style="text-decoration:line-through; margin-right: 5px;">' . $data['price'] . '</span>';
                    }
                    $data['option_price'] = $_return['price'];
                    $data['price'] = $old_price . $this->currency->format($this->tax->calculate($_return['price'], $data['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                    // finish process if no_return is set
                    if (!isset($_return['no_return'])) {
                        return;
                    }
                }
            }
        }
    }
    public function getOptionPrice($data) {
        $modules = array('bulkprice', 'xlevel', 'xdiscount');
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, 'getOptionPrice')) {
                $_return = $this->{$key}->{'getOptionPrice'}($data['price'], $data['product_id']);
                if ($_return !== false) {
                    $data['price'] = $_return['price'];
                    // finish process if no_return is set
                    if (!isset($_return['no_return'])) {
                        return;
                    }
                }
            }
        }
    }
    public function getQuantityDiscount($data) {
        $modules = array('bulkprice');
        foreach ($modules as $key) {
            if ($this->{$key} && method_exists($this->{$key}, 'getQuantityDiscount')) {
                $_return = $this->{$key}->{'getQuantityDiscount'}($data['quantity']['price'], $data['quantity']['product_id']);
                if ($_return !== false) {
                    $data['quantity']['price'] = $_return['price'];
                    // finish process if no_return is set
                    if (!isset($_return['no_return'])) {
                        return;
                    }
                }
            }
        }
    }
    public function getCartSpecialProducts() {
        return $this->_sp_products_cache;
    }
    public function setXProductStock($carts) {
        $_xproducts = array();
        if (VERSION < '2.1.0.0') { // TODO OC < 2.1.x, adjust code like ocm/front.php getCartProducts
            return $_xproducts;
        }
        foreach ($carts as $cart) {
            $option = json_decode($cart['option'], true);
            if ($option && (isset($option['xbundle']) || isset($option['xgift']) || isset($option['xcombination']))) {
                if (!isset($_xproducts[$cart['product_id']])) $_xproducts[$cart['product_id']] = 0;
                $_xproducts[$cart['product_id']] += $cart['quantity'];
            }
        }
        $this->_xproducts = $_xproducts;
    }
    public function getCartDiscount($type) {
        return isset($this->_cart_cache[$type]) ? $this->_cart_cache[$type] : array();
    }
    public function getXDiscountedProducts() {
        $return = array();
        foreach($this->_cart_cache as $each) {
            if (is_array($each)) {
                foreach($each as $product) {
                    $return[] = $product['product_id'];
                }
            }
        }
        return $return;
    }
}