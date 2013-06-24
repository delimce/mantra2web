<?php

function _grupos($ope = false, $id = false) {

    Security::hasPermissionTo(2); //id de almacen

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_grupo_producto");

    if ($ope == "edit") { ///editar
        $db->getTableFields("id,nombre,margen_a,margen_b,margen_c,margen_d,comision,activo", "id=$id");
        $db->close();
        $vista = 'almacen/grupo_edit.php';
        $param = array("datos" => $db);
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'almacen/grupo_new.php';
        $param = '';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,nombre",false,"nombre");
        $db->freeAndClose();
        $vista = 'almacen/grupo_list.php';
        $param = array("datos" => $db);
        $newBoton = 'almacen/grupos/new';
    }



    $data['backButton'] = 1;
    $data['siteTitle'] = 'Grupos de Productos';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

