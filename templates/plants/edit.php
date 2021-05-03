<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => (isset($detail["id"]) && $detail["id"] != 0 ? "Plant Edit - " . $detail["name"] : "New Plant")])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "plants"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <a href="/plants<?=(isset($detail["id"]) && $detail["id"] != 0 ? "/detail/" . $detail["id"] : "")?>" class="text-dark text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </a>
                            <?=(isset($detail["id"]) && $detail["id"] != 0 ? "Plant Detail" : "New Plant")?>
                        </h1>
                    </div>
                    <div class="row">
                        <form method="post" action="/plants/<?=(isset($detail["id"]) && $detail["id"] != 0 ? "update" : "create")?>">
                            <fieldset>
                                <legend>Plant Detail</legend>
                                <input type="hidden" name="id" value="<?=$detail["id"]?>">
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Name</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="Plant Name" name="name" value="<?=$detail["name"]?>">
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

                                <div class="mb-3">
                                    <label for="webcamInput" class="form-label">WebCam</label>
                                    <input type="text" id="webcamInput" class="form-control" placeholder="WebCam" name="webcam" value="<?=$detail["webcam"]?>">
                                </div>


                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" name="is_active" <?=($detail["is_active"] ? 'checked' : '')?> >
                                        <label class="form-check-label" for="disabledFieldsetCheck" >
                                            Is Active
                                        </label>
                                    </div>
                                </div>

                                <img src="<?= $detail["cover"] ?>" alt="<?=$detail["name"]?>">

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

                                <a href="/plants/detail/<?=$detail["id"]?>" class="btn btn-secondary">
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
    </body>
</html>