<?php 
include ('inc/header.php');
include ('inc/functions/functions.php');

$functions = new functions_Group();
$functions->processDeleteGroup($conn);
$groups = $functions->getAllGroups($conn);
?>
                    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Groups</h1>

                    <p class="mb-4">Datatables groups <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p>
                    <!-- DataTales Example -->

                    <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Datatables Groups</h6>
                        <a href="form_add_group.php" class="btn btn-primary">
                            Add Group
                        </a>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                $message = new message_Alert();
                                $message->alertMessage(); ?>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                       <?php foreach($groups as $row): ?>
                                        <tr>
                                            <td><?php echo $row->id; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->description; ?></td>
                                            <td>
                                                <a href="form_edit_group.php?id=<?php echo $row->id; ?>"
                                                    class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <a href="groups.php?action=hapus&id=<?php echo $row->id;?>"
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