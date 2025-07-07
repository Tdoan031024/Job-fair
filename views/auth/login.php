<?php include '../views/layouts/header.php'; ?>

<link rel="stylesheet" href="../assets/css/auth.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Đăng Nhập</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success_message']); ?></div>
                    <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>
                    <form method="POST" action="index.php?page=login">
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>