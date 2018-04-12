<div class="small-12 medium-4 large-4 columns nopuce">
    <h4>Administration du site</h4>
    	<ul>

    		<li>
	    		<?php
					echo $this->Html->link('Commandes',
									array('controller'=>'orders','action' => 'fournisseurindex')
									); 
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