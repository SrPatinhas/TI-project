<table class="table table-striped table-hover">
    <thead>
        <tr>
            <?php
                if($table_type == "plant") {
                    echo "<th scope='col'>Device</th>";
                }
            ?>
            <th scope="col">Category</th>
            <th scope="col">Value</th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($logs as $item){ ?>
            <tr>
                <?php
                    if($table_type == "plant") {
                        echo "<td>" . $item["device"]. "</td>";
                    }
                ?>
                <td><?=$item["category"]?></td>
                <td><?=$item["value"]?></td>
                <td><?=$item["date"]?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>