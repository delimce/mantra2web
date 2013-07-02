<script>

    //////funcion para ocultar botones
    function ocultar(cliId) {

        var prods = $("#items li:visible").length;

        if (cliId > 0)
            $("#agregarP").show();
        else
            $("#agregarP").hide();

        if (prods > 0)
            $("#continuaR").show();
        else
            $("#continuaR").hide();

    }



    /////funcion de carga lista de productos
    function listaproductos(idcatego) {

        $("#cantstock").html('&nbsp;');
        $("#botones").hide();

        $.ajax({
            type: "POST",
            url: "<?= Front::myUrl('ventas/listProd'); ?>",
            data: ({id: idcatego}),
            success: function(data) {
                $("#listaproductos").html(data);
            }

        })

    }



    /////funcion de carga lista de productos
    function mostrarStock(idprod) {

        /////validando
        if (idprod == 0)
            $("#botones").hide();
        else
            $("#botones").show();


        $.ajax({
            type: "POST",
            url: "<?= Front::myUrl('ventas/getStock'); ?>",
            data: ({id: idprod}),
            success: function(data) {
                $("#cantstock").html(data);
            }

        });



    }



    /////funcion que setea el cliente
    function setClienteId(idcli) {

        if (idcli > 0) {
            $("#agregarP").show();
            //    $("#continuaR").show();
        } else {
            $("#agregarP").hide();
            //   $("#continuaR").hide();

        }

        $("#cantstock").html('&nbsp;');
        $("#botones").hide();

        if ($("#continuaR").show())
            $("#continuaR").hide();

        $.ajax({
            type: "POST",
            url: "<?= Front::myUrl('ventas/setCliente'); ?>",
            data: ({id: idcli}),
            success: function(data) {
                $("#items").html(data);

                var myselect = $("#categoriap");
                myselect[0].selectedIndex = 0;
                myselect.selectmenu('refresh');
                $("#listaproductos").text('Seleccione grupo de productos');

            },
            complete: function() {
                $('#items').listview('refresh');

            }
        })


    }




    ////accion jquery
    $("div[data-role*='page']").live('pageshow', function() {


        var target_id = "cliente_id";
        $('#' + target_id + ' option').each(function() {
            var ind = $(this).index();
            $('#' + target_id + '-menu').find('[data-option-index=' + ind + ']').addClass($(this).attr('icon'));
        });
        var last_style;
        $('#' + target_id).on('change', function() {
            var selection = $(this).find(':selected').attr('icon');
            if (last_style) {
                $(this).closest('.ui-select').find('.ui-btn').removeClass(last_style);
            }
            $(this).closest('.ui-select').find('.ui-btn').addClass(selection);
            last_style = selection;
        });

        //$(document).ready(function() {

        ocultar($("#cliente_id").val());

        ///validar
        $("#form2").validate({
            rules: {
                cantidad: {
                    required: true,
                    digits: true,
                    min: 1

                }
            }

        })


        //////siguiente paso
        $("#next").click(function() {

            $(location).attr('href', 'viewOrder.php');

        });


        ////deshacer todo el pedido
        $("#deshacer").click(function() {

            var answer = confirm("desea deshacer este pedido?")
            if (answer) {

                $("#continuaR").hide(); ///oculto el boton de continuar

                $.ajax({
                    type: "POST",
                    url: "<?= Front::myUrl('ventas/undoOrder'); ?>",
                    cache: false,
                    success: function(data) {
                        $("#items").html(data);

                    },
                    complete: function() {
                        $('#items').listview('refresh');
                    }
                });



            }

            return false;

        });



        ////borrar item

        $("#borrar").click(function() {

            var answer = confirm("desea eliminar el producto del pedido?")
            if (answer) {


                var formData = $("#form2").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?= Front::myUrl('ventas/deleteItem'); ?>",
                    cache: false,
                    data: formData,
                    success: function(data) {

                        if (data == "")
                            $("#continuaR").hide();

                        $("#items").html(data);

                    },
                    complete: function() {
                        $('#items').listview('refresh');
                    }
                });



            }

            return false;

        });



        ////aÃ±adir y editar cantidad

        $("#add").click(function() {

            ////validar

            if (!$("#form2").valid())
                return false;

            var formData = $("#form2").serialize();

            $.ajax({
                type: "POST",
                url: "<?= Front::myUrl('ventas/addItem'); ?>",
                cache: false,
                data: formData,
                success: function(data) {
                    $("#items").html(data);
                    //  $("#items").append(data);
                },
                complete: function() {
                    $('#items').listview('refresh');
                }
            });

            if ($("#continuaR").hide())
                $("#continuaR").show();

            return false;
        });



        ////ejecuta funcion al cambiar la categoria
        $("#categoriap").change(function() {
            listaproductos($("#categoriap").val());
            $("#cantidad").val(1);

        });


        ////ejecuta funcion al cambiar el cliente
        $("#cliente_id").change(function() {
            setClienteId($("#cliente_id").val());
        });


    });

</script>




<label style="font-weight:bold" for="cliente_id" class="select">Cliente:</label>

<?= $cliente; ?>

Items de la Orden

<div id ="ItemStock" data-role="fieldcontain">
    <ul id="items" data-role="listview">


        <?php
        if (isset($_SESSION['PEDIDO_PRODID'])) {
            foreach ($_SESSION['PEDIDO_PRODID'] as $i => $value) {

                echo '<li>
            <b>Producto:</b> <span style="color:blue">' . $_SESSION['PEDIDO_PRODNOMBRE'][$i] . '</span>
            <fieldset style="font-size: 12px">
            <b>cantidad:</b> ' . $_SESSION['PEDIDO_PRODCANT'][$i] . ' <b>Precio</b> Bs ' . $_SESSION['PEDIDO_PRODPRECIO'][$i] . '                                         
            </fieldset>
            </li>';
            }
        }
        ?>


    </ul>
</div>  


<!--    para añadir productos    -->

<h3>Agregar Productos</h3>

<form id="form2" data-transition="slide"  method="post"> 


        <label for="categoriap" style="font-weight:bold" class="select">Grupo</label>
        <div>
            <?= $grupop ?>
        </div>


        <!--    lista de productos    -->  

        <div class="ui-grid-c ui-responsive">
            <div class="ui-block-a"><div class="ui-body ui-body-d" style="width:60%">nombre de un producto aqui</div></div>
            <div class="ui-block-b"><div class="ui-body ui-body-d">B</div></div>
            <div class="ui-block-c"><div class="ui-body ui-body-d">C</div></div>
        </div>
        <!--    lista de productos    -->  



</form> 





<div>
    <button data-role="deshacer" data-theme="b" id="deshacer" data-icon="delete" name="deshacer" value="submit-value" data-inline="true">Deshacer</button>  
    <button data-role="next" data-theme="b" id="continuaR" data-icon="check" data-ajax="false" name="continuaR" value="submit-value" data-inline="true">Continuar</button>
</div>

