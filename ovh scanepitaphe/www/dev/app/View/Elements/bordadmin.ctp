<div class="small-12 medium-4 large-4 columns nopuce">
    <h4>Administration du site</h4>
    	<ul>
    		<li>
	    		<?php
					echo $this->Html->link('Paramètres du site',
									array('controller'=>'dashboards','action' => 'lisopt')
									); 
				?>
			</li>
			<li>
	    		<?php
					echo $this->Html->link('Produits',
									array('controller'=>'products','action' => 'liste')
									); 
				?>
			</li>
			<li>
	    		<?php
					echo $this->Html->link('Modes de livraison',
									array('controller'=>'deliveries','action' => 'liste')
									); 
				?>
			</li>
    		<li>
	    		<?php
					echo $this->Html->link('Commandes',
									array('controller'=>'orders','action' => 'index')
									); 
				?>
			</li>
			<li>
	    		<?php
					echo $this->Html->link('Pages fixes',
									array('controller'=>'dashboards','action' => 'lispage')
									); 
				?>
			</li>	
			<li>
				<?php 
					echo '<a href="http://scanepitaphe.fr/app/webroot/payment/log.txt" target="_blank" title="Fichier log">Fichier log des paiments en ligne</a>';
				?>
			</li>
			<li>&nbsp;</li>
            <li>______________</li>
            <li><?php echo $this->Html->link(
                        'Retour à la page précédente',
                        $this->request->referer(),
                        array('title'=>'bouton pour revenir à la page précédente')
                        ); ?></li>
    	</ul>
</div>