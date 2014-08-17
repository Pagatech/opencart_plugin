<?php if ($testmode) { ?>
<div class="warning"><?php echo $text_testmode; ?></div>
<?php } ?>
<form action="<?php echo $action; ?>" method="post" id="payment">
  <?php $i = 0; ?>
  <?php foreach ($products as $product) { ?>
  <input type="hidden" name="product_code[<?php echo $i; ?>]" value="<?php echo $product['model']; ?>" />
  <input type="hidden" name="subtotal[<?php echo $i; ?>]" value="<?php echo $product['price']; ?>" />
  <input type="hidden" name="quantity[<?php echo $i; ?>]" value="<?php echo $product['quantity']; ?>" />
  <input type="hidden" name="description[<?php echo $i; ?>]" value="<?php echo $product['name']; ?>" />
  <?php $i++; ?>
  <?php } ?>
  <input type="hidden" name="currency" value="<?php echo $currency_code; ?>" />
  <input type="hidden" name="customer_account" value="<?php echo $first_name; ?>" />
  <input type="hidden" name="key" value="<?php echo $business; ?>">
  <input type="hidden" name="method" value="paga">
  
  <input type="hidden" name="invoice" value="<?php echo $invoice; ?>" />
  <?php if($testmode == '1') {$testmode = 'true';} ?>
  <input type="hidden" name="test" value="<?php echo $testmode; ?>" />
  <input type="hidden" name="return_url" value="<?php echo $return_url; ?>" />
</form>
<div class="buttons">
  <div class="right">
  <input type="submit" value="<?php echo $button_confirm; ?>" class="button" onclick="$('#payment').submit();"/>
  </div>
</div>