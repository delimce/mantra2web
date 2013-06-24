<?php

function _setCliente() {
    
  Security::setSessionVar("PEDIDO_CLIENTEID", Form::getvar("id", $_POST));
}

?>
