<style>
	.infinite_navigation{
		display:none;
	}
	.pshopper{
		height:400px;
	}
</style>
<div class="container">
  <div class="page-header">
    <h1>Nuestros Personal Shoppers</h1>  
  </div>
  <div class="alert in" id="alert-msg" style="display: none">
    <button type="button" class="close" >&times;</button> 
    <!--data-dismiss="alert"-->
    <div class="msg"></div>
  </div>
</div>

<div class="container" id="personal_shoppers">
<?php 
  

$this->renderPartial('_pshoppers',array(
	'profs'=>$profs,
	'pages'=>$pages,
));
?>
</div>
  
<!-- /container -->
<?php
function replace_accents($string) 
{ 
  return str_replace( array(' ','à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('','a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string); 
} 
?>




    
      
      
    
    

<script type="text/javascript">
    

 
    

// here is the magic
function refresh()
{
	//alert($('.check_ocasiones').serialize());
	//alert($('.check_ocasiones').length) 
       
       
    cargarLocal();
    <?php echo CHtml::ajax(array(
            'url'=>array('tienda/look'),
            'data'=> "js:$('.check_ocasiones, .check_shopper, #newFilter-form').serialize()",
            //'data' => array( 'ocasiones' => 55 ),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogColor div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogColor div.divForForm form').submit(addColor);
                }
                else
                {
                   //	alert(data.condicion);
                   $('#tienda_looks').html(data.div);
                   // setTimeout(\"$('#dialogColor').modal('hide') \",3000);
                }
                
                
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
