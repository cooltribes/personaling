<?php
/* @var $this CampanaController */

$this->breadcrumbs=array(
	'Campañas'=>array('/campana'),
	'Crear',
);
?>
<div class="container margin_top">

  <div class="page-header">
    <h1>Crear Campaña</h1>
  </div>
  <div class="row">
    
     
     	<?php echo $this->renderPartial('_form', array('model'=>$campana)); ?>
     
    
    
  </div>
</div>
<!-- /container -->
<script>
	$('#recepcion_inicio_day').on('change', validar_recepcion_inicio);
	$('#recepcion_inicio_month').on('change', validar_recepcion_inicio);
	$('#recepcion_inicio_year').on('change', validar_recepcion_inicio);
	
	$('#recepcion_fin_day').on('change', validar_recepcion_fin);
	$('#recepcion_fin_month').on('change', validar_recepcion_fin);
	$('#recepcion_fin_year').on('change', validar_recepcion_fin);
	
	$('#ventas_inicio_day').on('change', validar_ventas_inicio);
	$('#ventas_inicio_month').on('change', validar_ventas_inicio);
	$('#ventas_inicio_year').on('change', validar_ventas_inicio);
	
	$('#ventas_fin_day').on('change', validar_ventas_fin);
	$('#ventas_fin_month').on('change', validar_ventas_fin);
	$('#ventas_fin_year').on('change', validar_ventas_fin);
	
	$(document).on('ready', set_dates);
	
	function set_dates(){
        if($('#Campana_recepcion_inicio').val() != ''){
          	var array_fecha_hora = $('#Campana_recepcion_inicio').val().split(' ');
            var array_fecha = array_fecha_hora[0].split('-');
            $('#recepcion_inicio_day').val(array_fecha[2]);
            $('#recepcion_inicio_month').val(array_fecha[1]);
            $('#recepcion_inicio_year').val(array_fecha[0]);
        }
        
        if($('#Campana_recepcion_fin').val() != ''){
          	var array_fecha_hora = $('#Campana_recepcion_fin').val().split(' ');
            var array_fecha = array_fecha_hora[0].split('-');
            $('#recepcion_fin_day').val(array_fecha[2]);
            $('#recepcion_fin_month').val(array_fecha[1]);
            $('#recepcion_fin_year').val(array_fecha[0]);
        }
        
        if($('#Campana_ventas_inicio').val() != ''){
          	var array_fecha_hora = $('#Campana_ventas_inicio').val().split(' ');
            var array_fecha = array_fecha_hora[0].split('-');
            $('#ventas_inicio_day').val(array_fecha[2]);
            $('#ventas_inicio_month').val(array_fecha[1]);
            $('#ventas_inicio_year').val(array_fecha[0]);
        }
        
        if($('#Campana_ventas_fin').val() != ''){
          	var array_fecha_hora = $('#Campana_ventas_fin').val().split(' ');
            var array_fecha = array_fecha_hora[0].split('-');
            $('#ventas_fin_day').val(array_fecha[2]);
            $('#ventas_fin_month').val(array_fecha[1]);
            $('#ventas_fin_year').val(array_fecha[0]);
        }
	}
	
	function validar_recepcion_inicio(){
		var day = $('#recepcion_inicio_day').val();
		var month = $('#recepcion_inicio_month').val();
		var year = $('#recepcion_inicio_year').val();
		
		//console.log('validar');
		if(day != '-1' && month != '-1' && year != '-1'){
			if(validar_fecha(day, month, year)){
				$('#Campana_recepcion_inicio').val(year+'-'+month+'-'+day+' 00:00:01');
			}else{
				$('#recepcion_inicio_day').val('-1');
				$('#recepcion_inicio_month').val('-1');
				$('#recepcion_inicio_year').val('-1');
			}
		}
	}
	
	function validar_recepcion_fin(){
		var day = $('#recepcion_fin_day').val();
		var month = $('#recepcion_fin_month').val();
		var year = $('#recepcion_fin_year').val();
		
		//console.log('validar');
		if(day != '-1' && month != '-1' && year != '-1'){
			console.log('pasa');
			if(validar_fecha(day, month, year)){
				$('#Campana_recepcion_fin').val(year+'-'+month+'-'+day+' 00:00:01');
			}else{
				$('#recepcion_fin_day').val('-1');
				$('#recepcion_fin_month').val('-1');
				$('#recepcion_fin_year').val('-1');
			}
		}
	}
	
	function validar_ventas_inicio(){
		var day = $('#ventas_inicio_day').val();
		var month = $('#ventas_inicio_month').val();
		var year = $('#ventas_inicio_year').val();
		
		//console.log('validar');
		if(day != '-1' && month != '-1' && year != '-1'){
			if(validar_fecha(day, month, year)){
				$('#Campana_ventas_inicio').val(year+'-'+month+'-'+day+' 00:00:01');
			}else{
				$('#ventas_inicio_day').val('-1');
				$('#ventas_inicio_month').val('-1');
				$('#ventas_inicio_year').val('-1');
			}
		}
	}
	
	function validar_ventas_fin(){
		var day = $('#ventas_fin_day').val();
		var month = $('#ventas_fin_month').val();
		var year = $('#ventas_fin_year').val();
		
		//console.log('validar');
		if(day != '-1' && month != '-1' && year != '-1'){
			if(validar_fecha(day, month, year)){
				$('#Campana_ventas_fin').val(year+'-'+month+'-'+day+' 00:00:01');
			}else{
				$('#ventas_fin_day').val('-1');
				$('#ventas_fin_month').val('-1');
				$('#ventas_fin_year').val('-1');
			}
		}
	}
	
	function validar_fecha(dia, mes, anio){
        var numDias = 31;
        
        //console.log('Dia: '+dia+' - Mes: '+mes+' - Año: '+anio);
        
        if(mes == 4 || mes == 6 || mes == 9 || mes == 11){
            numDias = 30;
        }
        
        if(mes == 2){
            if(comprobarSiBisisesto(anio)){
                numDias = 29;
            }else{
                numDias = 28;
            }
        }
        
        if(dia > numDias){
            return false;
        }
        return true;
    }
    
    function comprobarSiBisisesto(anio){
        if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
            return true;
        }
        else {
            return false;
        }
    }
</script>