<?php require_once(ROOT_PATH.'user/modules/accordion/payment_history.php'); ?>
<!-- display payment history? -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridView">
  <tr>
    <th scope="col">Type</th>
    <th scope="col">Rate</th>
    <th scope="col">Currency</th>
    <th scope="col">Trial 1</th>
    <th scope="col">Trial 2</th>
    <th scope="col">Amount</th>
    <th scope="col">Date</th>
    <th scope="col">Expire</th>
    <th scope="col">Status</th>
  </tr>
  <?php echo $payment_history; ?>
</table>