<?php

function _vender() {

    Security::hasPermissionTo(4); //id del modulo de ventas


    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $form = new Form();
    $day = date("w"); ///dia que corresponde a la semana
    $vendedor = Security::getUserID();

    ////combo de clientes
    $db->setTable("tbl_cliente");
    $db->getTableAllRecords("id,nombre", "activo = 1 and dia_id = $day and vendedor = $vendedor");
    $default = Security::getSessionVar("PEDIDO_CLIENTEID");
    $cliente = $form->dbComboMobileStyle("cliente_id", $db, "nombre", "id", 'Seleccionar', $default);


    ////combo de grupo de producto
    $db2 = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db2->setTable("tbl_grupo_producto");
    $db2->getTableAllRecords("id,nombre", "activo = 1");
    $grupop = $form->dbComboMobile("categoriap", $db2, "nombre", "id", false, false);


    $param = array("cliente" => $cliente, "grupop" => $grupop);

    $data["backButton"] = 1;
    $data['siteTitle'] = 'Módulo de Ventas';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'ventas/vender.php', $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}