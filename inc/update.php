<?php
if (isset($_SESSION['upSuccess'])) { ?>
    <div class="alert alert-success"><?php echo $_SESSION['upSuccess'] ?></div>
<?php }
unset($_SESSION['upSuccess']);
?>