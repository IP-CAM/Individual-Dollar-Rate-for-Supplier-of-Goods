<?php

class ControllerExtensionModuleSupplierDollarsRate extends Controller {

	public function install(){
		$this->load->model('extension/module/supplier_dollars_rate');
		$this->model_extension_module_supplier_dollars_rate->install();
	}

	public function uninstall(){
		$this->load->model('extension/module/supplier_dollars_rate');
		$this->model_extension_module_supplier_dollars_rate->uninstall();
	}

	public function index() {

		$this->load->language('extension/module/supplier_dollars_rate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');



		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('supplier_dollars_rate', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'].'&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'		=> $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true),
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/supplier_dollars_rate', 'user_token=' . $this->session->data['user_token'], true),
		);

		$data["user_token"] = $this->session->data['user_token'];

		$data['action'] = $this->url->link('extension/module/supplier_dollars_rate', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true);

		$data['settings'] = $this->config->get('supplier_dollars_rate') ? $this->config->get('supplier_dollars_rate') : array();


		if (isset($this->request->post['supplier_dollars_rate_status'])) {
			$data['supplier_dollars_rate_status'] = $this->request->post['supplier_dollars_rate_status'];
		} else {
			$data['supplier_dollars_rate_status'] = $this->config->get('supplier_dollars_rate_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/supplier_dollars_rate', $data));

	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/supplier_dollars_rate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}


}