<tr>
    <?php foreach($albums as $album):?>
    <td><?=\yii\bootstrap\Html::img([$album->photo],['style'=>'width:100px'])?> </td>
    <?php endforeach;?>
</tr>



