<script>
  
    $("div[data-role*='page']").live('pageshow', function() { 
                    
        $('#form1').validate({
            rules:{
                r9nombre:{
                    required:true
                }
                
            }, 
            errorElement: "div"
        });
        
    
        $("#submit").click(function () {

            //validando
            if (!$("#form1").valid()) return false;
            
            var formData = $("#form1").serialize();
            
            $('#submit').attr('disabled', 'disabled');

            $.ajax({
                type:"POST",
                url:"<?= Front::myUrl('clientes/zonas_crud'); ?>",
                cache:false,
                data:formData,
                success:function(data) {
                   history.back();
                }
            });

            return false;
        });         
     
    });
</script>

<form id="form1" action="index.php" data-transition="slide"  method="post">

    <div data-role="fieldcontain">

        <label style="font-weight:bold" for="r9nombre">Nombre</label>
        <input type="text" data-mini="true" id="r9nombre" name="r9nombre" />
 
    </div>

    <button data-role="submit" data-theme="b" id="submit" value="submit-value" data-inline="true">Guardar</button>

</form>   