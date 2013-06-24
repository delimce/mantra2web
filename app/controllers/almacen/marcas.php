<?php

function _marcas($ope = false, $id = false) {

    Security::hasPermissionTo(2); //id de almacen

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_marca_producto");

    if ($ope == "edit") { ///editar
        $db->getTableFields("id,nombre", "id=$id");
        $db->close();
        $vista = 'almacen/marcas_edit.php';
        $param = array("datos" => $db);
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'almacen/marcas_new.php';
        $param = '';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,nombre",false,"nombre");
        $db->freeAndClose();
        $vista = 'almacen/marcas_list.php';
        $param = array("datos" => $db);
        $newBoton = 'almacen/marcas/new';
    }



    $data['backButton'] = 1;
    $data['siteTitle'] = 'Marcas de Productos';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

