<?php
/**
 *  BitBayar Payment Admin Controller
 */

class ControllerPaymentBitbayar extends Controller {

	//~ @var array $error Validation errors
	private $error = array();

	public function index() {
		$this->load->language('payment/bitbayar');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bitbayar', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title']		= $this->language->get('heading_title');

		$data['text_enabled']		= $this->language->get('text_enabled');
		$data['text_disabled']		= $this->language->get('text_disabled');
		$data['text_all_zones']		= $this->language->get('text_all_zones');
		$data['text_yes']			= $this->language->get('text_yes');
		$data['text_no']			= $this->language->get('text_no');
		$data['text_authorization']	= $this->language->get('text_authorization');
		$data['text_sale']			= $this->language->get('text_sale');

		$data['text_edit']			= $this->language->get('text_edit');
		$data['text_bitbayar']		= $this->language->get('text_bitbayar');

		$data['entry_email']		= $this->language->get('entry_email');
		$data['entry_api']			= $this->language->get('entry_api');
		$data['entry_password']		= $this->language->get('entry_password');
		$data['entry_currency']		= $this->language->get('entry_currency');

		$data['entry_buttons']		= $this->language->get('entry_buttons');
		$data['entry_buttons_text']	= $this->language->get('entry_buttons_text');
		$data['entry_geo_zone']		= $this->language->get('entry_geo_zone');
		$data['entry_status']		= $this->language->get('entry_status');
		$data['entry_sort_order']	= $this->language->get('entry_sort_order');

		//~ tabs
		$data['tab_general']		= $this->language->get('tab_general');
		$data['tab_order_status']	= $this->language->get('tab_order_status');
		$data['tab_help']	= $this->language->get('tab_help');

		//~ helps
		$data['help_api']			= $this->language->get('help_api');
		$data['help_password']		= $this->language->get('help_password');
		$data['help_email']			= $this->language->get('help_email');
		$data['help_currency']		= $this->language->get('help_currency');

		$data['button_save']		= $this->language->get('button_save');
		$data['button_cancel']		= $this->language->get('button_cancel');

		//~ payment statuses
		$data['entry_confirmed_status']				= $this->language->get('entry_confirmed_status');
		$data['entry_pending_status']				= $this->language->get('entry_pending_status');
		$data['entry_received_status']				= $this->language->get('entry_received_status');
		$data['entry_insufficient_amount_status']	= $this->language->get('entry_insufficient_amount_status');
		$data['entry_invalid_status']				= $this->language->get('entry_invalid_status');
		$data['entry_timeout_status']				= $this->language->get('entry_timeout_status');
		$data['entry_refunded_status']				= $this->language->get('entry_refunded_status');
		$data['entry_pat_status']					= $this->language->get('entry_pat_status');

		//~ payment helps
		$data['help_confirmed_status']				= $this->language->get('help_confirmed_status');
		$data['help_pending_status']				= $this->language->get('help_pending_status');
		$data['help_received_status']				= $this->language->get('help_received_status');
		$data['help_insufficient_amount_status']	= $this->language->get('help_insufficient_amount_status');
		$data['help_invalid_status']				= $this->language->get('help_invalid_status');
		$data['help_timeout_status']				= $this->language->get('help_timeout_status');
		$data['help_refunded_status']				= $this->language->get('help_refunded_status');
		$data['help_pat_status']					= $this->language->get('help_pat_status');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['api'])) {
			$data['error_api'] = $this->error['api'];
		} else {
			$data['error_api'] = '';
		}
		
		
		if (isset($this->error['idr'])){
			$data['error_idr'] = $this->error['idr'];
		}else{
			$data['error_idr'] = '';
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/bitbayar', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/bitbayar', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['bitbayar_email'])) {
			$data['bitbayar_email'] = $this->request->post['bitbayar_email'];
		} else {
			$data['bitbayar_email'] = $this->config->get('bitbayar_email');
		}

		if (isset($this->request->post['bitbayar_api'])) {
			$data['bitbayar_api'] = $this->request->post['bitbayar_api'];
		} else {
			$data['bitbayar_api'] = $this->config->get('bitbayar_api');
		}

		//~ Status Tab
		if (isset($this->request->post['bitbayar_confirmed_status_id'])) {
			$data['bitbayar_confirmed_status_id'] = $this->request->post['bitbayar_confirmed_status_id'];
		} else {
			$data['bitbayar_confirmed_status_id'] = $this->config->get('bitbayar_confirmed_status_id');
		}

		if (isset($this->request->post['bitbayar_pending_status_id'])) {
			$data['bitbayar_pending_status_id'] = $this->request->post['bitbayar_pending_status_id'];
		} else {
			$data['bitbayar_pending_status_id'] = $this->config->get('bitbayar_pending_status_id');
		}

		if (isset($this->request->post['bitbayar_timeout_status_id'])) {
			$data['bitbayar_timeout_status_id'] = $this->request->post['bitbayar_timeout_status_id'];
		} else {
			$data['bitbayar_timeout_status_id'] = $this->config->get('bitbayar_timeout_status_id');
		}

		if (isset($this->request->post['bitbayar_received_status_id'])) {
			$data['bitbayar_received_status_id'] = $this->request->post['bitbayar_received_status_id'];
		} else {
			$data['bitbayar_received_status_id'] = $this->config->get('bitbayar_received_status_id');
		}

		if (isset($this->request->post['bitbayar_invalid_status_id'])) {
			$data['bitbayar_invalid_status_id'] = $this->request->post['bitbayar_invalid_status_id'];
		} else {
			$data['bitbayar_invalid_status_id'] = $this->config->get('bitbayar_invalid_status_id');
		}

		if (isset($this->request->post['bitbayar_refunded_status_id'])) {
			$data['bitbayar_refunded_status_id'] = $this->request->post['bitbayar_refunded_status_id'];
		} else {
			$data['bitbayar_refunded_status_id'] = $this->config->get('bitbayar_refunded_status_id');
		}

		if (isset($this->request->post['bitbayar_pat_status_id'])) {
			$data['bitbayar_pat_status_id'] = $this->request->post['bitbayar_pat_status_id'];
		} else {
			$data['bitbayar_pat_status_id'] = $this->config->get('bitbayar_pat_status_id');
		}

		if (isset($this->request->post['bitbayar_insufficient_amount_status_id'])) {
			$data['bitbayar_insufficient_amount_status_id'] = $this->request->post['bitbayar_insufficient_amount_status_id'];
		} else {
			$data['bitbayar_insufficient_amount_status_id'] = $this->config->get('bitbayar_insufficient_amount_status_id');
		}


		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['bitbayar_geo_zone_id'])) {
			$data['bitbayar_geo_zone_id'] = $this->request->post['bitbayar_geo_zone_id'];
		} else {
			$data['bitbayar_geo_zone_id'] = $this->config->get('bitbayar_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['bitbayar_status'])) {
			$data['bitbayar_status'] = $this->request->post['bitbayar_status'];
		} else {
			$data['bitbayar_status'] = $this->config->get('bitbayar_status');
		}

		if (isset($this->request->post['bitbayar_buttons'])) {
			$data['bitbayar_buttons'] = $this->request->post['bitbayar_buttons'];
		} else {
			$data['bitbayar_buttons'] = $this->config->get('bitbayar_buttons');
		}

		if (isset($this->request->post['bitbayar_sort_order'])) {
			$data['bitbayar_sort_order'] = $this->request->post['bitbayar_sort_order'];
		} else {
			$data['bitbayar_sort_order'] = $this->config->get('bitbayar_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/bitbayar.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/bitbayar')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['bitbayar_api']) {
			$this->error['api'] = $this->language->get('error_api');
		} else {
		$apiID = $this->request->post['bitbayar_api'];

			if(strlen($apiID) != 33 || $apiID[0] != 'S') {
			  $this->error['api'] = $this->language->get('error_api_wrong');
			}
		}
		
		if(!$this->currency->getValue('IDR')){
			$this->error['idr'] = 'IDR Currency Require';
		}
		return !$this->error;
	}
}
?>