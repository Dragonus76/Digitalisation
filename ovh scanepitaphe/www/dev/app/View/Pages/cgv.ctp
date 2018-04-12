<div class="row">
	<div class="small-12 medium-3 large-3 columns menuleft">
		<h4 class="robotobold">Informations</h4>
		<?php foreach ($pags as $pag): ?>
			<ul>
				<li><?php echo $this->Html->link($pag['Page']['title'], array('controller'=>'pages','action'=>'display',$pag['Page']['slug'])); ?></li>
			</ul>
		<?php endforeach; ?>
	</div>
	<div class="small-12 medium-9  large-9 columns">
		<?php foreach ($cgvs as $cgv): ?>
			<h2 class="robotobold"><?php echo $cgv['Page']['title']; ?></h2>
			<?php echo $cgv['Page']['content']; ?>
		<?php endforeach; ?>
	</div>
</div>


