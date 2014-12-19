<style>
    .not-toload{background-color: #DDD} 
    .not-toload>h3{padding-top:15%} 
    .toload{border: 3px solid #DDD; cursor:pointer}
    
</style>

<div class="container margin_top_large">
    <div class="content">
        <div style="width:500px; margin:50px auto 0 auto">
            <div class="row-fluid margin_bottom_small"> 
                <div onclick="modal('banner',1,1,1);"  class="span12 margin_bottom_small toload" id="banner" style="height:220px;">
                    <?php echo $siteIm->getImage('banner');?>
                </div>
                <div class="span9 no_margin_left">
                    <div onclick="modal('slider',1,1,1);"  class="margin_bottom_small toload" id="slider" style="height:190px;">
                        <?php echo $siteIm->getImage('slider');?>
                    </div>
                    <div class="margin_bottom_small not-toload text_align_center" style="height:190px; ">
                        <h3>Looks</h3>
                    </div>
                    <div class="not-toload text_align_center" style="width:100%; height:167px;">
                        <h3>Personal Shoppers</h3>
                    </div>
                    
                
                </div>
                <div class="span3">
                    <div onclick="modal('art',1,1,3);" class="margin_bottom_small toload" id="art1" style=" height:130px;"></div>
                    <div onclick="modal('art',2,1,3);" class="margin_bottom_small toload" id="art2" style=" height:130px;"></div>
                    <div onclick="modal('art',3,1,3);" class="margin_bottom_small toload" id="art3" style="height:130px;"></div>
                    <div onclick="modal('art',4,1,3);" class="toload" id="art4" style=" height:130px;"></div>
                </div>
                
            </div>
            <div class="row-fluid no_margin_left">
                <div class="span12 margin_bottom_small no_margin_left not-toload text_align_center" style="height:50px;">
                    <h4>Productos</h4>
                </div>
                <div class="span12 margin_bottom_small no_margin_left not-toload text_align_center" style="height:50px;">
                    <h4>NewsLetter y Redes</h4>
                </div>
                <div class="span12 margin_bottom_small no_margin_left" style="">
                    <div class"row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <div onclick="modal('magazine',1,1,3);" class="span2 toload" style="height:50px;"></div>
                                <div onclick="modal('magazine',2,1,3);" class="span2 toload" style="height:50px;"></div>
                                <div onclick="modal('magazine',3,1,3);" class="span2 toload" style="height:50px;"></div>
                                <div onclick="modal('magazine',4,1,3);" class="span2 toload" style="height:50px;"></div>
                                <div onclick="modal('magazine',5,1,3);" class="span2 toload" style="height:50px;"></div>
                                <div onclick="modal('magazine',6,1,3);" class="span2 toload" style="height:50px;"></div>
                            </div>
                        </div>
                        <div class="span5">
                            <div class="row-fluid">
                                <div onclick="modal('organization',1,1,3);" class="span3 offset2 toload" style="height:50px;"></div>
                                <div onclick="modal('organization',2,1,3);" class="span3 toload" style="height:50px;"></div>
                                <div onclick="modal('organization',3,1,3);" class="span3 toload" style="height:50px;"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            
            
        </div>
        
        
    </div>


    
</div>
<div class="modal hide fade" id="toLoad">
</div>
<script>
function modal(name,index,group,type){ 
        
      $.ajax({ 
                      url: "formSiteImage",
                      type: "post",
                      datatype:'json',
                      data: {
                        name:name,
                        index:index,
                        group:group,
                        type:type,
                        
                        
                         },
                      success: function(data){
                          console.log(data);
                          var obj=JSON.parse(data);
                          if(!obj.confirm){
                              $('#toLoad').html(obj.form);    
                              $('#toLoad').modal(); 
                          }else{
                              if(confirm("Al cargar una imagen sobrescribirás la actual. ¿Deseas sobrescribir la imagen?")){
                                  $('#toLoad').html(obj.form);    
                                    $('#toLoad').modal(); 
                              }
                          }
                                              
                      },
                      error:function(){
                  
                      }
                });
}    
    
    
</script>


