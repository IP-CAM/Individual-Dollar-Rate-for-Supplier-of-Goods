<?php

class ModelCatalogSupplier extends Model
{

	public function addSupplier($data)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "suppliers SET name = '" . $data['supplier_name'] . "', rate = '" . (float)$data['supplier_rate'] . "'");

		$supplier_id = $this->db->getLastId();

		$this->cache->delete('supplier');

		return $supplier_id;
	}

	public function EditSupplier($data)
	{

		$query = "UPDATE " . DB_PREFIX . "suppliers SET name = '" . (string)$data['supplier_name'] . "', rate = '" . (float)$data['supplier_rate'] . "', coefficient = null  WHERE id = '" . (int)$data['supplier_id'] . "'";

		$this->db->query($query);

	}

	public function deleteSupplier($supplier_id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "suppliers` WHERE id = '" . (int)$supplier_id . "'");

		$this->cache->delete('supplier');
	}

	public function getSupplierFromProductId($product_id)
	{

		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "suppliers_and_products WHERE product_id = '" . (int)$product_id . "'";
		$query = $this->db->query($sql);

		return $query->row;

	}

	public function getSupplier($supplier_id)
	{
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "suppliers WHERE id = '" . $supplier_id . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getSuppliers()
	{

		$sql = "SELECT * FROM " . DB_PREFIX . "suppliers";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCost($product_id){

		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "suppliers_products_cost WHERE product_id = '" . $product_id . "'";

		$query = $this->db->query($sql);

		return $query->row;

	}

	public function getCosts()
	{

		$sql = "SELECT * FROM " . DB_PREFIX . "suppliers_products_cost";

		$query = $this->db->query($sql);

		return $query->rows;

	}

	public function getCurrencyUah(){

		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = 'UAH'";

		$query = $this->db->query($sql);

		return $query->row['value'];

	}

	public function updateCoefficient($supplier_id, $supplier_coefficient){

		$sql = "UPDATE " . DB_PREFIX . "suppliers SET coefficient = '" . $supplier_coefficient . "' WHERE id = '" . $supplier_id . "'";

		$this->db->query($sql);

	}

}

