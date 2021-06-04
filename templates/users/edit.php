<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => (isset($detail["id"]) && $detail["id"] != 0 ? "User Edit - " . $detail["name"] : "New User")])?>
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
                                <?php if(!isset($detail["id"])){ ?>
                                <input type="hidden" name="type" value="create_admin">
                                <?php } ?>
                                <div class="mb-3">
                                    <label for="input_name" class="form-label">Name</label>
                                    <input type="text" id="input_name" class="form-control" placeholder="User Name" value="<?=$detail["name"]?>" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="input_email" class="form-label">Email</label>
                                    <input type="text" id="input_email" class="form-control" placeholder="User Name" value="<?=$detail["email"]?>" name="email">
                                </div>

                                <h4 class="mb-3">Role</h4>
                                <div class="my-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="radiobutton_admin" value="admin" <?=($detail["role"] == "admin" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="radiobutton_admin">
                                            Admin
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="radiobutton_gardener" value="gardener" <?=($detail["role"] == "gardener" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="radiobutton_gardener">
                                            Gardener
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="radiobutton_user" value="user" <?=($detail["role"] == "user" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="radiobutton_user">
                                            User
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="radiobutton_device" value="device" <?=($detail["role"] == "device" ? 'checked' : '')?>>
                                        <label class="form-check-label" for="radiobutton_device">
                                            Device
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" name="is_active" <?=($detail["is_active"] ? 'checked' : '')?> >
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