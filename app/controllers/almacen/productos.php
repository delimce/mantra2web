<?php

function _productos($ope = false, $id = false) {

    Security::hasPermissionTo(2); //id de almacen

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_producto");

    if ($ope == "edit") { ///editar
        $db->setFields("*", "id = $id");
        $datos = $db->vectorDb();
        $dgrupo = $datos["grupo_id"];
        $dmarca = $datos["marca_id"];
        $dalmacen = $datos["almacen_id"];
        $diva = $datos["iva"];
        $dunidad = $datos["unidad_id"];
        $db->close();
        $vista = 'almacen/producto_edit.php';
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'almacen/producto_new.php';
        $datos = '';
        $newBoton = '';
    } else { //listar
        $db->setSql(FactoryDao::getProductList());
        $db->executeQuery();
        $db->freeAndClose();
        $vista = 'almacen/producto_list.php';
        $datos = $db;
        $newBoton = 'almacen/productos/new';
    }

    /*
     * para los combos
     */
    $db2 = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    

    $form = new Form();
    ////combo de grupos
    $db2->setTable("tbl_grupo_producto");
    $db2->getTableAllRecords("id,nombre", "activo = 1");
    $grupo = $form->dbComboMobile("r0grupo_id", $db2, "nombre", "id", false, $dgrupo);
    
    ////combo de marcas
    $db2->setTable("tbl_marca_producto");
    $db2->getTableAllRecords("id,nombre");
    $marca = $form->dbComboMobile("r0marca_id", $db2, "nombre", "id", false, $dmarca);
    
    
    ////combo de almacenes
    $db2->setTable("tbl_almacen");
    $db2->getTableAllRecords("id,nombre");
    $almacen = $form->dbComboMobile("r0almacen_id", $db2, "nombre", "id", false, $dalmacen);
    
    ///combo de iva
    $db2->setTable("tbl_iva");
    $db2->getTableAllRecords("tipoiva");
    $iva = $form->dbComboMobile("r0iva", $db2, "tipoiva", "tipoiva", false, $diva);
    
     ///combo de unidad
    $db2->setTable("tbl_unidad");
    $db2->getTableAllRecords("id,nombre");
    $unidad = $form->dbComboMobile("r0unidad_id", $db2, "nombre", "id", false, $dunidad);
    
    $param = array("datos" => $datos, "grupo" => $grupo, "marca" => $marca, "almacen" => $almacen,"iva" => $iva,"unidad" => $unidad);


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Productos';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

