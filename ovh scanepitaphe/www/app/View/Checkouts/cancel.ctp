<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Erreur dans le processus de paiement');?></h3>
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
                <p><?php echo __('Le processus de paiement a été interrompu. Vous n\'avez pas été débité et la commande a été annulée.');?>
        </p>
            </div>
        </div>

</div>