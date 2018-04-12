<?php $prodincarts = $this->Session->read('Cart'); ?>
<?php $totalPrice = 0; ?>
<table>
	<h1>Récapitulatif de la commande</h1>
	<tr>
		<th>Nom du Pack</th>
		<th>Prix HT en euros</th>
	</tr>
	

		<?php foreach ($prodincarts as $key => $product): ?>
		<tr>
			<td><?php echo $product['Product']['name']; ?></td>
			<td><?php echo $product['Product']['price']; ?></td>
			
		</tr>
		  <?php 
    //calcul du prix total
    $totalPrice = $totalPrice + $product['Product']['price']; 
    ?>
		<?php endforeach; ?>
 <tr>
        <th>Prix Total HT en euros : </th>
        <th><?php 
          //prix total
           echo number_format($totalPrice, '2', ',',' '); 
           ?>
        </th>

    </tr>
    <tr>
        <th>TVA en euros : </th>
        <th><?php 
          //calcul TVA
            $tva = $totalPrice*0.196;
           echo number_format($tva, '2', ',',' '); 
           ?>
        </th>
    </tr>
        <tr>
        <th>Prix TTC en euros : </th>
        <th><?php 
          //calcul TTC
            $ttc = $totalPrice+$tva;
           echo number_format($ttc, '2', ',',' '); 
           ?>
        </th>
    </tr>
	
</table>	