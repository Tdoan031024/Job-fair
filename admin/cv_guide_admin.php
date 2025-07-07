<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'topbar.php'; ?>

<style>
    .nav-tabs .nav-link { color: #495057; }
    .nav-tabs .nav-link.active { color: #007bff; font-weight: bold; }
    .tab-content { padding: 20px 0; }
    .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .card-header { background: #f8f9fa; border-bottom: 1px solid #dee2e6; }
    .btn-add { background: #28a745; border: none; }
    .btn-add:hover { background: #218838; }
    .table th { border-top: none; background: #f8f9fa; }
    .action-buttons .btn { margin: 0 2px; }
    .modal-header { background: #007bff; color: white; }
    .form-group label { font-weight: bold; }
    .preview-image { max-width: 200px; max-height: 150px; object-fit: cover; }
    .status-badge { font-size: 0.8em; }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa fa-file-alt"></i> Quản lý Hướng dẫn viết CV</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="cvGuideTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="blogs-tab" data-toggle="tab" href="#blogs" role="tab">
                                <i class="fa fa-newspaper"></i> Bài viết hướng dẫn
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="samples-tab" data-toggle="tab" href="#samples" role="tab">
                                <i class="fa fa-file"></i> Mẫu CV
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="videos-tab" data-toggle="tab" href="#videos" role="tab">
                                <i class="fa fa-video"></i> Video hướng dẫn
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab">
                                <i class="fa fa-image"></i> Hình ảnh
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="cvGuideTabContent">
                        <!-- Tab Bài viết -->
                        <div class="tab-pane fade show active" id="blogs" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Quản lý bài viết hướng dẫn</h5>
                                <button class="btn btn-add" onclick="openBlogModal()">
                                    <i class="fa fa-plus"></i> Thêm bài viết
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="blogsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tiêu đề</th>
                                            <th>Tóm tắt</th>
                                            <th>Hình ảnh</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Mẫu CV -->
                        <div class="tab-pane fade" id="samples" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Quản lý mẫu CV</h5>
                                <button class="btn btn-add" onclick="openSampleModal()">
                                    <i class="fa fa-plus"></i> Thêm mẫu CV
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="samplesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tiêu đề</th>
                                            <th>Mô tả</th>
                                            <th>Hình ảnh</th>
                                            <th>Tệp tin</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Video -->
                        <div class="tab-pane fade" id="videos" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Quản lý video hướng dẫn</h5>
                                <button class="btn btn-add" onclick="openVideoModal()">
                                    <i class="fa fa-plus"></i> Thêm video
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="videosTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tiêu đề</th>
                                            <th>Link video</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Hình ảnh -->
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Quản lý hình ảnh</h5>
                                <button class="btn btn-add" onclick="openImageModal()">
                                    <i class="fa fa-plus"></i> Thêm hình ảnh
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="imagesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Bài viết</th>
                                            <th>Hình ảnh</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bài viết -->
<div class="modal fade" id="blogModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blogModalTitle">Thêm bài viết</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="blogForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="blog_id" name="id">
                    <div class="form-group">
                        <label>Tiêu đề *</label>
                        <input type="text" class="form-control" id="blog_tieu_de" name="tieu_de" required>
                    </div>
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <textarea class="form-control" id="blog_tom_tat" name="tom_tat" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control" id="blog_noi_dung" name="noi_dung" rows="6"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" class="form-control-file" id="blog_hinh_anh" name="hinh_anh" accept="image/*">
                        <input type="hidden" id="blog_hinh_anh_old" name="hinh_anh_old">
                        <div id="blog_image_preview" class="mt-2"></div>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control" id="blog_trang_thai" name="trang_thai">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Mẫu CV -->
<div class="modal fade" id="sampleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sampleModalTitle">Thêm mẫu CV</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="sampleForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="sample_id" name="id">
                    <div class="form-group">
                        <label>Tiêu đề *</label>
                        <input type="text" class="form-control" id="sample_tieu_de" name="tieu_de" required>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" id="sample_mo_ta" name="mo_ta" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" class="form-control-file" id="sample_hinh_anh" name="hinh_anh" accept="image/*">
                        <input type="hidden" id="sample_hinh_anh_old" name="hinh_anh_old">
                        <div id="sample_image_preview" class="mt-2"></div>
                    </div>
                    <div class="form-group">
                        <label>Tệp tin</label>
                        <input type="file" class="form-control-file" id="sample_tep_tin" name="tep_tin" accept=".pdf,.doc,.docx">
                        <input type="hidden" id="sample_tep_tin_old" name="tep_tin_old">
                        <div id="sample_file_preview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Video -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalTitle">Thêm video</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="videoForm">
                <div class="modal-body">
                    <input type="hidden" id="video_id" name="id">
                    <div class="form-group">
                        <label>Tiêu đề *</label>
                        <input type="text" class="form-control" id="video_tieu_de" name="tieu_de" required>
                    </div>
                    <div class="form-group">
                        <label>Link video *</label>
                        <input type="url" class="form-control" id="video_link" name="link" placeholder="https://www.youtube.com/embed/..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hình ảnh -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm hình ảnh</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="imageForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bài viết *</label>
                        <select class="form-control" id="image_ma_bai_viet" name="ma_bai_viet" required>
                            <option value="">Chọn bài viết</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh *</label>
                        <input type="file" class="form-control-file" id="image_hinh_anh" name="hinh_anh" accept="image/*" required>
                        <div id="image_preview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentTab = 'blogs';

$(document).ready(function() {
    loadData();
    
    // Xử lý chuyển tab
    $('#cvGuideTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        currentTab = $(this).attr('id').replace('-tab', '');
        loadData();
    });
    
    // Xử lý form submit
    $('#blogForm').on('submit', function(e) {
        e.preventDefault();
        saveBlog();
    });
    
    $('#sampleForm').on('submit', function(e) {
        e.preventDefault();
        saveSample();
    });
    
    $('#videoForm').on('submit', function(e) {
        e.preventDefault();
        saveVideo();
    });
    
    $('#imageForm').on('submit', function(e) {
        e.preventDefault();
        saveImage();
    });
    
    // Preview hình ảnh
    $('#blog_hinh_anh, #sample_hinh_anh, #image_hinh_anh').change(function() {
        previewImage(this);
    });
    
    $('#sample_tep_tin').change(function() {
        previewFile(this);
    });
});

function loadData() {
    switch(currentTab) {
        case 'blogs':
            loadBlogs();
            break;
        case 'samples':
            loadSamples();
            break;
        case 'videos':
            loadVideos();
            break;
        case 'images':
            loadImages();
            break;
    }
}

function loadBlogs() {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_blogs',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                let html = '';
                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.ma_bai_viet}</td>
                            <td>${item.tieu_de}</td>
                            <td>${item.tom_tat || ''}</td>
                            <td>${item.hinh_anh ? `<img src="assets/uploads/${item.hinh_anh}" class="preview-image">` : 'Không có'}</td>
                            <td><span class="badge badge-${item.trang_thai == 1 ? 'success' : 'secondary'} status-badge">${item.trang_thai == 1 ? 'Hiển thị' : 'Ẩn'}</span></td>
                            <td>${new Date(item.ngay_tao).toLocaleDateString('vi-VN')}</td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-info" onclick="editBlog(${item.ma_bai_viet})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteBlog(${item.ma_bai_viet})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#blogsTable tbody').html(html);
            }
        }
    });
}

function loadSamples() {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_samples',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                let html = '';
                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.ma_mau_cv}</td>
                            <td>${item.tieu_de}</td>
                            <td>${item.mo_ta || ''}</td>
                            <td>${item.hinh_anh ? `<img src="assets/uploads/${item.hinh_anh}" class="preview-image">` : 'Không có'}</td>
                            <td>${item.tep_tin ? `<a href="assets/uploads/${item.tep_tin}" target="_blank">Tải về</a>` : 'Không có'}</td>
                            <td>${new Date(item.ngay_tao).toLocaleDateString('vi-VN')}</td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-info" onclick="editSample(${item.ma_mau_cv})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteSample(${item.ma_mau_cv})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#samplesTable tbody').html(html);
            }
        }
    });
}

function loadVideos() {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_videos',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                let html = '';
                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.tieu_de}</td>
                            <td><a href="${item.link}" target="_blank">Xem video</a></td>
                            <td>${new Date(item.ngay_tao).toLocaleDateString('vi-VN')}</td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-info" onclick="editVideo(${item.id})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteVideo(${item.id})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#videosTable tbody').html(html);
            }
        }
    });
}

function loadImages() {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_images',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                let html = '';
                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.ma_bai_viet}</td>
                            <td><img src="assets/uploads/${item.hinh_anh}" class="preview-image"></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-info" onclick="editImage(${item.id})"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" onclick="deleteImage(${item.id})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
                $('#imagesTable tbody').html(html);
            }
        }
    });
}

function openBlogModal(id = null) {
    $('#blogModalTitle').text(id ? 'Sửa bài viết' : 'Thêm bài viết');
    $('#blogForm')[0].reset();
    $('#blog_id').val('');
    $('#blog_image_preview').html('');
    $('#blog_hinh_anh_old').val('');
    $('#blogModal').modal('show');
}

function openSampleModal(id = null) {
    $('#sampleModalTitle').text(id ? 'Sửa mẫu CV' : 'Thêm mẫu CV');
    $('#sampleForm')[0].reset();
    $('#sample_id').val('');
    $('#sample_hinh_anh_old').val('');
    $('#sample_tep_tin_old').val('');
    $('#sample_image_preview').html('');
    $('#sample_file_preview').html('');
    // Reset input file khi mở modal
    $('#sample_hinh_anh').val('');
    $('#sample_tep_tin').val('');
    $('#sampleModal').modal('show');
}

function openVideoModal(id = null) {
    $('#videoModalTitle').text(id ? 'Sửa video' : 'Thêm video');
    $('#videoForm')[0].reset();
    $('#video_id').val('');
    $('#videoModal').modal('show');
}

function openImageModal(id = null) {
    $('#imageForm')[0].reset();
    $('#image_preview').html('');
    $('#image_ma_bai_viet').val('');
    $('#image_hinh_anh_old').remove();
    loadBlogsForImage(function() {
        if (id) {
            // Nếu là sửa, đổ dữ liệu cũ vào form
            $.ajax({
                url: 'ajax.php?action=get_cv_guide_images',
                type: 'POST',
                success: function(resp) {
                    if(resp) {
                        const data = JSON.parse(resp);
                        const img = data.find(item => item.id == id);
                        if(img) {
                            $('#image_ma_bai_viet').val(img.ma_bai_viet);
                            $('#image_preview').html(`<img src="assets/uploads/${img.hinh_anh}" class="preview-image">`);
                            // Thêm input hidden để lưu tên ảnh cũ
                            if (!$('#image_hinh_anh_old').length) {
                                $('<input>').attr({type:'hidden',id:'image_hinh_anh_old',name:'hinh_anh_old',value:img.hinh_anh}).appendTo('#imageForm');
                            } else {
                                $('#image_hinh_anh_old').val(img.hinh_anh);
                            }
                            $('#imageForm').attr('data-edit-id', id);
                        }
                    }
                }
            });
        } else {
            $('#imageForm').removeAttr('data-edit-id');
        }
        $('#imageModal').modal('show');
    });
}

function loadBlogsForImage(callback) {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_blogs',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                let html = '<option value="">Chọn bài viết</option>';
                data.forEach(item => {
                    html += `<option value="${item.ma_bai_viet}">${item.tieu_de}</option>`;
                });
                $('#image_ma_bai_viet').html(html);
                if (typeof callback === 'function') callback();
            }
        }
    });
}

function editBlog(id) {
    // Lấy dữ liệu bài viết và điền vào form
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_blogs',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                const blog = data.find(item => item.ma_bai_viet == id);
                if(blog) {
                    $('#blog_id').val(blog.ma_bai_viet);
                    $('#blog_tieu_de').val(blog.tieu_de);
                    $('#blog_tom_tat').val(blog.tom_tat);
                    $('#blog_noi_dung').val(blog.noi_dung);
                    $('#blog_trang_thai').val(blog.trang_thai);
                    $('#blog_hinh_anh_old').val(blog.hinh_anh);
                    if(blog.hinh_anh) {
                        $('#blog_image_preview').html(`<img src="assets/uploads/${blog.hinh_anh}" class="preview-image">`);
                    } else {
                        $('#blog_image_preview').html('');
                    }
                    // Reset input file khi sửa
                    $('#blog_hinh_anh').val('');
                    $('#blogModal').modal('show');
                }
            }
        }
    });
}

function editSample(id) {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_samples',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                const sample = data.find(item => item.ma_mau_cv == id);
                if(sample) {
                    $('#sample_id').val(sample.ma_mau_cv);
                    $('#sample_tieu_de').val(sample.tieu_de);
                    $('#sample_mo_ta').val(sample.mo_ta);
                    $('#sample_hinh_anh_old').val(sample.hinh_anh);
                    $('#sample_tep_tin_old').val(sample.tep_tin);
                    if(sample.hinh_anh) {
                        $('#sample_image_preview').html(`<img src="assets/uploads/${sample.hinh_anh}" class="preview-image">`);
                    } else {
                        $('#sample_image_preview').html('');
                    }
                    if(sample.tep_tin) {
                        $('#sample_file_preview').html(`<a href="assets/uploads/${sample.tep_tin}" target="_blank">Tải về</a>`);
                    } else {
                        $('#sample_file_preview').html('');
                    }
                    // Reset input file khi sửa
                    $('#sample_hinh_anh').val('');
                    $('#sample_tep_tin').val('');
                    $('#sampleModal').modal('show');
                }
            }
        }
    });
}

function editVideo(id) {
    $.ajax({
        url: 'ajax.php?action=get_cv_guide_videos',
        type: 'POST',
        success: function(resp) {
            if(resp) {
                const data = JSON.parse(resp);
                const video = data.find(item => item.id == id);
                if(video) {
                    $('#video_id').val(video.id);
                    $('#video_tieu_de').val(video.tieu_de);
                    $('#video_link').val(video.link);
                    openVideoModal(id);
                }
            }
        }
    });
}

function editImage(id) {
    openImageModal(id);
}

function saveBlog() {
    const formData = new FormData($('#blogForm')[0]);
    $.ajax({
        url: 'ajax.php?action=save_cv_guide_blog',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            if(resp == 1) {
                alert('Lưu thành công!');
                $('#blogModal').modal('hide');
                loadBlogs();
            } else {
                alert('Có lỗi xảy ra!');
            }
        }
    });
}

function saveSample() {
    const formData = new FormData($('#sampleForm')[0]);
    $.ajax({
        url: 'ajax.php?action=save_cv_guide_sample',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            if(resp == 1) {
                alert('Lưu thành công!');
                $('#sampleModal').modal('hide');
                loadSamples();
            } else {
                alert('Có lỗi xảy ra!');
            }
        }
    });
}

function saveVideo() {
    const formData = new FormData($('#videoForm')[0]);
    $.ajax({
        url: 'ajax.php?action=save_cv_guide_video',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            if(resp == 1) {
                alert('Lưu thành công!');
                $('#videoModal').modal('hide');
                loadVideos();
            } else {
                alert('Có lỗi xảy ra!');
            }
        }
    });
}

function saveImage() {
    const formData = new FormData($('#imageForm')[0]);
    // Nếu là sửa, thêm id vào formData
    const editId = $('#imageForm').attr('data-edit-id');
    if (editId) formData.append('id', editId);
    $.ajax({
        url: 'ajax.php?action=save_cv_guide_image',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            if(resp == 1) {
                alert('Lưu thành công!');
                $('#imageModal').modal('hide');
                loadImages();
            } else {
                alert('Có lỗi xảy ra!');
            }
        }
    });
}

function deleteBlog(id) {
    if(confirm('Bạn có chắc muốn xóa bài viết này?')) {
        $.ajax({
            url: 'ajax.php?action=delete_cv_guide_blog',
            type: 'POST',
            data: {id: id},
            success: function(resp) {
                if(resp == 1) {
                    alert('Xóa thành công!');
                    loadBlogs();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
}

function deleteSample(id) {
    if(confirm('Bạn có chắc muốn xóa mẫu CV này?')) {
        $.ajax({
            url: 'ajax.php?action=delete_cv_guide_sample',
            type: 'POST',
            data: {id: id},
            success: function(resp) {
                if(resp == 1) {
                    alert('Xóa thành công!');
                    loadSamples();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
}

function deleteVideo(id) {
    if(confirm('Bạn có chắc muốn xóa video này?')) {
        $.ajax({
            url: 'ajax.php?action=delete_cv_guide_video',
            type: 'POST',
            data: {id: id},
            success: function(resp) {
                if(resp == 1) {
                    alert('Xóa thành công!');
                    loadVideos();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
}

function deleteImage(id) {
    if(confirm('Bạn có chắc muốn xóa hình ảnh này?')) {
        $.ajax({
            url: 'ajax.php?action=delete_cv_guide_image',
            type: 'POST',
            data: {id: id},
            success: function(resp) {
                if(resp == 1) {
                    alert('Xóa thành công!');
                    loadImages();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewId = input.id.replace('_hinh_anh', '_image_preview');
            $(`#${previewId}`).html(`<img src="${e.target.result}" class="preview-image">`);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        // Nếu không có file, xóa preview
        const previewId = input.id.replace('_hinh_anh', '_image_preview');
        $(`#${previewId}`).html('');
    }
}

function previewFile(input) {
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        $('#sample_file_preview').html(`<span class="text-info">${fileName}</span>`);
    } else {
        $('#sample_file_preview').html('');
    }
}
</script>

</body>
</html> 