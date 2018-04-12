<div class="row minha">
    <div class="small-12 medium-12 large-12 columns center">
        <h3>Tableau de bord</h3>
    </div>
    <div class="row">
        <div class="small-12 medium-12 large-12 tdb lignetop">
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-male"></i><p>Créer une famille</p></div>',array('controller'=>'families','action'=>'add'),array(
                    'escapeTitle' => false, 'title' => 'créer une famille (groupe de personnes)'
                  ));
                ?>                                
            
            <?php
                    foreach ($user['Family'] as $key => $value) {
                        $personne = $this->requestAction('defunts/getbyfamily/'.$value['id']);
                        if(!empty($personne['Defunt']['avatar'])){
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/medias/defunts/'.'defunt_'.$personne['Defunt']['id'].'/'.$personne['Defunt']['avatar'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">'; 
                    }else{
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe" style="position: relative;background:url(http://scanepitaphe.fr/img/fond-gris.jpg)no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';                   
                    }
                    echo '<p class="top">Famille '.$value['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link('Modifier, voir les membres',array('controller'=>'families','action'=>'editprinc',$value['id']));
                    echo '</p></div>';
                    }
                ?>
            
        </div>
    </div>
    <div class="row margecinq">
        <div class="small-12 medium-12 large-12 tdb center">
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-qrcode"></i><p>Boutique</p></div>',array('controller'=>'products','action'=>'scanshop'),array(
                    'escapeTitle' => false, 'title' => 'se rendre dans la boutique Scanepitaphe'
                  ));
                ?>
            
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-cog"></i><p>Mon compte</p></div>',array('controller'=>'users','action'=>'info'),array(
                    'escapeTitle' => false, 'title' => 'paramètres de votre compte'
                  ));
                ?>                
            
           
                <?php
                    echo $this->Html->link(' <div class="small-12 medium-4b large-4b center bgvert left"><i class="fa fa-question"></i><p>Besoin d\'aide ?</p></div>',array('controller'=>'pages','action'=>'display','help'),array(
                    'escapeTitle' => false, 'title' => 'posez nous votre question'
                  ));
                ?>
                
            
        </div>
    </div>
</div>