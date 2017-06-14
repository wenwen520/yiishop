<table class="table">
    <tr>
        <td>日期</td>
        <td>当前添加</td>
    </tr>
    <?php foreach($count as $c ):?>
        <tr>
            <td><?=$c->day?></td>
            <td><?=$c->count.'条'?></td>
        </tr>
    <?php endforeach;?>
</table>