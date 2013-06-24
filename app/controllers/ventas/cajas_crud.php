<?php

function _cajas_crud() {

    Security::hasPermissionTo(4); //id de ventas
    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $form->dataInsert("r", "0", "tbl_caja", $_POST);
    $form->close();
}