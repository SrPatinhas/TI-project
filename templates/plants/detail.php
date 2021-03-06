<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Plant Detail - " . $detail["name"]])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "plants"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <a href="/plants" class="text-dark text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </a>
                            Plant Detail
                        </h1>
                    </div>
                    <div class="row">
                        <form>
                            <fieldset disabled>
                                <legend>Plant Detail</legend>

                                <?php if(!empty($detail["cover"])) { ?>
                                    <div class="col-4 mb-3">
                                        <div class="card bg-dark text-white">
                                            <img src="<?= $detail["cover"] ?>" class="card-img" alt="<?= $detail["name"] ?>">
                                            <div class="card-img-overlay">
                                                <h5 class="card-title"><?= $detail["name"] ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Name</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="Plant Name" value="<?=$detail["name"]?>">
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
                                    <input type="text" id="webcamInput" class="form-control" placeholder="WebCam" value="<?=$detail["webcam"]?>">
                                </div>


                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" <?=($detail["is_active"] ? 'checked' : '')?> >
                                        <label class="form-check-label" for="disabledFieldsetCheck" >
                                            Is Active
                                        </label>
                                    </div>
                                </div>

                            </fieldset>
                        </form>

                        <a href="/plants/edit/<?=$detail["id"]?>" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                            Edit
                        </a>
                    </div>
                </main>
            </div>
        </div>
        <?=$this->fetch('./layout/footer.php')?>
    </body>
</html>