<!-- Chargement des scripts -->
	<?php echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'); ?>
	<?php echo $this->Html->script('foundation.min', array('block' => 'scriptBottom'));?>
	<?php echo $this->Html->script('smooth-scroll', array('block' => 'scriptBottom'));?>
	<?php
		echo $this->fetch('scriptBottom');
	?>
	<script>
    	$(document).foundation();
	</script>
<script>
    smoothScroll.init();
</script>

<!-- Js writeBuffer -->
    <?php
    if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
    // Writes cached scripts?>
