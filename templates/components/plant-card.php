<div class="card">
    <img alt="<?=$item["name"]?>" class="card-img-top" src="<?=$item["cover"]?>">
    <div class="card-body">
        <h5 class="card-title"><?=$item["name"]?></h5>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Temperature
            <span class="badge bg-primary rounded-pill"><?=$item["temperature"]?> ºC</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Humidity
            <span class="badge bg-primary rounded-pill"><?=$item["humidity"]?>%</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Soil Moisture
            <span class="badge bg-primary rounded-pill"><?=$item["moisture"]?>%</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Light Intensity
            <span class="badge bg-primary rounded-pill"><?=$item["light"]?> lux</span>
        </li>
    </ul>
</div>