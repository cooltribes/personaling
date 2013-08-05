<td>
		<div class="span6">
       		<article class="item">
       			<a href="<?php echo Yii::app()->baseUrl."/look/".$data->id; ?>">
       				<?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$data->id)), "Look", array("width" => "3770", "height" => "400")); ?>
           			<!-- <img width="370" height="400" alt="Look" src="http://www.personaling.com/site/look/getImage/3" class="" id="imglook3" style=""> -->
           		</a>
              
              <div class="hidden-phone margin_top_small vcard row-fluid">
                <div class="span2 avatar ">
                	<?php echo CHtml::image($data->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); ?>
                	<!-- <img width="40" alt="Avatar" src="http://www.personaling.com/site/images/avatar_provisional_2.jpg" class="photo img-circle"> -->
                </div>
                <div class="span5">
                	<span class="muted">Look creado por: </span>
                  	<h5>
                  		<a href="<?php echo Yii::app()->baseUrl."/user/profile/perfil/id/".$data->user->id; ?>" title="perfil" class="url">
                  			<span class="fn">
                  			<?php echo $data->user->profile->first_name.' '.$data->user->profile->last_name; ?>
                  			</span>
                  		</a>
                  	</h5>
                </div>
                <div class="span5"><span class="precio"><small>Bs.</small> <?php echo $data->getPrecio(); ?></span></div>
              </div>
              <div class="share_like">
                <button class="btn-link" title="Me encanta" href="#"><span class="entypo icon_personaling_big">&hearts;</span></button>
                <div class="btn-group">
                  <button data-toggle="dropdown" class="dropdown-toggle btn-link"><span class="entypo icon_personaling_big"></span></button>
                  <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                    <!-- AddThis Button BEGIN 
                                            
                                            <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                                            <li><a class="addthis_button_tweet"></a></li>
                                            <li><a class="addthis_button_pinterest_pinit"></a></li>
                                        </ul>
                                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                                             AddThis Button END -->
                    
                  </ul>
                </div>
              </div>
              <span class="label label-important">Promoción</span> </article>
		</div>
</td>