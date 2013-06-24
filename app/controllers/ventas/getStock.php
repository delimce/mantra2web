<?php

function _getStock() {

    Security::hasPermissionTo(4); //id del modulo de ventas
    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $prod = Form::getvar("id", $_POST);

    if ($prod > 0) {
        $db->setSql(FactoryDao::getStockByproduct($prod));
        $db->getResultFields();
        $db->close();
        echo '<label style="font-weight:bold" class="select">Cant. Actual: </label>&nbsp;';
        echo $db->getField("inv");
    }
}
