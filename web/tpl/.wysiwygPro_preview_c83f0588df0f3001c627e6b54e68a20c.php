<?php
if ($_GET['randomId'] != "y_EYnVv7dLdnvHXwyiPTtgNlNtVjU8MZj3h3aQdj_9f4w749FL195pBggMuOBj7E") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
