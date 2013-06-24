<?php

function _iva_crud($borrar = false) {

    Security::hasPermissionTo(3); //id de finanzas

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $form->dataInsert("r", "0", "tbl_iva", $_POST);
    } else if (!$borrar) { ///editar reg 
        $form->dataUpdate("r", "0", "tbl_iva", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }


    $form->close();
}