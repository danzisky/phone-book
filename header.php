<html>
    <link rel="stylesheet" href="css/w3.css">
<?php
    if(isset($_REQUEST['status'])) {
        $status = $_REQUEST['status'];
        $status == 'success' ? $color = 'green' : $color = 'red';
    }
    if(isset($_REQUEST['message'])) {
        $message = $_REQUEST['message'];
?>
    <div class="w3-panel w3-padding-32 w3-light-<?php echo $color; ?>" onclick="this.style.display='none'">
        <div class="w3-text-<?php echo $color; ?>">
            <?php echo $message; ?>
        </div>
        <div class="w3-text-white w3-small">
            click to close
        </div>
    </div>
<?php
    }
?>
   
