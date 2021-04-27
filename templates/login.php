<!doctype html>
<html lang="pt-PT">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Login"])?>
        <!-- Custom styles for this template -->
        <link href="/assets/css/signin.css" rel="stylesheet">
    </head>
    <body class="text-center">
        <main class="form-signin">
            <form action="/login" method="POST" enctype="multipart/form-data">
                <img class="mb-4" src="assets/img/logo.png" alt="" width="72" height="57">
                <h1 class="h3 mb-3 fw-normal">Entrar</h1>

                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" >
                            <label for="floatingInput">Email</label>
                        </div>
                        <?php if (isset($message_error) && $message_error["email"] != '') { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $message_error["email"] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" >
                            <label for="floatingPassword">Password</label>
                        </div>
                        <?php if (isset($message_error) && $message_error["password"] != '') { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $message_error["password"] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                        <?php if (isset($message_error) && $message_error["data"] != '') { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $message_error["data"] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
                    </div>
                </div>

                <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
            </form>
        </main>
        <?=$this->fetch('./layout/footer.php')?>
        <script>
            var alertList = document.querySelectorAll('.alert')
            alertList.forEach(function (alert) {
                new bootstrap.Alert(alert)
            })
        </script>
    </body>
</html>
