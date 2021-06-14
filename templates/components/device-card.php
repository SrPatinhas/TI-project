<div class="col">
    <div class="card text-center">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <?php if($item["type"] == "actuators") { ?>
                    <div class="form-switch">
                        <input class="form-check-input force_state" data-id="<?=$item["id"]?>" type="checkbox" id="device_switch_<?=$item["id"]?>" name="switch_<?=$item["id"]?>" <?=($item["force_on"] ? 'checked' : '')?>>
                        <label class="form-check-label" for="device_switch_<?=$item["id"]?>" id="force_state_label_<?=$item["id"]?>"><?=($item["force_on"] ? "On" : "Off")?></label>
                    </div>
                <?php } ?>
                <div class="form-switch">
                    <input class="form-check-input change_active" data-id="<?=$item["id"]?>" type="checkbox" id="device_active_<?=$item["id"]?>" name="active_<?=$item["id"]?>" <?=($item["is_active"] ? 'checked' : '')?>>
                    <label class="form-check-label" for="device_active_<?=$item["id"]?>" id="change_active_label_<?=$item["id"]?>"><?=($item["is_active"] ? "Active" : "Disabled")?></label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title" data-bs-toggle="tooltip" data-bs-placement="top" title="<?=$item["local_name"]?>"><?=$item["name"]?></h5>
            <p class="card-text"></p>
            <a href="/device/view/<?=$item["id"]?>" class="btn btn-primary">More details</a>
        </div>
        <div class="card-footer text-muted">
            Value to switch state: <?=$item["switch_value"]?>
        </div>
    </div>
</div>