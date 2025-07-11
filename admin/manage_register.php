<?php include 'db_connect.php' ?>

<?php
if(isset($_GET['id'])){
$booking = $conn->query("SELECT * from audience where id = ".$_GET['id']);
foreach($booking->fetch_array() as $k => $v){
    $$k = $v;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-register">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
        <div class="form-group">
            <label for="" class="control-label">Sự kiện</label>
            <select name="event_id" id="" class="custom-select select2">
                <option></option>
                <?php 
                $event = $conn->query("SELECT * FROM events order by event asc");
                while($row=$event->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($event_id) && $event_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['event']) ?></option>
            <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Họ tên</label>
            <input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Địa chỉ</label>
            <textarea cols="30" rows = "2" required="" name="address" class="form-control"><?php echo isset($address) ? $address :'' ?></textarea>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Liên hệ #</label>
            <input type="text" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
        </div>
       <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="payment_status" name="payment_status" <?php echo isset($payment_status) && $payment_status == 1 ? "checked" : '' ?>>
              <label class="form-check-label" for="payment_status">
                Paid
              </label>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Status</label>
            <select name="status" id="" class="custom-select">
                <option value="0" <?php echo isset($status) && $status == 0 ? "selected" : '' ?>>Chờ xác minh</option>
                <option value="1" <?php echo isset($status) && $status == 1 ? "selected" : '' ?>>Đã xác nhận</option>
                <option value="2" <?php echo isset($status) && $status == 2 ? "selected" : '' ?>>Đã hủy</option>
            </select>
        </div>
    </form>
</div>

<script>
    $('#manage-register').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_register',
            method:"POST",
            data:$(this).serialize(),
            success:function(resp){
                if(resp == 1){
                    alert_toast("Audience Registration successfully updated","success")
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    })
</script>