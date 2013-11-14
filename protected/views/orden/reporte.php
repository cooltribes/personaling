<?php 
echo "REPORTE";
$n=0;
foreach($dataProvider->getData() as $data){
	$n++;	
	foreach($data->ohptc as $ptc){
		echo $n." ".$ptc->preciotallacolor_id." ".$ptc->cantidad."<br/>";
	}
} 





	$template = '<br/><br/>
				<div style="width:100%">
					<div  style="width:auto; float:left;"> 
					{summary}
					</div>
					<div  style="width:50%; float:right"> 
					{sorter}
					</div>
			 	 
			 	
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <thead>
			  <tr> 

			      <th>Marca</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th>Color</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Precio sin IVA</th>
                    <th>Precio con IVA</th>
                </tr>
			    </thead>
			    <tbody>
			    {items}
				</tbody>
			    </table>
			   
			    {pager}
				';
				
				
		
	Yii::app()->clientScript->registerScript('handle_ajax_function', "
			function setValues()
			{
				
				for(var i=0; i<arr.length;i++){
					$('#'+arr[i]).val(arr2[i]);
				}
			}
			");



		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_authitem',
	    'template'=>$template,
	    //'enableSorting'=>true,
	   // 'afterAjaxUpdate'=>'setValues',
	    
	    
	   
	 					
	));


















?>  
