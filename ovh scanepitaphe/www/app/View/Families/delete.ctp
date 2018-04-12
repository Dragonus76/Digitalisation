<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Confirmation suppression de la famille');?> <?php echo $family['Family']['name']; ?></h3>
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
        <div class="small-12 medium-12 large-12 tdb lignetop">
            <p class="footgrey justify">
                <?php echo __('ATTENTION!');?><br/>
                <?php echo __('La suppression de cette famille va engendrer la suppression de l\'ensemble des profils et contenus qui lui sont associés. Cette action est IRREVOCABLE et les profils et contenus supprimés ne pourront pas être récupérés.');?>
            </p>
            <?php
            echo $this->Form->create('Family');
            
                echo $this->Form->input('password',array('label' => __('Renseignez votre mot de passe pour confirmer'),'placeholder'=>__('renseignez votre mot de passe')));
                
                echo $this->Form->submit(__('Confirmer la suppression de cette famille'),array('class'=>'buttonvioletokfull postfix')); 
                echo $this->Form->end();
        ?>
        </div>
    </div>
</div>