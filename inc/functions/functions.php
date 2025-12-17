<?php
include ('config.php');
include ('functions_group.php');
include ('functions_user.php');


class message_Alert {
function alertMessage() {
    if (isset($_SESSION['message'])) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['message'] . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        unset($_SESSION['message']);
    }
}
}

?>

