<section class="py-5 text-center">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">No data to show for <?=$type?></h1>
            <p>
                <?php if ($type == "devices") { ?>
                <a href="/devices/new" class="btn btn-primary my-2">Add Devices</a>
                <?php } ?>
                <?php if ($type == "plants") { ?>
                <a href="/plants/new" class="btn btn-secondary my-2">Add Plants</a>
                <?php } ?>
            </p>
        </div>
    </div>
</section>