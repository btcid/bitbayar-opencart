<?php

//~ Heading
$_['heading_title']			= 'Bitcoin (BitBayar)';

//~ Text
$_['text_payment']			= 'Payment';
$_['text_success']			= 'Success: You have modified BitBayar payment details!';
$_['text_edit']				= 'Edit BitBayar';
//~ $_['text_bitbayar_payment']	= '<a target="_BLANK" href="https://bitbayar.com"><img src="view/image/payment/bitcoinpay-small.jpg" alt="BitBayar payment" title="BitBayar payment" /></a>';
$_['text_bitbayar']	= '<a onclick="window.open(\'https://www.bitbayar.com/\');"><img src="view/image/payment/bitbayar.png" alt="BitBayar" title="bitbayar" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']	= 'Authorization';
$_['text_sale']				= 'Sale';

//~ Entry
$_['entry_api']				= 'API Token:';
$_['entry_password']		= 'Callback password:';
$_['entry_email']			= 'E-Mail:';
$_['entry_currency']		= 'Payout currency:';

$_['entry_buttons']			= 'Button:';
$_['entry_buttons_text']	= 'Text Only';
$_['entry_geo_zone']		= 'Geo Zone:';
$_['entry_status']			= 'Status:';
$_['entry_sort_order']		= 'Sort Order:';

//~ Status
$_['entry_confirmed_status']			= 'Confirmed Status';
$_['entry_pending_status']				= 'Pending Status';
$_['entry_received_status']				= 'Received Status';
$_['entry_insufficient_amount_status']	= 'Insufficient Amount';
$_['entry_invalid_status']				= 'Invalid';
$_['entry_timeout_status']				= 'Timeout Status';
$_['entry_refunded_status']				= 'Refunded';
$_['entry_pat_status']					= 'Paid after timeout';

//~ Status help
$_['help_confirmed_status']				= 'This is THE ONLY payment status, you can consider as final. Payment is credited into balance and will be settled';
$_['help_pending_status']				= 'Waiting for payment';
$_['help_received_status']				= 'Payment has been received but not confirmed yet';
$_['help_insufficient_amount_status']	= 'Customer sent amount lower than required. Customer can ask for the refund directly from the invoice url';
$_['help_invalid_status']				= 'An error has occured';
$_['help_timeout_status']				= 'Payment has not been paid in given time period and has expired';
$_['help_refunded_status']				= 'Payment has been returned to customer';
$_['help_pat_status']					= 'Payment has been paid too late. Customer can ask for refund directly from the invoice url';

//~ Tab
$_['tab_general']						= 'General';
$_['tab_order_status']					= 'Order Status';
$_['tab_help']							= 'Help';

//~ Help
$_['help_api']				= 'API token is used for backed authentication and you should keep it private. You will find your API token in your account under settings & API';
$_['help_email']			= 'Email where notifications about Payment changes are sent.';


//~ Errors
$_['error_permission']			= 'Warning: You do not have permission to modify this payment module!';
$_['error_email']				= 'E-Mail required!';
$_['error_api']					= 'API key required!';
$_['error_api_wrong']			= 'API key is not valid!';
$_['error_api_general']			= 'Genaral API ERROR, please refer to support, with error code: ';
$_['error_currency']			= 'Payout currency required!';
$_['error_currency_invalid']	= 'Bad currency... Folowing currencies are supported:';
$_['error_currency_format']		= 'Bad currency format, use 3 letters';
$_['error_currency_set']		= 'You dont have any currency added. You need to add at least one payout in your account. Go to your BitBayar account Settings > Payout add the payout account.';
?>