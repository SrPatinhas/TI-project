<div class="card text-center">
    <div class="card-header">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="lights_switch">
            <label class="form-check-label" for="lights_switch">Ligada</label>
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?=$item["name"]?></h5>
        <p class="card-text"></p>
        <a href="/device/view/<?=$item["view"]?>" class="btn btn-primary">Ver detalhes</a>
    </div>
    <div class="card-footer text-muted">
        <?=$item["value"]?> gastos nas ultimas 48h
    </div>
</div>