<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Félicitations pour votre achat!');?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                __('Retour à la page précédente'),
                                $this->request->referer(),
                                array('title'=>__('bouton pour revenir à la page précédente'))
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
            <div class="small-12 medium-12 large-12 columns">
                <p><?php echo __('L\'équipe de Scanépitaphe vous remercie, votre paiement a été effectué avec succès.');?> 
        	<br/><?php echo __('Si vous avez acheté des extensions (textes, fichiers sonores, etc.), vous pouvez d\'ores et déjà en profiter.');?><br/><?php echo __('Si vous avez commander une plaque commémorative celle-ci vous sera livrée dans les plus brefs délais. Vous pouvez suivre le traitement de votre commande dans la rubrique "Mon compte" => "Mes commandes".');?>
        </p>
            </div>
        </div>

</div>