<?php

function _vendedor_crud() {

    Security::hasPermissionTo(3); //id de finanzas

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $_POST["r0usuario_id"] = Form::getVar("ide", $_POST); ///indica el id del usaurio
   
        $form->setTable("tbl_vendedor");
        $form->begin_transacction();
        $form->deleteWhere("usuario_id = {$_POST["r0usuario_id"]}");
        $form->dataInsert("r", "0", "tbl_vendedor", $_POST);
        $form->commit_transacction();
  


    $form->close();
}