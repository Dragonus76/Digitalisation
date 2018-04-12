<div id="footer">
    <div class="small-12 medium-12 large-12 columns">
        <ul>
            <li><a href="https://www.facebook.com/scan.epitaphe" title="suivez nous sur facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/scanepitaphe" title="suivez nous sur twitter"><i class="fa fa-twitter"></i></a></li>
        </ul>
     	<ul>
            <li><?php echo $this->Html->link('Accueil',array('controller'=>'pages','action'=>'display','Home')); ?></li>
            <li><?php echo $this->Html->link('A Propos',array('controller'=>'pages','action'=>'display','a_propos')); ?></li>
            <li><?php echo $this->Html->link('FAQ',array('controller'=>'pages','action'=>'display','faq')); ?></li>
            <li><?php echo $this->Html->link('CGV',array('controller'=>'pages','action'=>'display','cgv')); ?></li>
            <li><?php echo $this->Html->link('CGU',array('controller'=>'pages','action'=>'display','cgu')); ?></li>
            <li><?php echo $this->Html->link('Mentions Legales',array('controller'=>'pages','action'=>'display','legales')); ?></li>
            <li><?php echo $this->Html->link('Contact',array('controller'=>'pages','action'=>'display','contact')); ?></li>
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
            <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png" /></a>
        </li>
        </ul>
    </div>
	
</div>
