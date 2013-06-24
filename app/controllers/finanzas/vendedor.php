<?php

function _vendedor($ope = false, $id = false) {

    Security::hasPermissionTo(3); //id de finanzas
    
    
    //////ver la lista de usuarios vendedores
    $dv = new ObjectDB();
    $dv->setSql(FactoryDao::getUsersVendors());
    $vendors = $dv->matrixDb();
    $dv->close();
    
    /////////////

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_vendedor");

    if ($ope == "edit") { ///editar
        $db->getTableAllRecords("*", "usuario_id = $id");
        $datos = $db->vectorDb();
        $db->close();
        $vista = 'finanzas/vendor_edit.php';
        $param = array("datos" => $datos,"usuario"=>$id);
    } else { //listar
      
        $db->close();
        $vista = 'finanzas/vendor_list.php';
        $param = array("vendors"=>$vendors);
    }


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Vendedores';
    $data['newButton'] = '';
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

