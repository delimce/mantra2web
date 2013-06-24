<?php

function _save() {

    Security::sessionActive();

    ////para el cambio de clave
    $db = new ObjectDB();
    $db->setTable("tbl_usuario");

    $db->getTableFields("password", "id = " . Security::getUserID());
    $clave2 = Form::getvar("clave", $_POST);
    if ($db->getField("password") != $clave2)
        $_POST['r0password'] = md5($clave2);
    /////////////

    $db->dataUpdate("r", "0", "tbl_usuario", $_POST, "id = " . Security::getUserID());

    $db->close();

    ////cambiar variable de sesion
    Security::setUserName(Form::getVar("r0nombre"));

    echo 'datos actualizados con exito';
}

?>
