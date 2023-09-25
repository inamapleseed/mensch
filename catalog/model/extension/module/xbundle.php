<?php
class ModelExtensionModuleXBundle extends Model {
    private $mtype;
    public function __construct($registry) {
        parent::__construct($registry);
        $this->registry = $registry;
        $this->ocm = ($ocm = $this->registry->get('ocm_front')) ? $ocm : new OCM\Front($this->registry);
        $this->mtype = 'module';
    }
    public function getBundles($product_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "xbundle WHERE product_id = '".(int)$product_id."'";
        return  $this->db->query($sql)->rows;
    }
    public function getDiscountedPrice($discount, $price) {
        $discount = trim(trim($discount), '-');
        if (substr($discount, -1) == '%') {
            $discount = rtrim($discount,'%');
            $percent = true;
            $value = (float)$discount / 100;
        } else {
            $percent = false;
            $value = (float)$discount;
        }
        $amount = $percent ? ($value * $price) : $value;
        $return = $price - $amount;
        if ($return < 0) {
            $return = 0;
        }
        return $return;
    }
    public function getBundleProduct($product_id, $bundle_id) {
        $bundle_info = $this->db->query("SELECT * FROM " . DB_PREFIX . "xbundle WHERE product_id = '".(int)$product_id."' AND bundle_id = '".(int)$bundle_id."'")->row;
        /* latency version - will remove in future  */
        if ($bundle_info && empty($bundle_info['discount']) && !empty($bundle_info['price'])) {
            $bundle_info['discount'] = (float)$product_price - (float)$bundle_info['price'];
        }
        /* end of latency */
        return $bundle_info;
    }
    public function isBundleExist($product_id) {
        $sql = "SELECT bundle_id FROM " . DB_PREFIX . "xbundle WHERE product_id = '".(int)$product_id."'";
        return  $this->db->query($sql)->rows;
    }
    private function getCSS($xbundle_box) {
        $css = '<style type="text/css">
                .xbundle-wrapper {
                  position: relative;
                  min-height: 100px;
                  border: 1px solid #ccc;
                }
                .xbundle-wrapper i.xbloader {
                   position: absolute;
                   position: absolute;
                   left: 50%;
                   top: 39%;
                   font-size: 24px;
                }
                .xb .fa-angle-down, .xb .fa-angle-up, .xb .increase, .xb .decrease{
                    visibility: hidden !important;
                }
                .xb button[type="submit"], .xb input[type="submit"],
                .quick-checkout-wrapper tr.xb .input-group-btn button:first-child {
                  display: none !important;
                }
              </style>';

        if ($xbundle_box && $xbundle_box['css']) {
           $css .= '<style type="text/css">'.$xbundle_box['css'].'</style>';
        }
        return $css;
    }
    public function getScript($module_inject = false) {
        if ($this->ocm->isCacheAvail('xbundle_box')) {
            return '';
        }
        if (defined('JOURNAL3_ACTIVE')) {
            $default_selector = '.product-info:after';
        } else {
            $default_selector = '#content .row:after';
        }
        $xbundle_status = $this->ocm->getConfig('xbundle_status', $this->mtype);
        $xbundle_box = $this->ocm->getConfig('xbundle_box', $this->mtype);
        $xbundle_selector = ($xbundle_box && $xbundle_box['selector']) ? $xbundle_box['selector'] : $default_selector;

        $product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0;

        $position = '';
        if (strpos($xbundle_selector, ':') !== false) {
            list($selector, $position) = explode(':', $xbundle_selector);
        } else {
            $selector = $xbundle_selector;
        }
        if (!in_array($position, array('append', 'prepend', 'after', 'before'))) $position = 'append';
        
        $url = 'index.php?route=extension/module/xbundle/fetch&product_id='.$product_id;
        $xb_box = '';
        $box = '';
        if ($this->ocm->isProductPage() && $this->isBundleExist($product_id)) {
            $box = '<div class="xbundle-wrapper"><i class="fa fa-spinner fa-spin xbloader"></i></div>';
            if (!$module_inject) {
                if (isset($xbundle_box['tab'])) {
                    $language_id = $this->config->get('config_language_id');
                    $this->load->language($this->ext_path);
                    $xbundle_title = $this->ocm->getConfig('xbundle_title', $this->mtype);
                    if (!isset($xbundle_title[$language_id])) {
                        $box_title = $this->language->get('defualt_title');
                    } else {
                        $box_title = $xbundle_title[$language_id];
                    }
                    $_th = '<li><a href="#tab-xbundle" data-toggle="tab">' . $box_title . '</a></li>';
                    $_tc = '<div class="tab-pane tab-content" id="tab-xbundle">' . $box . '</div>';
                    $xb_box .= '$(\''.$selector.'\').'.$position.'(\''.$_th.'\');';
                    $xb_box .= '$(\''.$selector.'\').next().'.$position.'(\''.$_tc.'\');';
                } else {
                    $xb_box .= '$(\''.$selector.'\').first().'.$position.'(\''.$box.'\');';
                }
            }
            $xb_box .= '$(\'.xbundle-wrapper\').load(\''.$url.'\');';
        }
        $xb_js = '';
        if ($this->ocm->isCheckoutPage() || $this->ocm->isCartPage()) {
            $xb_js .= ' var xb_counter = 0;
                        function applyXBClass() {
                          var _xbn = $(\'xb\');
                          if (_xbn.length == xb_counter) {
                              return;
                          }
                         xb_counter = _xbn.length;
                         var _xbr = _xbn.closest(\'tr\').removeClass(\'xb\').addClass(\'xb\');
                         _xbr.find(\'input[type="text"]\').prop(\'disabled\',true);
                         /* Recheck if it applied correctly as client side rendering cause issue */
                         $(\'tr.xb\').each(function(i) {
                               var is_xb = $(this).find(\'xb\');
                               if (is_xb.length == 0) {
                                  $(this).removeClass(\'xb\');
                                  $(this).find(\'input[type="text"]\').prop(\'disabled\',false);
                               }
                         });
                    }';
            $xb_js .= '$(document).ajaxComplete(applyXBClass);';
            $xb_js .= 'applyXBClass();';
        }
        $html = '';
        if ($xbundle_status && ($this->ocm->isCheckoutPage() || $this->ocm->isCartPage() || $this->ocm->isProductPage())) {
            if ($module_inject) {
                $html .= $box;
                $this->ocm->setCache('xbundle_box', true);
            }
            $html .= $this->getCSS($xbundle_box);
            $html .= '<script type="text/javascript">'. $xb_box . $xb_js .'</script>';
        }
        return $html;
    }
}