<div class="row minha">
    <div class="small-12 medium-4 large-4 columns">
        <h6 class="greylight">Création d'une famille</h6>
        <h6 class="greylight"> Création d'une personne</h6>
        <h6 class="greylight"> Ajout d'une catégorie</h6>
        <h6>> Ajout de contenus</h6>
        <br/>


    </div>
    <div class="small-12 medium-8 large-8 columns">
        <div class="row">
          <?php $lim = $this->requestAction('options/limits/'); ?>
            <h4>Premiers pas sur Scanepitaphe</h4>
            <p style="text-align:justify;">Vous arrivez au terme de ce didactitiel. Désormais, vous êtes en mesure d'ajouter des contenus pour personnaliser la page de votre proche.</p>
            <p style="text-align:justify;">Plusieurs types de contenus sont possibles sur Scanepitaphe. Vous pouvez ajouter des contenus textes, des contenus photos, des contenus vidéos ou  encore des contenus sons.</p>
            <p style="text-align:justify;">Les contenus textes, photos et videos sont limités en nombre (<?php echo $lim['Option']['content']; ?> de chaque) mais à tout moment vous pouvez ajouter des extensions à votre compte en allant dans le Scanshop.</p>
        </div>
        <div class="row borderoneplus">
            <div class="row">
                <div class="small-12 medium-5 large-5 columns">
                    <ul>
                        <?php
                        echo '<li>';
                        echo $this->Html->link(
                          'Ajouter un contenu texte',
                          array(
                              'controller' => 'media', 
                              'action' => 'addtexte',
                              'admin'=>false
                              ),
                            array(
                                    'escapeTitle' => false, 'title' => 'ajouter un contenu texte sur la page d\'une personne'
                                  ));
                        echo '</li>';

                        echo '<li>';
                        echo $this->Html->link(
                          'Ajouter un contenu photo',
                          array(
                              'controller' => 'media', 
                              'action' => 'addimage',
                              'admin'=>false
                              ),
                            array(
                                    'escapeTitle' => false, 'title' => 'ajouter une image sur la page d\'une personne'
                                  ));
                        echo '</li>';
                        echo '<li>';
                        echo $this->Html->link(
                          'Ajouter un contenu sonore',
                          array(
                              'controller' => 'media', 
                              'action' => 'addson',
                              'admin'=>false
                              ),
                            array(
                                    'escapeTitle' => false, 'title' => 'ajouter un contenu sonore sur la page d\'une personne'
                                  ));
                        echo '</li>';
                        echo '<li>';
                        echo $this->Html->link(
                          'Ajouter un contenu vidéo',
                          array(
                              'controller' => 'media', 
                              'action' => 'addvideo',
                              'admin'=>false
                              ),
                            array(
                                    'escapeTitle' => false, 'title' => 'ajouter une vidéo sur la page d\'une personne'
                                  ));
                        echo '</li>';
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <p><?php echo $this->Html->link('Aller directement à mon tableau de bord',array('controller'=>'users','action'=>'account'));?></p>
        </div>
    </div>
    
</div>
           
