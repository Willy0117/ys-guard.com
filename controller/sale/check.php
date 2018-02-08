<?php
class ControllerSaleCheck extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/check');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/check');

		$this->getList();
	}
    // 追加
	public function add() {
		$this->load->language('sale/check');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/check');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_check->addCheck($this->request->post);

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

			$this->response->redirect($this->url->link('sale/check', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function edit() {
		$this->load->language('sale/check');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/check');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_check->editCheck($this->request->get['check_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			$this->response->redirect($this->url->link('sale/check', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	/*
	
	*/
	public function delete() {
		$this->load->language('sale/check');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/check');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $check_id) {
				$this->model_sale_check->deleteCheck($check_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_project_id'])) {
				$url .= '&filter_project_id=' . $this->request->get['filter_project_id'];
			}
		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->response->redirect($this->url->link('sale/check', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if ($_SERVER["REMOTE_ADDR"] !== "182.171.234.42") {
			$data['out'] = '1';
		} else {
			$data['out'] = '0';
		}
		
		if (isset($this->request->get['filter_project_id'])) {
			$filter_project_id = $this->request->get['filter_project_id'];
		} else {
			$filter_project_id = null;
		}
				
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
				
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}

		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
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

		if (isset($this->request->get['filter_project_id'])) {
			$url .= '&filter_project_id=' . $this->request->get['filter_project_id'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		$data['insert'] = $this->url->link('sale/check/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('sale/check/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['checks'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_customer' 			=> $filter_customer,
			'filter_project_id'        => $filter_project_id,
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit'),
			'limit'                    => $this->config->get('config_limit')
		);

		$this->load->model('sale/project');

		$data['projects'] = $this->model_sale_project->getProjects();
		
		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		$check_total = $this->model_sale_check->getTotalChecks($filter_data);

		$results = $this->model_sale_check->getChecks($filter_data);

		foreach ($results as $result) {
			$pj = '';
			foreach($data['projects'] as $value) {
				if ($value['project_id'] == $result['project_id'] ) $pr=$value['name'];
			}
			$cg = '';
			foreach($data['customer_groups'] as $value) {
				if ($value['customer_group_id'] == $result['customer_group_id'] ) $cg=$value['name'];
			}
			
			$data['checks'][] = array(
				'project'		 => $pr,
				'check_id'    => $result['check_id'],
				'name'           => $result['name'],
				'customer_group' => $cg,
				'customer'           => $result['customer'],
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'           => $this->url->link('sale/check/edit',  'token=' . $this->session->data['token'] . '&check_id=' . $result['check_id'] . $url , 'SSL'),
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

		$data['column_project'] = $this->language->get('column_project');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_customer_group'] = $this->language->get('column_customer_group');
		$data['column_customer'] = $this->language->get('column_customer');
		
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_project'] = $this->language->get('entry_project');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['filter_project_id'])) {
			$url .= '&filter_project_id=' . $this->request->get['filter_project_id'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_project'] = $this->url->link('sale/check', 'token=' . $this->session->data['token'] . '&sort=project_id' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('sale/check', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_customer_group'] = $this->url->link('sale/check','token=' . $this->session->data['token'] . '&sort=customer_group_id' . $url, 'SSL');
		$data['sort_customer'] = $this->url->link('sale/check','token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('sale/check', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_project_id'])) {
			$url .= '&filter_project_id=' . $this->request->get['filter_project_id'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
	
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $check_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/check', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($check_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($check_total - $this->config->get('config_limit_admin'))) ? $check_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $check_total, ceil($check_total / $this->config->get('config_limit_admin')));

		$data['filter_project_id'] = $filter_project_id;
		$data['filter_name'] = $filter_name;
		$data['filter_customer'] = $filter_customer;
		$data['filter_customer_group_id'] = $filter_customer_group_id;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/check_list.tpl', $data));
	}

	protected function getForm() {
		if ($_SERVER["REMOTE_ADDR"] !== "182.171.234.42") {
			$data['out'] = '1';
		} else {
			$data['out'] = '0';
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['check_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_project'] = $this->language->get('entry_project');
		$data['entry_customer'] = $this->language->get('entry_customer');				// 担当者
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_number'] = $this->language->get('entry_number');			// 喪家名
		$data['entry_name'] = $this->language->get('entry_name');			// 喪家名
		$data['entry_deceased'] = $this->language->get('entry_deceased');	// 故人名
		$data['entry_relation'] = $this->language->get('entry_relation');
		$data['entry_days'] = $this->language->get('entry_days');			// 通夜・告別式
		$data['entry_death'] = $this->language->get('entry_death');			// 亡くなった日
		
		$data['entry_mourner'] = $this->language->get('entry_mourner');
		$data['entry_mourner1'] = $this->language->get('entry_mourner1');
		$data['entry_mourner2'] = $this->language->get('entry_mourner2');
		$data['entry_mourner3'] = $this->language->get('entry_mourner3');
		$data['entry_address'] = $this->language->get('entry_address');

		$data['entry_default'] = $this->language->get('entry_default');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_sentence'] = $this->language->get('entry_sentence');

		$data['entry_design'] = $this->language->get('entry_design');
		$data['entry_family'] = $this->language->get('entry_family');
		$data['entry_crest'] = $this->language->get('entry_crest');
		$data['entry_protocol'] = $this->language->get('entry_protocol');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['check_id'])) {
			$data['check_id'] = $this->request->get['check_id'];
		} else {
			$data['check_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['customer'])) {
			$data['error_customer'] = $this->error['customer'];
		} else {
			$data['error_customer'] = '';
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

		if (isset($this->error['relation'])) {
			$data['error_relation'] = $this->error['relation'];
		} else {
			$data['error_relation'] = '';
		}

		if (isset($this->error['mourner'])) {
			$data['error_mourner'] = $this->error['mourner'];
		} else {
			$data['error_mourner'] = '';
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}

		if (isset($this->error['death'])) {
			$data['error_death'] = $this->error['death'];
		} else {
			$data['error_death'] = '';
		}

		if (isset($this->error['days'])) {
			$data['error_days'] = $this->error['days'];
		} else {
			$data['error_days'] = '';
		}
			
		if (isset($this->error['design'])) {
			$data['error_design'] = $this->error['design'];
		} else {
			$data['error_design'] = '';
		}
			
		if (isset($this->error['sentence'])) {
			$data['error_sentence'] = $this->error['sentence'];
		} else {
			$data['error_sentence'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_project_id'])) {
			$url .= '&filter_project_id=' . $this->request->get['filter_project_id'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		if (!isset($this->request->get['check_id'])) {
			$data['action'] = $this->url->link('sale/check/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('sale/check/edit', 'token=' . $this->session->data['token'] . '&check_id=' . $this->request->get['check_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('sale/check', 'token=' . $this->session->data['token'] . $url , 'SSL');

		if (isset($this->request->get['check_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$check_info = $this->model_sale_check->getCheck($this->request->get['check_id']);
		}

		$this->load->model('sale/project');

		$data['projects'] = $this->model_sale_project->getProjects();

		if (isset($this->request->post['project_id'])) {
			$data['project_id'] = $this->request->post['project_id'];
		} elseif (!empty($check_info)) {
			$data['project_id'] = $check_info['project_id'];
		} else {
			$data['project_id'] = 2;
		}
		
		$this->load->model('sale/protocol');

		$data['protocols'] = $this->model_sale_protocol->getProtocols();

		if (isset($this->request->post['protocol_id'])) {
			$data['protocol_id'] = $this->request->post['protocol_id'];
		} elseif (!empty($check_info)) {
			$data['protocol_id'] = $check_info['protocol_id'];
		} else {
			$data['protocol_id'] = 1;
		}

		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['customer_group_id'])) {
			$data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($check_info)) {
			$data['customer_group_id'] = $check_info['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		if (isset($this->request->post['customer'])) {
			$data['customer'] = $this->request->post['customer'];
		} elseif (!empty($check_info)) {
			$data['customer'] = $check_info['customer'];
		} else {
			$data['customer'] = '';
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($check_info)) {
			$data['name'] = $check_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['number'])) {
			$data['number'] = $this->request->post['number'];
		} elseif (!empty($check_info)) {
			$data['number'] = $check_info['number'];
		} else {
			$data['number'] = '1';
		}

		if (isset($this->request->post['deceased'])) {
			$data['deceased'] = $this->request->post['deceased'];
		} elseif (!empty($check_info)) {
			$data['deceased'] = $check_info['deceased'];
		} else {
			$data['deceased'] = '';
		}

		if (isset($this->request->post['death'])) {
			$data['death'] = $this->request->post['death'];
		} elseif (!empty($check_info)) {
			$data['death'] = $check_info['death'];
		} else {
			$data['death'] = '';
		}

		if (isset($this->request->post['relation'])) {
			$data['relation'] = $this->request->post['relation'];
		} elseif (!empty($check_info)) {
			$data['relation'] = $check_info['relation'];
		} else {
			$data['relation'] = '';
		}

		if (isset($this->request->post['design'])) {
			$data['design'] = $this->request->post['design'];
		} elseif (!empty($check_info)) {
			$data['design'] = $check_info['design'];
		} else {
			$data['design'] = '';
		}
				
		if (isset($this->request->post['mourner'])) {
			$data['mourner'] = $this->request->post['mourner'];
		} elseif (!empty($check_info)) {
			$data['mourner'] = $check_info['mourner'];
		} else {
			$data['mourner'] = '';
		}
		if (isset($this->request->post['mourner1'])) {
			$data['mourner1'] = $this->request->post['mourner1'];
		} elseif (!empty($check_info)) {
			$data['mourner1'] = $check_info['mourner1'];
		} else {
			$data['mourner1'] = '';
		}
		if (isset($this->request->post['mourner2'])) {
			$data['mourner2'] = $this->request->post['mourner2'];
		} elseif (!empty($check_info)) {
			$data['mourner2'] = $check_info['mourner2'];
		} else {
			$data['mourner2'] = '';
		}
		if (isset($this->request->post['mourner3'])) {
			$data['mourner3'] = $this->request->post['mourner3'];
		} elseif (!empty($check_info)) {
			$data['mourner3'] = $check_info['mourner3'];
		} else {
			$data['mourner3'] = '';
		}

		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($check_info)) {
			$data['address'] = $check_info['address'];
		} else {
			$data['address'] = '';
		}

		if (isset($this->request->post['sentence'])) {
			$data['sentence'] = $this->request->post['sentence'];
		} elseif (!empty($check_info)) {
			$data['sentence'] = $check_info['sentence'];
		} else {
			$data['sentence'] = '';
		}

		if (isset($this->request->post['days'])) {
			$data['days'] = $this->request->post['days'];
		} elseif (!empty($check_info)) {
			$data['days'] = $check_info['days'];
		} else {
			$data['days'] = '';
		}

		if (isset($this->request->post['crest'])) {
			$data['crest'] = $this->request->post['crest'];
		} elseif (!empty($check_info)) {
			$data['crest'] = $check_info['crest'];
		} else {
			$data['crest'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/check_form.tpl', $data));
	}


	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/check')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['customer']) < 2) || (utf8_strlen($this->request->post['customer']) > 32)) {
			$this->error['customer'] = $this->language->get('error_customer');
		}
		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!isset($this->request->post['deceased']) || $this->request->post['deceased'] != 1) {
			$this->error['deceased'] = $this->language->get('error_deceased');
		}

		if (!isset($this->request->post['relation']) || $this->request->post['relation'] != 1)  {
			$this->error['relation'] = $this->language->get('error_relation');
		}

		if (!isset($this->request->post['mourner']) || $this->request->post['mourner'] != 1)  {
			$this->error['mourner'] = $this->language->get('error_mourner');
		}

		if (!isset($this->request->post['address']) || $this->request->post['address'] != 1)  {
			$this->error['address'] = $this->language->get('error_address');
		}

		if (!isset($this->request->post['death']) || $this->request->post['death'] != 1)  {
			$this->error['death'] = $this->language->get('error_death');
		}

		if (!isset($this->request->post['days']) || $this->request->post['days'] != 1)  {
			$this->error['days'] = $this->language->get('error_days');
		}

		if (!isset($this->request->post['design']) || $this->request->post['design'] != 1)  {
			$this->error['design'] = $this->language->get('error_design');
		}
		
		if (!isset($this->request->post['sentence']) || $this->request->post['sentence'] != 1)  {
			$this->error['sentence'] = $this->language->get('error_sentence');
		}		
		return !$this->error;
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/check')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
