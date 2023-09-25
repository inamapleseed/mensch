<?php
class ModelExtensionModuleXBundle extends Model {
    use OCM\Traits\Back\Model\Product;
    public function addDBTables() {
        $sql = "
          CREATE TABLE IF NOT EXISTS `".DB_PREFIX."xbundle` (
           `product_id` int(8),
           `bundle_id` int(8),
           `discount` varchar(200),
            PRIMARY KEY (`product_id`,`bundle_id`)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);

        $sql = "
          CREATE TABLE IF NOT EXISTS `".DB_PREFIX."xbundle_preset` (
           `id` int(8) NOT NULL AUTO_INCREMENT,
           `name` varchar(255),
           `products` TEXT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
    }
    public function addBundle($product_id, $products) {
        $this->deleteBundle($product_id);
        foreach ($products as $bundle_id => $discount) {
           $sql ="INSERT INTo`" .DB_PREFIX . "xbundle` SET `product_id` = '".(int)$product_id."', bundle_id = '".(int)$bundle_id."', discount  = '" . $this->db->escape($discount) . "'";
            $this->db->query($sql);
        }
        return true;
    }
    public function getBundles($product_id) {
        $sql = "SELECT b.*, `p`.`price` AS actual_price, `pd`.`name` FROM " . DB_PREFIX . "xbundle b";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (b.bundle_id = p.product_id)";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (b.bundle_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND b.product_id = '".(int)$product_id."' ORDER BY `pd`.`name` ASC";

        return $this->db->query($sql)->rows;
    }
    public function deleteBundle($product_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "xbundle` WHERE product_id = '" . (int)$product_id . "'");
        return true;
    }
    public function addPresets($presets) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "xbundle_preset`");
        foreach ($presets as $preset) {
            $name = isset($preset['name']) ? $preset['name'] : 'Untitled Preset';
            $products = isset($preset['products']) ? $preset['products'] : array();
            $products = json_encode($products);
            $sql ="INSERT INTo`" .DB_PREFIX . "xbundle_preset` SET `name` = '" . $this->db->escape($name) . "', `products` = '" . $this->db->escape($products) . "'";
            $this->db->query($sql);
        }
    }
    public function getPresets() {
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "xbundle_preset` ORDER BY id asc")->rows;
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
    public function getPresetProducts($preset_id) {
        $this->load->model('catalog/product');
        $return = array();
        $preset = $this->db->query("SELECT * FROM `" . DB_PREFIX . "xbundle_preset` WHERE id='" . (int)$preset_id . "'")->row;
        if ($preset) {
            $products = json_decode($preset['products'], true);
            foreach ($products as $product_id => $discount) {
                $product_info = $this->model_catalog_product->getProduct($product_id);
                if ($product_info) {
                    $return[] = array(
                        'product_id'   => (int)$product_id,
                        'name'         => $product_info['name'],
                        'price'        => (float)$product_info['price'],
                        'discount'     => $discount,
                        'bundle'       => $this->getDiscountedPrice($discount, (float)$product_info['price'])
                    );
                }
            }
        }
        return $return;
    }
}