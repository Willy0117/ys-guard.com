<?php
class ControllerSettingServer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('config', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('setting/server', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['text_tax'] = $this->language->get('text_tax');

		$data['text_mail'] = $this->language->get('text_mail');
		$data['text_smtp'] = $this->language->get('text_smtp');

		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_admin_language'] = $this->language->get('entry_admin_language');

		$data['entry_product_limit'] = $this->language->get('entry_product_limit');
		$data['entry_product_description_length'] = $this->language->get('entry_product_description_length');
		$data['entry_limit_admin'] = $this->language->get('entry_limit_admin');
		$data['entry_product_count'] = $this->language->get('entry_product_count');

		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['entry_tax_default'] = $this->language->get('entry_tax_default');
		$data['entry_tax_customer'] = $this->language->get('entry_tax_customer');

		$data['entry_logo'] = $this->language->get('entry_logo');
		$data['entry_icon'] = $this->language->get('entry_icon');

		$data['entry_image_thumb'] = $this->language->get('entry_image_thumb');

		$data['entry_image_product'] = $this->language->get('entry_image_product');

		$data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$data['entry_smtp_hostname'] = $this->language->get('entry_smtp_hostname');
		$data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$data['entry_mail_alert'] = $this->language->get('entry_mail_alert');

		$data['entry_secure'] = $this->language->get('entry_secure');
		$data['entry_shared'] = $this->language->get('entry_shared');
		$data['entry_file_max_size'] = $this->language->get('entry_file_max_size');
		$data['entry_file_ext_allowed'] = $this->language->get('entry_file_ext_allowed');
		$data['entry_file_mime_allowed'] = $this->language->get('entry_file_mime_allowed');

		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_encryption'] = $this->language->get('entry_encryption');

		$data['entry_compression'] = $this->language->get('entry_compression');
		$data['entry_error_display'] = $this->language->get('entry_error_display');
		$data['entry_error_log'] = $this->language->get('entry_error_log');
		$data['entry_error_filename'] = $this->language->get('entry_error_filename');
		$data['entry_width'] = $this->language->get('entry_Width');
		$data['entry_height'] = $this->language->get('entry_Height');

		$data['help_geocode'] = $this->language->get('help_geocode');
		$data['help_location'] = $this->language->get('help_location');

		$data['help_product_limit'] = $this->language->get('help_product_limit');
		$data['help_product_description_length'] = $this->language->get('help_product_description_length');
		$data['help_limit_admin'] = $this->language->get('help_limit_admin');
		$data['help_product_count'] = $this->language->get('help_product_count');

		$data['help_tax_default'] = $this->language->get('help_tax_default');
		$data['help_tax_customer'] = $this->language->get('help_tax_customer');
		$data['help_customer_online'] = $this->language->get('help_customer_online');
		$data['help_customer_group'] = $this->language->get('help_customer_group');
		$data['help_customer_group_display'] = $this->language->get('help_customer_group_display');
		$data['help_customer_price'] = $this->language->get('help_customer_price');
		$data['help_account'] = $this->language->get('help_account');
		$data['help_account_mail'] = $this->language->get('help_account_mail');

		$data['help_icon'] = $this->language->get('help_icon');

		$data['help_mail_protocol'] = $this->language->get('help_mail_protocol');
		$data['help_mail_parameter'] = $this->language->get('help_mail_parameter');
		$data['help_mail_smtp_hostname'] = $this->language->get('help_mail_smtp_hostname');
		$data['help_mail_alert'] = $this->language->get('help_mail_alert');

		$data['help_secure'] = $this->language->get('help_secure');
		$data['help_shared'] = $this->language->get('help_shared');
		$data['help_robots'] = $this->language->get('help_robots');
		$data['help_seo_url'] = $this->language->get('help_seo_url');
		$data['help_file_max_size'] = $this->language->get('help_file_max_size');
		$data['help_file_ext_allowed'] = $this->language->get('help_file_ext_allowed');
		$data['help_file_mime_allowed'] = $this->language->get('help_file_mime_allowed');
		$data['help_maintenance'] = $this->language->get('help_maintenance');
		$data['help_password'] = $this->language->get('help_password');
		$data['help_encryption'] = $this->language->get('help_encryption');
		$data['help_compression'] = $this->language->get('help_compression');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_local'] = $this->language->get('tab_local');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_mail'] = $this->language->get('tab_mail');
		$data['tab_server'] = $this->language->get('tab_server');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['image_thumb'])) {
			$data['error_image_thumb'] = $this->error['image_thumb'];
		} else {
			$data['error_image_thumb'] = '';
		}

		if (isset($this->error['image_product'])) {
			$data['error_image_product'] = $this->error['image_product'];
		} else {
			$data['error_image_product'] = '';
		}

		if (isset($this->error['error_filename'])) {
			$data['error_error_filename'] = $this->error['error_filename'];
		} else {
			$data['error_error_filename'] = '';
		}

		if (isset($this->error['product_limit'])) {
			$data['error_product_limit'] = $this->error['product_limit'];
		} else {
			$data['error_product_limit'] = '';
		}

		if (isset($this->error['product_description_length'])) {
			$data['error_product_description_length'] = $this->error['product_description_length'];
		} else {
			$data['error_product_description_length'] = '';
		}

		if (isset($this->error['limit_admin'])) {
			$data['error_limit_admin'] = $this->error['limit_admin'];
		} else {
			$data['error_limit_admin'] = '';
		}

		if (isset($this->error['encryption'])) {
			$data['error_encryption'] = $this->error['encryption'];
		} else {
			$data['error_encryption'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('setting/server', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		$this->load->model('tool/image');

		if (isset($this->request->post['config_country_id'])) {
			$data['config_country_id'] = $this->request->post['config_country_id'];
		} else {
			$data['config_country_id'] = $this->config->get('config_country_id');
		}

		//$this->load->model('localisation/country');

		$data['countries'] = array();//$this->model_localisation_country->getCountries();

		if (isset($this->request->post['config_language'])) {
			$data['config_language'] = $this->request->post['config_language'];
		} else {
			$data['config_language'] = $this->config->get('config_language');
		}

		//$this->load->model('localisation/language');

		$data['languages'] = array();//$this->model_localisation_language->getLanguages();

		if (isset($this->request->post['config_admin_language'])) {
			$data['config_admin_language'] = $this->request->post['config_admin_language'];
		} else {
			$data['config_admin_language'] = $this->config->get('config_admin_language');
		}

		if (isset($this->request->post['config_limit_admin'])) {
			$data['config_limit_admin'] = $this->request->post['config_limit_admin'];
		} else {
			$data['config_limit_admin'] = $this->config->get('config_limit_admin');
		}

		if (isset($this->request->post['config_tax'])) {
			$data['config_tax'] = $this->request->post['config_tax'];
		} else {
			$data['config_tax'] = $this->config->get('config_tax');
		}

		if (isset($this->request->post['config_logo'])) {
			$data['config_logo'] = $this->request->post['config_logo'];
		} else {
			$data['config_logo'] = $this->config->get('config_logo');
		}

		if (isset($this->request->post['config_logo']) && is_file(DIR_IMAGE . $this->request->post['config_logo'])) {
			$data['logo'] = $this->model_tool_image->resize($this->request->post['config_logo'], 100, 100);
		} elseif ($this->config->get('config_logo') && is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $this->model_tool_image->resize($this->config->get('config_logo'), 100, 100);
		} else {
			$data['logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['config_image_thumb_width'])) {
			$data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
		} else {
			$data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
		}

		if (isset($this->request->post['config_image_thumb_height'])) {
			$data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
		} else {
			$data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
		}

		if (isset($this->request->post['config_image_product_width'])) {
			$data['config_image_product_width'] = $this->request->post['config_image_product_width'];
		} else {
			$data['config_image_product_width'] = $this->config->get('config_image_product_width');
		}

		if (isset($this->request->post['config_image_product_height'])) {
			$data['config_image_product_height'] = $this->request->post['config_image_product_height'];
		} else {
			$data['config_image_product_height'] = $this->config->get('config_image_product_height');
		}

		if (isset($this->request->post['config_mail'])) {
			$config_mail = $this->request->post['config_mail'];

			$data['config_mail_protocol'] = $config_mail['protocol'];
			$data['config_mail_parameter'] = $config_mail['parameter'];
			$data['config_smtp_hostname'] = $config_mail['smtp_hostname'];
			$data['config_smtp_username'] = $config_mail['smtp_username'];
			$data['config_smtp_password'] = $config_mail['smtp_password'];
			$data['config_smtp_port'] = $config_mail['smtp_port'];
			$data['config_smtp_timeout'] = $config_mail['smtp_timeout'];
		} elseif ($this->config->get('config_mail')) {
			$config_mail = $this->config->get('config_mail');

			$data['config_mail_protocol'] = $config_mail['protocol'];
			$data['config_mail_parameter'] = $config_mail['parameter'];
			$data['config_smtp_hostname'] = $config_mail['smtp_hostname'];
			$data['config_smtp_username'] = $config_mail['smtp_username'];
			$data['config_smtp_password'] = $config_mail['smtp_password'];
			$data['config_smtp_port'] = $config_mail['smtp_port'];
			$data['config_smtp_timeout'] = $config_mail['smtp_timeout'];
		} else {
			$data['config_mail_protocol'] = '';
			$data['config_mail_parameter'] = '';
			$data['config_smtp_hostname'] = '';
			$data['config_smtp_username'] = '';
			$data['config_smtp_password'] = '';
			$data['config_smtp_port'] = 25;
			$data['config_smtp_timeout'] = 5;
		}

		if (isset($this->request->post['config_secure'])) {
			$data['config_secure'] = $this->request->post['config_secure'];
		} else {
			$data['config_secure'] = $this->config->get('config_secure');
		}

		if (isset($this->request->post['config_file_max_size'])) {
			$data['config_file_max_size'] = $this->request->post['config_file_max_size'];
		} elseif ($this->config->get('config_file_max_size')) {
			$data['config_file_max_size'] = $this->config->get('config_file_max_size');
		} else {
			$data['config_file_max_size'] = 300000;
		}

		if (isset($this->request->post['config_file_ext_allowed'])) {
			$data['config_file_ext_allowed'] = $this->request->post['config_file_ext_allowed'];
		} else {
			$data['config_file_ext_allowed'] = $this->config->get('config_file_ext_allowed');
		}

		if (isset($this->request->post['config_file_mime_allowed'])) {
			$data['config_file_mime_allowed'] = $this->request->post['config_file_mime_allowed'];
		} else {
			$data['config_file_mime_allowed'] = $this->config->get('config_file_mime_allowed');
		}

		if (isset($this->request->post['config_password'])) {
			$data['config_password'] = $this->request->post['config_password'];
		} else {
			$data['config_password'] = $this->config->get('config_password');
		}

		if (isset($this->request->post['config_encryption'])) {
			$data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$data['config_encryption'] = $this->config->get('config_encryption');
		}

		if (isset($this->request->post['config_compression'])) {
			$data['config_compression'] = $this->request->post['config_compression'];
		} else {
			$data['config_compression'] = $this->config->get('config_compression');
		}

		if (isset($this->request->post['config_error_display'])) {
			$data['config_error_display'] = $this->request->post['config_error_display'];
		} else {
			$data['config_error_display'] = $this->config->get('config_error_display');
		}

		if (isset($this->request->post['config_error_log'])) {
			$data['config_error_log'] = $this->request->post['config_error_log'];
		} else {
			$data['config_error_log'] = $this->config->get('config_error_log');
		}

		if (isset($this->request->post['config_error_filename'])) {
			$data['config_error_filename'] = $this->request->post['config_error_filename'];
		} else {
			$data['config_error_filename'] = $this->config->get('config_error_filename');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/server.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'setting/server')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['config_image_thumb_width'] || !$this->request->post['config_image_thumb_height']) {
			$this->error['image_thumb'] = $this->language->get('error_image_thumb');
		}

		if (!$this->request->post['config_image_product_width'] || !$this->request->post['config_image_product_height']) {
			$this->error['image_product'] = $this->language->get('error_image_product');
		}

		if (!$this->request->post['config_error_filename']) {
			$this->error['error_error_filename'] = $this->language->get('error_error_filename');
		}

		if (!$this->request->post['config_limit_admin']) {
			$this->error['limit_admin'] = $this->language->get('error_limit');
		}

		if ((utf8_strlen($this->request->post['config_encryption']) < 3) || (utf8_strlen($this->request->post['config_encryption']) > 32)) {
			$this->error['encryption'] = $this->language->get('error_encryption');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function country() {
		$json = array();

		//$this->load->model('localisation/country');

		$country_info = array();//$this->model_localisation_country->getCountry($this->request->get['country_id']);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}