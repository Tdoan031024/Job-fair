<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
Class Action {
    //private $db;
    public $db; // Thêm dòng này để khai báo thuộc tính

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }
    
    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		if($type == 1)
			$establishment_id = 0;
		$data .= ", establishment_id = '$establishment_id' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['settings'][$key] = $value;
		}

			return 1;
				}
	}

	
	function save_venue(){
		extract($_POST);
		$data = " venue = '$venue' ";
		$data .= ", address = '$address' ";
		$data .= ", description = '$description' ";
		$data .= ", rate = '$rate' ";
		if(empty($id)){
			//echo "INSERT INTO arts set ".$data;
			$save = $this->db->query("INSERT INTO venue set ".$data);
			if($save){
				$id = $this->db->insert_id;
				$folder = "assets/uploads/venue_".$id;
				if(is_dir($folder)){
					$files = scandir($folder);
					foreach($files as $k =>$v){
						if(!in_array($v, array('.','..'))){
							unlink($folder."/".$v);
						}
					}
				}else{
					mkdir($folder);
				}
				if(isset($img)){
				for($i = 0 ; $i< count($img);$i++){
						$img[$i]= str_replace('data:image/jpeg;base64,', '', $img[$i] );
						$img[$i] = base64_decode($img[$i]);
						$fname = $id."_".strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents($folder."/".$fname,$img[$i]);
					}
				}
			}
		}else{
			$save = $this->db->query("UPDATE venue set ".$data." where id=".$id);
			if($save){
				$folder = "assets/uploads/venue_".$id;
				if(is_dir($folder)){
					$files = scandir($folder);
					foreach($files as $k =>$v){
						if(!in_array($v, array('.','..'))){
							unlink($folder."/".$v);
						}
					}
				}else{
					mkdir($folder);
				}

				if(isset($img)){
				for($i = 0 ; $i< count($img);$i++){
						$img[$i]= str_replace('data:image/jpeg;base64,', '', $img[$i] );
						$img[$i] = base64_decode($img[$i]);
						$fname = $id."_".strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents($folder."/".$fname,$img[$i]);
					}
				}
			}
		}
		if($save)
			return 1;
	}
	function delete_venue(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM venue where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_book(){
		extract($_POST);
		$data = " venue_id = '$venue_id' ";
		$data .= ", name = '$name' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", datetime = '$schedule' ";
		$data .= ", duration = '$duration' ";
		if(isset($status))
		$data .= ", status = '$status' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO venue_booking set ".$data);
		}else{
			$save = $this->db->query("UPDATE venue_booking set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_book(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM venue_booking where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_register(){
		extract($_POST);
		$data = " event_id = '$event_id' ";
		$data .= ", name = '$name' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		if(isset($status))
		$data .= ", status = '$status' ";
		if(isset($payment_status))
		$data .= ", payment_status = '$payment_status' ";
		else
		$data .= ", payment_status = '0' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO audience set ".$data);
		}else{
			$save = $this->db->query("UPDATE audience set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_register(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM audience where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_event(){
		extract($_POST);
		$data = " event = '$event' ";
		$data .= ",venue_id = '$venue_id' ";
		$data .= ", schedule = '$schedule' ";
		$data .= ", audience_capacity = '$audience_capacity' ";
		if(isset($payment_status))
		$data .= ", payment_type = '$payment_status' ";
		else
		$data .= ", payment_type = '2' ";
		if(isset($type))
			$data .= ", type = '$type' ";
		else
		$data .= ", type = '1' ";
			$data .= ", amount = '$amount' ";
		$data .= ", description = '".htmlentities(str_replace("'","&#x2019;",$description))."' ";
		if($_FILES['banner']['tmp_name'] != ''){
						$_FILES['banner']['name'] = str_replace(array("(",")"," "), '', $_FILES['banner']['name']);
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['banner']['name'];
						$move = move_uploaded_file($_FILES['banner']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", banner = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO events set ".$data);
			if($save){
				$id = $this->db->insert_id;
				$folder = "assets/uploads/event_".$id;
				if(is_dir($folder)){
					$files = scandir($folder);
					foreach($files as $k =>$v){
						if(!in_array($v, array('.','..'))){
							unlink($folder."/".$v);
						}
					}
				}else{
					mkdir($folder);
				}
				if(isset($img)){
				for($i = 0 ; $i< count($img);$i++){
						$img[$i]= str_replace('data:image/jpeg;base64,', '', $img[$i] );
						$img[$i] = base64_decode($img[$i]);
						$fname = $id."_".strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents($folder."/".$fname,$img[$i]);
					}
				}
			}
		}else{
			$save = $this->db->query("UPDATE events set ".$data." where id=".$id);
			if($save){
				$folder = "assets/uploads/event_".$id;
				if(is_dir($folder)){
					$files = scandir($folder);
					foreach($files as $k =>$v){
						if(!in_array($v, array('.','..'))){
							unlink($folder."/".$v);
						}
					}
				}else{
					mkdir($folder);
				}

				if(isset($img)){
				for($i = 0 ; $i< count($img);$i++){
						$img[$i]= str_replace('data:image/jpeg;base64,', '', $img[$i] );
						$img[$i] = base64_decode($img[$i]);
						$fname = $id."_".strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents($folder."/".$fname,$img[$i]);
					}
				}
			}
		}
		if($save)
			return 1;
	}
	function delete_event(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM events where id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function get_audience_report(){
		extract($_POST);
		$data = array();
		$event = $this->db->query("SELECT e.*,v.venue FROM events e inner join venue v on v.id = e.venue_id  where e.id = $event_id")->fetch_array();
		foreach($event as $k=>$v){
			if(!is_numeric($k))
			$data['event'][$k]=$v;
		}
		$audience = $this->db->query("SELECT * FROM audience where status = 1 and event_id = $event_id");
		if($audience->num_rows > 0):
			while($row=$audience->fetch_assoc()){
				$row['pstatus'] = $data['event']['payment_type'] == 1 ? "N/A" : ($row['status'] == 1 ? "Paid":'Unpaid');
				$data['data'][]=$row;
			}
		endif;
		return json_encode($data);

	}
	function get_venue_report(){
		extract($_POST);
		$data = array();
		$date = $month.'-01';
		$venue = $this->db->query("SELECT * FROM venue where id = $venue_id")->fetch_array();
		foreach($venue as $k=>$v){
			if(!is_numeric($k))
			$data['venue'][$k]=$v;
		}
		$data['venue']['month']=date("F, d",strtotime($date));
		// echo "SELECT * FROM event where date_format(schedule,'%Y-%m') = '$month' and venue = $venue_id";
		$event = $this->db->query("SELECT * FROM events where date_format(schedule,'%Y-%m') = '$month' and id = $venue_id");
		if($event->num_rows > 0):
			while($row=$event->fetch_assoc()){
				$row['fee'] = $row['payment_type'] == 1 ? "FREE" : number_format($row['amount'],2);
				$row['etype'] = $row['type'] == 1 ? "Public" : "Private";
				$row['sched'] = date("M d,Y h:i A",strtotime($row['schedule']));
				$data['data'][]=$row;
			}
		endif;
		return json_encode($data);

	}
	function save_art_fs(){
		extract($_POST);
		$data = " art_id = '$art_id' ";
		$data .= ", price = '$price' ";
		if(isset($status)){
		$data .= ", status = '$status' ";
		}
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO arts_fs set ".$data);
			
		}else{
			$save = $this->db->query("UPDATE arts_fs set ".$data." where id=".$id);
		}
		if($save){

			return json_encode(array("status"=>1,"id"=>$id));
		}
	}
	function delete_art_fs(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM arts_fs where id = ".$id);
		if($delete){
				return 1;
			}
	}
	function delete_order(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM orders where id = ".$id);
		if($delete){
				return 1;
			}
	}
	function update_order(){
		extract($_POST);
		$order = $this->db->query("UPDATE orders set status = $status, deliver_schedule = '$deliver_schedule' where id= $order_id ");
		if($order_id){
			if(in_array($status,array(1,3))){
				$fs = $this->db->query("UPDATE arts_fs set status = 1 where id = $fs_id ");
			}else{
				$fs = $this->db->query("UPDATE arts_fs set status = 0 where id = $fs_id ");
			}
			if($fs)
			return 1;
		}
	}
	// Cập nhật trạng thái liên hệ (sử dụng prepared statement)
    public function update_contact_status() {
        $stmt = $this->db->prepare("UPDATE contact SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $_POST['status'], $_POST['id']);
        return $stmt->execute() ? 1 : 0;
    }

    // Xóa tin nhắn (sử dụng prepared statement)
    public function delete_message() {
        $stmt = $this->db->prepare("DELETE FROM contact WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        return $stmt->execute() ? 1 : 0;
    }

    // Lấy danh sách việc làm (sử dụng prepared statement)
    public function get_jobs() {
        $stmt = $this->db->prepare("SELECT v.*, d.ten_cong_ty, d.logo 
                                   FROM viec_lam v 
                                   JOIN doanh_nghiep d ON v.doanh_nghiep_id = d.id 
                                   WHERE v.trang_thai = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        return json_encode($result->fetch_all(MYSQLI_ASSOC));
    }

    // Lưu việc làm (sử dụng prepared statement)
    public function save_job() {
        $data = [];
        $fields = [];
        $types = '';
        
        foreach($_POST as $k => $v) {
            if($k != 'id') {
                $fields[] = "$k=?";
                $data[] = $v;
                $types .= is_int($v) ? 'i' : 's';
            }
        }
        
        if(empty($_POST['id'])) {
            $fields[] = "ngay_tao=NOW()";
            $sql = "INSERT INTO viec_lam SET " . implode(", ", $fields);
        } else {
            $sql = "UPDATE viec_lam SET " . implode(", ", $fields) . " WHERE id=?";
            $data[] = $_POST['id'];
            $types .= 'i';
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$data);
        
        if($stmt->execute()) {
            return 1;
        } else {
            return json_encode(['status'=>'error', 'error'=>$stmt->error]);
        }
    }

    // Xóa việc làm (sử dụng prepared statement)
    public function delete_job() {
        $stmt = $this->db->prepare("DELETE FROM viec_lam WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        
        if($stmt->execute()) {
            return 1;
        } else {
            return json_encode(['status'=>'error', 'error'=>$stmt->error]);
        }
    }

    // Lấy thông tin doanh nghiệp (sử dụng prepared statement)
    public function get_company() {
        $stmt = $this->db->prepare("SELECT * FROM doanh_nghiep WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            return json_encode(['status'=>'success', 'data'=>$result->fetch_assoc()]);
        } else {
            return json_encode(['status'=>'error', 'msg'=>'Không tìm thấy doanh nghiệp']);
        }
    }

    // Lưu thông tin doanh nghiệp (sử dụng prepared statement)
    public function save_company() {
		$data = [];
		$fields = [];
		$types = '';
		
		// Kiểm tra trùng email (với bản ghi khác)
		if (!empty($_POST['email'])) {
			$email = $_POST['email'];
			$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
			$sqlCheck = "SELECT id FROM doanh_nghiep WHERE email = ? AND id != ?";
			$stmtCheck = $this->db->prepare($sqlCheck);
			$stmtCheck->bind_param("si", $email, $id);
			$stmtCheck->execute();
			$stmtCheck->store_result();
			if ($stmtCheck->num_rows > 0) {
				return json_encode(['status'=>'error', 'error'=>'Email đã tồn tại ở doanh nghiệp khác!']);
			}
		}
	
		foreach($_POST as $k => $v) {
			if(!in_array($k, ['id', 'logo'])) {
				$fields[] = "$k=?";
				$data[] = $v;
				$types .= is_int($v) ? 'i' : 's';
			}
		}
		
		// Xử lý upload logo
		$logoName = null;
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
			$allowed = ['jpg', 'jpeg', 'png', 'gif'];
			$ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
			
			if(in_array($ext, $allowed)) {
				$logoName = 'company_'.time().'.'.$ext;
				$uploadPath = '../admin/assets/uploads/'.$logoName;
				
				if(move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
					$fields[] = "logo=?";
					$data[] = $logoName;
					$types .= 's';
					
					// Xóa logo cũ nếu có
					if(!empty($_POST['id'])) {
						$oldLogo = $this->db->query("SELECT logo FROM doanh_nghiep WHERE id = ".$_POST['id'])->fetch_assoc()['logo'];
						if($oldLogo && file_exists('../admin/assets/uploads/'.$oldLogo)) {
							unlink('../admin/assets/uploads/'.$oldLogo);
						}
					}
				}
			}
		}
		
		if(empty($_POST['id'])) {
			$fields[] = "ngay_tao=NOW()";
			$sql = "INSERT INTO doanh_nghiep SET " . implode(", ", $fields);
		} else {
			$sql = "UPDATE doanh_nghiep SET " . implode(", ", $fields) . " WHERE id=?";
			$data[] = $_POST['id'];
			$types .= 'i';
		}
		
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param($types, ...$data);
		
		if($stmt->execute()) {
			return 1;
		} else {
			// Xóa file vừa upload nếu có lỗi
			if($logoName && file_exists('../admin/assets/uploads/'.$logoName)) {
				unlink('../admin/assets/uploads/'.$logoName);
			}
			return json_encode(['status'=>'error', 'error'=>$stmt->error]);
		}
	}

    // Xóa doanh nghiệp (sử dụng prepared statement)
    public function delete_company() {
        // Lấy thông tin logo trước khi xóa
        $stmt = $this->db->prepare("SELECT logo FROM doanh_nghiep WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $logo = $stmt->get_result()->fetch_assoc()['logo'];
        
        // Xóa doanh nghiệp
        $stmt = $this->db->prepare("DELETE FROM doanh_nghiep WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        
        if($stmt->execute()) {
            // Xóa file logo nếu tồn tại
            if($logo && file_exists('../admin/assets/uploads/'.$logo)) {
                unlink('../admin/assets/uploads/'.$logo);
            }
            return 1;
        } else {
            return json_encode(['status'=>'error', 'error'=>$stmt->error]);
        }
    }

    // Cập nhật trạng thái doanh nghiệp (sử dụng prepared statement)
    public function update_company_status() {
        $stmt = $this->db->prepare("UPDATE doanh_nghiep SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("ii", $_POST['status'], $_POST['id']);
        
        if($stmt->execute()) {
            return 1;
        } else {
            return json_encode(['status'=>'error', 'error'=>$stmt->error]);
        }
    }
	// Thêm vào class Action
	public function update_multiple_company_status() {
		if(!empty($_POST['ids']) && is_array($_POST['ids'])) {
			$ids = implode(',', array_map('intval', $_POST['ids']));
			$status = intval($_POST['status']);
			
			$stmt = $this->db->prepare("UPDATE doanh_nghiep SET trang_thai = ? WHERE id IN ($ids)");
			$stmt->bind_param("i", $status);
			
			if($stmt->execute()) {
				return 1;
			} else {
				return json_encode(['status'=>'error', 'error'=>$stmt->error]);
			}
		}
		return 0;
	}
	// Lấy thông tin lĩnh vực theo id
	public function get_linhvuc() {
		$stmt = $this->db->prepare("SELECT * FROM linh_vuc WHERE id = ?");
		$stmt->bind_param("i", $_POST['id']);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			return json_encode(['status'=>'success', 'data'=>$result->fetch_assoc()]);
		} else {
			return json_encode(['status'=>'error', 'msg'=>'Không tìm thấy lĩnh vực']);
		}
	}

	// Thêm/sửa lĩnh vực
	public function save_linhvuc() {
		$ten_linh_vuc = trim($_POST['ten_linh_vuc']);
		$mo_ta = isset($_POST['mo_ta']) ? trim($_POST['mo_ta']) : '';
		if(empty($ten_linh_vuc)) {
			return json_encode(['status'=>'error', 'msg'=>'Tên lĩnh vực không được để trống']);
		}
		if(empty($_POST['id'])) {
			// Thêm mới
			$stmt = $this->db->prepare("INSERT INTO linh_vuc (ten_linh_vuc, mo_ta) VALUES (?, ?)");
			$stmt->bind_param("ss", $ten_linh_vuc, $mo_ta);
			if($stmt->execute()) {
				return 1;
			} else {
				return json_encode(['status'=>'error', 'msg'=>$stmt->error]);
			}
		} else {
			// Sửa
			$stmt = $this->db->prepare("UPDATE linh_vuc SET ten_linh_vuc=?, mo_ta=? WHERE id=?");
			$stmt->bind_param("ssi", $ten_linh_vuc, $mo_ta, $_POST['id']);
			if($stmt->execute()) {
				return 1;
			} else {
				return json_encode(['status'=>'error', 'msg'=>$stmt->error]);
			}
		}
	}

	// Xóa lĩnh vực
	public function delete_linhvuc() {
		$stmt = $this->db->prepare("DELETE FROM linh_vuc WHERE id = ?");
		$stmt->bind_param("i", $_POST['id']);
		if($stmt->execute()) {
			return 1;
		} else {
			return json_encode(['status'=>'error', 'msg'=>$stmt->error]);
		}
	}

    public function get_cv_guide_blogs() {
        $res = $this->db->query("SELECT * FROM cv_guide_blog ORDER BY ngay_tao DESC");
        $data = [];
        while($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }
    public function save_cv_guide_blog() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $tieu_de = $this->db->real_escape_string($_POST['tieu_de']);
        $tom_tat = $this->db->real_escape_string($_POST['tom_tat']);
        $noi_dung = $this->db->real_escape_string($_POST['noi_dung']);
        $trang_thai = isset($_POST['trang_thai']) ? intval($_POST['trang_thai']) : 1;
        $hinh_anh = '';
        $old_image = '';
        if($id > 0) {
            // Lấy ảnh cũ trước khi update
            $res_img = $this->db->query("SELECT hinh_anh FROM cv_guide_blog WHERE ma_bai_viet=$id");
            if($res_img && $res_img->num_rows > 0) {
                $old_image = $res_img->fetch_assoc()['hinh_anh'];
            }
        }
        if(isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['tmp_name']) {
            $fname = time().'_'.$_FILES['hinh_anh']['name'];
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'assets/uploads/'.$fname);
            $hinh_anh = $fname;
            // Nếu update và có ảnh cũ, xóa file ảnh cũ
            if($id > 0 && $old_image && file_exists('assets/uploads/'.$old_image)) {
                @unlink('assets/uploads/'.$old_image);
            }
        } else if(isset($_POST['hinh_anh_old'])) {
            $hinh_anh = $this->db->real_escape_string($_POST['hinh_anh_old']);
        }
        if($id > 0) {
            $sql = "UPDATE cv_guide_blog SET tieu_de='$tieu_de', tom_tat='$tom_tat', noi_dung='$noi_dung', trang_thai=$trang_thai";
            if($hinh_anh) $sql .= ", hinh_anh='$hinh_anh'";
            $sql .= " WHERE ma_bai_viet=$id";
        } else {
            $sql = "INSERT INTO cv_guide_blog (tieu_de, tom_tat, noi_dung, hinh_anh, trang_thai) VALUES ('$tieu_de', '$tom_tat', '$noi_dung', '$hinh_anh', $trang_thai)";
        }
        $res = $this->db->query($sql);
        return $res ? 1 : 0;
    }
    public function delete_cv_guide_blog() {
        $id = intval($_POST['id']);
        // Lấy tên file ảnh trước khi xóa
        $res_img = $this->db->query("SELECT hinh_anh FROM cv_guide_blog WHERE ma_bai_viet=$id");
        $img = ($res_img && $res_img->num_rows > 0) ? $res_img->fetch_assoc()['hinh_anh'] : '';
        $res = $this->db->query("DELETE FROM cv_guide_blog WHERE ma_bai_viet=$id");
        if($res && $img && file_exists('assets/uploads/'.$img)) {
            @unlink('assets/uploads/'.$img);
        }
        return $res ? 1 : 0;
    }
    public function get_cv_guide_samples() {
        $res = $this->db->query("SELECT * FROM cv_guide_sample ORDER BY ngay_tao DESC");
        $data = [];
        while($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }
    public function save_cv_guide_sample() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $tieu_de = $this->db->real_escape_string($_POST['tieu_de']);
        $mo_ta = $this->db->real_escape_string($_POST['mo_ta']);
        $hinh_anh = '';
        $tep_tin = '';
        if(isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['tmp_name']) {
            $fname = time().'_'.$_FILES['hinh_anh']['name'];
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'assets/uploads/'.$fname);
            $hinh_anh = $fname;
        } else if(isset($_POST['hinh_anh_old'])) {
            $hinh_anh = $this->db->real_escape_string($_POST['hinh_anh_old']);
        }
        if(isset($_FILES['tep_tin']) && $_FILES['tep_tin']['tmp_name']) {
            $fname2 = time().'_'.$_FILES['tep_tin']['name'];
            move_uploaded_file($_FILES['tep_tin']['tmp_name'], 'assets/uploads/'.$fname2);
            $tep_tin = $fname2;
        } else if(isset($_POST['tep_tin_old'])) {
            $tep_tin = $this->db->real_escape_string($_POST['tep_tin_old']);
        }
        if($id > 0) {
            $sql = "UPDATE cv_guide_sample SET tieu_de='$tieu_de', mo_ta='$mo_ta'";
            if($hinh_anh) $sql .= ", hinh_anh='$hinh_anh'";
            if($tep_tin) $sql .= ", tep_tin='$tep_tin'";
            $sql .= " WHERE ma_mau_cv=$id";
        } else {
            $sql = "INSERT INTO cv_guide_sample (tieu_de, mo_ta, hinh_anh, tep_tin) VALUES ('$tieu_de', '$mo_ta', '$hinh_anh', '$tep_tin')";
        }
        $res = $this->db->query($sql);
        return $res ? 1 : 0;
    }
    public function delete_cv_guide_sample() {
        $id = intval($_POST['id']);
        $res = $this->db->query("DELETE FROM cv_guide_sample WHERE ma_mau_cv=$id");
        return $res ? 1 : 0;
    }
    public function get_cv_guide_videos() {
        $res = $this->db->query("SELECT * FROM cv_guide_video ORDER BY ngay_tao DESC");
        $data = [];
        while($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }
    public function save_cv_guide_video() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $tieu_de = $this->db->real_escape_string($_POST['tieu_de']);
        $link = $this->db->real_escape_string($_POST['link']);
        if($id > 0) {
            $sql = "UPDATE cv_guide_video SET tieu_de='$tieu_de', link='$link' WHERE id=$id";
        } else {
            $sql = "INSERT INTO cv_guide_video (tieu_de, link) VALUES ('$tieu_de', '$link')";
        }
        $res = $this->db->query($sql);
        return $res ? 1 : 0;
    }
    public function delete_cv_guide_video() {
        $id = intval($_POST['id']);
        $res = $this->db->query("DELETE FROM cv_guide_video WHERE id=$id");
        return $res ? 1 : 0;
    }
    public function get_cv_guide_images() {
        $res = $this->db->query("SELECT * FROM cv_guide_blog_images ORDER BY id DESC");
        $data = [];
        while($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }
    public function save_cv_guide_image() {
        $ma_bai_viet = isset($_POST['ma_bai_viet']) ? intval($_POST['ma_bai_viet']) : 0;
        $hinh_anh = '';
        if(isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['tmp_name']) {
            $fname = time().'_'.$_FILES['hinh_anh']['name'];
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'assets/uploads/'.$fname);
            $hinh_anh = $fname;
        }
        if($ma_bai_viet > 0 && $hinh_anh) {
            $sql = "INSERT INTO cv_guide_blog_images (ma_bai_viet, hinh_anh) VALUES ($ma_bai_viet, '$hinh_anh')";
            $res = $this->db->query($sql);
            return $res ? 1 : 0;
        }
        return 0;
    }
    public function delete_cv_guide_image() {
        $id = intval($_POST['id']);
        $res = $this->db->query("DELETE FROM cv_guide_blog_images WHERE id=$id");
        return $res ? 1 : 0;
    }
}