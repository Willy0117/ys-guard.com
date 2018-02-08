<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$data['text_api'] = $this->language->get('text_api');
		$data['text_backup'] = $this->language->get('text_backup');

		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_sales'] = $this->language->get('text_sales');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_catalog'] = $this->language->get('text_catalog');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_transport'] = $this->language->get('text_transport');
		$data['text_latenight'] = $this->language->get('text_latenight');
		$data['text_temple'] = $this->language->get('text_temple');
		$data['text_sect'] = $this->language->get('text_sect');
		$data['text_vehicle'] = $this->language->get('text_vehicle');

		$data['text_check'] = $this->language->get('text_check');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_customer_group'] = $this->language->get('text_customer_group');
		$data['text_protocol'] = $this->language->get('text_protocol');
		$data['text_project'] = $this->language->get('text_project');
		
		$data['text_error_log'] = $this->language->get('text_error_log');
		$data['text_extension'] = $this->language->get('text_extension');
		
		$data['text_master'] = $this->language->get('text_master');
		
		$data['text_server'] = $this->language->get('text_server');
		$data['text_system'] = $this->language->get('text_system');

		$data['text_tools'] = $this->language->get('text_tools');

		$data['text_user'] = $this->language->get('text_user');
		$data['text_user_group'] = $this->language->get('text_user_group');
		$data['text_users'] = $this->language->get('text_users');
		$data['text_tax'] = $this->language->get('text_tax');

		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		$data['sales'] = $this->url->link('sale/sales&filter_status=0', 'token=' . $this->session->data['token'], 'SSL');
		$data['list'] = $this->url->link('sale/sales&filter_status=1', 'token=' . $this->session->data['token'], 'SSL');
        
		$data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');

		$data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
		$data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
		$data['transport'] = $this->url->link('catalog/transport', 'token=' . $this->session->data['token'], 'SSL');
		$data['latenight'] = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'], 'SSL');
		$data['temple'] = $this->url->link('catalog/temple', 'token=' . $this->session->data['token'], 'SSL');
		$data['sect'] = $this->url->link('catalog/sect', 'token=' . $this->session->data['token'], 'SSL');
		$data['vehicle'] = $this->url->link('catalog/vehicle', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['check'] = $this->url->link('sale/check', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['customer'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
		$data['customer_group'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL');
		$data['protocol'] = $this->url->link('sale/protocol', 'token=' . $this->session->data['token'], 'SSL');
		$data['project'] = $this->url->link('sale/project', 'token=' . $this->session->data['token'], 'SSL');

		$data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');

		$data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
		$data['server'] = $this->url->link('setting/server', 'token=' . $this->session->data['token'], 'SSL');

		$data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
		$data['tax'] = $this->url->link('localisation/tax', 'token=' . $this->session->data['token'], 'SSL');

		$data['zone'] = $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], 'SSL');

		return $this->load->view('common/menu.tpl', $data);
	}
}