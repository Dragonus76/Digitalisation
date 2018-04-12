<div id="footer">
    <div class="small-12 medium-12 large-12 columns">
        <ul>
            <li><a href="https://www.facebook.com/scan.epitaphe" title="suivez nous sur facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/scanepitaphe" title="suivez nous sur twitter"><i class="fa fa-twitter"></i></a></li>
        </ul>
     	<ul>
            <li><?php echo $this->Html->link(__('Accueil'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','Home','admin'=>false)); ?></li>
            <li><?php echo $this->Html->link(__('A Propos'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','a_propos','admin'=>false)); ?></li>
            <li><?php echo $this->Html->link(__('FAQ'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','faq','admin'=>false)); ?></li>
            <li><?php echo $this->Html->link(__('CGV'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','cgv','admin'=>false)); ?></li>
            <li><?php echo $this->Html->link(__('CGU'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','cgu','admin'=>false)); ?></li>
            <li><?php echo $this->Html->link(__('Mentions Legales'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','legales','admin'=>false)); ?></li>
            <li><?php echo $this->Html->link(__('Contact'),array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','contact','admin'=>false)); ?></li>
        </ul>
        
        <ul>
            <!-- <li>
            <?php echo $this->Html->image("DH2C1E2-1.gif", array(
                    "alt" => "Certificat copyright",
                    'url' => 'http://www.copyrightfrance.com/certificat-depot-copyright-france-DH2C1E2.htm'
                )); 
 ?>
        </li> -->
        <li>
            <a rel="license" href="http://push-infographiste.fr"><img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png" /></a>
        </li>
        </ul>
    </div>
	
</div>
