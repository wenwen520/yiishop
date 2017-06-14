<?=\yii\bootstrap\Html::a('添加',['admin/add'],['class'=>'btn btn-info btn-sm'])?>

<table class="table table-bordered table-striped">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>
    <?php foreach($admins as $admin):?>
        <tr>
            <td><?=$admin->id?></td>
            <td><?=$admin->username?></td>
            <td><?=date('Y-d-m G:i:s',$admin->login_time)?></td>
            <td><?=$admin->login_ip?></td>
            <td>


                <?=\yii\bootstrap\Html::a('修改',['admin/edit','id'=>$admin->id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('删除',['admin/delete','id'=>$admin->id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>