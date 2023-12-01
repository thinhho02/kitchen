
<!-- Start: Sidebar -->
<div class="col-12 col-md-2">
    <!-- Start: Avatar -->
    <div class="py-4 px-3 mb-2">
        <div class="media d-flex justify-content-center flex-column align-items-center">
            <img src="/kitchen/image/<?php echo $row_user['avtar']; ?>" alt="avatar" width="80" height="80"
                 class="rounded-circle img-thumbnail shadow-sm">
            <div class="media-body text-center">
                <h5 class="m-0"><?php echo $row_user['full_name']; ?></h5>
                <p class="font-weight-normal text-muted mb-0">Quản lý</p>
            </div>
        </div>
    </div>
    <!-- End: Avatar -->

    <!-- Start: Block nav 1 -->
    <p class="font-weight-bold text-uppercase px-3 small py-4 mb-0">Món ăn</p>
    <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item active">
            <a href="/kitchen/admin/resource" class="nav-link text-dark bg-light">Quản lý nguyên liệu</a>
        </li>
        <li class="nav-item">
            <a href="/kitchen/admin/dish" class="nav-link text-dark bg-light">Quản lý món ăn</a>
        </li>
    </ul>
    <!-- End: Block nav 1 -->

    <!-- Start: Block nav 2 -->
    <p class="font-weight-bold text-uppercase px-3 small py-4 mb-0">Đơn hàng</p>
    <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
            <a href="#" class="nav-link text-dark bg-light">Quản lý đặt món</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-dark bg-light">Bla Bla</a>
        </li>
    </ul>
    <!-- End: Block nav 2 -->
</div>
<!-- End: Sidebar -->
