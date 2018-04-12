<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Scanepitaphe</title>
<?php echo $this->element('scripttop'); ?>
</head>
<body>
	<div id="container">
<div id="header">
			<?php echo $this->element('header'); ?>
		</div>
		<article id="content">
		<?php echo $this->Session->flash(); ?>
		
		<?php echo $this->fetch('content'); ?>

</article>
		<footer>
			<?php echo $this->element('divfoot'); ?>
			<?php echo $this->element('footer'); ?>
		</footer>
	</div>
<!-- 	<?php echo $this->element('sql_dump'); ?> -->
</body>
</html>
