<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col"><?=($table_type == "device" ?  "Plant" : "Device")?></th>
            <th scope="col">Category</th>
            <th scope="col">Value</th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($logs as $item){ ?>
            <tr>
                <td><?=($table_type == "device" ?  $item["plant"] : $item["device"])?></td>
                <td><?=$item["category"]?></td>
                <td><?=$item["value"]?><?=$item["category_unit"]?></td>
                <td><?=$item["date"]?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>