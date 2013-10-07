<?php
$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$data->id));

$looks = Look::model()->findAllByAttributes(array('user_id'=>$data->id));
$contador = 0;

$sql = "select count( distinct(a.tbl_orden_id) ) as total from tbl_orden_has_productotallacolor a, tbl_look b where a.look_id = b.id and b.user_id = ".$data->id;
$total = Yii::app()->db->createCommand($sql)->queryScalar();

?>

<tr <?php if($campana_ps) echo 'class="success"'; ?>>
	<td><input name="Check" class="check_ps" type="checkbox" value="<?php echo $data->id; ?>" <?php if($campana_ps) echo 'checked'; ?>></td>
	<td><?php echo CHtml::image($data->getAvatar(),'Avatar',array("width"=>"70", "height"=>"70")); ?></td>
	<td><strong> <span class="CAPS"><?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></span></strong><br>
	<strong>ID</strong>: <?php echo $data->id; ?></td>
	<td> <?php echo $data->email; ?> </td>
	<td><?php echo $total; ?></td>
</tr>