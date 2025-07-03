<?php include '../views/layouts/header.php'; ?>
<style>
/* Copy style từ event.css */
<?php include '../assets/css/event.css';
?>
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container my-5">
    <h2 class="text-center mb-5 text-primary">🎉 Danh sách Sự kiện</h2>

    <?php foreach ($events as $row): ?>
    <div class="event-list-item">
        <div class="event-banner">
            <img src="../Assets/images/<?php echo htmlspecialchars($row['banner']); ?>" alt="Banner">
        </div>
        <div class="event-content">
            <div>
                <div class="event-title"><?php echo htmlspecialchars($row['event']); ?></div>
                <div class="event-info">
                    <p><i class="fa fa-calendar-alt"></i> <?php echo date("d/m/Y H:i", strtotime($row['schedule'])); ?>
                    </p>
                    <p><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['venue']); ?></p>
                    <p><i class="fa fa-ticket-alt"></i>
                        <?php echo $row['payment_type'] == 1 ? 'Miễn phí' : number_format($row['amount'], 0) . ' VND'; ?>
                    </p>
                </div>
            </div>
            <div class="event-actions">
                <a href="index.php?page=view_event&id=<?php echo $row['id']; ?>"
                    class="btn btn-outline-primary btn-detail">
                    Xem chi tiết
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>


<script>
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