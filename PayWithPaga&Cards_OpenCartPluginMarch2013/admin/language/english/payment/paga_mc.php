<?php
// Heading
$_['heading_title']					 = 'Paga MasterCard';

// Text
$_['text_payment']					 = 'Payment';
$_['text_success']					 = 'Success: You have modified Paga account details!';
$_['text_paga_mc']				         = '<a onclick="window.open(\'https://www.mypaga.com\');"><img src="view/image/payment/pay-w-paga-mc.jpg" alt="Paga" title="Paga" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']			 = 'Authorization';
$_['text_sale']						 = 'Sale';

// Entry
$_['mc_entry_key']					     = 'Merchant Key:<br /><span class="help">Your Merchant Key is your unique Paga account identifier and is needed to set up Pay by Paga. Click <a onclick="window.open(\'https://www.mypaga.com/paga-web/start.paga\');">here</a> to retrieve your merchant key.</span>';
$_['mc_entry_test']					 = 'Sandbox Mode:<br /><span class="help">Select "YES" to run Pay with Paga in test mode.</span>';
$_['mc_entry_total']                    = 'Minimum Total:<br /><span class="help">Enter amount for maximum value of order that needs to be reached before this payment method becomes active.</span>';
$_['entry_canceled_reversal_status'] = 'Canceled Reversal Status:<br /><span class="help">Set status if transaction is not completed. "Canceled Reversal" recomended.</span>';
$_['mc_entry_completed_status']         = 'Completed Status:<br /><span class="help">Set status if transaction is completed. "Complete" recomended.</span>';
$_['mc_entry_status']					 = 'Status:<br /><span class="help">Select Enabled to enable this payment option.</span>';
$_['mc_entry_sort_order']				 = 'Sort Order:<br /><span class="help">Set order in which this payment option should show during checkout.</span>';

// Error
$_['error_permission']				 = 'Warning: You do not have permission to modify payment Paga!';
$_['error_key']					 = 'Merchant Key Required!';
?>