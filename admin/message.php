<?php include('db_connect.php');?>

<div class="container-fluid">
<style>
    input[type=checkbox] {
        -ms-transform: scale(1.5);
        -moz-transform: scale(1.5);
        -webkit-transform: scale(1.5);
        -o-transform: scale(1.5);
        transform: scale(1.5);
        padding: 10px;
    }
    .search-box {
        margin-bottom: 20px;
        position: relative;
    }
    .search-box input {
        padding-left: 40px;
        border-radius: 20px;
    }
    .search-box i {
        position: absolute;
        left: 15px;
        top: 10px;
        color: #6c757d;
    }
    .status-badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 10px;
    }
    .message-preview {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Responsive styles */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .card-header .btn-group {
            margin-top: 10px;
            width: 100%;
            justify-content: space-between;
        }
        .card-header .btn-group button {
            flex: 1;
            margin: 2px;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        .dropdown-menu {
            position: absolute !important;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .message-preview {
            max-width: 150px;
        }
    }
</style>

<div class="col-lg-12">
    <!--
    <div class="row mb-4 mt-4">
        <div class="col-md-12">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" id="searchContact" class="form-control" placeholder="Tìm kiếm liên hệ...">
            </div>
        </div>
        -->
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <b>Danh sách liên hệ</b>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-secondary" type="button" id="filter_all">Tất cả</button>
                        <button class="btn btn-sm btn-outline-primary" type="button" id="filter_new">Mới</button>
                        <button class="btn btn-sm btn-outline-success" type="button" id="filter_processed">Đã xử lý</button>
                        <button class="btn btn-sm btn-outline-info" type="button" id="filter_responded">Đã phản hồi</button>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover" id="contactTable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Thông tin người gửi</th>
                                    <th class="">Nội dung</th>
                                    <th class="">Thời gian</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $contacts = $conn->query("SELECT * FROM contact ORDER BY date_created DESC");
                                while($row = $contacts->fetch_assoc()):
                                    $message = html_entity_decode($row['message']);
                                    $message = strip_tags($message);
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="">
                                        <p><b><?php echo ucwords($row['full_name']) ?></b></p>
                                        <p><small>Tổ chức: <?php echo $row['organization'] ?></small></p>
                                        <p><small>Email: <?php echo $row['email'] ?></small></p>
                                        <p><small>Liên hệ: <?php echo $row['contact_method'] ?></small></p>
                                    </td>
                                    <td class="message-preview" title="<?php echo $message ?>">
                                        <?php echo $message ?>
                                    </td>
                                    <td class="">
                                        <?php echo date("M d, Y h:i A", strtotime($row['date_created'])) ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 0): ?>
                                            <span class="badge badge-secondary status-badge">Chờ xử lý</span>
                                        <?php elseif($row['status'] == 1): ?>
                                            <span class="badge badge-primary status-badge">Đã xử lý</span>
                                        <?php elseif($row['status'] == 2): ?>
                                            <span class="badge badge-success status-badge">Đã phản hồi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_message" type="button" 
                                            data-id="<?php echo $row['id'] ?>">
                                            <i class="fa fa-eye"></i> <span class="d-none d-md-inline">Xem</span>
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item mark_processed" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Đánh dấu đã xử lý</a>
                                                <a class="dropdown-item mark_responded" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Đánh dấu đã phản hồi</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_message" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Xóa</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Khởi tạo DataTable với responsive
        var table = $('#contactTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
            },
            "responsive": true,
            "autoWidth": false,
            "columnDefs": [
                { "responsivePriority": 1, "targets": 0 }, // Số thứ tự
                { "responsivePriority": 2, "targets": 4 }, // Trạng thái
                { "responsivePriority": 3, "targets": 5 }, // Thao tác
                { "responsivePriority": 4, "targets": 1 }, // Thông tin người gửi
                { "responsivePriority": 5, "targets": 2 }, // Nội dung
                { "responsivePriority": 6, "targets": 3 }  // Thời gian
            ]
        });
        
        // Tìm kiếm liên hệ
        $('#searchContact').keyup(function(){
            table.search($(this).val()).draw();
        });
        
        // Lọc theo trạng thái
        $('#filter_all').click(function(){
            table.columns(4).search('').draw();
        });
        $('#filter_new').click(function(){
            table.columns(4).search('Chờ xử lý').draw();
        });
        $('#filter_processed').click(function(){
            table.columns(4).search('Đã xử lý').draw();
        });
        $('#filter_responded').click(function(){
            table.columns(4).search('Đã phản hồi').draw();
        });
        
        // Xem chi tiết liên hệ
        $('.view_message').click(function(){
            uni_modal("Chi tiết liên hệ","view_message.php?id="+$(this).attr('data-id'), "large")
        });
        
        // Đánh dấu đã xử lý
        $('.mark_processed').click(function(){
            _conf("Bạn chắc chắn đánh dấu liên hệ này là ĐÃ XỬ LÝ?","update_status",[$(this).attr('data-id'), 1])
        });
        
        // Đánh dấu đã phản hồi
        $('.mark_responded').click(function(){
            _conf("Bạn chắc chắn đánh dấu liên hệ này là ĐÃ PHẢN HỒI?","update_status",[$(this).attr('data-id'), 2])
        });
        
        // Xóa liên hệ
        $('.delete_message').click(function(){
            _conf("Bạn chắc chắn muốn xóa liên hệ này?","delete_message",[$(this).attr('data-id')])
        });
    });
    
    function update_status(id, status){
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
    
    function delete_message(id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_message',
            method:'POST',
            data:{id:id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Xóa liên hệ thành công",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    }
</script>