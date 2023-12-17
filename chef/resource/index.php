<?php
session_start();
include '../../connect/connect.php';

if (!isset($_SESSION['employee_chef_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_chef_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);

$sql = "SELECT * FROM resources";
if (isset($_GET['units'])) {
    $units = explode("--", $_GET['units']);
    $sql .= " WHERE unit IN ('" . implode("', '", $units) . "')";
}

if (isset($_GET['sort'])) {
    $sort = explode(",", $_GET['sort']);
    $sql .= " ORDER BY " . $sort[0] . ' ' . $sort[1];
} else {
    $sql .= " ORDER BY name";
}
$resources = mysqli_query($con, $sql);

// query to get distinct unit values
$units = mysqli_query($con, "SELECT DISTINCT unit FROM resources");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen | Nguyên vật liệu</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/datatables.min.css">
    <link rel="stylesheet" href="../../css/vanillaSelectBox.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "../layouts/sidebar_kitchen.php" ?>

            <div class="col-12 col-md-10">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="text-uppercase">Quản lý nguyên liệu</h3>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex justify-content-md-end justify-content-between">
                            <button type="button" class="btn btn-success mr-3" data-toggle="modal" aria-label="add multiple button" data-target="#insertExcelModal">
                                <span class="mr-2">Thêm với Excel</span>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0,0,256,256" width="16px" height="16px">
                                    <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <g transform="scale(5.12,5.12)">
                                            <path d="M28.875,0c-0.01953,0.00781 -0.04297,0.01953 -0.0625,0.03125l-28,5.3125c-0.47656,0.08984 -0.82031,0.51172 -0.8125,1v37.3125c-0.00781,0.48828 0.33594,0.91016 0.8125,1l28,5.3125c0.28906,0.05469 0.58984,-0.01953 0.82031,-0.20703c0.22656,-0.1875 0.36328,-0.46484 0.36719,-0.76172v-5h17c1.09375,0 2,-0.90625 2,-2v-34c0,-1.09375 -0.90625,-2 -2,-2h-17v-5c0.00391,-0.28906 -0.12109,-0.5625 -0.33594,-0.75391c-0.21484,-0.19141 -0.50391,-0.28125 -0.78906,-0.24609zM28,2.1875v4.34375c-0.13281,0.27734 -0.13281,0.59766 0,0.875v35.40625c-0.02734,0.13281 -0.02734,0.27344 0,0.40625v4.59375l-26,-4.96875v-35.6875zM30,8h17v34h-17v-5h4v-2h-4v-6h4v-2h-4v-5h4v-2h-4v-5h4v-2h-4zM36,13v2h8v-2zM6.6875,15.6875l5.46875,9.34375l-5.96875,9.34375h5l3.25,-6.03125c0.22656,-0.58203 0.375,-1.02734 0.4375,-1.3125h0.03125c0.12891,0.60938 0.25391,1.02344 0.375,1.25l3.25,6.09375h4.96875l-5.75,-9.4375l5.59375,-9.25h-4.6875l-2.96875,5.53125c-0.28516,0.72266 -0.48828,1.29297 -0.59375,1.65625h-0.03125c-0.16406,-0.60937 -0.35156,-1.15234 -0.5625,-1.59375l-2.6875,-5.59375zM36,20v2h8v-2zM36,27v2h8v-2zM36,35v2h8v-2z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </button>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertModal" aria-label="add button">
                                <span class="mr-2">Thêm thủ công</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Start: Filter -->
                <div class="row my-4">
                    <div class="col-12 col-md-6">

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="sort">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                                                <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                            </svg>
                                        </label>
                                    </div>
                                    <select class="custom-select-sm" id="sort">
                                        <option value="name,asc" selected>Tên: A-Z</option>
                                        <option value="name,desc">Tên: Z-A</option>
                                        <option value="price,asc">Giá tăng dần</option>
                                        <option value="price,desc">Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="filter">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                                            </svg>
                                        </label>
                                    </div>
                                    <select multiple name="filter" id="filter" size="3" class="custom-select">
                                        <?php foreach ($units as $unit) : ?>
                                            <option value="<?= $unit['unit'] ?>"><?= $unit['unit'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div>
                            <button class="btn btn-outline-dark" type="button" id="btnFilter">
                                <span class="mr-2">Lọc</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End: Filter -->


                <!-- Start: Table -->
                <div>
                    <div id="button-wrapper"></div>
                    <div class="table-responsive">
                        <?php if ($resources) { ?>
                            <table class="table table-striped table-bordered" id="resource-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Tên</th>
                                        <th scope="col" class="text-center">Đơn vị</th>
                                        <th scope="col" class="text-center">Giá</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resources as $key => $resource) : ?>
                                        <tr>
                                            <th scope="row" class="align-middle"><?= $key + 1; ?></th>
                                            <td class="align-middle"><?= $resource['name']; ?></td>
                                            <td class="align-middle"><?= $resource['unit']; ?></td>
                                            <td class="align-middle text-right"><?= number_format($resource['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                            <td>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php
                            mysqli_free_result($resources);
                        }
                        ?>
                    </div>

                </div>
                <!-- End: Table -->
            </div>

        </div>
    </div>

    <!-- Start: Insert excel modal -->
    <div class="modal fade" id="insertExcelModal" tabindex="-1" role="dialog" aria-labelledby="insert excel modal" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <form method="post" action="../../api/resource/insertExcelResource.php" enctype="multipart/form-data" id="insertExcelForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm vật liệu bằng excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="excel" required id="file" accept="text/csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <label class="custom-file-label" for="file">Chọn file</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="import">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End: Insert excel modal -->

    <!-- Start: Modal -->
    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insert modal" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <form method="post" action=".../../../../api/resource/insertResource.php" id="insertForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm nguyên vật liệu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="resource-name">Tên:</label>
                            <input name="name" type="text" class="form-control" id="resource-name" aria-describedby="name resource" placeholder="Nhập tên nguyên vật liệu" required>
                        </div>
                        <div class="form-group">
                            <label for="resource-unit">Đơn vị:</label>
                            <input name="unit" type="text" class="form-control" id="resource-unit" aria-describedby="unit resource" placeholder="Nhập đơn vị tính" required>
                        </div>
                        <div class="form-group">
                            <label for="resource-price">Giá:</label>
                            <input name="price" type="number" value="1000" min="0" max="100000" class="form-control" id="resource-price" aria-describedby="price resource" placeholder="Nhập giá nguyên vật liệu" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End: Modal -->


    <!-- Start: Update resource -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="update modal" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <form method="post" action="/kitchen/api/resource/updateResource.php" id="updateForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật nguyên vật liệu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="id" type="text" hidden class="form-control" id="resource-update-id" aria-label="id resource" required>
                        <div class="form-group">
                            <label for="resource-update-name">Tên:</label>
                            <input name="name" type="text" class="form-control" id="resource-update-name" aria-describedby="name resource" placeholder="Nhập tên nguyên vật liệu" required>
                        </div>
                        <div class="form-group">
                            <label for="resource-update-unit">Đơn vị:</label>
                            <input name="unit" type="text" class="form-control" id="resource-update-unit" aria-describedby="unit resource" placeholder="Nhập đơn vị tính" required>
                        </div>
                        <div class="form-group">
                            <label for="resource-update-price">Giá:</label>
                            <input name="price" type="number" value="0" min="0" max="100000" class="form-control" id="resource-update-price" aria-describedby="price resource" placeholder="Nhập giá nguyên vật liệu" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End: Update resource -->

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/datatables.min.js"></script>
    <script src="../../js/sweetalert.min.js"></script>
    <script src="../../js/vanillaSelectBox.js"></script>
    <script>
    </script>
    <script>
        function confirmDelete(id, name) {
            swal({
                    title: "Bạn có chắc chắn muốn xoá không?",
                    text: "id: " + id + ", tên: " + name,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById("deleteForm-" + id).submit();
                    }
                });
        }

        <?php
        if (isset($_SESSION['status'])) {
            if ($_SESSION['status'] === "success") {
                echo 'swal("Thành công!","' . $_SESSION["message"] . '", "success");';
            } else {
                echo 'swal("Thất bại!", "' . $_SESSION["message"] . '", "error");';
            }
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
        ?>
    </script>

    <script type="text/javascript">
        let filterSelect = new vanillaSelectBox("#filter", {
            search: true,
            placeHolder: "Lọc theo đơn vị",
            translations: {
                "all": "Tất cả",
                "item": "item",
                "items": "lựa chọn",
                "selectAll": "Tất cả",
                "clearAll": "Bỏ chọn tất cả"
            },
            itemsSeparator: ", ",
            maxOptionWidth: 140,
            maxWidth: 500,
            maxHeight: 400,
            minWidth: 200,
        });

        let sortSelect = new vanillaSelectBox("#sort");
        let filters = [];

        var params = new URLSearchParams(window.location.search);
        let filterParams = params.get("units");
        if (filterParams) {
            filters = filterParams.split("--");
        }
        let sort = [params.get("sort") || 'name,asc'];
        sortSelect.setValue(sort);
        filterSelect.setValue(filters);

        function getValues(id) {
            let result = [];
            let collection = document.querySelectorAll("#" + id + " option");
            collection.forEach(function(item) {
                if (item.selected) {
                    result.push(item.value);
                }
            });
            return result;
        }

        document.getElementById("filter").addEventListener("change", function(e) {
            filters = getValues("filter");
        });

        document.getElementById("sort").addEventListener("change", function(e) {
            sort = getValues("sort");
        });

        document.getElementById("btnFilter").addEventListener("click", function(e) {
            let params = new URLSearchParams(window.location.search);
            if (sort.length === 0) {
                params.delete("sort")
            } else {
                params.set("sort", sort.toString());
            }
            if (filters.length === 0) {
                params.delete("units")
            } else {
                params.set("units", filters.join("--"));
            }
            window.location.search = params.toString();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".nav-link").removeClass("active")
            $("#chef-resource").addClass("active")
            $('#insertForm').submit(function(event) {
                let name = $('#resource-name').val().trim();
                let unit = $('#resource-unit').val().trim();
                let price = $('#resource-price').val();

                if (name === '' || unit === '' || price === '' || isNaN(parseFloat(price)) || parseFloat(price) < 0) {
                    swal("Thất bại!", "Hãy nhập đầy đủ thông tin.", "error");
                    event.preventDefault();
                }
            });

            $('#updateForm').submit(function(event) {
                var id = $('#resource-update-id').val().trim();
                var name = $('#resource-update-name').val().trim();
                var unit = $('#resource-update-unit').val().trim();
                var price = $('#resource-update-price').val();

                if (id === '' || name === '' || unit === '' || price === '' || isNaN(parseFloat(price)) || parseFloat(price) < 0) {
                    swal("Thất bại!", "Hãy nhập đầy đủ thông tin.", "error");
                    event.preventDefault();
                }
            });

            $('input[type="file"]').change(function(e) {
                let fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            });

            $('.edit').click(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let unit = $(this).data('unit');
                let price = $(this).data('price');

                $('#resource-update-id').attr("value", id);
                $('#resource-update-name').val(name);
                $('#resource-update-unit').val(unit);
                $('#resource-update-price').val(price);
            });

            const table = $('#resource-table').DataTable({
                buttons: [{
                        extend: 'print',
                        text: 'In',
                        title: 'Danh sách nguyên liệu',

                    },
                    {
                        extend: 'excel',
                        text: 'Xuất Excel',
                        title: 'Danh Sách Nguyên Liệu',
                        sheetName: 'Nguyên liệu',
                    },
                    {
                        extend: 'copy',
                    },
                ],
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                    },
                    {
                        targets: 4,
                        orderable: false,
                    }
                ],
                columns: [{
                        orderable: false
                    },
                    null,
                    null,
                    null,
                    {
                        orderable: false
                    },
                ],
                language: {
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    info: "Hiển thị _START_ đến _END_ trong tổng _TOTAL_ dòng",
                    infoFiltered: "(lọc từ _MAX_ dòng)",
                    paginate: {
                        previous: '‹‹',
                        next: '››'
                    },
                    search: "Tìm:"
                },
            });

            table.buttons().container().appendTo("#button-wrapper");
        });
    </script>
</body>

</html>