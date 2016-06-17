    <?php
	header('Content-Type: text/html; charset=ISO-8859-1');
    //conexion a la base de datos
    require_once("../../../dbconexion/conexion.php");
    $cn = conectarse();
    //archivo con listas seleccionables
    include("../select/selects.php");
    include("../select/Consult.php");
    $hoy = date("d/m/Y");
    $usuario = base64_decode($_GET['usuario']);
    ?>
	<!DOCTYPE>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <title>Agendar Paciente</title>
        <script language="javascript" type="text/javascript" src="../javascript/ajax.js"></script>
    <script language="javascript" src="../../../js/jquery.js" type="text/javascript"></script>
    <script language="javascript" src="../../../js/jquery.maskedinput.js" type="text/javascript"></script>
    <script language="javascript" src="../../../js/jquery.form.js"></script>
    <script language="javascript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
	    <script language='javascript'>
        //funcion para validar el agendamiento
        function ValidarAgenda() {


            var fechacita, horacita, tipo_afiliacion, servicio;
            fechacita = document.nuevo_informe.fechacita.value;
            horacita = document.nuevo_informe.horacita.value;
            tipo_afiliacion = document.nuevo_informe.tipo_afiliacion.value;
            servicio = document.nuevo_informe.servicio.value;
            Vistaestudio = document.nuevo_informe.Vistaestudio.value;
//var input = document.getElementById('archivo').value;
            if (fechacita == "" || horacita == "" || tipo_afiliacion == "" || servicio == "" || Vistaestudio == "") {
//		alert('hello world');
                mensaje = '<font size="2" color="#FF0000">Los campos se�alados con * son obligatorios</font>';
                //etiqueta donde voy a mostrar la respuesta
                document.getElementById('resultado').innerHTML = mensaje;
            }
            else {
//		alert('what�s up?');
                document.nuevo_informe.submit();
            }
        }
        jQuery(function ($) {
            $("#hora2").mask("99:99");
        });
        $(document).ready(function()
        {
            MostrarEstudios();
            MostrarEstudios(1)
        });
    </script>
        <link type="text/css" href="css/TablaCss.css" rel="stylesheet"/>
        <style type="text/css">
        .img {
            width: 100px;
            height: 85px;
            border: none;
        }
        input[readonly]
        {
        color: #696969;
        }
    </style>
    </head>
<body onload="MostrarEstudios()" onBeforeUnload="return window.opener.mostrarAgenda();">
<form name="nuevo_informe" id="nuevo_informe" method="post" action="Inserts/RegDatosPacienteProcedure.php"
      enctype="multipart/form-data">
    <table>
        <tr>
            <td width="30%">
                <fieldset>
                    <legend><strong>Informaci&oacute;n de la orden GHIPS</strong></legend>
                    <table>
                        <tr>
                            <td align="left"><img class="img" src="../images/<?php echo 'ips_universitaria.JPG'; ?>"/><br/><br/><br/>
                            </td>
                            <td><strong><?php echo $sed; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td ALIGN="CENTER" style="background-color: #5c9ccc " colspan="2"><strong>ORDENES MEDICAS</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <br/><strong>Paciente: </strong><?php echo utf8_decode($nom1 . ' ' . $nom2 . ' ' . $ape1 . ' ' . $ape2) ?>
                                <br/>
                                <strong>N&uacute;mero de
                                    identificaci&oacute;n: </strong><?php echo $tipoD . ' - ' . $idpac ?><br/>
                                <strong>Fecha de nacimiento: </strong> <?php echo $f_nac; ?><br/>
                                <strong>Edad: </strong> <?php echo (integer)$edad_posible . ' ' . $unidad; ?><br/>
                                <strong>G&eacute;nero: </strong> <?php echo $sex; ?><br/>
                                <strong>Departamento: </strong> <?php echo $departamento; ?><br/>
                                <strong>Municipio: </strong> <?php echo $municipio; ?><br/>
                                <strong>Direcci&oacute;n: </strong> <?php echo $direccion; ?><br/>
                                <strong>Tel&eacute;fono: </strong> <?php echo $telefonos; ?><br/>
                                <strong>Aseguradora: </strong> <?php echo $eps; ?><br/><br/>
                                <strong>N&uacute;mero de atenci&oacute;n: </strong> <?php echo $idOrd; ?><br/>
                                <strong>Ubicaci&oacute;n: </strong> <?php echo $ubicacion; ?><br/>
                                <strong>Medico solicitante: </strong> <?php echo $medico_solicitante; ?><br/>
                                <strong>Identificaci&oacute; Medico
                                    Solicitante: </strong> <?php echo $idmedreferencia; ?><br/>
                                <strong>Especialidad: </strong> <?php echo $especialidad; ?><br/><br/>
                                <strong>Cups: </strong> <?php echo $codcups; ?><br/>
                                <strong>Estudio solicitado: </strong> <?php echo $descServ; ?><br/>
                                <strong>Tipo estudio: </strong> <?php echo $desc_tecnica; ?><br/>
                                <strong>Tipo Paciente: </strong> <?php echo $desc_tipo_pac; ?><br/>
                                <strong>Prioridad: </strong> <?php echo $prioridad; ?><br/>
                                <strong>Fecha de Solicitud: </strong> <?php echo $fch_sol; ?> <br/>
                                <strong>Hora de Solicitud: </strong> <?php echo $hora_creada; ?> <br/>
                                <strong>Fecha Cita: </strong> <?php echo $fch_cita; ?><br/>
                                <strong>Hora de Solicitud: </strong> <?php echo $hora_cita; ?> <br/><br/>
                                <strong>Diagnostico:&nbsp;</strong> <?php echo utf8_decode($diagnostico); ?><br/><br/>
                                <strong>Sustentacion:&nbsp;</strong> <?php echo utf8_decode($sustentacion); ?><br/><br/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
            <td width="70%">
                <fieldset>
                    <legend><strong>Informaci&oacute;n del paciente</strong></legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="16%"><strong>Tipo documento</strong><br><label for="tipo_documento"></label>
                                <input type="text" name="desc_tipo_documento" value="<?php echo $desc_tipo; ?>"
                                       class="textmedium" readonly="readonly"/><span class="asterisk">*</span>
                                <input type="hidden" name="tipo_documento" value="<?php echo $id_tipo_doc; ?>"
                                       class="textmedium"/></td>
                            <td width="16%"><strong>N&deg; Documento</strong><br><label for="ndocumento"></label>

                                <input type="text" name="ndocumento" id="ndocumento" value="<?php echo $idpac; ?>"
                                       placeholder="Numero de documento" class="textlarge" readonly/><span
                                    class="asterisk">*</span></td>
                            <td width="16%"><strong>1&deg; Nombre</strong><br><label for="pnombre"></label>
                                <input type="text" name="pnombre" value="<?php echo utf8_decode($nom1) ?>"
                                       placeholder="Primer Nombre" class="textlarge" readonly/><span
                                    class="asterisk">*</span></td>
                            <td width="16%"><strong>2&deg; Nombre</strong><br><label for="snombre"></label>
                                <input type="text" name="snombre" value="<?php echo utf8_decode($nom2) ?>"
                                       placeholder="Segundo Nombre" class="textlarge" readonly/></td>
                            <td width="16%"><strong>1&deg; Apellido</strong><br><label for="papellido"></label>
                                <label for="papellido"></label>
                                <input type="text" name="papellido" value="<?php echo utf8_decode($ape1) ?>"
                                       placeholder="Primer Apellido" class="textlarge" readonly/><span class="asterisk">*</span>
                            </td>
                            <td width="16%"><strong>2&deg; Apellido</strong><br><label for="sapellido"></label>
                                <input type="text" name="sapellido" value="<?php echo utf8_decode($ape2) ?>"
                                       placeholder="Segundo Apellido" class="textlarge" readonly/></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de nacimiento:</strong><br>
                                <label for="fecha_nacimiento"></label>
                                <input type="text" name="fecha_nacimiento" class="textlarge"
                                       value="<?php echo $f_nac ?>"
                                       placeholder="DD/MM/AAAA" readonly/><span
                                    class="asterisk">*</span></td>
                            <td id="divedad"><strong>Edad</strong><br/>
                                <input type="text" readonly="readonly" name="edad" id="edad" size="8"
                                       value="<?php echo (integer)$edad_posible; ?>" class="textSmall"/>
                                <label for="unidadedad2"></label>
                                <select name="unidadedad" id="unidadedad2" style="width:95px" disabled>
                                    <option value="A�O" <?php
                                    if (utf8_encode($unidad == 'A�O')) {
                                        ?>
                                        selected="selected"
                                        <?php
                                    } ?> >A�O(S)
                                    </option>
                                    <option value="MES" <?php
                                        if ($unidad == 'MES') {
                                            ?>
                                            selected="selected"
                                            <?php
                                        } ?> MES(ES)
                                    </option>
                                    <option value="DIA" <?php
                                        if ($unidad == 'DIA')
                                        {
                                        ?>
                                            selected="selected"
                                            <?php
                                            }
                                            ?>DIA(S)
                                    </option>
                                </select>
                                <span class="asterisk">*</span></td>
                            <td><strong>Genero</strong><br><input type="text" readonly="readonly" name="genero_1"
                                                                  id="genero_1" value="<?php echo $sex; ?>"
                                                                  class="textmedium"/><input type="hidden" name="genero"
                                                                                             id="genero"
                                                                                             value="<?php echo $id_sexo; ?>"
                                                                                             class="textmedium"/>
                                <span class="asterisk">*</span></td>
                            <td colspan="2"><strong>EPS / E-EPS</strong><br><label for="eps"></label>
                                <?php
                                //obtener datos de la EPS si hay una registrada
                                $conEps = mysql_query("SELECT ideps, UPPER(desc_eps) AS desc_eps FROM eps WHERE idestado = '2'", $cn);
                                //                        $regEps = mysql_fetch_array($conEps);
                                //                        $codEps = $regEps['ideps'];
                                //                        if ($codEps == 0) {
                                //                            ?>
                                <div class="ui-widget">
                                    <select id="ideps" name="ideps" class="text">
                                        <option value="">Seleccionar EPS</option>
                                        <?php
                                        while ($RegsEps = mysql_fetch_array($conEps)) {
                                            ?>
                                            <option value="<?php echo $RegsEps['ideps'] ?>"
                                                <?php if ($RegsEps['ideps'] == $id_eps) {
                                                    echo 'selected';
                                                } ?>
                                                ><?php echo $RegsEps['desc_eps']
                                                ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"/></td>
                            <td><strong>Tipo Afiliaci&oacute;n</strong><br>
                                <select name="tipo_afiliacion" class="textlarge">
                                    <?php
                                    while ($rowTipoAfiliacion = mysql_fetch_array($ListaTipoAfilicacion)) {
                                        ?>
                                        <option value="<?php echo $rowTipoAfiliacion['id_tipoafiliacion'] ?>"
                                            <?php
                                            if ($rowTipoAfiliacion['id_tipoafiliacion'] == $regpaciente['id_tipoafiliacion']) {
                                                ?>
                                                selected="selected"
                                                <?php
                                            }
                                            ?>
                                            >
                                            <?php echo $rowTipoAfiliacion['desc_tipoafiliacion'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="asterisk">*</span>
                                </label></td>
                            <td><strong>Nivel</strong><br><select name="nivel_afiliacion" class="textlarge">
                                    <option value="0">N/A</option>
                                    <?php
                                    for ($x = 1; $x <= 4; $x = $x + 1) {
                                        ?>
                                        <option value="<?php echo $x ?>"
                                            <?php
                                            if ($x == $regpaciente['nivel']) {
                                                ?>
                                                selected="selected"
                                                <?php
                                            }
                                            ?>
                                            >
                                            <?php echo $x ?></option>
                                        <?php
                                    }
                                    ?>
                                </select></td>
                        <tr>
                            <td></td>
                            <td>
                                <div id="validarfechanacimiento"></div>
                            </td>
                            <td colspan="5"></td>
                        </tr>
                        </tr>
                    </table>
                </fieldset>
                <br>
                <div id="Contacto">
                    <fieldset>
                        <!--<legend><a href="#" onclick="muestra_oculta()"><strong>Informacion de contacto</strong></a></legend>-->
                        <legend><strong>Informaci&oacute;n de contacto</strong></legend>
                        <!--<div id="contacto" style="display:none" >-->
                        <div>
                            <table width="100%" align="center">
                                <tr>
                                    <td width="30%">
                                        <strong>Departamento</strong><br>
                                        <select name="dep" id="dep" onChange="cargarMunicipio()" class="textNormal">
                                            <option value="0">.: Seleccione :.</option>
                                            <?php
                                            while ($rowDpto = mysql_fetch_array($listaDepartamentos)) {
                                                ?>
                                                <option value="<?php echo $rowDpto['cod_dpto'] ?>"
                                                    <?php
                                                    if ($rowDpto['cod_dpto'] == $id_departamento) {
                                                        ?>
                                                        selected="selected"
                                                        <?php
                                                    }
                                                    ?>
                                                    >
                                                    <?php echo utf8_decode($rowDpto['nombre_dpto']) ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select><span id="validar_departamento" class="asterisk" style="display: none">*</span>
                                        <input type="text" readonly value="<?php echo $departamento ?>" style="width: 312px"/>
                                    </td>
                                    <td width="20%"><label for="municipio"></label>
                                        <strong> Municipio</strong><br>
                                        <select name="mun" id="mun" class="textNormal">
                                            <option value="0">.: Seleccione :.</option>
                                            <?php
                                            while ($rowMpo = mysql_fetch_array($ListaMunicipio)) {
                                                ?>
                                                <option value="<?php echo $rowMpo['cod_mun'] ?>"
                                                    <?php
                                                    if ($rowMpo['cod_mun'] == $id_municipio) {
                                                        ?>
                                                        selected="selected"
                                                        <?php
                                                    }
                                                    ?>
                                                    >
                                                    <?php echo utf8_decode($rowMpo['nombre_mun']) ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select><span id="validar_municipio" class="asterisk"
                                                       style="display: none">*</span>
                                        <input type="text" style="width: 203px" readonly value="<?php echo $municipio ?>"/>
                                    </td>
                                    <td width="16%"><label for="barrio"></label>
                                        <strong>Barrio</strong><br>
                                        <input name="barrio" type="text" id="barrio"
                                               value="<?php echo $regpaciente['barrio']; ?>"
                                               class="textNormal" placeholder="Barrio"/><span id="validar_barrio"
                                                                                              class="asterisk"
                                                                                              style="display: none">*</span>
                                    </td>
                                    <td width="16%"><label for="direccion"></label>
                                        <strong>Direccion</strong><br>
                                        <input name="direccion" id="direccion" type="text"
                                               value="<?php echo $direccion; ?>"
                                               class="textNormal" placeholder="Direcci?n del domicilio"/><span
                                            id="validar_direccion" class="asterisk" style="display: none">*</span></td>
                                    <td width="20%"><strong>Tel / movil</strong><br><label for="tel"></label>
                                        <input name="tel" id="tel" type="text" value="<?php echo $telefonos; ?>"
                                               class="textlarge"
                                               placeholder="Fijo"/>/
                                        <label for="movil"></label>
                                        <input name="movil" type="text" value="<?php echo $cel; ?>" class="textlarge"
                                               placeholder="Movil"/> <span id="validar_telefono" class="asterisk"
                                                                           style="display: none">*</span></td>
                                    <td width="10%"><label for="email"></label>
                                        <strong>E-m@il</strong><br>
                                        <input name="email" type="email" value="<?php echo $regpaciente['email']; ?>"
                                               class="textNormal" placeholder="Correo electronico"/></td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <br/>
                <fieldset>
                    <legend><strong>Informaci&oacute;n de acompa&ntilde;antes</strong></legend>
                    <?php
                    $sqlacudiente = mysql_query("SELECT * FROM r_acudiente WHERE id_paciente = '$documento'", $cn);
                    while ($rowacudiente = mysql_fetch_array($sqlacudiente)) {
                        echo '<label>Documento</label>
    <input  type="text" value="' . $rowacudiente['id_acudiente'] . '" class="text"/>
    <label>Nombres/Apellido</label>
    <input  type="text" value="' . $rowacudiente['nombres'] . '" class="text" />
    <label>Telefono</label>
    <input  type="text" value="' . $rowacudiente['telefono'] . '"/>
   	<label>Parentezco</label>
    <input  type="text" value="' . $rowacudiente['parentezco'] . '" class="text" /></br></br>';
                    }
                    ?>
                    <div id="contenedor">
                        <label>Documento</label>
                        <input type="text" name="Documento[]" id="Documento" class="text"/>
                        <label>Nombres</label>
                        <input type="text" name="Nombres[]" id="Nombres" class="text"/>
                        <label>Apellidos</label>
                        <input type="text" name="Apellidos[]" id="Apellidos" class="text"/>
                        <label>Telefono</label>
                        <input type="text" name="Telefono[]" id="Telefono" class="text"/>
                        <label>Parentezco</label>
                        <input type="text" name="Parentezco[]" id="Parentezco" class="text"/>
                        <input onClick="Clonar()" id="1" type="button" value="+"/>

                        <div class="error_form">
                        </div>
                    </div>
                </fieldset>
                <br/>

                <div id="parciales"></div>
                <fieldset>
                    <div id="EstudiosClon">
                        <legend><strong>Informaci&oacute;n para la agenda</strong></legend>
                        <table width="100%">
                            <tr>
                                <td width="22%"><strong>N&deg; orden / Ingreso</strong><br/>
                                    <input type="text" name="norden" id="norden" class="text"
                                           placeholder="Numero de ingreso u orden de servicio" value="<?php echo $idOrd; ?>" readonly/>
                                    <span class="asterisk">*</span></td>
                                <td width="24%"><strong>Entidad Reponsable de Pago (ERP):</strong><br/>
                                    <select name="erp" class="text" id="erp">
                                        <option value="">.: Seleccione :.</option>
                                        <?php
                                        while ($rowerp = mysql_fetch_array($listaSede)) {
                                            ?>
                                            <option value="<?php echo $rowerp['idsede'] ?>"
                                                <?php if ($rowerp['idsede'] == $sedeOri) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowerp['descsede'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($listasede);
                                        ?>
                                    </select>
                                    <span class="asterisk">*</span></td>
                                <td width="23%"><strong>Sede</strong><br/>
                                    <select name="sede" id="sede" class="text">
                                        <option value="">.: Seleccione :.</option>
                                        <?php
                                        $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
                                        while ($rowSede = mysql_fetch_array($listaSede)) {
                                            ?>
                                            <option value="<?php echo $rowSede['idsede'] ?>"
                                                <?php if ($rowSede['idsede'] == $sedeOri) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowSede['descsede'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($listasede);
                                        ?>
                                    </select>
                                    <span class="asterisk">*</span></td>
                                <td width="24%"><strong>Lugar de
                                        Realizacion:</strong><br/>
                                    <select name="realizacion" class="text" id="realizacion">
                                        <option value="">.: Seleccione :.</option>
                                        <?php
                                        $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
                                        while ($rowrealizacion = mysql_fetch_array($listaSede)) {
                                            ?>
                                            <option value="<?php echo $rowrealizacion['idsede'] ?>"
                                                <?php if ($rowrealizacion['idsede'] == $sedeOri) {
                                                    echo 'selected';
                                                } ?>> <?php echo $rowrealizacion['descsede'] ?></option>
                                        <?php }
                                        mysql_free_result($listasede);
                                        ?>
                                    </select>
                                    <span class="asterisk">*</span></td>
                            </tr>
                            <tr>
                                <td><strong>Servicio</strong><br/>
                                    <select name="servicio" class="text" id="servicio" onChange="MostrarEstudios()">
                                        <option value="">.: Seleccione :.</option>
                                        <?php
                                        while ($rowServicio = mysql_fetch_array($listaServicio)) {
                                            ?>
                                            <option value="<?php echo $rowServicio['idservicio'] ?>"
                                                <?php if ($rowServicio['idservicio'] == $id_serv) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowServicio['descservicio'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($listaServicio);
                                        ?>
                                    </select><span class="asterisk"> *</span></td>
                                <td colspan="2">
                                    <strong>Estudio</strong><br>
                                    <input name="textfield"
                                           style="width:90%; font-family:Arial, Helvetica, sans-serif; font-size:11px;"
                                           readonly="readonly" type="text"
                                           value="<?php echo $codcups . ' - ' . $descServ;
                                           ?>" class="text" size="80"/>

                                    <div class="ui-widget">
                                        <select id="estudio" name="estudio" class="text">
                                            <option value="">Seleccionar Estudio</option>
                                        </select>
                                    </div>
                                </td>
                                <div id="vistaidestudio"></div>
                                <td>
                                    <div id="showproyeccion" style="display: none">
                                        <strong>Proyecciones Adicionales</strong>
                                        <select id="proyeccionesrx" name="proyeccionesrx" class="form-control">
                                            <option value="0">Seleccione a cantidad de proyecciones realizadas</option>

                                            <?php for ($i = 1; $i <= 2; $i++) {
                                                ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?>Proyeccion(es)
                                                </option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                    <div id="showreconstruccion" style="display:none">
                                        <label for="reconstruccion"><strong>Reconstruccion 3D</strong></label>
                                        <input type="checkbox" name="reconstruccion" id="reconstruccion" value="1"/>
                                    </div>
                                    <div id="showguia" style="display:none">
                                        <strong>Gu&iacute;a Ecogr&aacute;fica</strong>
                                        <input type="radio" name="guia" value="1048"
                                               onchange="validateradio()"/>
                                        <strong>Gu&iacute;a Tomogr&aacute;fica</strong>
                                        <input type="radio" name="guia" value="166"
                                               onchange="validateradio()"/>
                                        <input type="hidden" name="guiaselected" id="guiaselected" val="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td id="tecnicaestudio"><strong>Tecnica</strong><br/>
                                    <select name="tecnica" id="tecnica" class="text" onBlur="ValidarEstudio()"
                                            onChange="ValidarEstudio()">
                                        <?php
                                        while ($rowTecnica = mysql_fetch_array($listaTecnica)) {
                                            ?>
                                            <option value="<?php echo $rowTecnica['id_tecnica'] ?>"
                                                <?php if ($rowTecnica['id_tecnica'] == $tecnica) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowTecnica['desc_tecnica'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($listaTecnica);
                                        ?>
                                        <option value="4" style="display: none;">SIMPLE Y CONTRASTADO</option>
                                    </select>
                                    <span class="asterisk">*</span></td>
                                <td><strong>Copago</strong><br/>
                                    <input type="numeric" value="0" id="copago" name="copago" class="text"></td>
                                <td><strong>Peso Paciente</strong><br/>
                                    <input type="number" id="pesop" name="pesop" class="text"
                                           placeholder="Peso en Kilogramos"
                                           value="0"></td>
                                <td>
                                    <div id="showcomparativa" style="display: none">
                                        <label for="comparativa"><strong>Comparativa </strong></label>
                                        <input type="checkbox" name="comparativa" id="comparativa" value="1"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td id="valilado"><strong>Lado</strong><br/>
                                    <select name="lado" id="lado" class="text">
                                        <?php

                                        while ($rowExtremidad = mysql_fetch_array($listaExtremidad)) {
                                            ?>
                                            <option value="<?php echo $rowExtremidad['id_extremidad'] ?>"
                                               ><?php echo $rowExtremidad['desc_extremidad'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($listaExtremidad);
                                        ?>
                                    </select>
                                    <span class="asterisk">*</span></td>
                                <td id="descripcion_extremidad"><strong>Extremidad:</strong><br><input type="text"
                                                                                                       name="Extremidad"
                                                                                                       class="text"
                                                                                                       placeholder="Ejemplo:(Mano, Pie, Cuello de pie, Mu�eca, entre otros...)"
                                                                                                       onKeyUp="this.value=this.value.toUpperCase()"
                                                                                                       onFocus="BuscarExtremidad()"
                                                                                                       id="Extremidad"/>
                                </td>
                                <td width="24%"><strong>Adicional:</strong><br/>
                                    <input type="text" name="adicional" class="text"
                                           placeholder="Registrar adiciones al estudio solo si es necesario"
                                           onKeyUp="this.value=this.value.toUpperCase()" onFocus="BuscarAdicional()"
                                           id="adicional" value="<?php echo $desc_adicional; ?>"/></td>
                                <td width="21%">
                                    <strong>Portail</strong>
                                         <input type="checkbox" name="portatil" id="portatil" value="1" <?php if ($portatil == "true") { ?> checked <?php } ?>/>
                                    <strong>Anestesia</strong>
                                           <input type="checkbox" name="anestesia" id="anestesia" value="1" <?php if ($anestesia == "true"   ) { ?> checked <?php } ?>/>
                                    
                                    <label for="sedacion"><strong>Sedaci&oacute;n </strong></label>
                                    <input type="checkbox" name="sedacion" id="sedacion" value="1"/></td>
                            </tr>
                            <tr>
                                <td><strong>Tipo paciente</strong><br/>
                                    <select name="tipopaciente" id="tipopaciente" class="text"
                                            onChange="Validartipopaciente()">
                                        <option value="">.: Seleccione :.</option>
                                        <?php

                                        while ($rowTipoPaciente = mysql_fetch_array($ListaTipoPAciente)) {
                                            ?>
                                            <option value="<?php echo $rowTipoPaciente['idtipo_paciente'] ?>"
                                                <?php if ($rowTipoPaciente['idtipo_paciente'] == $id_tipo_paciente) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowTipoPaciente['desctipo_paciente'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($ListaTipoPAciente);
                                        ?>
                                    </select>
                                    <span class="asterisk">*</span></td>
                                <td><strong>Prioridad</strong><br>
                                    <select name="prioridad" id="prioridad" class="text">
                                        <option value="">.: Seleccione :.</option>
                                        <?php

                                        while ($rowPrioridad = mysql_fetch_array($listaPrioridad)) {
                                            ?>
                                            <option value="<?php echo $rowPrioridad['id_prioridad'] ?>"
                                                <?php if ($rowPrioridad['id_prioridad'] == $id_prioridad) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowPrioridad['desc_prioridad'] ?></option>
                                            <?php
                                        }
                                        mysql_free_result($listaPrioridad);
                                        ?>
                                    </select>
                                    <span class="asterisk">*</span></td>
                                <td><strong>Ubicacion</strong><br>
                                    <input type="text" name="ubicacion" class="text"
                                           placeholder="Ubicaci?n del paciente"
                                           onKeyUp="this.value=this.value.toUpperCase()"
                                           value="<?php echo $ubicacion; ?>"/>
                                    <span class="asterisk">*</span></td>
                                <td><strong>Medico solicitante</strong><br>
                                    <input type="text" name="medsolicita" class="text"
                                           placeholder="Medico que solicita el estudio"
                                           onKeyUp="this.value=this.value.toUpperCase()"
                                           value="<?php echo $medico_solicitante; ?>"/></td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <input type="checkbox" onclick="SubirAdjunto(<?php echo $idOrd ?>)"/>
                                    <div id="vista_orden"</div>
                                    <label><strong>Archivos a Subir:</strong><br/></label>
                                    <input type="file" id="archivo" name="archivos[]" multiple="multiple"/></td>
                                <td><strong>Fecha y hora de solicitud</strong><br>
                                    <input name="fechasolicitud" type="text" value="<?php echo $fch_sol; ?>"
                                            readonly/>
                                    <span class="asterisk">*</span>
                                    <input type="text" name="horasolicitud" placeholder="00:00" class="textmedium"
                                           id="hora" value="<?php echo $hora_creada; ?>" readonly/>
                                    <span class="asterisk">*</span></td>
                                <td><strong>Fecha y hora de preparaci&oacute;n</strong><br>
                                    <input type="text" name="fechapreparacion"
                                           value="<?php echo $fch_sol ?>" readonly/>
                                    <span class="asterisk" id="val_fecha_preparacion" style="display: none">*</span>
                                    <input type="text" name="horapreparacion" onBlur="MostrarCitas()"
                                           placeholder="00:00"
                                           class="textmedium"
                                           id="hora3" value="<?php echo $hora_creada; ?>" readonly/>
                                    <span class="asterisk" id="val_hora_preparacion" style="display: none">*</span></td>
                                <td><strong>Fecha y hora de la cita</strong><br>
                                    <input type="text" name="fechacita" id="datepicker2" value="<?php echo $fch_cita ?>"
                                           onChange="MostrarCitas()" readonly/>
                                    <span class="asterisk">*</span>
                                    <input type="text" name="horacita" placeholder="00:00" class="textmedium" value="<?php echo $hora_cita ?>" id="hora2"
                                           onChange="ValidarCita();" onBlur="ValidarCita()" readonly/>
                                    <span class="asterisk">*</span></td>
                            </tr>
                            <td colspan="4">
                    <textarea name="observaciones" id="observaciones" cols="45" rows="5"
                              placeholder="Realizar las observaciones necesarias" style="width:60%" onfocus="ValidarCita()"></textarea></td>
                            <div id="Valestudio"></div>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div id="resultado"></div>
                                </td>
                                <td>
                                    <div id="ValCita"></div>
                                </td>
                            </tr>
                            <div id="MosCita" title="Alerta Citas"></div>

                        </table>
                </fieldset>
            </td>
        </tr>
    </table>


    <!-- Para agregar mas estudios en el agendamiento --------------------------------------------------------------------------------------------------->
    <div id="AgregarEstudio" title="Agregar Estudio">
        <fieldset>
            <input type="hidden" name="ndocumento1" id="ndocumento1" value="<?php echo $documento ?>"
                   placeholder="Numero de documento" class="textlarge"/>
            <legend><strong>Informaci&oacute;n para la agenda</strong></legend>
            <table width="100%">
                <tr>
                    <td width="22%"><strong>N&deg; orden / Ingreso</strong><br/>
                        <input type="text" name="norden1" id="norden1" class="text"
                               placeholder="Numero de ingreso u orden de servicio" value="<?php echo $idOrd; ?>" readonly/>
                        <span class="asterisk">*</span>
                    <td width="24%"><strong>Entidad Reponsable de Pago (ERP):</strong><br/>
                        <select name="erp1" class="text" id="erp1">
                            <option value="">.: Seleccione :.</option>
                            <?php
                            $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
                            while ($rowSede = mysql_fetch_array($listaSede)) {
                                ?>
                                <option value="<?php echo $rowSede['idsede'] ?>"
                                    <?php if ($rowSede['idsede'] == $sedeOri) {
                                        echo 'selected';
                                    } ?>><?php echo $rowSede['descsede'] ?></option>
                                <?php
                            }
                            mysql_free_result($listasede);
                            ?>
                        </select>
                        <span class="asterisk">*</span></td>
                    <td width="23%"><strong>Sede</strong><br/>
                        <select name="sede1" id="sede1" class="text">
                            <option value="">.: Seleccione :.</option>
                            <?php
                            $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
                            while ($rowSede = mysql_fetch_array($listaSede)) {
                                ?>
                                <option value="<?php echo $rowSede['idsede'] ?>"
                                    <?php if ($rowSede['idsede'] == $sedeOri) {
                                        echo 'selected';
                                    } ?>><?php echo $rowSede['descsede'] ?></option>
                                <?php
                            }
                            mysql_free_result($listasede);
                            ?>
                        </select>
                        <span class="asterisk">*</span></td>
                    <td width="24%"><strong>Lugar de
                            Realizacion:</strong><br/>
                        <select name="realizacion1" class="text" id="realizacion1">
                            <option value="">.: Seleccione :.</option>
                            <?php
                            $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
                            while ($rowSede = mysql_fetch_array($listaSede)) {
                                ?>
                                <option value="<?php echo $rowSede['idsede'] ?>"
                                    <?php if ($rowSede['idsede'] == $sedeOri) {
                                        echo 'selected';
                                    } ?>><?php echo $rowSede['descsede'] ?></option>
                                <?php
                            }
                            mysql_free_result($listasede);
                            ?>
                        </select>
                        <span class="asterisk">*</span></td>
                </tr>
                <tr>
                    <td><strong>Servicio</strong><br/>
                        <select name="servicio1" class="text" id="servicio1" onChange="MostrarEstudios(1)">
                            <option value="">.: Seleccione :.</option>
                            <?php
                            $listaServicio = mysql_query("SELECT * FROM servicio WHERE idestado_actividad=1 AND alias!='' ORDER BY descservicio ASC", $cn);
                            while ($rowServicio = mysql_fetch_array($listaServicio)) {
                                ?>
                                <option value="<?php echo $rowServicio['idservicio'] ?>"
                                                <?php if ($rowServicio['idservicio'] == $id_serv) {
                                                    echo 'selected';
                                                } ?>><?php echo $rowServicio['descservicio'] ?></option>
                                            <?php
                                        }
                            mysql_free_result($listaServicio);
                            ?>
                        </select><span class="asterisk"> *</span></td>
                    <td colspan="2"><strong>Estudio</strong><br/>
                        <input name="textfield"
                               style="width:90%; font-family:Arial, Helvetica, sans-serif; font-size:11px;"
                               readonly="readonly" type="text"
                               value="<?php echo $codcups . ' - ' . $descServ;
                               ?>" class="text" size="80"/>
                        <div class="ui-widget">
                            <select id="estudio1" name="estudio1" class="text">
                                <option value="">Seleccionar Estudio</option>
                            </select>
                        </div>
                    </td>
                    <div id="vistaidestudio1"></div>
                    <td>
                        <div id="showproyeccion1" style="display: none">
                            <strong>Proyecciones Adicionales</strong>
                            <select id="proyeccionesrx1" name="proyeccionesrx1" class="form-control">
                                <option value="0">Seleccione a cantidad de proyecciones realizadas</option>

                                <?php for ($i = 1; $i <= 2; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Proyeccion(es)</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <div id="showreconstruccion1" style="display:none">
                            <label for="reconstruccion1"><strong>Reconstruccion 3D</strong></label>
                            <input type="checkbox" name="reconstruccion1" id="reconstruccion1" value="1"/>
                        </div>
                        <div id="showguia1" style="display:none">
                            <strong>Gu&iacute;a Ecogr&aacute;fica</strong>
                            <input type="radio" name="guia1" value="1048"
                                   onchange="validateradio('1')"/>
                            <strong>Gu&iacute;a Tomogr&aacute;fica</strong>
                            <input type="radio" name="guia1" value="166"
                                   onchange="validateradio('1')"/>
                            <input type="hidden" id="guiaselected1" val="">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="tecnicaestudio1"><strong>Tecnica</strong><br/>
                        <select name="tecnica1" id="tecnica1" class="text" onBlur="ValidarEstudio(1)"
                                onChange="ValidarEstudio(1)">
                            <?php
                            $listaTecnica = mysql_query("SELECT * FROM r_tecnica WHERE idestado = '1' ORDER BY desc_tecnica desc", $cn);
                            while ($rowTecnica = mysql_fetch_array($listaTecnica)) {
                                ?>
                                <option value="<?php echo $rowTecnica['id_tecnica'] ?>"
                                    <?php if ($desc_tecnica == "Simple y Contrastado") {
                                        echo 'selected';
                                    } ?>><?php echo $rowTecnica['desc_tecnica'] ?></option>
                                <?php
                            }
                            mysql_free_result($listaTecnica);
                            ?>
                        </select>
                        <span class="asterisk">*</span></td>
                    <td><strong>Copago</strong><br/>
                        <input type="numeric" value="0" id="copago1" name="copago1" class="text"></td>
                    <td>
                        <div id="showcomparativa1" style="display: none">
                            <label for="comparativa1"><strong>Comparativa </strong></label>
                            <input type="checkbox" name="comparativa1" id="comparativa1" value="1"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="valilado1"><strong>Lado</strong><br/>
                        <select name="lado1" id="lado1" class="text">
                            <?php
                            $listaExtremidad = mysql_query("SELECT * FROM r_extremidad WHERE idestado='1'", $cn);
                            while ($rowExtremidad = mysql_fetch_array($listaExtremidad)) {
                                echo '<option value="' . $rowExtremidad['id_extremidad'] . '">' . $rowExtremidad['desc_extremidad'] . '</option>';
                            }
                            mysql_free_result($listaExtremidad);
                            ?>
                        </select>
                        <span class="asterisk">*</span></td>
                    <td id="descripcion_extremidad1"><strong>Extremidad:</strong><br/><input type="text"
                                                                                             name="Extremidad1"
                                                                                             id="extremidad1"
                                                                                             class="text"
                                                                                             placeholder="Ejemplo:(Mano, Pie, Cuello de pie, Mu�eca, entre otros...)"
                                                                                             onKeyUp="this.value=this.value.toUpperCase()"
                                                                                             onFocus="BuscarExtremidad()"/>
                    </td>
                    <td width="24%"><strong>Adicional:</strong><br/>
                        <input type="text" name="adicional1" class="text"
                               placeholder="Registrar adiciones al estudio solo si es necesario"
                               onKeyUp="this.value=this.value.toUpperCase()" onFocus="BuscarAdicional(1)"
                               id="adicional1"/></td>
                    <td width="21%">
                        <label for="portatil1"><strong>Portatil</strong></label>
                        <input type="checkbox" name="portatil1" id="portatil1" value="1"/>
                        <label for="anestesia1"><strong>Anestesia</strong></label>
                        <input type="checkbox" name="anestesia1" id="anestesia1" value="1"/>
                        <label for="sedacion1"><strong>Sedaci&oacute;n </strong></label>
                        <input type="checkbox" name="sedacion1" id="sedacion1" value="1"/></td>
                </tr>
                <td><strong>Fecha y hora de solicitud</strong><br>
                    <input name="fechasolicitud1" type="text" id="datepicker1" value="<?php echo $fch_sol ?>"  readonly/>
                    <span class="asterisk">*</span>
                    <input type="text" name="horasolicitud1" id="hora1" class="textmedium"  value="<?php echo $hora_creada ?>" readonly/>
                    <span class="asterisk">*</span></td>
                <td><strong>Fecha y hora de preparaci&oacute;n</strong><br>
                    <input type="text" name="fechapreparacion" id="datepicker31"
                           value="<?php echo $fch_sol ?>" readonly/>
                    <span class="asterisk" id="val_fecha_preparacion1" style="display: none">*</span>
                    <input type="text" name="horapreparacion1" onBlur="MostrarCitas(1)" placeholder="00:00"
                           class="textmedium" value="<?php echo $hora_creada ?>" id="hora31"
                            readonly/>
                    <span class="asterisk" id="val_hora_preparacion1" style="display: none">*</span></td>
                <td><strong>Fecha y hora de la cita</strong><br>
                    <input type="text" name="fechacita1" id="datepicker21"  value="<?php echo $fch_cita ?>"
                           onChange="MostrarCitas()" readonly/>
                    <span class="asterisk">*</span>
                    <input type="text" name="horacita1" id="hora21" placeholder="00:00" class="textmedium" value="<?php echo $hora_cita ?>" readonly/>
                    <span class="asterisk">*</span></td>
                </tr>
                <td colspan="4">
                    <textarea name="observaciones1" id="observaciones1" cols="45" rows="5"
                              placeholder="Realizar las observaciones necesarias" style="width:60%"></textarea></td>
                <div id="Valestudio1"></div>
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="resultado1"></div>
                    </td>
                    <td colspan="3">
                        <div id="ValCita1"></div>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
</form>
<script src="JavasScript/FuncionesAgendamiento.js"></script>
<script src="../js/ajax.js"></script>
</html>