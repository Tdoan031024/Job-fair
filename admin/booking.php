<?php include('db_connect.php');?>

<div class="container-fluid">
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
</style>
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Danh sách đặt chỗ địa điểm</b>
						<span class="">

							<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_book">
					<i class="fa fa-plus"></i> Mới</button>
				</span>
					</div>
					<div class="card-body">
						
						<table class="table table-bordered table-condensed table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Thông tin đặt chỗ</th>
									<th class="">Thông tin khách hàng</th>
									<th class="">Trạng thái</th>
									<th class="text-center">Hoạt động</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$booking = $conn->query("SELECT b.*,v.venue from venue_booking b inner join venue v on v.id = b.venue_id");
								while($row=$booking->fetch_assoc()):
									
								?>
								<tr>
									
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p>Địa điểm: <b><?php echo ucwords($row['venue']) ?></b></p>
										 <p><small>Lịch trình: <b><?php echo date("M d,Y h:i A",strtotime($row['datetime'])) ?></b></small></p>
										 <p><small>Khoảng thời gian: <?php echo ucwords($row['duration']) ?></small></p>
									</td>
									<td class="">
										 <p>Đã đặt bởi: <b><?php echo  ucwords($row['name']) ?></b></p>
										 <p><small>Email: <b><?php echo  ucwords($row['email']) ?></b></small></p>
										 <p><small>Liên hệ: <b><?php echo  ucwords($row['contact']) ?></b></small></p>
										 <p><small>Địa chỉ: <b><?php echo  ucwords($row['address']) ?></b></small></p>
									</td>
									<td class="text-center">
										 <?php if($row['status'] == 0): ?>
										 	<span class="badge badge-secondary">Chờ xác minh</span>
										 <?php elseif($row['status'] == 1): ?>
										 	<span class="badge badge-primary">Đã xác nhận</span>
										<?php elseif($row['status'] == 2): ?>
										 	<span class="badge badge-danger">Đã hủy</span>
										 <?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_book" type="button" data-id="<?php echo $row['id'] ?>" >Sửa</button>
										<?php if(in_array($row['status'],array(0,2))): ?>
										<button class="btn btn-sm btn-outline-danger delete_book" type="button" data-id="<?php echo $row['id'] ?>">Xóa</button>
										 <?php endif; ?>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#new_book').click(function(){
		uni_modal("New Entry","manage_booking.php")
	})
	
	$('.edit_book').click(function(){
		uni_modal("Manage Book Details","manage_booking.php?id="+$(this).attr('data-id'))
		
	})
	$('.delete_book').click(function(){
		_conf("Are you sure to delete this Person?","delete_book",[$(this).attr('data-id')])
	})

	function delete_book($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_book',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>