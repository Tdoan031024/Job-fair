<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_venue"){
	$save = $crud->save_venue();
	if($save)
		echo $save;
}
if($action == "save_book"){
	$save = $crud->save_book();
	if($save)
		echo $save;
}
if($action == "delete_book"){
	$save = $crud->delete_book();
	if($save)
		echo $save;
}

if($action == "save_register"){
	$save = $crud->save_register();
	if($save)
		echo $save;
}
if($action == "delete_register"){
	$save = $crud->delete_register();
	if($save)
		echo $save;
}
if($action == "delete_venue"){
	$save = $crud->delete_venue();
	if($save)
		echo $save;
}
if($action == "update_order"){
	$save = $crud->update_order();
	if($save)
		echo $save;
}
if($action == "delete_order"){
	$save = $crud->delete_order();
	if($save)
		echo $save;
}
if($action == "save_event"){
	$save = $crud->save_event();
	if($save)
		echo $save;
}
if($action == "delete_event"){
	$save = $crud->delete_event();
	if($save)
		echo $save;
}
if($action == "save_artist"){
	$save = $crud->save_artist();
	if($save)
		echo $save;
}
if($action == "delete_artist"){
	$save = $crud->delete_artist();
	if($save)
		echo $save;
}
if($action == "get_audience_report"){
	$get = $crud->get_audience_report();
	if($get)
		echo $get;
}
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}
if($action == "get_pdetails"){
	$get = $crud->get_pdetails();
	if($get)
		echo $get;
}

// Thêm vào sau các action khác
if($action == 'update_contact_status'){
    $save = $crud->update_contact_status();
    if($save)
        echo $save;
}

if($action == 'delete_message'){
    $save = $crud->delete_message();
    if($save)
        echo $save;
}

if($action == 'get_companies') {
    $search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';
    $linh_vuc = isset($_POST['linh_vuc']) ? intval($_POST['linh_vuc']) : 0;
    $quy_mo = isset($_POST['quy_mo']) ? $conn->real_escape_string($_POST['quy_mo']) : '';
    
    // Xây dựng query với prepared statement để tránh SQL injection
    $query = "SELECT d.*, l.ten_linh_vuc FROM doanh_nghiep d 
              LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id 
              WHERE d.trang_thai = 1";
    
    $conditions = [];
    $params = [];
    $types = '';
    
    if (!empty($search)) {
        $conditions[] = "d.ten_cong_ty LIKE ?";
        $params[] = "%$search%";
        $types .= 's';
    }
    
    if (!empty($linh_vuc)) {
        $conditions[] = "d.linh_vuc_id = ?";
        $params[] = $linh_vuc;
        $types .= 'i';
    }
    
    if (!empty($quy_mo)) {
        $conditions[] = "d.quy_mo = ?";
        $params[] = $quy_mo;
        $types .= 's';
    }
    
    if (!empty($conditions)) {
        $query .= " AND " . implode(" AND ", $conditions);
    }
    
    $query .= " ORDER BY d.ten_cong_ty ASC";
    
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $doanh_nghiep = $stmt->get_result();
    
    ob_start();
    ?>
    <?php if($doanh_nghiep->num_rows > 0): ?>
        <?php while($row = $doanh_nghiep->fetch_assoc()): ?>
            <div class="col-md-12">
                <div class="card company-list">
                    <div class="d-flex">
                        <div class="logo-container">
                            <?php if(!empty($row['logo'])): ?>
                                <img src="admin/assets/uploads/<?php echo $row['logo'] ?>" alt="<?php echo $row['ten_cong_ty'] ?>">
                            <?php else: ?>
                                <img src="admin/assets/uploads/default_company.png" alt="Logo mặc định">
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="company-info">
                                <h3><?php echo $row['ten_cong_ty'] ?></h3>
                                <p><i class="fa fa-map-marker"></i> <?php echo $row['dia_chi'] ?></p>
                                <p><i class="fa fa-phone"></i> <?php echo $row['so_dien_thoai'] ?></p>
                                <p><i class="fa fa-envelope"></i> <?php echo $row['email'] ?></p>
                                <p><i class="fa fa-globe"></i> <a href="<?php echo $row['website'] ?>" target="_blank"><?php echo $row['website'] ?></a></p>
                                <div class="mt-2">
                                    <span class="industry"><?php echo $row['ten_linh_vuc'] ?></span>
                                    <span class="size"><?php echo $row['quy_mo'] ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center mt-3">
                                <button class="btn btn-primary view-detail" data-id="<?php echo $row['id'] ?>">
                                    <i class="fa fa-info-circle mr-1"></i> Xem chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">Không tìm thấy doanh nghiệp nào phù hợp.</div>
        </div>
    <?php endif; ?>
    <?php
    $html = ob_get_clean();
    echo json_encode(['status' => 'success', 'html' => $html]);
}

if($action == 'get_jobs'){
    $get = $crud->get_jobs();
    if($get)
        echo $get;
}

if($action == 'save_job'){
    $save = $crud->save_job();
    if($save)
        echo $save;
}

if($action == 'delete_job'){
    $save = $crud->delete_job();
    if($save)
        echo $save;
}
if($action == 'get_company'){
    echo $crud->get_company();
    exit;
}

if($action == 'save_company'){
    echo $crud->save_company();
    exit;
}

if($action == 'delete_company'){
    $id = $_POST['id'];
    // Get logo path before delete
    $logo = $crud->db->query("SELECT logo FROM doanh_nghiep WHERE id = $id")->fetch_assoc()['logo'];
    
    $delete = $crud->db->query("DELETE FROM doanh_nghiep WHERE id = $id");
    if($delete){
        // Delete logo file
        if($logo && file_exists('../admin/assets/uploads/'.$logo)){
            unlink('../admin/assets/uploads/'.$logo);
        }
        echo 1;
    }else{
        echo json_encode(array('status'=>'error','error'=>$crud->db->error));
    }
    exit;
}

if($action == 'update_company_status'){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $update = $crud->db->query("UPDATE doanh_nghiep SET trang_thai = $status WHERE id = $id");
    if($update){
        echo 1;
    }else{
        echo json_encode(array('status'=>'error','error'=>$crud->db->error));
    }
    exit;
}

if($action == 'get_job'){
    $id = $_POST['id'];
    $stmt = $crud->db->prepare("SELECT * FROM viec_lam WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        echo json_encode(['status'=>'success', 'data'=>$result->fetch_assoc()]);
    } else {
        echo json_encode(['status'=>'error', 'msg'=>'Không tìm thấy việc làm']);
    }
    exit;
}

if($action == 'get_linhvuc') {
    echo $crud->get_linhvuc();
    exit;
}

if($action == 'save_linhvuc') {
    echo $crud->save_linhvuc();
    exit;
}

if($action == 'delete_linhvuc') {
    echo $crud->delete_linhvuc();
    exit;
}

// Banner Slides Actions
if($action == 'save_banner'){
    include 'db_connect.php';
    
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $conn->real_escape_string($_POST['title']);
    $subtitle = $conn->real_escape_string($_POST['subtitle']);
    $button_text = $conn->real_escape_string($_POST['button_text']);
    $button_link = $conn->real_escape_string($_POST['button_link']);
    $sort_order = intval($_POST['sort_order']);
    $is_active = intval($_POST['is_active']);
    
    $image_name = '';
    
    // Handle file upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)) {
            $image_name = time() . '_' . $filename;
            $upload_path = 'assets/uploads/' . $image_name;
            
            if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // File uploaded successfully
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Không thể upload file']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Định dạng file không được hỗ trợ']);
            exit;
        }
    }
    
    if($id > 0) {
        // Update existing banner
        if(!empty($image_name)) {
            $sql = "UPDATE banner_slides SET title = ?, subtitle = ?, button_text = ?, button_link = ?, sort_order = ?, is_active = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssiisi", $title, $subtitle, $button_text, $button_link, $sort_order, $is_active, $image_name, $id);
        } else {
            $sql = "UPDATE banner_slides SET title = ?, subtitle = ?, button_text = ?, button_link = ?, sort_order = ?, is_active = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssiii", $title, $subtitle, $button_text, $button_link, $sort_order, $is_active, $id);
        }
    } else {
        // Insert new banner
        if(empty($image_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng chọn hình ảnh']);
            exit;
        }
        $sql = "INSERT INTO banner_slides (title, subtitle, button_text, button_link, sort_order, is_active, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiis", $title, $subtitle, $button_text, $button_link, $sort_order, $is_active, $image_name);
    }
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi lưu dữ liệu']);
    }
}

if($action == 'get_banner'){
    include 'db_connect.php';
    
    $id = intval($_POST['id']);
    $sql = "SELECT * FROM banner_slides WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy banner']);
    }
}

if($action == 'delete_banner'){
    include 'db_connect.php';
    
    $id = intval($_POST['id']);
    
    // Get image name before deleting
    $sql = "SELECT image FROM banner_slides WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = 'assets/uploads/' . $row['image'];
        
        // Delete file if exists
        if(file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Delete from database
    $sql = "DELETE FROM banner_slides WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xóa banner']);
    }
}