<?php
include ('inc/header.php');
include ('inc/functions/functions.php');

$functions = new functions_User();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $editData = $functions->getUserById($conn, $id);
}

$functions->processEditUser($conn);
?>

<div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    <div class="card mb-4">
        <div class="card-header">Form Edit</div>
        <div class="card-body">
            <form method="POST" action="form_edit_user.php">
                <input type="hidden" name="id" value="<?php echo $editData->id; ?>">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $editData->username; ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $editData->email; ?>">
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo $editData->first_name; ?>">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo $editData->last_name; ?>">
                </div>
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" name="company" class="form-control" value="<?php echo $editData->company; ?>">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $editData->phone; ?>">
                </div>
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="users.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>