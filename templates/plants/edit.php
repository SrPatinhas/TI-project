<!doctype html>
<html lang="en">
<head>
    <?=$this->fetch('./layout/header.php', ["title" => "Plant Edit - " . $detail["name"]])?>
    <!-- Custom styles for this template -->
    <link href="/assets/css/dashboard.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
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
                <form method="post" action="/plants/<?=($detail["id"] != 0 ? "update" : "create")?>">
                    <fieldset>
                        <legend>Plant Detail</legend>
                        <input type="hidden" name="id" value="<?=$detail["id"]?>">
                        <input type="hidden" name="cover" value="<?= $detail["cover"] ?>">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input type="text" id="nameInput" class="form-control" name="name" placeholder="Plant Name" value="<?=$detail["name"]?>">
                        </div>
                        <div class="mb-3">
                            <label for="locationInput" class="form-label">Location</label>
                            <input type="text" id="locationInput" class="form-control" name="location" placeholder="Location" value="<?=$detail["location"]?>">
                        </div>
                        <div class="mb-3">
                            <label for="webcamInput" class="form-label">WebCam</label>
                            <input type="text" id="webcamInput" class="form-control" name="webcam" placeholder="WebCam" value="<?=$detail["webcam"]?>">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?=($detail["is_active"] ? 'checked' : '')?> >
                                <label class="form-check-label" for="is_active" >
                                    Is Active
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                </form>
                <form action="/filepond/process" method="post" enctype="multipart/form-data">
                    <input type="file" name="filepond[]" value="<?= $detail["cover"] ?>">
                </form>
            </div>
        </main>
    </div>
</div>
<?=$this->fetch('./layout/footer.php')?>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="/assets/js/filepond.js"></script>
</body>
</html>