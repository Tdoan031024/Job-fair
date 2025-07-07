<?php include '../views/layouts/header.php'; ?>
<head>
    <link rel="stylesheet" href="../assets/css/view_company.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f6f8fb; }
        .cv-guide-hero { background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%); color: #fff; padding: 48px 0 32px 0; text-align: center; border-radius: 0 0 32px 32px; }
        .cv-guide-hero h1 { font-size: 2.8rem; font-weight: bold; margin-bottom: 12px; letter-spacing: 1px; }
        .cv-guide-hero p { font-size: 1.2rem; }
        .cv-guide-section { margin: 48px 0; }
        .cv-guide-section h2 { font-size: 2rem; font-weight: bold; margin-bottom: 24px; color: #4e54c8; }
        .cv-guide-blogs { display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; }
        .cv-guide-blog { background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(78,84,200,0.08); flex: 1 1 420px; min-width: 340px; max-width: 540px; padding: 0 0 24px 0; display: flex; flex-direction: column; transition: box-shadow 0.2s; position: relative; }
        .cv-guide-blog:hover { box-shadow: 0 8px 32px rgba(78,84,200,0.18); }
        .cv-guide-blog .blog-img { width: 100%; height: 240px; object-fit: cover; border-radius: 20px 20px 0 0; }
        .cv-guide-blog .blog-content-wrap { padding: 24px; display: flex; flex-direction: column; height: 100%; }
        .cv-guide-blog h3 { font-size: 1.4rem; font-weight: bold; margin-bottom: 8px; color: #222; }
        .cv-guide-blog .blog-summary { color: #555; margin-bottom: 12px; font-size: 1.05rem; }
        .cv-guide-blog .blog-content { color: #666; font-size: 1rem; line-height: 1.6; margin-bottom: 10px; }
        .cv-guide-blog .blog-date { font-size: 0.95rem; color: #888; margin-bottom: 8px; }
        .cv-guide-blog .blog-gallery { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .cv-guide-blog .blog-gallery img { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid #eee; transition: border 0.2s; }
        .cv-guide-blog .blog-gallery img:hover { border: 2px solid #4e54c8; }
        .cv-guide-samples { display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; }
        .cv-sample { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); width: 260px; padding: 16px; text-align: center; transition: box-shadow 0.2s; }
        .cv-sample:hover { box-shadow: 0 4px 16px rgba(78,84,200,0.12); }
        .cv-sample img { width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; }
        .cv-sample .cv-title { font-weight: bold; margin-bottom: 6px; color: #222; }
        .cv-sample .cv-desc { color: #555; font-size: 0.98rem; margin-bottom: 8px; }
        .cv-sample .btn { margin-top: 4px; background: #4e54c8; color: #fff; border-radius: 20px; padding: 6px 20px; font-weight: 500; border: none; transition: background 0.2s; }
        .cv-sample .btn:hover { background: #222; color: #fff; }
        .cv-guide-tools { text-align: center; margin: 32px 0; }
        .cv-guide-tools a { display: inline-block; background: #4e54c8; color: #fff; padding: 12px 32px; border-radius: 24px; font-weight: bold; font-size: 1.1rem; text-decoration: none; transition: background 0.2s; }
        .cv-guide-tools a:hover { background: #222; }
        .cv-guide-videos { display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; }
        .cv-video { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); width: 340px; padding: 16px; text-align: center; }
        .cv-video iframe { width: 100%; height: 190px; border-radius: 8px; margin-bottom: 12px; }
        .cv-video .video-title { font-weight: bold; margin-bottom: 6px; color: #222; }
        .cv-video .video-date { font-size: 0.95rem; color: #888; margin-bottom: 8px; }
        .loading { text-align: center; padding: 40px; color: #666; }
        .no-data { text-align: center; padding: 40px; color: #999; font-style: italic; }
        @media (max-width: 900px) {
            .cv-guide-blogs, .cv-guide-samples, .cv-guide-videos { flex-direction: column; align-items: center; }
            .cv-guide-blog, .cv-video { max-width: 100%; min-width: 0; }
        }
    </style>
    <!-- Lightbox gallery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" />
</head>

<div class="cv-guide-hero">
    <h1>Hướng dẫn viết CV chuyên nghiệp</h1>
    <p>Hỗ trợ sinh viên tạo CV ấn tượng, phù hợp với nhà tuyển dụng hiện đại.</p>
</div>

<div class="container">
    <!-- Bài viết hướng dẫn -->
    <div class="cv-guide-section">
        <h2>Bài viết hướng dẫn</h2>
        <div class="cv-guide-blogs" id="blogsContainer">
            <div class="loading">
                <i class="fa fa-spinner fa-spin fa-2x"></i><br>
                Đang tải bài viết...
            </div>
        </div>
    </div>

    <!-- Mẫu CV tham khảo -->
    <div class="cv-guide-section">
        <h2>Mẫu CV tham khảo</h2>
        <div class="cv-guide-samples" id="samplesContainer">
            <div class="loading">
                <i class="fa fa-spinner fa-spin fa-2x"></i><br>
                Đang tải mẫu CV...
            </div>
        </div>
    </div>

    <!-- Video hướng dẫn -->
    <div class="cv-guide-section">
        <h2>Video hướng dẫn viết CV</h2>
        <div class="cv-guide-videos" id="videosContainer">
            <div class="loading">
                <i class="fa fa-spinner fa-spin fa-2x"></i><br>
                Đang tải video...
            </div>
        </div>
    </div>

    <!-- Công cụ chỉnh sửa CV trực tuyến -->
    <div class="cv-guide-section cv-guide-tools">
        <h2>Công cụ chỉnh sửa CV trực tuyến</h2>
        <a href="https://www.topcv.vn/" target="_blank">Truy cập công cụ tạo CV miễn phí tại TopCV.vn</a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
$(document).ready(function() {
    loadAllCVGuide();
});

function loadAllCVGuide() {
    let blogs = [], samples = [], videos = [], images = [];
    let loaded = 0;
    const total = 4;
    let errorOccurred = false;
    function checkLoaded() {
        loaded++;
        if (loaded === total) renderAll();
    }
    function handleError(section) {
        errorOccurred = true;
        if(section === 'blogs') $('#blogsContainer').html('<div class="no-data">Không thể tải bài viết. Vui lòng thử lại sau.</div>');
        if(section === 'samples') $('#samplesContainer').html('<div class="no-data">Không thể tải mẫu CV. Vui lòng thử lại sau.</div>');
        if(section === 'videos') $('#videosContainer').html('<div class="no-data">Không thể tải video. Vui lòng thử lại sau.</div>');
        checkLoaded();
    }
    $.ajax({ url: '../admin/ajax.php?action=get_cv_guide_blogs', type: 'POST', success: function(resp) { try{ blogs = JSON.parse(resp); }catch(e){ handleError('blogs'); return; } checkLoaded(); }, error: function(){ handleError('blogs'); } });
    $.ajax({ url: '../admin/ajax.php?action=get_cv_guide_samples', type: 'POST', success: function(resp) { try{ samples = JSON.parse(resp); }catch(e){ handleError('samples'); return; } checkLoaded(); }, error: function(){ handleError('samples'); } });
    $.ajax({ url: '../admin/ajax.php?action=get_cv_guide_videos', type: 'POST', success: function(resp) { try{ videos = JSON.parse(resp); }catch(e){ handleError('videos'); return; } checkLoaded(); }, error: function(){ handleError('videos'); } });
    $.ajax({ url: '../admin/ajax.php?action=get_cv_guide_images', type: 'POST', success: function(resp) { try{ images = JSON.parse(resp); }catch(e){ images = []; } checkLoaded(); }, error: function(){ images = []; checkLoaded(); } });

    function renderAll() {
        // Render blogs
        let blogHtml = '';
        if (blogs.length > 0) {
            blogs.forEach(blog => {
                blogHtml += `<div class="cv-guide-blog">
                    ${blog.hinh_anh ? `<img class='blog-img' src="admin/assets/uploads/${blog.hinh_anh}" alt="${blog.tieu_de}">` : ''}
                    <div class="blog-content-wrap">
                        <div class="blog-date"><i class='fa fa-calendar'></i> ${blog.ngay_tao ? new Date(blog.ngay_tao).toLocaleDateString('vi-VN') : ''}</div>
                        <h3>${blog.tieu_de}</h3>
                        <div class="blog-summary">${blog.tom_tat || ''}</div>
                        <div class="blog-content">${blog.noi_dung || ''}</div>
                        ${(() => {
                            const blogImgs = images.filter(img => img.ma_bai_viet == blog.ma_bai_viet);
                            if(blogImgs.length === 0) return '';
                            let gallery = '<div class="blog-gallery">';
                            blogImgs.forEach(img => {
                                gallery += `<a href="admin/assets/uploads/${img.hinh_anh}" data-lightbox="blog-${blog.ma_bai_viet}" data-title="${blog.tieu_de}"><img src="admin/assets/uploads/${img.hinh_anh}" alt="Ảnh liên quan"></a>`;
                            });
                            gallery += '</div>';
                            return gallery;
                        })()}
                    </div></div>`;
            });
        } else {
            blogHtml = '<div class="no-data">Chưa có bài viết hướng dẫn nào.</div>';
        }
        $('#blogsContainer').html(blogHtml);

        // Render samples
        let sampleHtml = '';
        if (samples.length > 0) {
            samples.forEach(sample => {
                sampleHtml += `<div class="cv-sample">
                    ${sample.hinh_anh ? `<img src="admin/assets/uploads/${sample.hinh_anh}" alt="${sample.tieu_de}">` : ''}
                    <div class="cv-title">${sample.tieu_de}</div>
                    <div class="cv-desc">${sample.mo_ta || ''}</div>
                    ${sample.tep_tin ? `<a href="admin/assets/uploads/${sample.tep_tin}" class="btn" download><i class='fa fa-download'></i> Tải về</a>` : ''}
                    <div style="color:#888;font-size:0.95rem;margin-top:6px;">${sample.ngay_tao ? new Date(sample.ngay_tao).toLocaleDateString('vi-VN') : ''}</div>
                </div>`;
            });
        } else {
            sampleHtml = '<div class="no-data">Chưa có mẫu CV nào.</div>';
        }
        $('#samplesContainer').html(sampleHtml);

        // Render videos
        let videoHtml = '';
        if (videos.length > 0) {
            videos.forEach(video => {
                videoHtml += `<div class="cv-video">
                    <iframe src="${video.link}" title="${video.tieu_de}" frameborder="0" allowfullscreen></iframe>
                    <div class="video-title">${video.tieu_de}</div>
                    <div class="video-date">${video.ngay_tao ? new Date(video.ngay_tao).toLocaleDateString('vi-VN') : ''}</div>
                </div>`;
            });
        } else {
            videoHtml = '<div class="no-data">Chưa có video hướng dẫn nào.</div>';
        }
        $('#videosContainer').html(videoHtml);
    }
}
</script>

<?php include '../views/layouts/footer.php'; ?> 