<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <div class="container-fluid p-0">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">Smart Garden v1.0</a>

        <div class="dropdown text-end me-4">
            <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $user["name"] ?>
            </a>
            <ul class="dropdown-menu text-small dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownUser1" style="">
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</header>