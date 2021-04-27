<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => $error["code"]])?>
        <!-- Custom styles for this template -->
        <link href="/assets/css/404.css" rel="stylesheet">
    </head>
    <body>
        <section class="page_404 container">
                <div class="row align-items-center">
                    <div class="col text-center align-self-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center "><?=$error["code"]?></h1>
                        </div>
                        <div class="contant_box_404">
                            <h3 class="h2">
                                Look like you're lost
                            </h3>
                            <p>the page you are looking for not available! (<?=$error["message"]?>)</p>
                            <a href="/" class="link_404">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>