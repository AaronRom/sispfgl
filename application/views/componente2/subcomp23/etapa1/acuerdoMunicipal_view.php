<script type="text/javascript">        
    $(document).ready(function(){
        /*ZONA DE BOTONES*/
        $("#agregar").button();
        $("#editar").button();
        $("#eliminar").button();
        $("#guardar").button();
        $("#cancelar").button();
        
        /*PARA EL DATEPICKER*/
        $( "#reu_fecha" ).datepicker({
            showOn: 'both',
            buttonImage: '<?php echo site_url('resource/imagenes/calendario.png'); ?>',
            buttonImageOnly: true, 
            dateFormat: 'dd/mm/yy'
        });
        /*FIN DEL DATEPICKER*/
        /*ZONA DE VALIDACIONES*/
        function validaSexo(value, colname) {
            if (value == 0 ) return [false,"Seleccione el Sexo del Participante"];
            else return [true,""];
        }
        /*FIN ZONA VALIDACIONES*/
        /*GRID PARTICIPANTES*/
        var tabla=$("#participantes");
        tabla.jqGrid({
            //url: 'welcome/muestraArticulos',
            //editurl:'welcome/gestionArticulo',
            datatype:'json',
            altRows:true,
            height: "100%",
            hidegrid: false,
            colNames:['id','Nombres','Apellidos','Sexo','Cargo','Teléfono'],
            colModel:[
                {name:'par_id',index:'par_id', width:40,editable:false,editoptions:{size:15} },
                {name:'par_nombre',index:'par_nombre',width:200,editable:true,
                    editoptions:{size:25,maxlength:50}, 
                    formoptions:{label: "Nombres",elmprefix:"(*)"},
                    editrules:{required:true} 
                },
                {name:'par_apellido',index:'par_apellido',width:200,editable:true,
                    editoptions:{size:25,maxlength:50}, 
                    formoptions:{label: "Apellidos",elmprefix:"(*)"},
                    editrules:{required:true} 
                },
                {name:'par_sexo',index:'par_sexo',editable:true,edittype:"select",width:40,
                    editoptions:{ value: '0:Seleccione;f:Femenino; m:Masculino' }, 
                    formoptions:{ label: "Sexo",elmprefix:"(*)"},
                    editrules:{custom:true, custom_func:validaSexo}
                },
                {name:'par_cargo',index:'par_cargo',width:250,editable:true,
                    editoptions:{size:25,maxlength:30}, 
                    formoptions:{ label: "Cargo",elmprefix:"(*)"},
                    editrules:{required:true} 
                },
                {name:'par_tel',index:'par_tel',width:100,editable:true,
                    editoptions:{size:10,maxlength:9}, 
                    formoptions:{ label: "Teléfono",elmprefix:"(*)"},
                    editrules:{required:true} 
                }
            ],
            multiselect: false,
            caption: "Personal de Enlace Municipal",
            rowNum:10,
            rowList:[10,20,30],
            loadonce:true,
            pager: jQuery('#pagerParticipantes'),
            viewrecords: true     
        }).jqGrid('navGrid','#pagerParticipantes',
        {edit:false,add:false,del:false,search:false,refresh:false,
            beforeRefresh: function() {
                tabla.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}
        }
    ).hideCol('par_id');
        /* Funcion para regargar los JQGRID luego de agregar y editar*/
        function despuesAgregarEditar() {
            tabla.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
            return[true,'']; //no error
        }
                
        //AGREGAR
        $("#agregar").click(function(){
            tabla.jqGrid('editGridRow',"new",
            {closeAfterAdd:true,addCaption: "Agregar ",
                height:200,align:'center',reloadAfterSubmit:true,width:550,
                processData: "Cargando...",afterSubmit:despuesAgregarEditar,
                bottominfo:"Campos marcados con (*) son obligatorios", 
                onclickSubmit: function(rp_ge, postdata) {
                    $('#mensaje').dialog('open');
                }
            });
        });

        //EDITAR
        $("#editar").click(function(){
            var gr = tabla.jqGrid('getGridParam','selrow');
            if( gr != null )
                tabla.jqGrid('editGridRow',gr,
            {closeAfterEdit:true,editCaption: "Editando ",
                height:200,align:'center',reloadAfterSubmit:true,width:550,
                processData: "Cargando...",afterSubmit:despuesAgregarEditar,
                bottominfo:"Campos marcados con (*) son obligatorios", 
                onclickSubmit: function(rp_ge, postdata) {
                    $('#mensaje').dialog('open');
                    ;}
            });
            else $('#mensaje2').dialog('open'); 
        });
    
        //ELIMINAR
        $("#eliminar").click(function(){
            var grs = tabla.jqGrid('getGridParam','selrow');
            if( grs != null ) tabla.jqGrid('delGridRow',grs,
            {msg: "Desea Eliminar esta ?",caption:"Eliminando ",
                height:100,align:'center',reloadAfterSubmit:true,width:550,
                processData: "Cargando...",
                onclickSubmit: function(rp_ge, postdata) {
                    $('#mensaje').dialog('open');                            
                }}); 
            else $('#mensaje2').dialog('open'); });
        /*DIALOGOS DE VALIDACION*/
        $('.mensaje').dialog({
            autoOpen: false,
            width: 300,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                }
            }
        });
        /*FIN DIALOGOS VALIDACION*/
            
    });
</script>
<form>
    <h2 class="h2Titulos">Etapa 1: Condiciones Previas</h2>
    <h2 class="h2Titulos">Producto 1: Acuerdo Municipal</h2>
    <div style="position: relative;left: 70px;">
       
        <br>
        <table>
            <tr>
            <td  width="200"><strong>Departamento:</strong></td>
            <td  width="200"><strong>Municipio:</strong></td>
            <td  width="200"><strong>Fecha: </strong><input id="reu_fecha" name="reu_fecha" type="text" size="10"/></td>
            </tr>
        </table>
        <p>¿Consejo Municipal conoce el proceso de planificación? 
            <input type="radio" name="acu_num_p1" value="true">SI </input>
            <input type="radio" name="acu_num_p1" value="false">NO </input>
        </p>
        <p>¿Consejo Municipal apoya el proceso? 
            <input type="radio" name="acu_num_p2" value="true">SI </input>
            <input type="radio" name="acu_num_p2" value="false">NO </input>
        </p>
        <br></br>
        <table>
            <tr>
            <td style="width:80px;"></td>
            <td width="300px">
                <strong>Contrapartida</strong>
            <fieldset style="width:170px;">
                <legend>Aportes de la Municipalidad</legend>
                <?php foreach ($contrapartidas as $aux) { ?>
                    <input type="checkbox" name="<?php echo $aux->con_id; ?>" value="<?php echo $aux->con_id; ?>" ><?php echo $aux->con_nombre; ?></input></br>
                <?php } ?>
            </fieldset>

            </td>
            <td style="width: 50px;"></td>
            <td>
                <strong>¿Se esta de acuerdo con los criterios de la participación?</strong>
            <fieldset style="width:200px;">
                <legend><strong>Criterios</strong></legend>
                <table>
                    <?php foreach ($criterios as $aux) { ?>
                        <tr>
                        <td><?php echo $aux->cri_nombre; ?></td>
                        <td><input type="radio" name="<?php echo $aux->cri_id; ?>" value="true">SI </input></td>
                        <td><input type="radio" name="<?php echo $aux->cri_id; ?>" value="false">NO </input></td>
                        </tr>
                    <?php } ?>
                </table>  

            </fieldset>
            </td>
            </tr>
        </table>

        <br></br>

        <table id="participantes"></table>
        <div id="pagerParticipantes"></div>

        <div style="position: relative;left: 275px; top: 5px;">
            <input type="button" id="agregar" value="  Agregar  " />
            <input type="button" id="editar" value="   Editar   " />
            <input type="button" id="eliminar" value="  Eliminar  " />
        </div>
        <table style="position: relative;top: 15px;">
            <tr>
            <td>
                <p>Observaciones:</br><textarea id="acu_mun_observacion" cols="48" rows="5"></textarea></p>
            </td>
            <td style="width: 50px"></td>
            <td>
            <fieldset   style="border-color: #2F589F;height:85px;width:175px;position: relative;left: 50px;">
                <legend align="center"><strong>Cantidad de Participantes</strong></legend>
                <table>
                    <tr>
                    <td class="textD">Hombres: </td>
                    <td><input class="bordeNo" id="hombres" type="text" size="5" readonly="readonly" /></td>
                    </tr>
                    <tr>
                    <td class="textD">Mujeres: </td>
                    <td><input class="bordeNo" id="mujeres" type="text" size="5" readonly="readonly" /></br></td>
                    </tr>
                    <tr>
                    <td class="textD">Total: </td>
                    <td><input class="bordeNo" id="total" type="text" size="5" readonly="readonly" /></td>
                    </tr>
                </table> 
            </fieldset>
            </td>
            </tr>

        </table>
        
        <center style="position: relative;top: 20px">
            <div>
                <p><input type="submit" id="guardar" value="Guardar Acuerdo" />
                    <input type="button" id="cancelar" value="Cancelar" />
                </p>
            </div>
        </center>
    </div>
</form>
<div id="mensaje" class="mensaje" title="Aviso de la operación">
    <p>La acción fue realizada con satisfacción</p>
</div>
<div id="mensaje2" class="mensaje" title="Aviso">
    <p>Debe Seleccionar una fila para continuar</p>
</div>