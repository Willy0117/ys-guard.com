<?php
class ControllerToolRestore extends Controller {
        private $error = array();

        public function index() {
                $this->load->language('tool/restore');

                $this->document->title = $this->language->get('heading_title');

                $this->load->model('tool/restore');

                $this->getList();
        }

        public function insert() {
                $this->load->language('tool/restore');

                $this->document->title = $this->language->get('heading_title');

                $this->load->model('tool/restore');

                if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                        $this->model_tool_restore->addhall($this->request->post);

                        $this->session->data['success'] = $this->language->get('text_success');

                        $this->redirect(HTTPS_SERVER . 'index.php?route=tool/restore&token=' . $this->session->data['token']);
                }

                $this->getForm();
        }

        public function update() {
                $this->load->language('tool/restore');

                $this->document->title = $this->language->get('heading_title');

                $this->load->model('tool/restore');

                if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                        $this->model_tool_restore->edithall($this->request->get['estimate_id'], $this->request->post);

                        $this->session->data['success'] = $this->language->get('text_success');

                        $this->redirect(HTTPS_SERVER . 'index.php?route=tool/restore&token=' . $this->session->data['token']);
                }

                $this->getForm();
        }

        public function delete() {
                $this->load->language('tool/restore');

                $this->document->title = $this->language->get('heading_title');

                $this->load->model('tool/restore');

                if (isset($this->request->post['selected']) && $this->validateDelete()) {
                        foreach ($this->request->post['selected'] as $estimate_id) {
                                $this->model_tool_restore->deleterestore($estimate_id);
                        }

                        $this->session->data['success'] = $this->language->get('text_success');

                        $this->redirect(HTTPS_SERVER . 'index.php?route=tool/restore&token=' . $this->session->data['token']);
                }

                $this->getList();
        }

        private function getList() {
                $this->document->breadcrumbs = array();

                $this->document->breadcrumbs[] = array(
                'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
                'text'      => $this->language->get('text_home'),
                'separator' => FALSE
                );

                $this->document->breadcrumbs[] = array(
                'href'      => HTTPS_SERVER . 'index.php?route=tool/restore&token=' . $this->session->data['token'],
                'text'      => $this->language->get('heading_title'),
                'separator' => ' :: '
                );

                $this->data['insert'] = HTTPS_SERVER . 'index.php?route=tool/restore/insert&token=' . $this->session->data['token'];
                $this->data['delete'] = HTTPS_SERVER . 'index.php?route=tool/restore/delete&token=' . $this->session->data['token'];

                $this->data['restores'] = array();

                $results = $this->model_tool_restore->getrestores(0);

                foreach ($results as $result) {
                        $action = array();

                        $action[] = array(
                                'text' => $this->language->get('text_edit'),
                                'href' => HTTPS_SERVER . 'index.php?route=tool/restore/update&token=' . $this->session->data['token'] . '&estimate_id=' . $result['estimate_id']
                        );

                        $this->data['restores'][] = array(
                                'selected'    => isset($this->request->post['selected']) && in_array($result['estimate_id'], $this->request->post['selected']),
								'estimate_id' => $result['estimate_id'],
                                'name'        => $result['cust_name'],
                                'type'        => $result['estimate_type_name'],
								'action'      => $action
                        );
                }

                $this->data['heading_title'] = $this->language->get('heading_title');

                $this->data['text_no_results'] = $this->language->get('text_no_results');

                $this->data['column_id'] = $this->language->get('column_id');
                $this->data['column_name'] = $this->language->get('column_name');
                $this->data['column_type'] = $this->language->get('column_type');

                $this->data['column_action'] = $this->language->get('column_action');

                $this->data['button_restore'] = $this->language->get('button_restore');
                $this->data['button_delete'] = $this->language->get('button_delete');

                if (isset($this->error['warning'])) {
                        $this->data['error_warning'] = $this->error['warning'];
                } else {
                        $this->data['error_warning'] = '';
                }

                if (isset($this->session->data['success'])) {
                        $this->data['success'] = $this->session->data['success'];

                        unset($this->session->data['success']);
                } else {
                        $this->data['success'] = '';
                }

                $this->template = 'tool/restore_list.tpl';
                $this->children = array(
                        'common/header',
                        'common/footer'
                );

                $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
        }

        private function validateDelete() {
                if (!$this->user->hasPermission('modify', 'tool/restore')) {
                        $this->error['warning'] = $this->language->get('error_permission');
                }

                if (!$this->error) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
}
?>