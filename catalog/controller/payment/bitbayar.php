<?php

class ControllerPaymentBitbayar extends Controller {
	public function index() {
		$this->language->load('payment/bitbayar');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bitbayar.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/payment/bitbayar.tpl', $data);
			} else {
				return $this->load->view('default/template/payment/bitbayar.tpl', $data);
			}
		}

	}

	public function callback() {

		//~ confirmation process
		$orderId=$_POST['invoice_id'];
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($orderId);


		// api check invoice
		$data_check=array(
			'token' => $this->config->get('bitbayar_api'),
			'id'	=> $_POST['id']
		);

		$url = 'https://bitbayar.com/api/check_invoice';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_check));
		$return = curl_exec($ch);
		curl_close($ch);
		$result=json_decode($return);

		if($result->status!='paid'){
			$order_status_id = $this->config->get('bitbayar_invalid_status_id');
		}else{
			$order_status_id = $this->config->get('bitbayar_confirmed_status_id');
			
			$PaymentHash = "Bitcoin (BitBayar) <br>PaymentID: " . $result->id . "<br>Tx Hash: ". $result->txid;
			$paymentQuery = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $PaymentHash . "' WHERE `order_id` = " . $result->invoice_id);
		}

		// Progress the order status
		$this->model_checkout_order->addOrderHistory($orderId, $order_status_id);
		
		// Notify admin email
		$email_to = $this->config->get('bitbayar_email');
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');            
		$mail->setTo($email_to);
		$mail->setFrom("no-reply@".$_SERVER['HTTP_HOST']);
		$mail->setSender("no-reply@".$_SERVER['HTTP_HOST']);
		$mail->setSubject("New Payment Invoice #".$_POST['invoice_id']);
		$mail->setText(print_r($result, TRUE));

		$mail->send();

	}

  public function paysend() {
	//Getting API-ID from config
	$apiID = $this->config->get('bitbayar_api');
	$bitbayar_url = 'https://bitbayar.com/api/create_invoice';

	//data preparation
	$this->load->model('checkout/order');
	$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

	$price = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
	

	$cname = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
	$csurname = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
	$cnamecomplete = "{$cname} {$csurname}";
	$cemail = html_entity_decode($order_info['email'], ENT_QUOTES, 'UTF-8');

	$idorder = $order_info['order_id'];    
	$order_currency = $order_info['currency_code'];
	$idr_exchange_rate = $this->currency->getValue('IDR');
	if(!$idr_exchange_rate){
		exit('Currency IDR required!');
	}

	//data packing
	//additional checks
	$notiEmail = $this->config->get('bitbayar_email');
	$lang = $this->session->data['language'];
	$settCurr = $this->config->get('bitbayar_currency');


	$postData = array(
		'token'		=> $apiID,
		'invoice_id'	=> $idorder,
		'rupiah'		=> $idr_exchange_rate*floatval($price),
		'memo'			=> 'Invoice #'.$idorder. ' Opencart',
		'callback_url'	=> $this->url->link('payment/bitbayar/callback', '', 'SSL'),
		'url_success'	=> $this->url->link('payment/bitbayar/return_url'),
		'url_failed'	=> $this->url->link('payment/bitbayar/return_url')
	);

	if (($notiEmail !== NULL) && (strlen($notiEmail) > 5)){
		$postData['notify_email'] = $notiEmail;
		}
	if ((strcmp($lang, "cs") !== 0)||(strcmp($lang, "en") !== 0)||(strcmp($lang, "de") !== 0)){
		$postData['lang'] = "en";
	}
	else{
		$postData['lang'] = $lang;
	}

	$content = json_encode($postData);
	//~ echo "<pre>";
	//~ print_r($content);

	//~ //sending data via cURL
	//~ //open connection
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL,$bitbayar_url);
	curl_setopt($ch,CURLOPT_POST,count($postData));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);

	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10); # timeout after 10 seconds, you can increase it
	//curl_setopt($ch,CURLOPT_HEADER,false);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  # Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); # Some server may refuse your request if you dont pass user agent

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	//execute post
	$result = curl_exec($ch);

	//close connection
	curl_close($ch);


	//sending to server, and waiting for response
	$response = json_decode($result);
	
	if(isset($response -> success)){
		//adding paymentID to payment method
		$BitbayarPaymentId = $response -> id;
		$BitbayarInvoiceUrl = "<br>Invoice: https://bitbayar.com/payment/". $BitbayarPaymentId;
		//$prePaymentMethod = html_entity_decode($order_info['payment_method'], ENT_QUOTES, 'UTF-8');
		$finPaymentMethod = "Bitcoin (BitBayar)". "<br>PaymentID: " . $BitbayarPaymentId . $BitbayarInvoiceUrl;

		$paymentQuery = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $finPaymentMethod . "' WHERE `order_id` = " . $order_info['order_id']);

		//redirect to bitbayar payment
		$paymentUrl = $response -> payment_url;
		header("Location: ".$paymentUrl);
		die();
	}else{
		exit('BitBayar API Error: '.$response->error_message);
	}
}


    public function return_url(){
      $returnStatus = $this->request->get['status'];

      if(strcmp($returnStatus,"paid") == 0)
        $this->load->language('checkout/success');
      elseif(strcmp($returnStatus,"cancel") == 0)
        $this->load->language('payment/bitbayar_cancel');
      else
        $this->load->language('payment/bitbayar_fail');


      if (isset($this->session->data['order_id'])) {
    			$this->cart->clear();

    			// Add to activity log
    			$this->load->model('account/activity');

    			if ($this->customer->isLogged()) {
    				$activity_data = array(
    					'customer_id' => $this->customer->getId(),
    					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
    					'order_id'    => $this->session->data['order_id']
    				);

    				$this->model_account_activity->addActivity('order_account', $activity_data);
    			} else {
    				$activity_data = array(
    					'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
    					'order_id' => $this->session->data['order_id']
    				);

    				$this->model_account_activity->addActivity('order_guest', $activity_data);
    			}


			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
    }
}
?>