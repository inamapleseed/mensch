<?php
class ModelXeroOpcXero extends Model {
	public function createTable() {
    $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "xero_customer (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `oc_customer_id` int(11) NOT NULL,
      `xero_customer_id` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

    $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "xero_product (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `oc_product_id` int(11) NOT NULL,
      `xero_product_id` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

    $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "xero_order (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `oc_order_id` int(11) NOT NULL,
      `xero_order_id` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "xero_payment (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `order_id` int(11) NOT NULL,
		  `xero_payment_id` varchar(100) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
	}

  public function dropTable() {
    $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "xero_customer");
    $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "xero_product");
    $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "xero_order");
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "xero_payment");
	}
}
