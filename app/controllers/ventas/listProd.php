<?php

function _listProd() {

    Security::hasPermissionTo(4); //id del modulo de ventas
    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));

    $catid = Form::getvar("id", $_POST);

    if ($catid > 0) {

        $form = new Form();

        ////combo de productos
        $db->setTable("tbl_producto");
        $db->getTableAllRecords("id,nombre", "activo = 1 and grupo_id = $catid");
        $cliente = $form->dbComboMobile("producto", $db, "nombre", "id", "Seleccionar",false,"mostrarStock(this.value)");

        echo $cliente;
    } else {

        echo 'Seleccione el grupo de producto';
    }
}
