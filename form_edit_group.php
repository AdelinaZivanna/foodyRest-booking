<?php
include ('inc/header.php');
include ('inc/functions/functions.php');

$functions = new functions_Group();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $editData = $functions->getGroupById($conn, $id);
}

$functions->processEditGroup($conn, );
?>

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Edit Group</h1>
    <div class="card mb-4">
        <div class="card-header">Form Edit</div>
        <div class="card-body">
            <form method="POST" action="form_edit_group.php">
                <input type="hidden" name="id" value="<?php echo $editData->id; ?>">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $editData->name; ?>">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"><?php echo $editData->description; ?></textarea>
                </div>
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="groups.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>    
    </div>

<?php include('inc/footer.php'); ?>
