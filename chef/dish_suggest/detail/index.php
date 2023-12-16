<?php
include '../../../connect/connect.php';
session_start();

if (!isset($_SESSION['employee_chef_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_chef_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);


$dish_id = $_GET['id'] ?? null;

$sql = "SELECT * FROM dishes WHERE dish_id = $dish_id";
$result = mysqli_query($con, $sql);
$dish = mysqli_fetch_assoc($result);
mysqli_free_result($result);

$dishDetails = mysqli_query($con, "SELECT resources.name, resources.price, resources.unit, dish_detail.quantity, dish_detail.id FROM dish_detail INNER JOIN resources ON dish_detail.resource_id = resources.id WHERE dish_detail.dish_id = $dish_id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen | Chi tiết món ăn</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/datatables.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "../../layouts/sidebar.php" ?>

            <div class="col-12 col-md-10">
                <!-- Start: Page header -->
                <div class="d-flex justify-content-between my-4">
                    <h3 class="text-uppercase">Chi tiết món ăn</h3>
                </div>
                <!-- End: Page header -->

                <div class="container pt-5">
                    <!-- Start: Image dish -->
                    <div>
                        <div class="d-flex justify-content-center">
                            <img src="/kitchen/image/<?php echo $dish['image']; ?>" alt="dish" class="img-thumbnail img-fluid" style="object-fit: contain; height: 20rem; width: 20rem;">
                        </div>
                        <form class="d-flex justify-content-center pt-3" id="changeImageForm" enctype="multipart/form-data" method="post" action="/kitchen/api/dish/updateImageDish.php">
                            <input name="id" value="<?= $dish_id ?>" hidden aria-label="id dish">
                            <input type="button" id="get-file" value="Chọn ảnh" class="btn btn-primary">
                            <input type="file" id="image" class="d-none" name="image" accept=".jpeg, .jpg, .png" aria-label="image dish">
                        </form>
                    </div>
                    <!-- End: Image dish -->
                    <form id="updateForm" method="post" action="/kitchen/api/dish/updateDish.php">
                        <input name="id" hidden type="text" class="form-control" id="dish-id" aria-label="dish id" value="<?= $dish['dish_id'] ?>">

                        <div class="form-group">
                            <label for="dish-name">Tên món ăn</label>
                            <input name="name" value="<?php echo $dish['name']; ?>" type="text" class="form-control" id="dish-name" aria-describedby="dish name" placeholder="Nhập tên món ăn" required>
                        </div>

                        <div class="form-group">
                            <label for="dish-category">Danh mục</label>
                            <select id="dish-category" class="form-control" name="category_id">
                                <?php $categories = mysqli_query($con, "SELECT * FROM categories"); ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option <?= ($category['id'] === $dish['category_id']) ? 'selected' : '' ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dish-price">Giá</label>
                            <input name="price" value="<?php echo $dish['price']; ?>" type="number" class="form-control" id="dish-price" aria-describedby="dish name" placeholder="Nhập giá món" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="dish-is_approved">Tình trạng xét duyệt</label>
                            <select name="is_approved" disabled class="form-control" id="dish-is_approved" value="<?php echo $dish['is_approved']; ?>">
                                <option value="1" <?php echo ($dish['is_approved'] == 1) ? 'selected' : ''; ?>>Chưa duyệt
                                </option>
                                <option value="0" <?php echo ($dish['is_approved'] == 0) ? 'selected' : ''; ?>>Đã duyệt
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dish-remove">Trạng thái</label>
                            <select name="remove" disabled class="form-control" id="dish-remove">
                                <option value="1" <?php echo ($dish['remove'] == 1) ? 'selected' : ''; ?>>Đã xóa</option>
                                <option value="0" <?php echo ($dish['remove'] == 0) ? 'selected' : ''; ?>>Hoạt động</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dish-description">Mô tả</label>
                            <textarea name="description" required class="form-control" id="dish-description" rows="3" cols="50"><?= htmlspecialchars($dish['description']); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>

                <div class="pt-5">
                    <h5 class="py-4">Danh sách nguyên liệu</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="resource-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Tên nguyên liệu</th>
                                    <th scope="col" class="text-center">Đơn vị</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-center">Giá</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalAmount = 0;
                                foreach ($dishDetails as $key => $detail) :
                                    $quantity = floatval($detail['quantity']);
                                    $price = floatval($detail['price']);
                                    $subtotal = $price * $quantity;
                                    $totalAmount += $subtotal;
                                ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $detail['name'] ?></td>
                                        <td><?php echo $detail['unit'] ?></td>
                                        <td><?php echo $detail['quantity'] ?></td>
                                        <td class="text-right"><?php echo number_format($detail['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-link edit" aria-label="edit button" data-toggle="modal" data-id="<?= $detail['id'] ?>" data-name="<?= $detail['name'] ?>" data-price="<?= $detail['price'] ?>" data-unit="<?= $detail['unit'] ?>" data-quantity="<?= $detail['quantity'] ?>" data-target="#updateDishDetail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                    </svg>
                                                </button>
                                                <form id="deleteForm-<?= $detail['id'] ?>" method="post" action="/kitchen/api/dish/detail/deleteDishDetail.php">
                                                    <input type="hidden" name="id" value="<?= $detail['id'] ?>">
                                                    <button type="button" class="btn btn-link text-danger" aria-label="delete button" onclick="confirmDelete(<?php echo $detail['id'] ?>, '<?php echo $detail['name'] ?>', <?php echo $detail['quantity'] ?>)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="font-weight-bold h5">Tổng cộng chí phí nguyên liệu: <?php echo number_format($totalAmount, 0, ',', '.') . ' VNĐ'; ?></p>
                    </div>
                </div>

                <!-- Start: Table resource -->
                <div class="pt-5">
                    <h5 class="py-4">Các nguyên liệu khác hiện có</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="other-resource-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Tên nguyên liệu</th>
                                    <th scope="col" class="text-center">Đơn vị</th>
                                    <th scope="col" class="text-center">Giá</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $resources = mysqli_query($con, "SELECT resources.id,resources.name,resources.price,resources.unit FROM resources WHERE resources.id NOT IN (SELECT dish_detail.resource_id FROM dish_detail WHERE dish_detail.dish_id = $dish_id) ORDER BY name"); ?>
                                <?php foreach ($resources as $key => $resource) : ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $resource['name'] ?></td>
                                        <td><?php echo $resource['unit'] ?></td>
                                        <td class="text-right"><?php echo number_format($resource['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-link insert" data-name="<?= $resource['name'] ?>" data-price="<?= $resource['price'] ?>" data-unit="<?= $resource['unit'] ?>" data-toggle="modal" data-target="#insertResourceToDishModal" data-resource-id="<?php echo $resource['id'] ?>">Thêm
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End: Table resource -->

            </div>

        </div>
    </div>


    <!-- Start: Insert dish detail -->
    <div class="modal fade" id="insertResourceToDishModal" tabindex="-1" role="dialog" aria-labelledby="update modal" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <form method="post" action="/kitchen/api/dish/detail/insertDishDetail.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm nguyên vật liệu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="dish_id" value="<?php echo $dish_id ?>" hidden aria-label="insert dish id">
                        <input name="resource_id" id="insert-dish-id" hidden aria-label="insert resource id">
                        <div class="form-group">
                            <label for="name-resource-insert">Tên nguyên liệu:</label>
                            <input type="text" class="form-control" id="name-resource-insert" disabled aria-describedby="name resource" placeholder="Nhập tên">
                        </div>
                        <div class="form-group">
                            <label for="unit-resource-insert">Đơn vị:</label>
                            <input type="text" class="form-control" id="unit-resource-insert" disabled aria-describedby="unit resource" placeholder="Nhập đơn vị">
                        </div>
                        <div class="form-group">
                            <label for="price-resource-insert">Giá:</label>
                            <input type="text" class="form-control" id="price-resource-insert" disabled aria-describedby="price resource" placeholder="Nhập giá">
                        </div>
                        <div class="form-group">
                            <label for="quantity-dish-detail">Số lượng:</label>
                            <input name="quantity" type="number" class="form-control" id="quantity-dish-detail" aria-describedby="name resource" placeholder="Nhập số lượng" min="1" required value="1">
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
    <!-- End: Update dish detail -->

    <!-- Start: Update dish detail -->
    <div class="modal fade" id="updateDishDetail" tabindex="-1" role="dialog" aria-labelledby="update modal" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <form method="post" action="/kitchen/api/dish/detail/updateDishDetail.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật nguyên vật liệu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="update-dish-detail-id" hidden name="id" aria-label="id dish detail">
                        <div class="form-group">
                            <label for="name-resource">Tên nguyên liệu:</label>
                            <input type="text" class="form-control" id="name-resource" disabled aria-describedby="name resource" placeholder="Nhập tên">
                        </div>
                        <div class="form-group">
                            <label for="unit-resource">Đơn vị:</label>
                            <input type="text" class="form-control" id="unit-resource" disabled aria-describedby="unit resource" placeholder="Nhập đơn vị">
                        </div>
                        <div class="form-group">
                            <label for="price-resource">Giá:</label>
                            <input type="text" class="form-control" id="price-resource" disabled aria-describedby="price resource" placeholder="Nhập giá">
                        </div>
                        <div class="form-group">
                            <label for="update-quantity-dish-detail">Số lượng:</label>
                            <input name="quantity" type="number" class="form-control" id="update-quantity-dish-detail" aria-describedby="quantity dish detail" placeholder="Nhập số lượng" required min="1">
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
    <!-- End: Update dish detail -->

    <script src="../../../js/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="../../../js/datatables.min.js"></script>
    <script src="../../../js/sweetalert.min.js"></script>
    <script>
        function confirmDelete(id, name, quantity) {
            swal({
                    title: "Bạn có chắc chắn muốn xoá không?",
                    text: "id: " + id + ", tên: " + name + ", số lượng: " + quantity + "",
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
        $(document).ready(function() {
            $(".nav-link").removeClass("active")
            $("#chef-suggest").addClass("active")
            $('#updateForm').submit(function(event) {
                let id = $('#dish-id').val().trim();
                let name = $('#dish-name').val().trim();
                let price = $('#dish-price').val();
                let description = $('#dish-description').val().trim();

                if (id === '' || name === '' || price === '' || isNaN(parseFloat(price)) || parseFloat(price) < 0 || description === '') {
                    swal("Thất bại!", "Hãy nhập đầy đủ thông tin.", "error");
                    event.preventDefault();
                }
            });

            // handle change image
            $('#get-file').click(function() {
                $('#image').click();
            });

            $('input[type=file]').change(function(e) {
                e.preventDefault();
                console.log("abc")
                console.log($(this).val())
                $('#changeImageForm').submit();
                console.log("abc2")
            });

            // handle pass data to modal
            $('.edit').click(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let unit = $(this).data('unit');
                let price = $(this).data('price');
                let quantity = $(this).data('quantity');

                $('#update-dish-detail-id').attr("value", id);
                $('#name-resource').attr("value", name);
                $('#unit-resource').val(unit);
                $('#price-resource').val(price);
                $('#update-quantity-dish-detail').val(quantity);
            });

            $('.insert').click(function() {
                let id = $(this).data('resource-id');
                let name = $(this).data('name');
                let unit = $(this).data('unit');
                let price = $(this).data('price');

                $('#name-resource-insert').attr("value", name);
                $('#unit-resource-insert').val(unit);
                $('#price-resource-insert').val(price);
                $('#insert-dish-id').attr("value", id);
            });

            $('#other-resource-table').DataTable({
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

            $('#resource-table').DataTable({
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                    },
                    {
                        targets: 5,
                        orderable: false,
                    }
                ],
                columns: [{
                        orderable: false
                    },
                    null,
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
                    search: "Tìm:",
                    emptyTable: "Chưa có nguyên liệu nào.",
                },
            });
        });
    </script>
</body>

</html>