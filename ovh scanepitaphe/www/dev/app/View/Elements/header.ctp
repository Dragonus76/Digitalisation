<nav class="top-bar headr" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <div class="logohead">
    <?php 
    echo $this->Html->image('logo-home.png', 
              array(
                'alt' => 'logo retour accueil du site',
                'width'=>'80px',

                'url' => array('controller' => 'pages', 'action' => 'display', 'home','admin'=>false)
                )); 
     ?>
  </div>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
      <?php 
      if($this->Session->read('Auth.User.id')){
        

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-tag"></i>',
          array(
              'controller' => 'categories', 
              'action' => 'addall',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => 'ajouter une catégorie de contenus à une personne'
                  ));
        echo '</li>';

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-file-pdf-o"></i>',
          array(
              'controller' => 'media', 
              'action' => 'addpdf',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => 'ajouter un pdf sur la page d\'une personne'
                  ));
        echo '</li>';

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-youtube-play"></i>',
          array(
              'controller' => 'media', 
              'action' => 'addvideo',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => 'ajouter une vidéo sur la page d\'une personne'
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-music"></i>',
          array(
              'controller' => 'media', 
              'action' => 'addson',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => 'ajouter un son sur la page d\'une personne'
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-picture-o"></i>',
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
          '<i class="fa fa-pencil"></i>',
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
            'Tableau de bord',
            array(
              'controller' => 'users', 
              'action' => 'account',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => 'mon tableau de bord'
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
            'Se déconnecter',
            array(
              'controller' => 'users', 
              'action' => 'logout',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => 'se déconnecter'
                  ));
        echo '</li>';
      }
    ?>      
    </ul>

  </section>
</nav>