<div class="row minha">
    <div class="small-12 medium-4 large-4 columns">
        <h6 class="greylight">Création d'une famille</h6>
        <h6>> Ajout d'un proche</h6>

    </div>
    <div class="small-12 medium-8 large-8 columns">
        <div class="row">
            <h4>Premiers pas sur Scanepitaphe</h4>
            <p>Vous venez de créer une famille. Désormais, vous allez pouvoir ajouter des proches ou groupes de proches au sein de cette famille.</p>
            <p>Ajoutez votre premier proche et passez à l'étape suivante : l'ajout de contenus!</p>
        </div>
        <div class="row borderoneplus">
            <div class="row">
                <div class="small-12 medium-5 large-5 columns">
                    <?php
                     echo $this->Form->create('Defunt',array('type' => 'file'));
                 echo $this->Form->input('family_id', array('type' => 'hidden', 'value' => $id)); 
                 echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id'])); 
                echo $this->Form->input('title', array('label' => 'Titre (Monsieur, Madame, Famille, etc.)'));
                echo $this->Form->input('firstname', array('label' => 'Prénom'));
                echo $this->Form->input('name', array('label' => 'Nom'));
                    ?>
                </div>
                <div class="small-12 medium-7 large-7 columns">
                    <?php
                        echo $this->Form->input('avatar_url',array('label' => 'Photo de profil', 'type' => 'file'));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="small-12 medium-6 large-6 columns inline">
                    <?php
                        echo $this->Form->input('birthdate', array(
                                                'label' => 'Date de naissance',
                                                'dateFormat' => 'DMY',
                                                'minYear' => date('Y') - 2000,
                                                'maxYear' => date('Y'),
                                 'separator' =>'',
                                                'empty'=>true
                    ));
                    ?>
                </div>
                <div class="small-12 medium-6 large-6 columns inline">
                    <?php
                    echo $this->Form->input('deathdate', array(
                                                'label' => 'Date de décès',
                                                'dateFormat' => 'DMY',
                                                'minYear' => date('Y') - 2000,
                                                'maxYear' => date('Y'),
                                                 'empty'=>true,
                                 'separator' =>''
                    ));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="small-12 medium-12 large-12 columns">
                     <?php
                echo $this->Form->submit('Ajouter un proche',array('class'=>'button postfix')); 
                echo $this->Form->end();
        ?>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <p><?php echo $this->Html->link('Aller directement à mon tableau de bord',array('controller'=>'users','action'=>'account'));?></p>
        </div>
    </div>
</div>
           
