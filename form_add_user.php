<?php 
include ('inc/header.php');
include ('inc/functions/functions.php');

$functions = new functions_User();
$functions->processAddUser($conn);

?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Page Add User</h1>
                    <div class="card">
                        <form action="form_add_user.php" method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name">
                            </div>   
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" name="company">
                            </div>         
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone">
                            </div> 
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                <a href="users.php" class="btn btn-secondary">Kembali</a>       
                            </div>
                        </div>  
                    </form>                                       
                    </div>
                </div>
                <!-- /.container-fluid -->

<?php 
include('inc/footer.php');
?>