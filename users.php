<?php 
include ('inc/header.php');
include ('inc/functions/functions.php');

$functions = new functions_User();
$functions->processDeleteUser($conn);
$users = $functions->getAllUsers($conn);
?>

                    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Users</h1>
                    <p class="mb-4">Datatables Users <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Datatables Users</h6>
                        <a href="form_add_user.php" class="btn btn-primary">
                            Add User
                        </a>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                $message = new message_Alert();
                                $message->alertMessage();
                                ?>                               
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Email</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Company</th>
                                            <th>Phone</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Email</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Company</th>
                                            <th>Phone</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                       <?php foreach ($users as $row): ?>
                                        <tr>
                                            <td><?php echo $row->username; ?></td>
                                            <td><?php echo $row->password; ?></td>
                                            <td><?php echo $row->email; ?></td>
                                            <td><?php echo $row->first_name; ?></td>
                                            <td><?php echo $row->last_name; ?></td>
                                            <td><?php echo $row->company; ?></td>
                                            <td><?php echo $row->phone; ?></td>
                                            <td>
                                                <a href="form_edit_user.php?id=<?php echo $row->id; ?>" class="btn btn-warning btn-sm">Edit</a>       
                                                <a href="users.php?action=hapus&id=<?php echo $row->id;?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin mau hapus?')">
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
<?php 
include('inc/footer.php');
?>