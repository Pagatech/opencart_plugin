<?php
class ControllerPaymentPaga extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/paga');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			$this->model_setting_setting->editSetting('paga', $this->request->post);

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

		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
		$this->data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

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
			'href'      => $this->url->link('payment/paga', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/paga', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['merchant_key'])) {
			$this->data['merchant_key'] = $this->request->post['merchant_key'];
		} else {
			$this->data['merchant_key'] = $this->config->get('merchant_key');
		}

		if (isset($this->request->post['paga_test'])) {
			$this->data['paga_test'] = $this->request->post['paga_test'];
		} else {
			$this->data['paga_test'] = $this->config->get('paga_test');
		}
		
		if (isset($this->request->post['paga_total'])) {
			$this->data['paga_total'] = $this->request->post['paga_total'];
		} else {
			$this->data['paga_total'] = $this->config->get('paga_total'); 
		} 

		if (isset($this->request->post['paga_canceled_reversal_status_id'])) {
			$this->data['paga_canceled_reversal_status_id'] = $this->request->post['paga_canceled_reversal_status_id'];
		} else {
			$this->data['paga_canceled_reversal_status_id'] = $this->config->get('paga_canceled_reversal_status_id');
		}
		
		if (isset($this->request->post['paga_completed_status_id'])) {
			$this->data['paga_completed_status_id'] = $this->request->post['paga_completed_status_id'];
		} else {
			$this->data['paga_completed_status_id'] = $this->config->get('paga_completed_status_id');
		}	
		
		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['paga_status'])) {
			$this->data['paga_status'] = $this->request->post['paga_status'];
		} else {
			$this->data['paga_status'] = $this->config->get('paga_status');
		}
		
		if (isset($this->request->post['paga_sort_order'])) {
			$this->data['paga_sort_order'] = $this->request->post['paga_sort_order'];
		} else {
			$this->data['paga_sort_order'] = $this->config->get('paga_sort_order');
		}

		$this->template = 'payment/paga.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/paga')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['merchant_key']) {
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