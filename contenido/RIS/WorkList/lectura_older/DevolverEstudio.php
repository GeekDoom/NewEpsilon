<?php
//conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idInforme = base64_decode($_GET['idInforme']);
$usuario = base64_decode($_GET['usuario']);
//obtener los datos de la agenda
$sql = mysql_query("SELECT l.hora, i.id_informe, l.fecha, i.id_paciente,
CONCAT(p.nom1,' ', p.nom2,'<br>', p.ape1,' ', p.ape2) AS nombre, es.nom_estudio, t.desc_tecnica FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
WHERE i.id_informe = '$idInforme'", $cn);
$reg = mysql_fetch_array($sql);
$consulta = mysql_query("SELECT * FROM r_motivodevolucion", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Detalles :.</title>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;}
fieldset
{
	width:90%;
	font-family: Arial, Helvetica, sans-serif;
}
.asteris {
	color: #F00;
}
</style>
<script language="JavaScript" src="../../../../js/ajax.js"></script>
<script language="javascript">
	function enviarObservacion()
	{
		//declarar variables
		usuario = document.observacion.usuario.value;
		informe = document.observacion.informe.value;
		observacion = document.observacion.observacion.value;
		motivo = document.observacion.motivo.value
		//validar campos obligatorios
		if(observacion=="" || motivo=="")
		{
			mensaje = "<font color='#FF0000'><strong>Los Campos con asterico son obligatorios, motivo y observacion</strong></font>";
			document.getElementById('respuesta').innerHTML = mensaje;			
		}
		else
		{
			mensaje = "";
			document.getElementById('respuesta').innerHTML = mensaje;
			document.observacion.submit();
		}
	}
</script>
</head>
<body onBeforeUnload="return window.opener.mostrarAgenda();">
<form id="observacion" name="observacion" method="post" action="AccionDevolverEstudio.php">
<fieldset>

<legend><strong>Detalles de la cita</strong></legend>
<table width="100%" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#CCCCCC" style="color:#333"><strong>Paciente:</strong></td>
      </tr>
    <tr>
      <td>N° de identificacion: <strong><?php echo $reg['id_paciente'] ?></strong></td>
      <td>Nombres y Apellidos: <strong><?php echo $nombres ?></strong></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCCCCC" style="color:#333"><strong>Información del estudio:</strong>&nbsp;</td>
      </tr>
    <tr>
      <td>Estudio: <strong><?php echo $reg['nom_estudio']?></strong></td>
      <td>Tecnica: <strong><?php echo $reg['desc_tecnica']?></strong></td>
    </tr>
    <tr>
      <td>Fecha y hora: <strong><?php echo $reg['fecha'] ?></strong>/<strong><?php echo $reg['hora']?></strong></td>
      <td>Motivo:
        <label for="motivo"></label>
        <select name="motivo" id="motivo">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($regconsulta = mysql_fetch_array($consulta))
			{
				echo '<option value="'.$regconsulta['idmotivo'].'">'.$regconsulta['desc_motivo'].'</option>';
			}
		?>
        </select>
        <span class="asteris">*</span></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCCCCC" style="color:#333"><strong>Observacion:</strong></td>
    </tr>
    <tr>
      <td colspan="2"><textarea name="observacion" placeholder="Registre aqui sus comentarios y observaciones" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60"></textarea><span class="asteris">*</span></td>
    </tr>
    <tr>
      <td width="50%"><input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" />
      <input type="hidden" name="informe" id="informe" value="<?php echo $idInforme ?>" /><div id="respuesta"></div></td>
      <td width="50%" align="right"><input type="button" value="Agregar Observacion" onClick="enviarObservacion()" /></td>
    </tr>
  </table>

</fieldset>
  </form>
<!-- Mostrar las observaciones registradas durante el proceso -->
<fieldset>
<legend><strong>Observaciones:</strong></legend>
<?php
	//consultar cantidad de comentarios
	$sqlComentario = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora,CONCAT(f.nombres,' ', f.apellidos)  AS nombres
	FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	WHERE o.id_informe = '$idInforme'", $cn);
	$regComentario = mysql_num_rows($sqlComentario);
	echo '<table width="100%" border="0" align="center">';
	if($regComentario!=0 || $regComentario!="")
	{
		while($rowComentario = mysql_fetch_array($sqlComentario))
		{
			echo '<tr>
			<td><strong>'.$rowComentario['nombres'].'</strong>hizo la siguiente observación, a las <strong>'.$rowComentario['hora'].'</strong> del <strong>'.$rowComentario['fecha'].'</strong><br><textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">'.$rowComentario['observacion'].'</textarea></td>
			</tr>';
		}
	}
	echo '</table>';
?>
</fieldset>
</body>
</html>