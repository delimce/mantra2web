<?php

function _index() {

    Security::sessionActive();


    $db = new ObjectDB();

    $db->setTable("tbl_usuario");
    $db->getTableFields("nombre,telefono1,user,password,email", "id = " . Security::getUserID());

    $db->close();
    
    $data['backButton'] = 1;
    $data['siteTitle'] = 'Cambiar clave';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'micuenta/cuenta_form.php', array("datos" => $db));
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}