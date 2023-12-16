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
            <?php include "../../layouts/sidebar_kitchen.php" ?>

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
                        <!-- <form class="d-flex justify-content-center pt-3" id="changeImageForm" enctype="multipart/form-data"
                          method="post" action="/kitchen/api/dish/updateImageDish.php">
                        <input name="id" value="<?php //$dish_id 
                                                ?>" hidden aria-label="id dish">
                        <input type="button" id="get-file" value="Chọn ảnh" class="btn btn-primary">
                        <input type="file" id="image" class="d-none" name="image" accept=".jpeg, .jpg, .png"
                               aria-label="image dish">
                    </form> -->
                    </div>
                    <!-- End: Image dish -->
                    <form id="updateForm" method="post" action="/kitchen/api/dish/updateDish.php">
                        <input name="id" hidden type="text" class="form-control" id="dish-id" aria-label="dish id" value="<?= $dish['dish_id'] ?>">

                        <div class="form-group">
                            <label for="dish-name">Tên món ăn</label>
                            <input name="name" value="<?php echo $dish['name']; ?>" type="text" class="form-control" id="dish-name" aria-describedby="dish name" placeholder="Nhập tên món ăn" disabled>
                        </div>

                        <div class="form-group">
                            <label for="dish-category">Danh mục</label>
                            <select id="dish-category" class="form-control" name="category_id" disabled>
                                <?php $categories = mysqli_query($con, "SELECT * FROM categories"); ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option <?= ($category['id'] === $dish['category_id']) ? 'selected' : '' ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dish-price">Giá</label>
                            <input name="price" value="<?php echo $dish['price']; ?>" type="number" class="form-control" id="dish-price" aria-describedby="dish name" placeholder="Nhập giá món" disabled>
                        </div>

                        <div class="form-group">
                            <label for="dish-is_approved">Tình trạng xét duyệt</label>
                            <select name="is_approved" disabled class="form-control" id="dish-is_approved" value="<?php echo $dish['is_approved']; ?>">
                                <option value="1" <?php echo ($dish['is_approved'] == 0) ? 'selected' : ''; ?>>Chưa duyệt
                                </option>
                                <option value="0" <?php echo ($dish['is_approved'] == 1) ? 'selected' : ''; ?>>Đã duyệt
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
                            <textarea name="description" disabled class="form-control" id="dish-description" rows="3" cols="50"><?= htmlspecialchars($dish['description']); ?></textarea>
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

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="font-weight-bold h5">Tổng cộng chí phí nguyên liệu: <?php echo number_format($totalAmount, 0, ',', '.') . ' VNĐ'; ?></p>
                    </div>
                </div>



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
            $("#chef-dish").addClass("active")
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