<?php

function _productos_crud($borrar = false) {

    Security::hasPermissionTo(2); //id de almacen

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $_POST["r0fecha_creado"] = Calendar::getDatabaseDateTime();

        $form->dataInsert("r", "0", "tbl_producto", $_POST);
    } else if (!$borrar) { ///editar reg 
        $_POST["r0fecha_mod"] = Calendar::getDatabaseDateTime();

        $form->dataUpdate("r", "0", "tbl_producto", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }


    $form->close();
}