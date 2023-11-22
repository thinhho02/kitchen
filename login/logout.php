<?php
session_start();
include '../connect/connect.php';
// $employee_id = $_SESSION['employee_id'];
// $employee_manager_id = $_SESSION['employee_manager_id'];
// $employee_shipper_id = $_SESSION['employee_shipper_id'];
// $employee_kitchen_id = $_SESSION['employee_kitchen_id'];
$id = $_REQUEST['id'];
$select = mysqli_query($con, "Select * from employees where `employee_id` = '$id'");
$results = mysqli_fetch_assoc($select);
// echo var_dump($results);
// $employee_id = $results['employee_id'];
if ($id) {
    if (isset($_SESSION['employee_id'])) {
        if ($_SESSION['employee_id'] === $id) {
            mysqli_query($con, "UPDATE `employees` SET `status` = false WHERE `employee_id` = '$id'");
            unset($_SESSION['employee_id']);                // logout nhân viên
            header('location:../login');
            die;
        }
    } elseif (isset($_SESSION['employee_manager_id'])) {
        if ($_SESSION['employee_manager_id'] === $id) {
            unset($_SESSION['employee_manager_id']);         //logout quản lý
            header('location:../login');
            die;
        }
    } elseif (isset($_SESSION['employee_deliver_id'])) {
        if ($_SESSION['employee_deliver_id'] === $id) {
            unset($_SESSION['employee_deliver_id']);        //logout shipper
            header('location:../login');
            die;
        }
    } elseif (isset($_SESSION['employee_chef_id'])) {
        if ($_SESSION['employee_chef_id'] === $id) {
            unset($_SESSION['employee_chef_id']);           //logout nhà bếp
            header('location:../login');
            die;
        }
    }
} else {
    header('location:../login');
}

    // if(isset($_SESSION[`$employee_id`])){
    //     unset($_SESSION[`$employee_id`]);
    // }
    // header('location:../login');
    // die;
