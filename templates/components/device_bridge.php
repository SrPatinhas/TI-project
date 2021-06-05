<div class="mb-3">
    <label for="select_device_bridge" class="form-label">Connection Device</label>
    <select id="select_device_bridge" class="form-select" name="device_bridge_id" <?=(empty($devices) ? "" : "required" )?>>
        <option value="">[Type] > Select an option (Line - Position)</option>
        <?php foreach($devices as $item){ ?>
            <option value="<?=$item["id"]; ?>" <?=($selected == $item["id"] ? 'selected': '') ?> >[<?=$item['type']; ?>] > <?=$item['name']; ?> (<?=$item['line']; ?> - <?=$item['position']; ?>)</option>
        <?php } ?>
    </select>
</div>