<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => (isset($detail["id"]) && $detail["id"] != 0 ? "Device Detail" : "New Device")])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "devices"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <a href="/devices<?=(isset($detail["id"]) && $detail["id"] != 0 ? "/detail/" . $detail["id"] : "")?>" class="text-dark text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </a>
                            <?=(isset($detail["id"]) && $detail["id"] != 0 ? "Device Detail" : "New Device")?>
                        </h1>
                    </div>
                    <div class="row">
                        <form method="post" action="/devices/<?=(isset($detail["id"]) && $detail["id"] != 0 ? "update" : "create")?>">
                            <fieldset>
                                <legend>Device Edit</legend>
                                <input type="hidden" name="id" value="<?=$detail["id"]?>">
                                <div class="mb-3">
                                    <label for="input_name" class="form-label">Name</label>
                                    <input required type="text" id="input_name" class="form-control" placeholder="Name" name="name" value="<?=$detail["name"]?>">
                                </div>
                                <div class="mb-3">
                                    <label for="input_local_name" class="form-label">Local Name</label>
                                    <input required type="text" id="input_local_name" class="form-control" placeholder="Local Name" name="name_local" value="<?=$detail["name_local"]?>">
                                </div>

                                <div class="mb-3">
                                    <label for="input_description" class="form-label">Description</label>
                                    <textarea id="input_description" class="form-control" placeholder="Local Name" name="description" cols="3">
                                        <?=$detail["description"]?>
                                    </textarea>
                                </div>

                                <?=$this->fetch('./components/category.php', ["categories" => $categories, "selected" => $detail["category_id"]])?>

                                <?=$this->fetch('./components/device_bridge.php', ["devices" => $devices, "selected" => $detail["device_bridge_id"]])?>

                                <div class="mb-3">
                                    <label for="select_type" class="form-label">Type</label>
                                    <select id="select_type" class="form-select" name="type" required>
                                        <option value="" >Select an option</option>
                                        <option value="actuators" <?=($detail["type"] == "actuators" ? 'selected': '') ?>>Actuators</option>
                                        <option value="sensor" <?=($detail["type"] == "sensor" ? 'selected': '') ?>>Sensor</option>
                                        <option value="other" <?=($detail["type"] == "other" ? 'selected': '') ?>>Other</option>
                                    </select>
                                </div>


                                <h5 class="mb-3">Device Location in greenhouse</h5>
                                <div class="mb-3">
                                    <div class="greenhouse-grid">
                                        <?php
                                        $i = 0;
                                        while ($greenhouse['line'] > $i) {
                                            $i++;
                                            $j = 0;
                                            echo "<div class='grid-line'>";
                                            echo "<span>" . $i . "</span>";
                                            while ($greenhouse['position'] > $j) {
                                                $j++;
                                                echo "<input required class='d-none' type='radio' name='grid-position' id='radio_$i$j' value='$i-$j' " . ($detail["line"] == $i && $detail["position"] == $j ? 'checked="checked"' : '') .">";
                                                echo "<label class='grid-position' for='radio_$i$j'>$j</label>";
                                            }
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-6 col-md-4">
                                        <div class="range-wrap">
                                            <label for="range_min" class="form-label">Value % to switch the device status</label>
                                            <div class="range-value form-label" id="range_min_label"></div>
                                            <input id="range_min" class="form-range" type="range" min="-100" max="100" value="<?=$detail["switch_value"]?>" step="1" oninput="showVal('range_min', ' <?=$detail["measure"]?>')" name="switch_value">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="checkbox_temperature" name="force_on" <?=($detail["force_on"] ? 'checked' : '')?>>
                                            <label class="form-check-label" for="checkbox_temperature">Always Open</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkbox_isActive" name="is_active" <?=($detail["is_active"] ? 'checked' : '')?> >
                                        <label class="form-check-label" for="checkbox_isActive" >
                                            Is Active
                                        </label>
                                    </div>
                                </div>

                                <?php
                                    if(!empty($errors)) {
                                        foreach($errors as $key => $value){
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?=$value ?>
                                    </div>
                                <?php
                                        }
                                    }
                                ?>

                                <a href="/devices/detail/<?=$detail["id"]?>" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </fieldset>
                        </form>
                    </div>
                </main>
            </div>
        </div>
        <?=$this->fetch('./layout/footer.php')?>

        <script>
            document.addEventListener("DOMContentLoaded", startRangeInput());

            function startRangeInput() {
                showVal('range_min', ' <?=$detail["measure"]?>');
            }

            function showVal(name, unit){
                const range = document.getElementById(name);
                const range_label = document.getElementById(name + "_label" );
                const newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) );
                const newPosition = 10 - (newValue * 0.2);

                range_label.innerHTML = `<span>${range.value} ${unit}</span>`;
                range_label.style.left = `calc(${newValue}% + (${newPosition}px))`;
            }
        </script>
    </body>
</html>