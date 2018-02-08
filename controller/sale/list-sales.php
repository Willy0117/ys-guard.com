<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

class ControllerSaleSales extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		$this->getList();
	}
    // 追加
	public function add() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_sales->addsales($this->request->post);

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

			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getForm();
	}
	/*
	// 運行管理表出力
	*/
	public function excel() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_sale_sales->excel($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}		

			if (isset($this->request->get['filter_deceased'])) {
				$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group'])) {
				$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
			}

			if (isset($this->request->get['filter_travel'])) {
				$url .= '&filter_travel=' . $this->request->get['filter_travel'];
			}

			if (isset($this->request->get['filter_recorded'])) {
				$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getForm();
	}
	/*
	// 指図書印刷->pdf
	*/
	public function print() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_sale_sales->print($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}		

			if (isset($this->request->get['filter_deceased'])) {
				$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group'])) {
				$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
			}

			if (isset($this->request->get['filter_travel'])) {
				$url .= '&filter_travel=' . $this->request->get['filter_travel'];
			}

			if (isset($this->request->get['filter_recorded'])) {
				$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getForm();
	}
	/*
	編集
	*/
	public function edit() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_sales->editSale($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}		

			if (isset($this->request->get['filter_deceased'])) {
				$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group'])) {
				$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
			}

			if (isset($this->request->get['filter_travel'])) {
				$url .= '&filter_travel=' . $this->request->get['filter_travel'];
			}

			if (isset($this->request->get['filter_recorded'])) {
				$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getForm();
	}
	/*
	// 経済連送信データ作成
	*/
	public function send() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			$this->model_sale_sales->send($this->request->post['selected']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
	
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_deceased'])) {
				$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group'])) {
				$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
			}

			if (isset($this->request->get['filter_travel'])) {
				$url .= '&filter_travel=' . $this->request->get['filter_travel'];
			}

			if (isset($this->request->get['filter_recorded'])) {
				$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getList();
	}
	/*
	// 指図書印刷
	*/
	public function pdf() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			$this->model_sale_sales->pdf($this->request->post['selected']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_deceased'])) {
				$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group'])) {
				$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
			}

			if (isset($this->request->get['filter_travel'])) {
				$url .= '&filter_travel=' . $this->request->get['filter_travel'];
			}

			if (isset($this->request->get['filter_recorded'])) {
				$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getList();
	}	
	/*
	
	*/
	public function delete() {
		$token = $this->session->data['token'];
		
		$this->load->language('sale/sales');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/sales');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $sales_id) {
				$this->model_sale_sales->deletesales($sales_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_deceased'])) {
				$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_address'])) {
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group'])) {
				$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
			}

			if (isset($this->request->get['filter_travel'])) {
				$url .= '&filter_travel=' . $this->request->get['filter_travel'];
			}

			if (isset($this->request->get['filter_recorded'])) {
				$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/sales', 'token=' . $token . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$token = $this->session->data['token'];

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
		if (isset($this->request->get['filter_deceased'])) {
			$filter_deceased = $this->request->get['filter_deceased'];
		} else {
			$filter_deceased = null;
		}
				
		if (isset($this->request->get['filter_address'])) {
			$filter_address = $this->request->get['filter_address'];
		} else {
			$filter_address = null;
		}
		
		if (isset($this->request->get['filter_customer_group'])) {
			$filter_customer_group = $this->request->get['filter_customer_group'];
		} else {
			$filter_customer_group = null;
		}
		
		if (isset($this->request->get['filter_travel'])) {
			$filter_travel = $this->request->get['filter_travel'];
		} else {
			$filter_travel = '';
		}		
		
		if (isset($this->request->get['filter_recorded'])) {
			$filter_recorded = $this->request->get['filter_recorded'];
		} else {
			$filter_recorded = '';
		}	

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_deceased'])) {
			$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group'])) {
			$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
		}

		if (isset($this->request->get['filter_travel'])) {
			$url .= '&filter_travel=' . $this->request->get['filter_travel'];
		}

		if (isset($this->request->get['filter_recorded'])) {
			$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['insert'] = $this->url->link('sale/sales/add', 'token=' . $token . $url, 'SSL');
		$data['copy'] = $this->url->link('sale/sales/copy', 'token=' . $token . $url, 'SSL');
		$data['send'] = $this->url->link('sale/sales/send', 'token=' . $token . $url, 'SSL');
		$data['pdf'] = $this->url->link('sale/sales/pdf', 'token=' . $token . $url, 'SSL');
		$data['delete'] = $this->url->link('sale/sales/delete', 'token=' . $token . $url, 'SSL');

		$data['sales'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_deceased'          => $filter_deceased,
			'filter_customer_group' => $filter_customer_group,
			'filter_address' 		   => $filter_address,
			'filter_travel'       	   => $filter_travel,
			'filter_recorded'          => $filter_recorded,
			'filter_status'       	   => $filter_status,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		$sales_total = $this->model_sale_sales->getTotalSales($filter_data);

		$results = $this->model_sale_sales->getSales($filter_data);

		foreach ($results as $result) {
			$cg = '';
			foreach($data['customer_groups'] as $value) {
				if ($value['id'] == $result['customer_group'] ) $cg=$value['name'];
			}
			
			$data['sales'][] = array(
				'recorded'     => date($this->language->get('date_format_short'), strtotime($result['recorded'])),
				'travel'     => date($this->language->get('date_format_short'), strtotime($result['travel'])),
				'slip'          => $result['slip'],		//　伝票No.
				'name'          => $result['name'],		//　喪主名
				'deceased'		=> $result['deceased'],		// 故人名
				'address'		=> $result['address'],		// 住所
				'customer_group'=> $cg,
				'id'           => $result['id'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'print'         => $result['print'],			
				'edit'           => $this->url->link('sale/sales/edit',  'token=' . $token . '&id=' . $result['id'] . $url , 'SSL'),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_login'] = $this->language->get('text_login');

		$data['column_slip'] = $this->language->get('column_slip');
		$data['column_recorded'] = $this->language->get('column_recorded');
		$data['column_travel'] = $this->language->get('column_travel');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_deceased'] = $this->language->get('column_deceased');
		$data['column_customer_group'] = $this->language->get('column_customer_group');
		$data['column_address'] = $this->language->get('column_address');
		$data['column_print'] = $this->language->get('column_print');
		$data['column_status'] = $this->language->get('column_status');
		
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');			// 喪家名
		$data['entry_deceased'] = $this->language->get('entry_deceased');			// 喪家名
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_travel'] = $this->language->get('entry_travel');
		$data['entry_recorded'] = $this->language->get('entry_recorded');
		$data['entry_address'] = $this->language->get('entry_address');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_transmission'] = $this->language->get('button_transmission');
		$data['button_print'] = $this->language->get('button_print');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['button_copy'] = $this->language->get('button_copy');

		$data['token'] = $token;

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

		if (isset($this->request->get['filter_deceased'])) {
			$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group'])) {
			$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
		}

		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_travel'])) {
			$url .= '&filter_travel=' . $this->request->get['filter_travel'];
		}

		if (isset($this->request->get['filter_recorded'])) {
			$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_slip'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=slip' . $url, 'SSL');

		$data['sort_status'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=status' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=name' . $url, 'SSL');
		$data['sort_deceased'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=deceased' . $url, 'SSL');
		$data['sort_customer_group'] = $this->url->link('sale/sales','token=' . $token . '&sort=customer_group' . $url, 'SSL');
		$data['sort_customer'] = $this->url->link('sale/sales','token=' . $token . '&sort=customer' . $url, 'SSL');
		$data['sort_travel'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=travel' . $url, 'SSL');
		$data['sort_recorded'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=recorded' . $url, 'SSL');
		$data['sort_address'] = $this->url->link('sale/sales', 'token=' . $token . '&sort=address' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_deceased'])) {
			$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group'])) {
			$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
		}
	
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_travel'])) {
			$url .= '&filter_travel=' . $this->request->get['filter_travel'];
		}
		
		if (isset($this->request->get['filter_recorded'])) {
			$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $sales_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/sales', 'token=' . $token . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($sales_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sales_total - $this->config->get('config_limit_admin'))) ? $sales_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sales_total, ceil($sales_total / $this->config->get('config_limit_admin')));

		$data['filter_deceased'] = $filter_deceased;
		$data['filter_name'] = $filter_name;
		$data['filter_address'] = $filter_address;
		$data['filter_customer_group'] = $filter_customer_group;
		$data['filter_travel'] = $filter_travel;
		$data['filter_recorded'] = $filter_recorded;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/sales_list.tpl', $data));
	}

	protected function getForm() {
		$token = $this->session->data['token'];
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_sales'] = $this->language->get('tab_sales');
		$data['tab_inspection'] = $this->language->get('tab_inspection');

		$data['text_form'] = !isset($this->request->get['sales_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');

		$data['entry_purpose'] = $this->language->get('entry_purpose');
		$data['entry_recorded'] = $this->language->get('entry_recorded');
		$data['entry_project'] = $this->language->get('entry_project');
		
		$data['entry_travel'] = $this->language->get('entry_travel');	// 運行日
		$data['entry_weekday'] = $this->language->get('entry_weekday');	// 曜日
		$data['entry_weather'] = $this->language->get('entry_weather');	// 天候
		
		$data['entry_driver'] = $this->language->get('entry_driver');	// 担当者
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');

		$data['entry_name'] = $this->language->get('entry_name');			// 喪家名
		$data['entry_deceased'] = $this->language->get('entry_deceased');	// 故人名
		$data['entry_telphone'] = $this->language->get('entry_telphone');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_sect'] = $this->language->get('entry_sect');
		$data['entry_temple'] = $this->language->get('entry_temple');
		
		$data['entry_vehicle'] = $this->language->get('entry_vehicle');
		$data['entry_highway'] = $this->language->get('entry_highway');
		
		$data['entry_place']= $this->language->get('entry_place');
		$data['entry_metar']= $this->language->get('entry_metar');
		$data['entry_start']= $this->language->get('entry_start');
		$data['entry_end']	= $this->language->get('entry_end');
		$data['entry_time']	= $this->language->get('entry_time');
		$data['entry_distance'] = $this->language->get('entry_distance');
		$data['entry_mileage'] = $this->language->get('entry_mileage');

		$data['entry_default'] = $this->language->get('entry_default');
		$data['entry_comment'] = $this->language->get('entry_comment');

		$data['entry_sales'] = $this->language->get('entry_sales');
		$data['entry_travel'] = $this->language->get('entry_travel');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_quantity']		 = $this->language->get('entry_quantity');
		$data['entry_tax']		 = $this->language->get('entry_tax');
		$data['entry_price']		 = $this->language->get('entry_price');
		$data['entry_amount']		 = $this->language->get('entry_amount');
		$data['entry_summary']		 = $this->language->get('entry_summary');
		$data['entry_inspection'] = $this->language->get('entry_inspection');
		/* */
		$data['entry_health'] = $this->language->get('entry_health');
		$data['entry_appearance'] = $this->language->get('entry_appearance');
		$data['entry_license'] = $this->language->get('entry_license');
		$data['entry_fuel'] = $this->language->get('entry_fuel');
		$data['entry_condition'] = $this->language->get('entry_condition');
		$data['entry_oil'] = $this->language->get('entry_oil');
		$data['entry_tire'] = $this->language->get('entry_tire');
		$data['entry_light'] = $this->language->get('entry_light');
		$data['entry_drinking']  = $this->language->get('entry_drinking');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_excel'] = $this->language->get('button_excel');
		$data['button_print'] = $this->language->get('button_print');

		$data['token'] = $token;

		if (isset($this->request->get['id'])) {
			$data['id'] = $this->request->get['id'];
		} else {
			$data['id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['purpose'])) {
			$data['error_purpose'] = $this->error['purpose'];
		} else {
			$data['error_purpose'] = '';
		}

		if (isset($this->error['recorded'])) {
			$data['error_recorded'] = $this->error['recorded'];
		} else {
			$data['error_recorded'] = '';
		}	
		
		if (isset($this->error['travel'])) {
			$data['error_travel'] = $this->error['travel'];
		} else {
			$data['error_travel'] = '';
		}

		if (isset($this->error['weather'])) {
			$data['error_weather'] = $this->error['weather'];
		} else {
			$data['error_weather'] = '';
		}
		
		if (isset($this->error['customer'])) {
			$data['error_customer'] = $this->error['customer'];
		} else {
			$data['error_customer'] = '';
		}

		if (isset($this->error['customer_group'])) {
			$data['error_customer_group'] = $this->error['customer_group'];
		} else {
			$data['error_customer_group'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['deceased'])) {
			$data['error_deceased'] = $this->error['deceased'];
		} else {
			$data['error_deceased'] = '';
		}

		if (isset($this->error['telhone'])) {
			$data['error_telphone'] = $this->error['telphone'];
		} else {
			$data['error_telphone'] = '';
		}

		if (isset($this->error['sect'])) {
			$data['error_sect'] = $this->error['sect'];
		} else {
			$data['error_sect'] = '';
		}
		
		if (isset($this->error['temple'])) {
			$data['error_temple'] = $this->error['temple'];
		} else {
			$data['error_temple'] = '';
		}
		
		if (isset($this->error['driver'])) {
			$data['error_driver'] = $this->error['driver'];
		} else {
			$data['error_driver'] = '';
		}
		
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_deceased'])) {
			$url .= '&filter_deceased=' . urlencode(html_entity_decode($this->request->get['filter_deceased'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group'])) {
			$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
		}

		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_travel'])) {
			$url .= '&filter_travel=' . $this->request->get['filter_travel'];
		}

		if (isset($this->request->get['filter_recorded'])) {
			$url .= '&filter_recorded=' . $this->request->get['filter_recorded'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

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
			$data['action'] = $this->url->link('sale/sales/add', 'token=' . $token . $url, 'SSL');
			$data['excel'] = $this->url->link('sale/sales/excel', 'token=' . $token . $url , 'SSL');
			$data['print'] = $this->url->link('sale/sales/print', 'token=' . $token . $url , 'SSL');
		} else {
			$data['action'] = $this->url->link('sale/sales/edit', 'token=' . $token . '&id=' . $this->request->get['id'] . $url, 'SSL');
			$data['excel'] = $this->url->link('sale/sales/excel', 'token=' . $token . '&id=' . $this->request->get['id'] . $url , 'SSL');
			$data['print'] = $this->url->link('sale/sales/print', 'token=' . $token . '&id=' . $this->request->get['id'] . $url , 'SSL');
		}

		$data['cancel'] = $this->url->link('sale/sales', 'token=' . $token . $url , 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$sales_info = $this->model_sale_sales->getSale($this->request->get['id']);
			$sales_mileage = $this->model_sale_sales->getMileage($this->request->get['id']);
			$sales_detail = $this->model_sale_sales->getDetail($this->request->get['id']);
			
		}
	
		$this->load->model('user/user');

		$data['users'] = $this->model_user_user->getUsers();

		if (isset($this->request->post['sect'])) {
			$data['sect'] = $this->request->post['sect'];
		} elseif (!empty($sales_info)) {
			$data['sect'] = $sales_info['sect'];
		} else {
			$data['sect'] = 0;
		}
		
		$this->load->model('catalog/sect');

		$data['sects'] = $this->model_catalog_sect->getSects();

		if (isset($this->request->post['sect'])) {
			$data['sect'] = $this->request->post['sect'];
		} elseif (!empty($sales_info)) {
			$data['sect'] = $sales_info['sect'];
		} else {
			$data['sect'] = 0;
		}
		
		$this->load->model('catalog/temple');

		$data['temples'] = $this->model_catalog_temple->getTemples();

		if (isset($this->request->post['temple'])) {
			$data['temple'] = $this->request->post['temple'];
		} elseif (!empty($sales_info)) {
			$data['temple'] = $sales_info['temple'];
		} else {
			$data['temple'] = 0;
		}
		// 計上日
		if (isset($this->request->post['recorded'])) {
			$data['recorded'] = $this->request->post['recorded'];
		} elseif (!empty($sales_info)) {
			$data['recorded'] = $sales_info['recorded'];
		} else {
			$data['recorded'] = date('Y-m-d');
		}
		// 運航日
		if (isset($this->request->post['travel'])) {
			$data['travel'] = $this->request->post['travel'];
		} elseif (!empty($sales_info)) {
			$data['travel'] = $sales_info['travel'];
		} else {
			$data['travel'] = date('Y-m-d');
		}

		$this->load->model('catalog/product');

		$data['purposes'] = $this->model_catalog_product->getProductsByCategoryId(6); 
		
		if (isset($this->request->post['purpose'])) {
			$data['purpose'] = $this->request->post['purpose'];
		} elseif (!empty($sales_info)) {
			$data['purpose'] = $sales_info['purpose'];
		} else {
			$data['purpose'] = $data['purposes'][0]['id'];
		}
	
		$data['weekdays'] = array("日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日");
		
		if (isset($this->request->post['weekday'])) {
			$data['weekday'] = $this->request->post['weekday'];
		} elseif (!empty($sales_info)) {
			$data['weekday'] = $sales_info['weekday'];
		} else {
			$data['weekday'] = '';
		}

		if (isset($this->request->post['weather'])) {
			$data['weather'] = $this->request->post['weather'];
		} elseif (!empty($sales_info)) {
			$data['weather'] = $sales_info['weather'];
		} else {
			$data['weather'] = '';
		}
		
		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['customer_group'])) {
			$data['customer_group'] = $this->request->post['customer_group'];
		} elseif (!empty($sales_info)) {
			$data['customer_group'] = $sales_info['customer_group'];
		} else {
			$data['customer_group'] = 0;
		}

		if (isset($this->request->post['customer'])) {
			$data['customer'] = $this->request->post['customer'];
		} elseif (!empty($sales_info)) {
			$data['customer'] = $sales_info['author_id'];
		} else {
			$data['customer'] = '';
		}
		/* 喪主名 */
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($sales_info)) {
			$data['name'] = $sales_info['name'];
		} else {
			$data['name'] = '';
		}
		/* 故人名 */
		if (isset($this->request->post['deceased'])) {
			$data['deceased'] = $this->request->post['deceased'];
		} elseif (!empty($sales_info)) {
			$data['deceased'] = $sales_info['deceased'];
		} else {
			$data['deceased'] = '';
		}

		if (isset($this->request->post['telphone'])) {
			$data['telphone'] = $this->request->post['telphone'];
		} elseif (!empty($sales_info)) {
			$data['telphone'] = $sales_info['telphone'];
		} else {
			$data['telphone'] = '';
		}

		if (isset($this->request->post['driver'])) {
			$data['driver'] = $this->request->post['driver'];
		} elseif (!empty($sales_info)) {
			$data['driver'] = $sales_info['driver_id'];
		} else {
			$data['driver'] = '';
		}

		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($sales_info)) {
			$data['address'] = $sales_info['address'];
		} else {
			$data['address'] = '';
		}		

		$this->load->model('catalog/vehicle');
		$data['vehicles'] = $this->model_catalog_vehicle->getVehicles();
		
		/* 使用車両 */
		if (isset($this->request->post['vehicle'])) {
			$data['vehicle'] = $this->request->post['vehicle'];
		} elseif (!empty($sales_info)) {
			$data['vehicle'] = $sales_info['used_vehicle'];
		} else {
			$data['vehicle'] = '';
		}
		/* 高速料金 */
		if (isset($this->request->post['highway'])) {
			$data['highway'] = $this->request->post['highway'];
		} elseif (!empty($sales_info)) {
			$data['highway'] = $sales_info['chage'];
		} else {
			$data['highway'] = 0;
		}
		/* 小計 */
		if (isset($this->request->post['total1'])) {
			$data['total1'] = $this->request->post['total1'];
		} elseif (!empty($sales_info)) {
			$data['total1'] = $sales_info['total1'];
		} else {
			$data['total1'] = 0;
		}	
		/* 税 小計 */
		if (isset($this->request->post['tax1'])) {
			$data['tax1'] = $this->request->post['tax1'];
		} elseif (!empty($sales_info)) {
			$data['tax1'] = $sales_info['tax1'];
		} else {
			$data['tax1'] = 0;
		}	
		/* 小計 */
		if (isset($this->request->post['total2'])) {
			$data['total2'] = $this->request->post['total2'];
		} elseif (!empty($sales_info)) {
			$data['total2'] = $sales_info['total2'];
		} else {
			$data['total2'] = 0;
		}	
		/* 税 小計 */
		if (isset($this->request->post['tax2'])) {
			$data['tax2'] = $this->request->post['tax2'];
		} elseif (!empty($sales_info)) {
			$data['tax2'] = $sales_info['tax2'];
		} else {
			$data['tax2'] = 0;
		}	
		/* 売り上げ情報 */
		$data['after'] = $this->model_catalog_product->getProductsByCategoryId(7); // 深夜・早朝割増
		$data['wait'] = $this->model_catalog_product->getProductsByCategoryId(8);  // 待機時間

		if (isset($this->request->post['price'])) {
			$data['prices'] = $this->request->post['price'];
		} elseif (!empty($sales_detail)) {
			//print_r((array)json_decode($sales_detail['detail'],true));
			$data['prices'] = (array)json_decode($sales_detail['detail'],true);
		} else {
			$i=0;
			while ($i < 10) {
				$data['prices'][$i] = array(
					'id'=>0,
					'name'=>'',
					'summary'=>'',
					'quantity'=>1,
					'unit_price'=>0,
					'amount'=>0,
					'tax'=>0,
					'model'=>'',
					'tax_id'=>1,
					'invoice'=>0,
				);
				$i++;
			}
			foreach($data['purposes'] as $result) {
				if ( $result['id'] == $data['purpose'] ) {	
					$data['prices'][0]['id'] = $result['id'];
					$data['prices'][0]['name'] = $result['name'];
					$data['prices'][0]['model'] = $result['model'];
					$data['prices'][0]['tax_id'] = 1; /* 消費税8%に固定する*/
				}
			}
			$data['prices'][1]['id'] = $data['after'][0]['id'];
			$data['prices'][1]['name'] = $data['after'][0]['name'];
			$data['prices'][1]['model'] = $data['after'][0]['model'];
			$data['prices'][1]['summary'] = '22時〜翌朝5時まで30分毎';
			$data['prices'][1]['tax_id'] = 1; /* 消費税8%に固定する*/

			$data['prices'][2]['id'] = $data['wait'][0]['id'];
			$data['prices'][2]['name'] = $data['wait'][0]['name'];
			$data['prices'][2]['model'] = $data['wait'][0]['model'];
			$data['prices'][2]['summary'] = '30分毎';
			$data['prices'][2]['tax_id'] = 1; /* 消費税8%に固定する*/
		}
			foreach($data['purposes'] as $result) {
				if ( $result['id'] == $data['purpose'] ) {	
					$data['prices'][0]['id'] = $result['id'];
					$data['prices'][0]['name'] = $result['name'];
					$data['prices'][0]['model'] = $result['model'];
					$data['prices'][0]['tax_id'] = 1; /* 消費税8%に固定する*/
				}
			}
		$data['prices'][1]['id'] = $data['after'][0]['id'];
		$data['prices'][1]['name'] = $data['after'][0]['name'];
		$data['prices'][1]['model'] = $data['after'][0]['model'];
		$data['prices'][1]['summary'] = '22時〜翌朝5時まで30分毎';
		$data['prices'][1]['tax_id'] = 1; /* 消費税8%に固定する*/;;

		$data['prices'][2]['id'] = $data['wait'][0]['id'];
		$data['prices'][2]['name'] = $data['wait'][0]['name'];
		$data['prices'][2]['model'] = $data['wait'][0]['model'];
		$data['prices'][2]['summary'] = '30分毎';
		$data['prices'][2]['tax_id'] = 1; /* 消費税8%に固定する*/;

		if (isset($this->request->post['mileage'])) {
			$data['mileage'] = (array)$this->request->post['mileage'];
		} elseif (!empty($sales_mileage)) {
			$data['mileage'] = (array)json_decode($sales_mileage['mileage'],true);
		} else {
			$data['mileage'][0] = array('via'=>'出庫','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'①','mileage'=>0,'wait'=>0);
			$data['mileage'][1]	= array('via'=>'','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'②','mileage'=>0,'wait'=>0);
			$data['mileage'][2]	= array('via'=>'','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>0,'mileage'=>0,'wait'=>0);
			$data['mileage'][3]	= array('via'=>'','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'③','mileage'=>0,'wait'=>0);
			$data['mileage'][4] = array('via'=>'','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'待機時間','mileage'=>0,'wait'=>0);
			$data['mileage'][5]	= array('via'=>'','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'④','mileage'=>0,'wait'=>0);
			$data['mileage'][6]	= array('via'=>'','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'所要時間','mileage'=>0,'wait'=>0);
			$data['mileage'][7]	= array('via'=>'帰庫','date'=>date('Y-m-d'),'time'=>date('H:i:'),'metar'=>'⑤','mileage'=>0,'wait'=>0);
		}			
		
		$data['inspections'] = array(
			array('key'=>'health','name'=>'健康状態','id'=>0),
			array('key'=>'appearance','name'=>'身だしなみ','id'=>1),
			array('key'=>'license','name'=>'免許証の保持','id'=>2),
			array('key'=>'drinking','name'=>'アルコールチェッカー','id'=>3),
		);

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} elseif (!empty($sales_info)) {
			$data['selected'] = (array)json_decode($sales_info['selected']);
		} else {
			$data['selected'] = array();
		}		

		/* comment */
		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (!empty($sales_info)) {
			$data['comment'] = $sales_info['comment'];
		} else {
			$data['comment'] = '';
		}
		/* memo */
		if (isset($this->request->post['memo'])) {
			$data['memo'] = $this->request->post['memo'];
		} elseif (!empty($sales_info)) {
			$data['memo'] = $sales_info['memo'];
		} else {
			$data['memo'] = '';
		}

		$this->load->model('localisation/tax');

		$results = $this->model_localisation_tax->getTaxes();
		foreach($results as $value ){
			$data['taxes'][] = array('id'=>$value['id'],'rate'=>$value['rate']);
		}	
		
		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/sales_form.tpl', $data));
	}


	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/sales')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['purpose'] == '')  {
			$this->error['purpose'] = $this->language->get('error_purpose');
		}

		if ($this->request->post['customer_group'] == '') {
			$this->error['customer_group'] = $this->language->get('error_customer_group');
		}

		if ($this->request->post['recorded'] != '')  {
			list($Y, $m, $d) = explode('-', $this->request->post['recorded']);
			if (checkdate($m, $d, $Y) === true) {
			} else {
				$this->error['recorded'] = $this->language->get('error_recorded');
			}
		}

		if ($this->request->post['travel'] != '')  {
			list($Y, $m, $d) = explode('-', $this->request->post['travel']);
			if (checkdate($m, $d, $Y) === true) {
			} else {
				$this->error['travel'] = $this->language->get('error_travle');
			}
		}

		if ($this->request->post['weather'] == '')  {
			$this->error['weather'] = $this->language->get('error_weather');
		}

		if ($this->request->post['driver'] == '*')  {
			$this->error['warning'] = $this->language->get('error_warning');
		}		
		
		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!isset($this->request->post['telphone']) ) {
			$number = $this->request->post['telphone'];
			if (!is_string($number) || !preg_match('/\A\d{2,4}+-\d{2,4}+-\d{4}\z/', $number) ) {
				$this->error['telphone'] = $this->language->get('error_telphone');
			}
		}
		/*
		if ((utf8_strlen($this->request->post['deceased']) <2) || (utf8_strlen($this->request->post['deceased']) > 32)) {
			$this->error['deceased'] = $this->language->get('error_deceased');
		}
		*/
		if ((utf8_strlen($this->request->post['address']) <2) || (utf8_strlen($this->request->post['address']) >128)) {
			$this->error['address'] = $this->language->get('error_address');
		}
		if ($this->error) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/sales')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function mileage() {
		
	}
}
