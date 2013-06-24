<div>N° de Vendedores: <?= count($vendors) ?></div>
<ul data-role="listview" data-inset="true">
    <?php foreach ($vendors as $i => $value) {
        
     ?>
        <li>
            <a class="check" data-ajax="false" href="<?= Front::myUrl("finanzas/vendedor/edit/{$vendors[$i]['id']}") ?>">
                <div><span style="color:blue"><?php echo $vendors[$i]['nombre'];  ?></span></div>
            </a>
        </li>

    <?php } ?>  
</ul>