<!-- Start: Sidebar -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<!-- <link rel="stylesheet" href="/kitchen/css/style.css"> -->
<style>
    a.active,
    button.active {
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
    .icon-logout{
        color: white;
    }
</style>
<div class="col-12 col-md-2 d-flex justify-content-center border-right p-0">
    <div class="d-flex flex-column" style="width: 100%">
        <!-- Start: Avatar -->
        <div>
            <div class="py-2 px-3 mb-2">
                <div class="media d-flex justify-content-center flex-column align-items-center">
                    <img src="/kitchen/image/<?php echo $row_user['avatar']; ?>" alt="avatar" style="width: 80px; height: 80px;" class="rounded-circle img-thumbnail shadow-sm">
                    <div class="media-body text-center">
                        <h5 class="m-0"><?php echo $row_user['full_name']; ?></h5>

                        <p class="font-weight-normal text-muted mb-0">Quản lý</p>
                    </div>
                </div>
            </div>


            <p class="font-weight-bold text-uppercase px-3 small pt-1 pb-2 mb-0">Dashboard</p>
            <ul class="nav flex-column bg-white mb-0">
                <li class="nav-item">
                    <a href="/kitchen/admin/" class="nav-link text-dark bg-light" id="statistic">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a href="/kitchen/admin/list_order/" class="nav-link text-dark bg-light" id="order-manage">Quản lý đơn hàng</a>
                </li>
            </ul>


            <p class="font-weight-bold text-uppercase px-3 small pt-4 pb-2 mb-0">Món ăn</p>
            <ul class="nav flex-column bg-white mb-0">
                <li class="nav-item">
                    <a href="/kitchen/admin/resource" class="nav-link text-dark bg-light" id="resource-manage">Quản lý nguyên liệu</a>
                </li>
                <li class="nav-item">
                    <a href="/kitchen/admin/dish" class="nav-link text-dark bg-light" id="dish-manage">Quản lý món ăn</a>
                </li>
                <li class="nav-item">
                    <a href="/kitchen/admin/suggest" class="nav-link text-dark bg-light" id="dishSuggest-manage">Duyệt món ăn</a>
                </li>
            </ul>


            <p class="font-weight-bold text-uppercase px-3 small pt-4 pb-2 mb-0">Tài khoản</p>
            <ul class="nav flex-column bg-white mb-0">
                <li class="nav-item">
                    <a href="/kitchen/admin/create_employee" class="nav-link text-dark bg-light" id="add-account">Tạo tài khoản</a>
                </li>
                <li class="nav-item">
                    <a href="/kitchen/admin/list_employee" class="nav-link text-dark bg-light" id="list-account">Danh sách tài khoản</a>
                </li>
            </ul>



        </div>

        <div class="nav align-items-center justify-content-end profile-info px-3 mt-5">
            <a href="/kitchen/login/logout.php?id=<?php echo $id ?>" class="icon-logout">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #a9a9a9;">
                    <ion-icon name="log-out-outline" style="font-size: 25px;"></ion-icon>
                </div>
            </a>

        </div>


    </div>

</div>
<!-- End: Sidebar -->