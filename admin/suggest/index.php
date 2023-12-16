<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);
$sql = "SELECT dishes.dish_id, dishes.name, dishes.price, categories.name AS category_name FROM dishes JOIN categories ON dishes.category_id = categories.id WHERE remove = 0 and is_approved = 0";

if (isset($_GET['categories'])) {
    $sql .= " WHERE categories.name IN ('" . implode("', '", explode("--", $_GET['categories'])) . "')";
}

if (isset($_GET['sort'])) {
    $sort = explode(",", $_GET['sort']);
    $sql .= " ORDER BY " . $sort[0] . ' ' . $sort[1];
} else {
    $sql .= " ORDER BY name";
}

$dishes = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen | Đề xuất món ăn</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/datatables.min.css">
    <link rel="stylesheet" href="../../css/vanillaSelectBox.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "../layouts/sidebar.php" ?>

            <div class="col-12 col-md-10">
                <!-- Start: Page header -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="text-uppercase">Món ăn đang được đề xuất</h3>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex justify-content-end">
                            <!-- Start: Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertModal">
                                <span class="mr-2">Thêm thủ công</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                            </button>
                            <!-- End: Button trigger modal -->
                        </div>
                    </div>
                </div>
                <!-- End: Page header -->

                <div class="row py-4">
                    <div class="col-12 col-md-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="sort">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                                        <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                    </svg>
                                </label>
                            </div>
                            <select class="custom-select-sm" id="sort">
                                <option value="name" selected>Tên: A-Z</option>
                                <option value="name,desc">Tên: Z-A</option>
                                <option value="price,asc">Giá tăng dần</option>
                                <option value="price,desc">Giá giảm dần</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="example">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                                    </svg>
                                </label>
                            </div>
                            <select multiple name="filter" id="filter" size="3" class="custom-select">
                                <?php $categories = mysqli_query($con, "SELECT * FROM categories"); ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-outline-dark" type="button" id="btnFilter">
                            <span class="mr-2">Lọc</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                            </svg>
                        </button>
                    </div>
                </div>


                <!-- Start: Table -->
                <div>
                    <div id="button-wrapper"></div>
                    <div class="table-responsive">
                        <?php if ($dishes) { ?>
                            <table class="table table-striped table-bordered" id="dishes-table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Tên</th>
                                        <th scope="col" class="text-center">Danh mục</th>
                                        <th scope="col" class="text-center">Giá</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dishes as $key => $dish) : ?>
                                        <tr>
                                            <th scope="row" class="align-middle">
                                                <?= $key + 1; ?>
                                            </th>
                                            <td class="align-middle">
                                                <?= $dish['name']; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= $dish['category_name']; ?>
                                            </td>
                                            <td class="align-middle text-right">
                                                <?= number_format($dish['price'], 0, ',', '.') . ' VNĐ'; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="btn btn-link" aria-label="view detail button" onclick="viewDetail(<?= $dish['dish_id']; ?>)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                        </svg>
                                                    </button>
                                                    <form id="CheckForm-<?= $dish['dish_id'] ?>" method="post" action="/kitchen/api/dish/CheckDish.php">
                                                        <input type="text" hidden name="id" aria-label="id Check" value="<?= $dish['dish_id']; ?>">
                                                        <button type="button" class="btn btn-link " aria-label="Check button" onclick="confirmCheck(<?= $dish['dish_id'] ?>, '<?= $dish['name'] ?>')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                            </svg> </button>
                                                    </form>


                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php
                            mysqli_free_result($dishes);
                        }
                        ?>
                    </div>
                </div>
                <!-- End: Table -->
            </div>

        </div>
    </div>

    <!-- Start: Modal -->
    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insert modal" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <form method="post" action="/kitchen/api/chef/insertDish.php" id="insertForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm món ăn</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="dish-name-insert">Tên:</label>
                            <input name="name" type="text" class="form-control" id="dish-name-insert" aria-describedby="name resource" placeholder="Nhập tên món" required>
                        </div>
                        <div class="form-group">
                            <label for="dish-image-insert">Ảnh:</label>
                            <input name="image" type="file" class="form-control" id="dish-image-insert" aria-describedby="image resource" placeholder="Chọn ảnh" accept=".jpeg, .jpg, .png" required>
                        </div>
                        <div class="form-group">
                            <label for="dish-category-insert">Danh mục:</label>
                            <select id="dish-category-insert" class="form-control" name="category">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dish-price-insert">Giá:</label>
                            <input name="price" type="number" value="10000" min="0" max="100000" class="form-control" required id="dish-price-insert" placeholder="Nhập giá món">
                        </div>
                        <div class="form-group">
                            <label for="dish-description-insert">Mô tả:</label>
                            <textarea name="description" class="form-control" id="dish-description-insert" rows="3" required></textarea>
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

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/datatables.min.js"></script>
    <script src="../../js/sweetalert.min.js"></script>
    <script src="../../js/vanillaSelectBox.js"></script>



    <script>
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
        let filterParams = params.get("categories");
        if (filterParams) {
            filters = filterParams.split("--");
        }
        let sort = [params.get("sort") || 'name,asc'];
        sortSelect.setValue(sort);
        filterSelect.setValue(filters);
        console.log(sort)
        console.log(filters)

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
            console.log(filters);
        });

        document.getElementById("sort").addEventListener("change", function(e) {
            sort = getValues("sort");
            console.log(sort);
        });

        document.getElementById("btnFilter").addEventListener("click", function(e) {
            let params = new URLSearchParams(window.location.search);
            console.log(sort.length)
            if (sort.length === 0) {
                params.delete("sort")
            } else {
                params.set("sort", sort.toString());
            }
            if (filters.length === 0) {
                params.delete("categories")
            } else {
                params.set("categories", filters.join("--"));
            }
            window.location.search = params.toString();
        });

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

        function confirmCheck(id, name) {
            swal({
                    title: "Bạn có chắc chắn muốn cập nhật không?",
                    text: "id: " + id + ", tên: " + name,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willUpdate) => {
                    if (willUpdate) {

                        document.getElementById("CheckForm-" + id).submit();
                    }
                });
        }

        function viewDetail(dish_id) {
            window.location.href = "/kitchen/admin/dish/detail/?id=" + dish_id;
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
        $(document).ready(function() {
            $(".nav-link").removeClass("active")
            $("#dishSuggest-manage").addClass("active")
            // validation form
            $('#insertForm').submit(function(event) {
                let name = $('#dish-name-insert').val().trim();
                let price = $('#dish-price-insert').val();
                let description = $('#dish-description-insert').val().trim();

                if (name === '' || price === '' || isNaN(parseFloat(price)) || parseFloat(price) < 0 || description === '') {
                    swal("Thất bại!", "Hãy nhập đầy đủ thông tin.", "error");
                    event.preventDefault();
                }
            });

            const table = $('#dishes-table').DataTable({
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