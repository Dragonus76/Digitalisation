<!-- POSTS -->
<div class="clientpages">
	

<h1>Admin ClientPage</h1>

<p><?php echo 'Vous êtes bien connecté en tant que : '.$username;?></p>

<p><?php echo $this->Html->link('Se deconnecter', array('controller' => 'users', 'action' => 'logout') ); ?></p>
<p>Quelle page souhaitez-vous administrer?</p>
<p>
    <?php foreach ($listedespagesuser as $listedespages): ?>
    <tr>
        <td><?php echo $listedespages['MyClientPage']['id']; ?></td>      
    </tr>
    <?php endforeach; ?>
</p>
<pre><?php print_r($listedespagesuser);?></pre>



<ul>
	
</ul>

</div><!-- clientpages -->