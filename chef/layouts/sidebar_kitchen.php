<!-- Start: Sidebar -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<!-- <link rel="stylesheet" href="/kitchen/css/style.css"> -->
<style>
    .active {
        background-color: #58588e !important;
        color: white !important;
    }

    .nav .nav-link {
        padding: 8px 16px;
    }

    .nav .nav-link:hover {
        background-color: #58588e !important;
        color: white !important;
    }
</style>
<div class="col-12 col-md-2 d-flex justify-content-center p-0 border-right" style="height: 90vh;">
    <div class="d-flex flex-column justify-content-between" style="width: 100%">
        <!-- Start: Avatar -->
        <div>
            <div class="py-4 px-3 mb-2">
                <div class="media d-flex justify-content-center flex-column align-items-center">
                    <img src="/kitchen/image/<?php echo $row_user['avatar']; ?>" alt="avatar" style="width: 80px; height: 80px;" class="rounded-circle img-thumbnail shadow-sm">
                    <div class="media-body text-center">
                        <h5 class="m-0"><?php echo $row_user['full_name']; ?></h5>

                        <p class="font-weight-normal text-muted mb-0">Bếp</p>
                    </div>
                </div>
            </div>
            <!-- End: Avatar -->
            <!-- Start: Block nav 2 -->
            <p class="font-weight-bold text-uppercase px-3 small pt-3 pb-1 mb-0">Đơn hàng</p>
            <ul class="nav flex-column bg-white mb-0">
                <li class="nav-item">
                    <a href="/kitchen/chef/" class="nav-link text-dark bg-light" id="manage-dish">Quản lý đơn hàng</a>
                </li>

            </ul>
            <!-- End: Block nav 2 -->
            <!-- Start: Block nav 1 -->
            <p class="font-weight-bold text-uppercase px-3 small pt-4 pb-1 mb-0">Món ăn</p>
            <ul class="nav flex-column bg-white mb-0">
                <li class="nav-item active">
                    <a href="/kitchen/chef/resource" class="nav-link text-dark bg-light" id="chef-resource">Nguyên liệu</a>
                </li>
                <li class="nav-item">
                    <a href="/kitchen/chef/dish" class="nav-link text-dark bg-light" id="chef-dish">Món ăn</a>
                </li>
                <li class="nav-item">
                    <a href="/kitchen/chef/dish_suggest" class="nav-link text-dark bg-light" id="chef-suggest">Đề xuất món ăn</a>
                </li>
            </ul>
            <!-- End: Block nav 1 -->


        </div>
        <a href="/kitchen/login/logout.php?id=<?php echo $id ?>" class="link-profile px-3">
            <div class="nav align-items-center justify-content-end profile-info" style="color: white">
                <div class="icon-profile">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #a9a9a9;">
                        <ion-icon name="log-out-outline" style="font-size: 25px;"></ion-icon>
                    </div>
                </div>

            </div>
        </a>

    </div>

</div>
<!-- End: Sidebar -->