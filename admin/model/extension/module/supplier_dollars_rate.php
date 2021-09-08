<?php

class ModelExtensionModuleSupplierDollarsRate extends Controller {

	public function install() {

		$this->installTables();

		return TRUE;

	}

	public function installTables(){

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppliers` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` varchar(50) NOT NULL,
              `rate` float NOT NULL,
              `coefficient` float,
               PRIMARY KEY (`id`)
            ) DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppliers_and_products` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `product_id` INT NOT NULL,
              `supplier_id` INT NOT NULL,
               PRIMARY KEY (`id`)
            ) DEFAULT CHARSET=utf8;");

	}

	public function upgrade(){

		$this->installTables();

	}

	public function uninstall(){

		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "suppliers");
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "suppliers_products_cost");
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "suppliers_and_products");

	}

}