<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('ASIA/tokyo');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');


class ControllerCommonProductManager extends Controller {
	public function index() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->getList();
	}

	protected function getList() {
		$filter_status = 1;
		
		if (isset($this->request->get['index'])) {
			$data['index'] = $this->request->get['index'];
		} else {
			$data['index'] = 3;
		}
		
		if (isset($this->request->get['filter_customer_group'])) {
			$filter_customer_group = $this->request->get['filter_customer_group'];
		} else {
			$filter_customer_group = null;
		}

		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {
			$filter_date = date('Y-m-d');
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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

		if (isset($this->request->get['filter_customer_group'])) {
			$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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

		$data['products'] = array();

		$qan = $this->config->get('config_limit');

		$filter_data = array(
			'filter_customer_group'   => $filter_customer_group,
			'filter_date'   => $filter_date,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $qan,
			'limit'           => $qan
		);

		$product_total = $this->model_catalog_product->mgetTotalProducts($filter_data);

		$results = $this->model_catalog_product->mgetProducts($filter_data);

		$this->load->model('catalog/category');

		$data['categoryes'] = $this->model_catalog_category->getCategories(0);

		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		foreach ($results as $result) {
			$category = '';
			foreach($data['categoryes'] as $resu) {
				if ($resu['category_id'] == $result['category_id']) $category = $resu['name'];
			}
			$customer_group = '';
			foreach($data['customer_groups'] as $resu) {
				if ($resu['id'] == $result['customer_group']) $customer_group = $resu['name'];
			}

			$data['products'][] = array(
				'id'			 => $result['id'],
				'customer_group' => $customer_group,
				'category' 		 => $category,
				'name'      	 => $result['name'],
				'price'			 => $result['price'],
				'tax_id'		 => $result['tax_id'],
				'model'     	 => $result['model'],
				'quantity' 		 => $result['quantity'],
				'invoice' 		 => $result['invoice'],
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_customer_group'] = $this->language->get('column_customer_group');

		$data['column_category'] = $this->language->get('column_category');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');

		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');


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
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_customer_group'] = $this->url->link('common/productmanager', 'token=' . $this->session->data['token'] . '&sort=p.customer_group' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('common/productmanager', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_category'] = $this->url->link('common/productmanager', 'token=' . $this->session->data['token'] . '&sort=pd.category' . $url, 'SSL');
		
		$data['sort_model'] = $this->url->link('common/productmanager', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('common/productmanager', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');

		$url = '';		
		
		if (isset($this->request->get['index'])) {
			$url .= '&index=' . $this->request->get['index'];
		}
		
		if (isset($this->request->get['filter_customer_group'])) {
			$url .= '&filter_customer_group=' . $this->request->get['filter_customer_group'];
		}
		
		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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
		$this->load->model('localisation/tax');

		$results = $this->model_localisation_tax->getTaxes();
		foreach($results as $value ){
			$data['taxes'][] = array('id'=>$value['id'],'rate'=>$value['rate']);
		}	

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $qan;
		$pagination->url = $this->url->link('common/productmanager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $qan) + 1 : 0, ((($page - 1) * $qan) > ($product_total - $qan)) ? $product_total : ((($page - 1) * $qan) + $qan), $product_total, ceil($product_total / $qan));

		$data['filter_customer_group'] = $filter_customer_group;
		$data['filter_date'] = $filter_date;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->response->setOutput($this->load->view('catalog/list.tpl', $data));
	}

}