<?php

function _sucursal_crud($borrar = false) {

    Security::hasPermissionTo(1); //id de clientes

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $_POST["r0cobrador"] = Form::getVar("vendedor", $_POST);
        $_POST["r0vendedor"] = Form::getVar("vendedor", $_POST);

        $form->dataInsert("r", "0", "tbl_cliente_sucursal", $_POST);
    } else if (!$borrar) { ///editar reg 
        $_POST["r0cobrador"] = Form::getVar("vendedor", $_POST);
        $_POST["r0vendedor"] = Form::getVar("vendedor", $_POST);
        $form->dataUpdate("r", "0", "tbl_cliente_sucursal", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }


    $form->close();
}