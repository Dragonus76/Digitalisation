<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php $descr = $this->requestAction('options/webdesc/'); ?>
<?php $word = $this->requestAction('options/webword/'); ?>
<?php $title = $this->requestAction('options/webtitle/'); ?>

<meta name="description" content="<?php echo $descr['Option']['content']; ?>"/>

<meta name="keywords" content="<?php echo $word['Option']['content']; ?>"/>


<?php if(!empty($personne['Defunt']['title'])): ?>
	<?php if(!empty($personne['Defunt']['firstname'])): ?>
		<?php if(!empty($personne['Defunt']['name'])): ?>
			<meta property="og:title" content="<?php echo $personne['Defunt']['title'].' '.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name']; ?>"/>
		<?php else: ?>
			<meta property="og:title" content="<?php echo $personne['Defunt']['title'].' '.$personne['Defunt']['firstname']; ?>"/>
		<?php endif ?>
	<?php else: ?>
		<?php if(!empty($personne['Defunt']['name'])): ?>
			<meta property="og:title" content="<?php echo $personne['Defunt']['title'].' '.$personne['Defunt']['name']; ?>" />
		<?php else: ?>	
			<meta property="og:title" content="<?php echo $personne['Defunt']['title']; ?>"/>
		<?php endif ?>
	<?php endif ?>
<?php else: ?>
	<?php if(!empty($personne['Defunt']['firstname'])): ?>
		<?php if(!empty($personne['Defunt']['name'])): ?>
			<meta property="og:title" content="<?php echo $personne['Defunt']['firstname'].' '.$personne['Defunt']['name']; ?>" />
		<?php else: ?>
			<meta property="og:title" content="<?php echo $personne['Defunt']['firstname']; ?>"/>
		<?php endif ?>
	<?php else: ?>
		<?php if(!empty($personne['Defunt']['name'])): ?>
			<meta property="og:title" content="<?php echo $personne['Defunt']['name']; ?>" />			
		<?php else: ?>
			<meta property="og:title" content="<?php echo $title['Option']['content']; ?>" />
		<?php endif ?>
	<?php endif ?>
<?php endif ?>

<?php if(!empty($personne['Defunt']['avatar']) && !empty($personne['Defunt']['id'])): ?>
    <meta property="og:image" content="http://scanepitaphe.fr/img/medias/defunts/defunt_<?php echo $personne['Defunt']['id'].'/'.$personne['Defunt']['avatar']; ?>" />
<?php else: ?>
    <meta property="og:image" content="http://scanepitaphe.fr/img/logo-A4-social-scanepitaphe.jpg" />
<?php endif ?>

<meta property="og:site_name" content="Scanepitaphe" />	

<meta property="og:description" content="<?php echo $descr['Option']['content']; ?>" />
	
<meta property="og:locale" content="fr_FR" />

<meta property="og:type" content="website" />

<?php if (!isset($canonical)): ?>
	<?php $canonical = $this->request->here(); ?>
<?php endif ?>
<?php if ($canonical !== false): ?>
    <?php echo '<link rel="canonical" href="http://scanepitaphe.fr' . $this->Html->url($canonical) . '"/>'; ?>
<?php endif ?>
<meta property="og:url" content="<?php echo 'http://scanepitaphe.fr'.$this->Html->url($canonical); ?>" />

<?php
		
		echo $this->Html->meta('icon');
		echo $this->Html->css('foundation');
		echo $this->Html->css('normalize');
		echo $this->Html->css('font-awesome');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('vendor/modernizr', array('inline' => false));
		echo $this->Html->script('vendor/ckeditor/ckeditor');
		echo $this->fetch('script');
?>
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<script language="javascript" type="text/javascript">
    <!--
    function popitup(url) {
    	width = 450;
        height = 200;
        if(window.innerWidth)
        {
        var left = (window.innerWidth-width)/2;
        var top = (window.innerHeight-height)/2;
        }
        else
        {
        var left = (document.body.clientWidth-width)/2;
        var top = (document.body.clientHeight-height)/2;
        }
    	newwindow=window.open(url,'name','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
    	if (window.focus) {newwindow.focus()}
    	return false;
    }
    // -->
  </script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48359368-1', 'scanepitaphe.fr');
  ga('send', 'pageview');

</script>

