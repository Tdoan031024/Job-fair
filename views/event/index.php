<?php include '../views/layouts/header.php'; ?>
<style>
/* Copy style từ event.php */
<?php include '../assets/css/event.css';
?>
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <h4 class="text-center text-white">Sự kiện sắp tới</h4>
    <hr class="divider">
    <?php while($row = $events->fetch_assoc()): ?>
    <?php
        $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
        $desc = strtr(html_entity_decode($row['description']),$trans);
        $desc = str_replace(array("<li>","</li>"), array("",","), $desc);
        ?>
    <div class="card event-list" data-id="<?php echo $row['id'] ?>">
        <div class='banner'>
            <?php if(!empty($row['banner'])): ?>
            <img src="../Assets/images/<?php echo($row['banner']) ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="row align-items-center justify-content-center text-center h-100">
                <div class="">
                    <h3><b class="filter-txt"><?php echo ucwords($row['event']) ?></b></h3>
                    <div><small>
                            <p><b><i class="fa fa-calendar"></i>
                                    <?php echo date("F d, Y h:i A",strtotime($row['schedule'])) ?></b></p>
                        </small></div>
                    <hr>
                    <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                    <br>
                    <hr class="divider" style="max-width: calc(80%)">
                    <button class="btn btn-primary float-right read_more" data-id="<?php echo $row['id'] ?>">Đọc
                        thêm</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php endwhile; ?>
</div>

<script>
$('.read_more').click(function() {
    location.href = "index.php?page=view_event&id=" + $(this).attr('data-id');
});
$('.banner img').click(function() {
    viewer_modal($(this).attr('src'));
});
$('#filter').keyup(function(e) {
    var filter = $(this).val();
    $('.card.event-list .filter-txt').each(function() {
        var txto = $(this).html();
        if ((txto.toLowerCase()).includes((filter.toLowerCase()))) {
            $(this).closest('.card').toggle(true);
        } else {
            $(this).closest('.card').toggle(false);
        }
    });
});
</script>

<?php include '../views/layouts/footer.php'; ?>