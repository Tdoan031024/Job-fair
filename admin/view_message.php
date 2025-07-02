<?php 
include('db_connect.php');
$contact = $conn->query("SELECT * FROM contact where id = ".$_GET['id']);
$row = $contact->fetch_assoc();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Họ và tên:</b> <?php echo $row['full_name'] ?></p>
                            <p><b>Tổ chức:</b> <?php echo $row['organization'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Email:</b> <?php echo $row['email'] ?></p>
                            <p><b>Liên hệ:</b> <?php echo $row['contact_method'] ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p><b>Thời gian gửi:</b> <?php echo date("M d, Y h:i A", strtotime($row['date_created'])) ?></p>
                            <p><b>Trạng thái:</b> 
                                <?php 
                                $status = ['Chờ xử lý', 'Đã xử lý', 'Đã phản hồi'];
                                echo $status[$row['status']];
                                ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Nội dung liên hệ:</h5>
                            <div class="border p-3" style="background:#f8f9fa; border-radius:5px;">
                                <?php echo nl2br(html_entity_decode($row['message'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button class="btn btn-secondary" onclick="window.history.back()">Đóng</button>
                        <?php if($row['status'] == 0): ?>
                            <button class="btn btn-primary ml-2" onclick="updateStatus(<?php echo $row['id'] ?>, 1)">Đánh dấu đã xử lý</button>
                        <?php endif; ?>
                        <button class="btn btn-success ml-2" onclick="updateStatus(<?php echo $row['id'] ?>, 2)">Đánh dấu đã phản hồi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateStatus(id, status){
        start_load()
        $.ajax({
            url:'ajax.php?action=update_contact_status',
            method:'POST',
            data:{id:id, status:status},
            success:function(resp){
                if(resp==1){
                    alert_toast("Cập nhật trạng thái thành công",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    }
</script>