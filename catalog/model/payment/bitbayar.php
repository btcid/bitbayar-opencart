<?php
/**
 *  Copyright (C) Digito.cz, Digito Proprietary License
 * */
class ModelPaymentBitbayar extends Model {
 public function getMethod($address, $total) {
		$this->load->language('payment/bitbayar');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('bitbayar_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (0 > $total) {
			$status = false;
		} elseif (!$this->config->get('bcp_payment_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$currencies = array(
			'IDR',
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
			'TRY'
		);

		if (!in_array(strtoupper($this->currency->getCode()), $currencies)) {
			$status = false;
		}
		
		//Getting button variant
		$btnVar = $this->config->get('bitbayar_buttons');

		$method_data = array();
		if ($status) {
			if($btnVar == 'text'){
			$method_data = array(
				'code'			=> 'bitbayar',
				'title'			=> $this->language->get('text_title'),
				'terms'			=> '',
				'sort_order'	=> $this->config->get('bitbayar_sort_order')
				);
			}
			else{
			$titleImg = "<img src=\"/admin/view/image/payment/bitbayar-pay-{$btnVar}.png\" alt=\"Bitbayar\">";
			$method_data = array(
					'code'       => 'bitbayar',
					'title'      => $titleImg,
					'terms'      => '',
					'sort_order' => $this->config->get('bitbayar_sort_order')
				);
			}
		}

		return $method_data;
	}
}
?>