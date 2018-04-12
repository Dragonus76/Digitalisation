<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Gestion de votre compte</h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                'Retour à la page précédente',
                                $this->request->referer(),
                                array('title'=>'bouton pour revenir à la page précédente')
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 tdb lignetop">
        <?php
        echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe" style="padding:0;">';

                    echo '<p class="top">Mes coordonnées</p>';
                    echo '<p class="bottom">'.$this->Html->link('Modifier',array('controller'=>'users','action'=>'edit'));
                    echo '</p></div>';

                    echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe" style="padding:0;">';

                    echo '<p class="top">Supprimer mon compte</p>';
                    echo '<p class="bottom">'.$this->Html->link("Supprimer",array('controller'=>'users','action'=>'delete'));
                    echo '</p></div>';
                    ?>

      </div>
    </div>
</div>