<div class="col">
    <div class="card">
        <img alt="<?=$item["name"]?>" class="card-img-top" src="<?=$item["cover"]?>">
        <div class="card-img-overlay text-white">
            <h5 class="card-title"><?= $item["name"] ?></h5>
        </div>
        <ul class="list-group list-group-flush">
            <?php
                foreach ($item["log"] as $log) {
                    if (!empty($log["value"])) {
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><b><?=$log["name"]?></b> <small>(<?=$log["date"]?>)</small></span>
                    <span class="badge bg-primary rounded-pill"><?=$log["value"]?></span>
                </li>
            <?php
                    }
                }
            ?>
        </ul>
        <div class="card-footer text-end">
            <a href="/plant/view/<?=$item["id"]?>" class="card-link">More details</a>
        </div>
    </div>
</div>