<div class="col">
    <div class="card text-center">
        <div class="card-header">
            <!-- <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="device_switch_<?=$item["id"]?>" name="switch_<?=$item["id"]?>" <?=($item["force_on"] ? 'checked' : '')?>>
                <label class="form-check-label" for="device_switch_<?=$item["id"]?>"><?=($item["force_on"] ? "On" : "Off")?></label>
            </div> -->
            <span><?=($item["force_on"] ? "On" : "Off")?></span>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?=$item["name"]?></h5>
            <p class="card-text"></p>
            <a href="/device/view/<?=$item["id"]?>" class="btn btn-primary">More details</a>
        </div>
        <div class="card-footer text-muted">
            <?=$item["value"]?> gastos nas ultimas 48h
        </div>
    </div>
</div>