<div class="row">
	<div class="small-12 medium-3 large-3 columns menuleft">
		<h4 class="robotobold"><?php echo __('Informations');?></h4>
		<?php foreach ($pags as $pag): ?>
			<ul>
				<li><?php echo $this->Html->link($pag['Page']['title'], array('controller'=>'pages','action'=>'display',$pag['Page']['slug'])); ?></li>
			</ul>
		<?php endforeach; ?>
	</div>
	<div class="small-12 medium-9  large-9 columns">
	
			<h2 class="robotobold"><?php echo $cgvs['Page']['title']; ?></h2>
			<?php echo $cgvs['Page']['content']; ?>
	
	</div>
</div>


