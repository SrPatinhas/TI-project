<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Webcams List"])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "webcams"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Webcams</h1>
                    </div>
                    <div class="row">
                        <div class="row row-cols-1 row-cols-md-4 g-6">

                            <?php foreach($webcams as $item){ ?>
                            <div class="col mb-5">
                                <div class="card h-100">
                                    <?php if(str_ends_with($item["webcam"], 'mjpg')){ ?>
                                        <img src="<?=$item["webcam"]?>" class="card-img-top" alt="<?=$item["name"]?>">
                                    <?php } else { ?>
                                        <video src="<?=$item["webcam"]?>" class="card-img-top" poster="/assets/img/no_image.png" autoplay muted></video>
                                    <?php } ?>
                                    <div class="card-footer">
                                        <small class="text-muted">Plant: <b><?=$item["name"]?></b> - Grid: <?=$item["line"]?>/<?=$item["position"]?></small>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </main>
            </div>
        </div>
        <?=$this->fetch('./layout/footer.php')?>
    </body>
</html>