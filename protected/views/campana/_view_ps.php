<?php
$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$data->id));
?>

<tr <?php if($campana_ps) echo 'class="success"'; ?>>
	<td><input name="Check" class="check_ps" type="checkbox" value="<?php echo $data->id; ?>" <?php if($campana_ps) echo 'checked'; ?>></td>
	<td><?php echo CHtml::image($data->getAvatar(),'Avatar',array("width"=>"70", "height"=>"70")); ?></td>
	<td><strong> <span class="CAPS"><?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></span></strong><br>
	<strong>ID</strong>: <?php echo $data->id; ?></td>
	<td> <?php echo $data->email; ?> </td>
	<td>500 </td>
</tr>