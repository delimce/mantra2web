<?php

function _iva($ope = false, $id = false) {

    Security::hasPermissionTo(3); //id de finanzas

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_iva");

    if ($ope == "edit") { ///editar
        $db->setFields("*", "id = $id");
        $datos = $db->vectorDb();
        $diva = $datos["tipoiva"];
        $db->close();
        $vista = 'finanzas/iva_edit.php';
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'finanzas/iva_new.php';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,fecha,tipoiva,porcentaje",false,"fecha desc");
        $db->freeAndClose();
        $datos = $db;
        $vista = 'finanzas/iva_list.php';
        $newBoton = 'finanzas/iva/new';
    }


        ///combo de iva
    $form = new Form();
    $ivarray = array("A", "B");
    $iva = $form->arrayComboMobile("r0tipoiva", $ivarray, $ivarray, false, $diva);
    
    $param = array("datos" => $datos,"iva"=>$iva);

    $data['backButton'] = 1;
    $data['siteTitle'] = 'I.V.A';
    $data['newButton'] = $newBoton;
    
    
    $data['css'][] = '<link rel="stylesheet" href="'.Front::myUrl('css/jqm-datebox.min.css').'" />';
    $data['head'][] = '<script type="text/javascript" src="' . Front::myUrl('jscripts/jqm-datebox.core.min.js') . '"></script>';
    $data['head'][] = '<script type="text/javascript" src="' . Front::myUrl('jscripts/jqm-datebox.mode.calbox.min.js') . '"></script>';
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

