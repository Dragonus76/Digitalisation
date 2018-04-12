<div class="row minha">
    <div class="small-12 medium-12 large-12 columns center">
        <h3><?php echo __('Tableau de bord');?></h3>
    </div>
    <div class="row">
        <div class="small-12 medium-12 large-12 tdb lignetop">
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-male"></i><p>'.__('Créer une famille').'</p></div>',array('language'=>Configure::read('Config.language'),'controller'=>'families','action'=>'add'),array(
                    'escapeTitle' => false, 'title' => __('créer une famille (groupe de personnes)')
                  ));
                ?>                                
            
            <?php
                    foreach ($families as $key => $value) {
                        $personne = $this->requestAction('defunts/getbyfamily/'.$value['FamilyUsers']['family_id']);
                        $family = $this->requestAction('families/getbyid/'.$value['FamilyUsers']['family_id']);
                        if(!empty($personne['Defunt']['avatar'])){
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/medias/defunts/'.'defunt_'.$personne['Defunt']['id'].'/'.$personne['Defunt']['avatar'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">'; 
                    }else{
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe" style="position: relative;background:url(http://scanepitaphe.fr/img/fond-gris.jpg)no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';                   
                    }
                    echo '<p class="top">Famille '.$family['Family']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link(__('Modifier, voir les membres'),array('language'=>Configure::read('Config.language'),'controller'=>'families','action'=>'editprinc',$family['Family']['id']));
                    echo '</p></div>';
                    }
                ?>
            
        </div>
    </div>
    <div class="row margecinq">
        <div class="small-12 medium-12 large-12 tdb center">
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-qrcode"></i><p>'.__('Boutique').'</p></div>',array('language'=>Configure::read('Config.language'),'controller'=>'products','action'=>'scanshop'),array(
                    'escapeTitle' => false, 'title' => __('se rendre dans la boutique Scanepitaphe')
                  ));
                ?>
            
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-cog"></i><p>'.__('Mon compte').'</p></div>',array('language'=>Configure::read('Config.language'),'controller'=>'users','action'=>'info'),array(
                    'escapeTitle' => false, 'title' => __('paramètres de votre compte')
                  ));
                ?>                
            
           
                <?php
                    echo $this->Html->link(' <div class="small-12 medium-4b large-4b center bgvert left"><i class="fa fa-question"></i><p>'.__('Besoin d\'aide ?').'</p></div>',array('language'=>Configure::read('Config.language'),'controller'=>'pages','action'=>'display','help'),array(
                    'escapeTitle' => false, 'title' => __('posez nous votre question')
                  ));
                ?>
                
            
        </div>
    </div>
</div>