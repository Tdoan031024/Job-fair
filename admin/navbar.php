<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Trang chủ</a>
				<a href="index.php?page=booking" class="nav-item nav-booking"><span class='icon-field'><i class="fa fa-th-list"></i></span> Danh sách đặt địa điểm</a>
				<a href="index.php?page=audience" class="nav-item nav-audience"><span class='icon-field'><i class="fa fa-users"></i></span> Danh sách khán giả</a>
				<a href="index.php?page=venue" class="nav-item nav-venue"><span class='icon-field'><i class="fa fa-map-marked-alt"></i></span> Địa điểm</a>
				<a href="index.php?page=events" class="nav-item nav-events"><span class='icon-field'><i class="fa fa-calendar"></i></span> Sự kiện</a>
				<a class="nav-item nav-business" data-toggle="collapse" href="#businessCollapse" role="button" aria-expanded="false" aria-controls="businessCollapse"><span class='icon-field'><i class="fa fa-building"></i></span> Doanh nghiệp <i class="fa fa-angle-down float-right"></i></a>
				<div class="collapse" id="businessCollapse">
					<a href="index.php?page=business" class="nav-item nav-business-list pl-4"><span class='icon-field'><i class="fa fa-list"></i></span> Danh sách doanh nghiệp</a>
					<a href="index.php?page=jobs" class="nav-item nav-jobs pl-4"><span class='icon-field'><i class="fa fa-briefcase"></i></span> Quản lý việc làm</a>
					<a href="index.php?page=cv_guide_admin" class="nav-item nav-cv_guide_admin pl-4"><span class='icon-field'><i class="fa fa-file-alt"></i></span> Hướng dẫn viết CV</a>
					<a href="index.php?page=quanly_linhvuc" class="nav-item nav-quanly_linhvuc pl-4"><span class='icon-field'><i class="fa fa-tags"></i></span> Quản lý lĩnh vực</a>
				</div>
				<a href="index.php?page=message" class="nav-item nav-message"><span class='icon-field'><i class="fa fa-envelope"></i></span> Tin nhắn</a>
				<a  class="nav-item nav-reports" data-toggle="collapse" href="#reportCollpase" role="button" aria-expanded="false" aria-controls="reportCollpase"><span class='icon-field'><i class="fa fa-file"></i></span> Báo cáo <i class="fa fa-angle-down float-right"></i></a>
				<div class="collapse" id="reportCollpase">
					<a href="index.php?page=audience_report" class="nav-item nav-audience_report"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Báo cáo đối tượng</a>
					<a href="index.php?page=venue_report" class="nav-item nav-venue_report"><span class='icon-field'><i class="fa fa-map-marker-alt"></i></span> Báo cáo địa điểm</a>
				</div>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Người dùng</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> Cài đặt hệ thống</a>
				<a href="index.php?page=banner_slides" class="nav-item nav-banner_slides"><span class='icon-field'><i class="fa fa-images"></i></span> Quản lý Banner</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>