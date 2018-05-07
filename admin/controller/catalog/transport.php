<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

class ControllerCatalogTransport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/transport');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/transport');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/transport');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/transport');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_transport->addTransport($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/transport');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/transport');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_transport->editTransport($this->request->get['id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/transport');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/transport');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_catalog_transport->deleteTransport($id);
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

			$this->response->redirect($this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'distance';
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

		$data['insert'] = $this->url->link('catalog/transport/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/transport/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['transports'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$transport_total = $this->model_catalog_transport->getTotalTransports();

		$results = $this->model_catalog_transport->getTransports($filter_data);
		

		foreach ($results as $result) {
			$data['transports'][] = array(
				'id'    => $result['id'],
				'distance'         => $result['distance'],
				'price'            => $result['price'],
				'invoice'          => $result['invoice'],
				'date_from'             => $result['date_from'],
				'date_to'               => $result['date_to'],
				'status'		   => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'             => $this->url->link('catalog/transport/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_distance'] = $this->language->get('column_distance');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_invoice'] = $this->language->get('column_invoice');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_date_from'] = $this->language->get('column_date_from');
		$data['column_date_to'] = $this->language->get('column_date_to');

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

		$data['sort_distance'] = $this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . '&sort=distance' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . '&sort=price' . $url, 'SSL');
		$data['sort_invoice'] = $this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . '&sort=invoice' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $transport_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transport_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transport_total - $this->config->get('config_limit_admin'))) ? $transport_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transport_total, ceil($transport_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/transport_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_distance'] = $this->language->get('entry_distance');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_invoice'] = $this->language->get('entry_invoice');
		$data['entry_sort_price'] = $this->language->get('entry_sort_price');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_from'] = $this->language->get('entry_date_from');
		$data['entry_date_to'] = $this->language->get('entry_date_to');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['distance'])) {
			$data['error_distance'] = $this->error['distance'];
		} else {
			$data['error_distance'] = array();
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
			$data['action'] = $this->url->link('catalog/transport/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/transport/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/transport', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$transport_info = $this->model_catalog_transport->gettransport($this->request->get['id']);
		}

		if (isset($this->request->post['distance'])) {
			$data['distance'] = $this->request->post['distance'];
		} elseif (!empty($transport_info)) {
			$data['distance'] = $transport_info['distance'];
		} else {
			$data['distance'] = '';
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($transport_info)) {
			$data['price'] = $transport_info['price'];
		} else {
			$data['price'] = '';
		}

		if (isset($this->request->post['invoice'])) {
			$data['invoice'] = $this->request->post['invoice'];
		} elseif (!empty($transport_info)) {
			$data['invoice'] = $transport_info['invoice'];
		} else {
			$data['invoice'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($transport_info)) {
			$data['status'] = $transport_info['status'];
		} else {
			$data['status'] = '';
		}

        if (isset($this->request->post['date_from'])) {
			$data['date_from'] = $this->request->post['date_from'];
		} elseif (!empty($transport_info)) {
			$data['date_from'] = $transport_info['date_from'];
		} else {
			$data['date_from'] = '0000-01-01';
		}

        if (isset($this->request->post['date_to'])) {
			$data['date_to'] = $this->request->post['date_to'];
		} elseif (!empty($transport_info)) {
			$data['date_to'] = $transport_info['date_to'];
		} else {
			$data['date_to'] = '9999-12-31';
		}
        
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/transport_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/transport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['distance'] < 10)  {
			$this->error['distance'] = $this->language->get('error_distance');
		}
		if (!isset($this->error['distance'])) {
			$distance = $this->request->post['distance']; 
			if ($distance >=10 && $distance <= 250) {
				if ($distance%10 == 0) {
				} else {
					$this->error['distance'] = $this->language->get('error_not_distance');
			    }
			} else if ($distance >= 280 && $distance <=550 ) {
				if (($distance-10)%30 == 0) {
				} else {
					$this->error['distance'] = $this->language->get('error_not_distance');
			    }
			
			} else if ($distance >=600 && $distance <=1100) {
				if ($distance%50 == 0) {
				} else {
					$this->error['distance'] = $this->language->get('error_not_distance');
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/transport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function getPrice() {
		$json = array();

		$this->load->model('catalog/transport');

		if (isset($this->request->get['distance']) && isset($this->request->get['travel']) ) {
			$distance = $this->request->get['distance'];
			$travel = $this->request->get['travel'];
			$json = $this->model_catalog_transport->getMileage($distance,$travel);
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
