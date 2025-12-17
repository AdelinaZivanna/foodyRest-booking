<?php 
include ('inc/header.php');
include ('inc/functions/functions.php');

$functions = new functions_Group();
$functions->processAddGroup($conn);
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Page Add Group</h1>
                    <div class="card">
                        <form action="form_add_group.php" method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                        <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <a href="groups.php" class="btn btn-secondary">Kembali</a>
                        </div>  
                    </form>                                       
                    </div>
                </div>
                <!-- /.container-fluid -->

<?php 
include('inc/footer.php');
?>