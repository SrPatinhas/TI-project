<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Logs List"])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "logs"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Logs List</h1>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Device</th>
                                        <th scope="col">Line/Position</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($list as $item) {
                                ?>
                                    <tr>
                                        <td><?=$item["name"]?></td>
                                        <td><?=$item["line"]?>/<?=$item["position"]?></td>
                                        <td><?=$item["value"]?><?=$item["category_unit"]?></td>
                                        <td><?=$item["date"]?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <?=$this->fetch('./layout/footer.php')?>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
        <script>
            const dataTable = new simpleDatatables.DataTable("#datatable");
        </script>
    </body>
</html>