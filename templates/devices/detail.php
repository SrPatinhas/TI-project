<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Users List"])?>
        <!-- Custom styles for this template -->
        <link href="/assets/css/dashboard.css" rel="stylesheet">
        <link href="/assets/css/settings.css" rel="stylesheet">
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "users"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <a href="/users" class="text-dark text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </a>
                            User Detail
                        </h1>
                    </div>
                    <div class="row">
                        <form>
                            <fieldset disabled>
                                <legend>User Detail</legend>
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
                                            echo "<input class='d-none' type='radio' name='flexRadioDefault' id='radio_$j$i' disabled>";
                                            echo "<label class='grid-position' for='radio_$j$i'>$j</label>";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </fieldset>
                        </form>
                        <a href="/users/edit/<?=$detail["id"]?>" class="btn btn-primary">
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