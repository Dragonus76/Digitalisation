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

    echo $this->fetch('css');

?>




<link type="text/css" href="http://scanepitaphe.fr/interact/css/jquery.ui.theme.css" rel="stylesheet" />
        <link type="text/css" href="http://scanepitaphe.fr/interact/css/jquery.ui.core.css" rel="stylesheet" />
        <link type="text/css" href="http://scanepitaphe.fr/interact/css/jquery.ui.resizable.css" rel="stylesheet" />
        <link type="text/css" href="http://scanepitaphe.fr/interact/css/jquery.ui.slider.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="http://scanepitaphe.fr/interact/css/style.css" />
  <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script type="text/javascript" src="json2.js"></script>
        <style>
       span.reference{
              position:absolute;
              right:10px;
              top:10px;
              font-size:12px;
          }
          span.reference a{
        text-transform:uppercase;
              color:#444;
        letter-spacing:1px;
        font-weight:normal;
        text-shadow:1px 1px 1px #fff;
              text-decoration:none;
          }
          span.reference a:hover{
              color:#000;
          }
    h1{ 
        line-height:48px;
        font-size:48px;
        font-family: "Myriad Pro", "Trebuchet MS", Arial, sans-serif;
        color:#888;
        font-weight:normal;
        text-transform:none;
        padding: 40px 0 30px 30px;
        text-shadow:1px 1px 1px #fff;
    }
    </style>

</head>
<body>
<div id="header">
      <?php echo $this->element('header'); ?>
    </div>
			<?php echo $this->fetch('content'); ?>
			<footer>
      <?php echo $this->element('divfoot'); ?>

    </footer> 
</body>
</html>
