<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Device Detail"])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "devices"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <a href="/devices" class="text-dark text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </a>
                            Device Detail
                        </h1>
                    </div>
                    <div class="row">
                        <form>
                            <fieldset disabled>
                                <legend>Device Edit</legend>
                                <div class="mb-3">
                                    <label for="input_name" class="form-label">Name</label>
                                    <input type="text" id="input_name" class="form-control" placeholder="Name" name="name" value="<?=$detail["name"]?>">
                                </div>
                                <div class="mb-3">
                                    <label for="input_local_name" class="form-label">Local Name</label>
                                    <input type="text" id="input_local_name" class="form-control" placeholder="Local Name" name="name_local" value="<?=$detail["name_local"]?>">
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
                                    <select id="select_type" class="form-select" name="type">
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
                                                echo "<input class='d-none' type='radio' name='grid-position' id='radio_$j$i' value='$j-$i' " . ($detail["line"] == $i && $detail["position"] == $j ? 'checked="checked"' : '') .">";
                                                echo "<label class='grid-position' for='radio_$j$i'>$j</label>";
                                            }
                                            echo "</div>";
                                        }
                                        ?>
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
                            </fieldset>
                        </form>
                    </div>

                    <div class="mt-5 mb-5">
                        <?=$this->fetch('./components/chart.php', ["title" => "Last 15 records of this device", "dataset" => $datasets, "labels" => $labels])?>
                    </div>
                    <div class="row mt-5 mb-5">
                        <?=$this->fetch('./components/log-table.php', ["logs" => $logs, "table_type" => "device", "title" => "All entries in logs for this device"])?>
                    </div>
                </main>
            </div>
        </div>
        <?=$this->fetch('./layout/footer.php')?>
    </body>
</html>