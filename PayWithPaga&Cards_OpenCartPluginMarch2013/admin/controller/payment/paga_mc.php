<?php
class ControllerPaymentPagaMC extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/paga_mc');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			$this->model_setting_setting->editSetting('paga_mc', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');

		$this->data['mc_entry_key'] = $this->language->get('mc_entry_key');
		$this->data['mc_entry_test'] = $this->language->get('mc_entry_test');
		$this->data['mc_entry_total'] = $this->language->get('mc_entry_total');	
		$this->data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
		$this->data['mc_entry_completed_status'] = $this->language->get('mc_entry_completed_status');
		$this->data['mc_entry_status'] = $this->language->get('mc_entry_status');
		$this->data['mc_entry_sort_order'] = $this->language->get('mc_entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['email'])) {
			$this->data['error_key'] = $this->error['email'];
		} else {
			$this->data['error_key'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/paga_mc', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/paga_mc', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['mc_merchant_key'])) {
			$this->data['mc_merchant_key'] = $this->request->post['mc_merchant_key'];
		} else {
			$this->data['mc_merchant_key'] = $this->config->get('mc_merchant_key');
		}

		if (isset($this->request->post['mc_paga_test'])) {
			$this->data['mc_paga_test'] = $this->request->post['mc_paga_test'];
		} else {
			$this->data['mc_paga_test'] = $this->config->get('mc_paga_test');
		}
		
		if (isset($this->request->post['mc_paga_total'])) {
			$this->data['mc_paga_total'] = $this->request->post['mc_paga_total'];
		} else {
			$this->data['mc_paga_total'] = $this->config->get('mc_paga_total'); 
		} 

		if (isset($this->request->post['mc_paga_canceled_reversal_status_id'])) {
			$this->data['mc_paga_canceled_reversal_status_id'] = $this->request->post['mc_paga_canceled_reversal_status_id'];
		} else {
			$this->data['mc_paga_canceled_reversal_status_id'] = $this->config->get('mc_paga_canceled_reversal_status_id');
		}
		
		if (isset($this->request->post['mc_paga_completed_status_id'])) {
			$this->data['mc_paga_completed_status_id'] = $this->request->post['mc_paga_completed_status_id'];
		} else {
			$this->data['mc_paga_completed_status_id'] = $this->config->get('mc_paga_completed_status_id');
		}	
		
		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['paga_mc_status'])) {
			$this->data['paga_mc_status'] = $this->request->post['paga_mc_status'];
		} else {
			$this->data['paga_mc_status'] = $this->config->get('paga_mc_status');
		}
		
		if (isset($this->request->post['paga_mc_sort_order'])) {
			$this->data['paga_mc_sort_order'] = $this->request->post['paga_mc_sort_order'];
		} else {
			$this->data['paga_mc_sort_order'] = $this->config->get('paga_mc_sort_order');
		}

		$this->template = 'payment/paga_mc.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/paga_mc')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['mc_merchant_key']) {
			$this->error['email'] = $this->language->get('error_key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>