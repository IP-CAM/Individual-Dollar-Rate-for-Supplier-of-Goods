<?php

class ControllerCatalogSupplier extends Controller {

	public function index(){

		$this->load->language('catalog/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/supplier');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/supplier', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['suppliers'] = $this->model_catalog_supplier->getSuppliers();

		$data['add'] = $this->url->link('catalog/supplier/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['edit'] = $this->url->link('catalog/supplier/edit', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('catalog/supplier/delete', 'user_token=' . $this->session->data['user_token'], true);
		$data['coefficient'] = $this->url->link('catalog/supplier/coefficient', 'user_token=' . $this->session->data['user_token'], true);
		$data['calculate_all'] = $this->url->link('catalog/supplier/allCoefficient', 'user_token=' . $this->session->data['user_token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/supplier_list', $data));
	}

	public function add(){

		$this->load->language('catalog/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/supplier');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_supplier->addSupplier($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('catalog/supplier', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();

	}

	public function edit(){

		$this->load->language('catalog/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/supplier');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_supplier->EditSupplier($this->request->post);

			$this->session->data['sucess'] = $this->language->get('text_sucess');

			$this->response->redirect($this->url->link('catalog/supplier', 'user_token=' . $this->session->data['user_token'], true));

		}



	}

	public function delete(){

		$this->load->model('catalog/supplier');

		$this->load->language('catalog/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		if(($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$supplier_id = $this->request->post['supplier_id'];
			$this->model_catalog_supplier->deleteSupplier($supplier_id);

			$this->session->data['success'] = $this->language->get('text_success');

		}

		$this->response->redirect($this->url->link('catalog/supplier', 'user_token=' . $this->session->data['user_token'], true));

	}

	public function coefficient($supplier_id = null){

		if($supplier_id == null){
			$supplier_id = $this->request->post['supplier_id'];
		}

		$this->load->model('catalog/supplier');

		$supplier = $this->model_catalog_supplier->getSupplier($supplier_id);
		$supplier_rate = $supplier['rate'];

		$store_rate = $this->model_catalog_supplier->getCurrencyUah();

		$supplier_coefficient = $supplier_rate / $store_rate;

		$this->model_catalog_supplier->updateCoefficient($supplier_id, $supplier_coefficient);

		if($supplier_id == null){
			$this->response->redirect($this->url->link('catalog/supplier', 'user_token=' . $this->session->data['user_token'], true));
		} else {
			return TRUE;
		}


	}

	public function allCoefficient(){

		$this->load->model('catalog/supplier');

		$suppliers = $this->model_catalog_supplier->getSuppliers();

		foreach ($suppliers as $supplier) {

			$this->coefficient($supplier['id']);

		}

		$this->response->redirect($this->url->link('catalog/supplier', 'user_token=' . $this->session->data['user_token'], true));

	}

	protected function getForm(){

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['action'] = $this->url->link('catalog/supplier/add', 'user_token=' . $this->session->data['user_token'], true);

		$this->response->setOutput($this->load->view('catalog/supplier_form', $data));

	}

	protected function validateForm() {

		return !$this->error;
	}

}
