<?php include '../views/layouts/header.php'; ?>

<style>
/* Copy style từ about.php */
<?php include '../assets/css/view_event.css';
?>
</style>

<style>
<?php if ( !empty($event['banner'])): ?>header.masthead {
    background: url(assets/uploads/<?php echo $event['banner'] ?>);
    background-repeat: no-repeat;
    background-size: cover;
}

<?php endif;
?>
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-4 align-self-end mb-4 pt-2 page-title">
                <h4 class="text-center text-white"><b><?php echo ucwords($event['event']) ?></b></h4>
                <hr class="divider my-4" />
                <p class="text-center text-white"><small><b><i>Địa điểm:
                                <?php echo ucwords($event['venue']) ?></i></b></small></p>
            </div>
        </div>
    </div>
</header>
<section></section>
<div class="container">
    <div class="col-lg-12">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12"></div>
                    <div class="col-md-12" id="content">
                        <div id="imagesCarousel" class="carousel slide col-sm-4 float-left ml-0 mx-4"
                            data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $images = array();
                                $fpath = 'assets/uploads/event_' . $event['id'];
                                if (is_dir($fpath)) {
                                    $images = scandir($fpath);
                                    $i = 1;
                                    foreach ($images as $k => $v):
                                        if (!in_array($v, array('.', '..'))):
                                            $active = $i == 1 ? 'active' : '';
                                ?>
                                <div class="carousel-item <?php echo $active ?>">
                                    <img class="img-fluid" src="<?php echo $fpath . '/' . $v ?>" alt="">
                                </div>
                                <?php
                                            $i++;
                                        else:
                                            unset($images[$v]);
                                        endif;
                                    endforeach;
                                }
                                ?>
                                <a class="carousel-control-prev" href="#imagesCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#imagesCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <ol class="carousel-indicators">
                                <?php for ($v = 0; $v < ($i - 1); $v++): ?>
                                <li data-target="#imagesCarousel" data-slide-to="<?php echo $v ?>"
                                    class="<?php echo ($v == 0) ? 'active' : '' ?>"></li>
                                <?php endfor; ?>
                            </ol>
                        </div>
                        <p>
                        <p><b><i class="fa fa-calendar"></i>
                                <?php echo date("F d, Y h:i A", strtotime($event['schedule'])) ?></b></p>
                        <?php echo html_entity_decode($event['description']); ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr class="divider" style="max-width: 100%;" />
                        <div class="text-center">
                            <button class="btn btn-primary" id="register" type="button">Đăng ký</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#imagesCarousel img, #banner img').click(function() {
    viewer_modal($(this).attr('src'));
});
$('#register').click(function() {
    uni_modal("Submit Registration Request", "index.php?page=registration&event_id=<?php echo $event['id'] ?>");
});
</script>

<?php include 'views/layouts/footer.php'; ?>