<div>N° de Cajas: <?= $datos->getNumRows() ?></div>
<ul data-role="listview" data-inset="true">
    <?php while ($row = $datos->getRowFields()) { ?>
        <li>

            <div><span style="color:blue">
                   <?php $vende = Vector::findInArray($vendors,"id", $row->usuario_id, "nombre"); ?> 
                <?php echo $row->nombre ?> (<?php echo ($vende=="")?'CAJA':$vende;  ?>)</span>
                <br><?php echo number_format($row->saldo, 2) ?>
            </div>

        </li>

    <?php } ?>  
</ul>