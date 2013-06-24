<?php

function _almacen($ope = false, $id = false) {

    Security::hasPermissionTo(2); //id del modulo de almacen

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_almacen");

    if ($ope == "edit") { ///editar
        $db->getTableFields("id,nombre", "id=$id");
        $db->close();
        $vista = 'almacen/almacen_edit.php';
        $param = array("datos" => $db);
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'almacen/almacen_new.php';
        $param = '';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,nombre");
        $db->freeAndClose();
        $vista = 'almacen/almacen_list.php';
        $param = array("datos" => $db);
        $newBoton = 'almacen/almacen/new';
    }


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Almacenes';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}
