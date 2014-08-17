<?php
class ControllerPaymentPagaMC extends Controller {
	protected function index() {
		$this->language->load('payment/paga_mc');
		
		$this->data['text_testmode'] = $this->language->get('text_testmode');		
    	
		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['testmode'] = $this->config->get('mc_paga_test');
		
		if (!$this->config->get('mc_paga_test')) {
    		$this->data['action'] = 'https://www.mypaga.com/paga-web/epay/ePay.paga';
  		} else {
			$this->data['action'] = 'https://www.mypaga.com/paga-web/epay/ePay.paga';
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		if ($order_info) {
			$currencies = array(
				'AUD',
				'CAD',
				'EUR',
				'GBP',
				'JPY',
				'USD',
				'NZD',
				'CHF',
				'HKD',
				'SGD',
				'SEK',
				'DKK',
				'PLN',
				'NOK',
				'HUF',
				'CZK',
				'ILS',
				'MXN',
				'MYR',
				'BRL',
				'PHP',
				'TWD',
				'THB',
				'TRY',
				'NGN'
			);
			
			if (in_array($order_info['currency_code'], $currencies)) {
				$currency = $order_info['currency_code'];
			} else {
				$currency = 'USD';
			}		
		
			$this->data['business'] = $this->config->get('mc_merchant_key');
			$this->data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');				
			
			$this->data['products'] = array();
			
			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();
	
				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => $option['option_value']
					);
				}
				
				$this->data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'price'    => $this->currency->format($product['price'], $currency, false, false),
					'quantity' => $product['quantity'],
					'option'   => $option_data,
					'weight'   => $product['weight']
				);
			}	
			
			$this->data['discount_amount_cart'] = 0;
			
			$total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $currency, false, false);

			if ($total > 0) {
				$this->data['products'][] = array(
					'name'     => $this->language->get('text_total'),
					'model'    => '',
					'price'    => $total,
					'quantity' => 1,
					'option'   => array(),
					'weight'   => 0
				);	
			} else {
				$this->data['discount_amount_cart'] -= $this->currency->format($total, $currency, false, false);
			}
			
			$this->data['currency_code'] = $currency;
			$this->data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');	
			$this->data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');	
			$this->data['address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');	
			$this->data['address2'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');	
			$this->data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');	
			$this->data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');	
			$this->data['country'] = $order_info['payment_iso_code_2'];
			$this->data['return_url'] = str_replace('&amp;', '&', $this->url->link('payment/paga_mc/success', 'order_id=' . $this->session->data['order_id']));
			$this->data['email'] = $order_info['email'];
			$this->data['invoice'] = $this->session->data['order_id'] . ' - ' . html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
			$this->data['lc'] = $this->session->data['language'];
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paga_mc.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/paga_mc.tpl';
			} else {
				$this->template = 'default/template/payment/paga_mc.tpl';
			}
	//echo "<pre>";print_r($this->data);die();
			$this->render();
		}
	}
	
	public function success() {
		$this->load->model('checkout/order');
		
		if($_POST['status'] == 'SUCCESS'){
			$this->model_checkout_order->confirm($this->request->get['order_id'], $this->config->get('config_order_status_id'));
		    $this->model_checkout_order->update($this->request->get['order_id'], $this->config->get('mc_paga_completed_status_id'));
		    $this->redirect($this->url->link('checkout/success'));
		}
		else{	
		   $this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
		}
	}
}
?>