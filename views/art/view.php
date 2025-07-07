<?php include '../views/layouts/header.php'; ?>
<style>
.imgs {
    margin: .5em;
    max-width: 100%;
    max-height: 100%;
}

.imgs img {
    max-width: 100%;
    max-height: 100%;
    cursor: pointer;
}

#content {
    border-left: 1px solid gray;
}

header.masthead {
    min-height: 20vh !important;
    height: 20vh !important;
}
</style>

<header class="masthead"></header>
<section>
    <div class="container-field">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <?php
                                $images = array();
                                $fpath = 'assets/uploads/artist_' . $art['id'];
                                if (is_dir($fpath)) {
                                    $images = scandir($fpath);
                                    foreach ($images as $k => $v):
                                        if (!in_array($v, array('.', '..'))):
                                ?>
                                <div class="imgs">
                                    <img src="<?php echo $fpath . '/' . $v ?>" alt="">
                                </div>
                                <?php
                                        else:
                                            unset($images[$v]);
                                        endif;
                                    endforeach;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-8" id="content">
                            <h4 class="text-center"><b><?php echo ucwords($art['art_title']) ?></b></h4>
                            <hr class="divider">
                            <center><small><?php echo ucwords($art['aname']) ?></small></center>
                            <center>
                                <?php if ($fs): ?>
                                <div>
                                    <span class="badge badge-success">For Sale</span>
                                    <span class="badge badge-secondary"><i class="fa fa-tag"></i>
                                        <?php echo number_format($fs['price'], 2) ?></span>
                                    <span class="badge badge-primary"><a href="javascript:void(0)"
                                            class="order_this text-white"
                                            data-id="<?php echo $fs['id'] ?>">Buy</a></span>
                                </div>
                                <?php endif; ?>
                            </center>
                            <br>
                            <?php echo html_entity_decode($art['art_description']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$('.imgs img').click(function() {
    viewer_modal($(this).attr('src'));
});
$('.order_this').click(function() {
    uni_modal("Request Order", "index.php?page=manage_order&fs_id=" + $(this).attr('data-id'));
});
</script>

<?php include 'views/layouts/footer.php'; ?>