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