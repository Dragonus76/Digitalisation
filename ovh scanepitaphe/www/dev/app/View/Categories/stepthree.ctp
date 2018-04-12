<div class="row minha">
    <div class="small-12 medium-4 large-4 columns">
        <h6 class="greylight">Création d'une famille</h6>
        <h6 class="greylight"> Ajout d'un proche</h6>
        <h6>> Ajout d'une catégorie</h6>
        <br/>


    </div>
    <div class="small-12 medium-8 large-8 columns">
        <div class="row">
            <h4>Premiers pas sur Scanepitaphe</h4>
            <p style="text-align:justify;">Vous venez d'ajouter un proche. Vous allez pouvoir ajouter différents contenus afin de compléter la page de ce proche.</p>
            <p style="text-align:justify;">Mais avant cela, il est impératif de créer une catégorie. Les catégories vous permettent de classer les contenus par types, évènements, etc. selon vos envies. Un contenu ne doit pas obligatoirement appartenir à une catégorie.</p>
            <p style="text-align:justify;">Pour continuer, créez une catégorie de votre choix. Celle-ci pourra être modifiée à tout moment par la suite.</p>
        </div>
        <div class="row borderoneplus">
            <div class="row">
                <div class="small-12 medium-12 large-12 columns">
                    <h4>Ajouter une catégorie pour la page de <?php echo $personne['Defunt']['firstname'].' '.$personne['Defunt']['name'];?></h4>
        
        <?php
            echo $this->Form->create('Category');
            echo $this->Form->input('defunt_id', array('type' => 'hidden', 'value' => $personne['Defunt']['id']));
            echo $this->Form->input('name',array('label' => 'Nom de la catégorie', 'placeholder'=>'renseignez le nom de la catégorie','class' => 'ckeditor'));
            echo $this->Form->submit('Ajouter cette catégorie',array('class'=>'button postfix')); 
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
           
