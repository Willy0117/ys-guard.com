<?php
class ControllerCatalogLatenight extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/latenight');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/latenight');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/latenight');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/latenight');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_latenight->addLatenight($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/latenight');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/latenight');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_latenight->editLatenight($this->request->get['latenight_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/latenight');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/latenight');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $latenight_id) {
				$this->model_catalog_latenight->deleteLatenight($latenight_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'timeindex';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['insert'] = $this->url->link('catalog/latenight/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/latenight/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['latenights'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('localisation/tax');
		
		$data['taxes'] = $this->model_localisation_tax->getTaxes('0');
		
		$latenight_total = $this->model_catalog_latenight->getTotallatenights();

		$results = $this->model_catalog_latenight->getlatenights($filter_data);

		foreach ($results as $result) {
			$tax = '';
			foreach($data['taxes'] as $value) {
				if ($value['id'] == $result['tax_id'] ) $tax=$value['title'];
			}
			$data['latenights'][] = array(
				'id'    => $result['id'],
				'timeindex'  => $result['timeindex'],
				'price'      => $result['price'],
				'invoice'	=> $result['invoice'],
				'tax' => $tax,
				'edit'            => $this->url->link('catalog/latenight/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_timeindex'] = $this->language->get('column_timeindex');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_invoice'] = $this->language->get('column_invoice');
		$data['column_tax'] = $this->language->get('column_tax');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_timeindex'] = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . '&sort=timeindex' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . '&sort=price' . $url, 'SSL');
		$data['sort_invoice'] = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . '&sort=invoice' . $url, 'SSL');
		$data['sort_tax'] = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . '&sort=tax' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $latenight_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($latenight_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($latenight_total - $this->config->get('config_limit_admin'))) ? $latenight_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $latenight_total, ceil($latenight_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/latenight_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['latenight_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_timeindex'] = $this->language->get('entry_timeindex');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_invoice'] = $this->language->get('entry_invoice');
		$data['entry_tax'] = $this->language->get('entry_tax');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['timeindex'])) {
			$data['error_timeindex'] = $this->error['timeindex'];
		} else {
			$data['error_timeindex'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('catalog/latenight/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/latenight/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/latenight', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$latenight_info = $this->model_catalog_latenight->getlatenight($this->request->get['id']);
		}

		if (isset($this->request->post['timeindex'])) {
			$data['timeindex'] = $this->request->post['timeindex'];
		} elseif (!empty($latenight_info)) {
			$data['timeindex'] = $latenight_info['timeindex'];
		} else {
			$data['timeindex'] = '';
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($latenight_info)) {
			$data['price'] = $latenight_info['price'];
		} else {
			$data['price'] = '';
		}

		if (isset($this->request->post['invoice'])) {
			$data['invoice'] = $this->request->post['invoice'];
		} elseif (!empty($latenight_info)) {
			$data['invoice'] = $latenight_info['invoice'];
		} else {
			$data['invoice'] = '';
		}

		$this->load->model('localisation/tax');
		
		$data['taxes'] = $this->model_localisation_tax->getTaxes('0');
		
		if (isset($this->request->post['tax_id'])) {
			$data['tax_id'] = $this->request->post['tax_id'];
		} elseif (!empty($latenight_info)) {
			$data['tax_id'] = $latenight_info['tax_id'];
		} else {
			$data['tax_id'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/latenight_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/latenight')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['timeindex'] <30 || $this->request->post['timeindex'] > 420) {
				$this->error['timeindex'] = $this->language->get('error_timeindex');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/latenight')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
			
	public function getLateNightPrice() {
		$json = array();

		$this->load->model('catalog/latenight');

		if (isset($this->request->get['minute']) )  {
			$minute = $this->request->get['minute'];
			$json = $this->model_catalog_latenight->getLatenightByPrice($minute);
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}