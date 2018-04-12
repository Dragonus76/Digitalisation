<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48359368-1', 'scanepitaphe.fr');
  ga('send', 'pageview');

</script>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php $descr = $this->requestAction('options/webdesc/'); ?>
<?php $word = $this->requestAction('options/webword/'); ?>
<?php $title = $this->requestAction('options/webtitle/'); ?>
<?php
	echo '<meta name="description" content="'.$descr['Option']['content'].'"/>';
	echo '<meta name="keywords" content="'.$word['Option']['content'].'" />';
?>	
	<meta property="og:locale" content="fr_FR" />
	<meta property="og:type" content="website" />
<?php
	echo '<meta property="og:title" content="'.$title['Option']['content'].'" />';
	echo '<meta property="og:description" content="'.$descr['Option']['content'].'" />';
?>
	<meta property="og:url" content="http://scanepitaphe.fr/" />
<?php
	echo '<meta property="og:site_name" content="'.$title['Option']['content'].'" />';
?>

<?php
		
		echo $this->Html->meta('icon');
		echo $this->Html->css('foundation');
		echo $this->Html->css('normalize');
		echo $this->Html->css('font-awesome');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('vendor/modernizr', array('inline' => false));
		echo $this->Html->script('vendor/ckeditoradmin/ckeditor');
		echo $this->fetch('script');
?>
