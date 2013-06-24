<?php

function _almacen_crud($borrar = false) {

     Security::hasPermissionTo(2); //id del modulo de almacen

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $_POST["r9blk_fec"] = date("Y-m-d");
        $form->dataInsert("r", "9", "tbl_almacen", $_POST);
    } else if (!$borrar) { ///editar reg 
        $form->dataUpdate("r", "9", "tbl_almacen", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }
    
    $form->close();
}