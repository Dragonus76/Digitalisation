<?php foreach ($options as $option): ?>
	<div class="row listfilm">
		<div class="small-12 medium-6  large-6 columns" style="text-align:center;">
		  	<?php
				echo $option['Option']['name']; 
			?>
		</div>
		
		<div class="small-12 medium-6  large-6 columns">
			<?php
		  		echo $this->Html->link('Editer',
					array('controller'=>'options','action' => 'edit',$option['Option']['id'])
					); 
		  		
		  	?>
		</div>
	</div>
<?php endforeach; ?>

