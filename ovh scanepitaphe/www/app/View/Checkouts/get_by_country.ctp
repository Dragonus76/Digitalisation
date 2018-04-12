<option value=""></option>
<?php foreach ($deliveries as $key => $value): ?>
<option value="<?php echo $value['Delivery']['value']; ?>"><?php echo $value['Delivery']['name'].' - '.$value['Delivery']['value'].' euros'; ?></option>
<?php endforeach; ?>

