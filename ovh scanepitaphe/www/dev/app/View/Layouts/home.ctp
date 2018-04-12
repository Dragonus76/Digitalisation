<?php
/**
* Website Name: Memories
* Description: The aim of this site is to offer the possibility to user to create a personal webpage to write * their biography of the one of lost one.
* Author: Benjamin Guimond
* Author URI: http://push-infographiste.fr
* Version: 1
* Tags: online memorials, biography, e-commerce, individual webpage
*/
?>
<!DOCTYPE html>
<!-- Website Name: Memories
Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
Author: Benjamin Guimond
Author URI: http://push-infographiste.fr
Version: 1
Tags: online memorials, biography, e-commerce, individual webpage
-->
<html itemscope itemtype="http://schema.org/WebPage">
<head>
	<?php echo $this->Html->charset(); ?>
	<title itemprop="name">
		 <?php $title = $this->requestAction('options/webtitle/'); ?>

		<?php echo $title['Option']['content']; ?>
	
	</title>
<?php echo $this->element('scripttop'); ?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php echo $this->element('headerhome'); ?>
		</div>
		<article id="content">
			<div style="top:8em;position:absolute;min-width:100%;z-index:100;">
			<?php echo $this->Session->flash(); ?>
		</div>

			<?php echo $this->fetch('content'); ?>
		</article>
		<footer>
			<?php echo $this->element('divfoot'); ?>
			<?php echo $this->element('footer'); ?>
		</footer>
	</div>
</body>
</html>
