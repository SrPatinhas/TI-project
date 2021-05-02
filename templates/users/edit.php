<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => (isset($detail["id"]) && $detail["id"] != 0 ? "User Edit - " . $detail["name"] : "New User")])?>
        <!-- Custom styles for this template -->
        <link href="/assets/css/dashboard.css" rel="stylesheet">
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "users"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <a href="/users/detail/<?=$detail["id"]?>" class="text-dark text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </a>
                            <?=(isset($detail["id"]) && $detail["id"] != 0 ? "User Detail" : "New User")?>
                        </h1>
                    </div>
                    <div class="row">
                        <form method="post" action="/users/<?=(isset($detail["id"]) && $detail["id"] != 0 ? "update" : "create")?>">
                            <fieldset>
                                <legend>User Edit</legend>
                                <input type="hidden" name="id" value="<?=$detail["id"]?>">
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Name</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="User Name" value="<?=$detail["name"]?>">
                                </div>
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Email</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="User Name" value="<?=$detail["email"]?>">
                                </div>

                                <h4 class="mb-3">Role</h4>
                                <div class="my-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" <?=($detail["role"] == "admin" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Admin
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" <?=($detail["role"] == "gardener" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Gardener
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" <?=($detail["role"] == "user" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            User
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" <?=($detail["is_active"] ? 'checked' : '')?> >
                                        <label class="form-check-label" for="disabledFieldsetCheck" >
                                            Is Active
                                        </label>
                                    </div>
                                </div>

                                <a href="/users/detail/<?=$detail["id"]?>" class="btn btn-secondary">
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