<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php require_once('inc/connection.php'); ?>
<?php
if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
} else {
    $page = 1;
}
$limit = 7;
$offset = ($page - 1) * $limit;
$query = "select count(id) as totle from posts";
$run = mysqli_query($con, $query);
if (mysqli_num_rows($run) == 1) {
    $post = mysqli_fetch_assoc($run);
    $totle = $post['totle'];
}
$numberOfPages = ceil($totle / $limit);
if ($page < 1 or $page > $numberOfPages) {
    header("location" . $_SERVER['PHP_SELF'] . "?page=1");
}
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
} else {
    $query = "select id,title,created_at from posts limit $limit offset $offset";
    $runQuery = mysqli_query($con, $query);
    if (mysqli_num_rows($runQuery) > 0) {
        $posts = mysqli_fetch_all($runQuery, MYSQLI_ASSOC);
    } else {
        $msgs = "no post founded";
    }
?>
    <div class="container-fluid pt-4">
        <div class="row">
            <?php require_once 'inc/success.php'; ?>
            <?php require_once 'inc/update.php'; ?>
            <div class="col-md-10 offset-md-1">
                <div class="d-flex justify-content-between border-bottom mb-5">
                    <div>
                        <h3><?php echo $msg['All posts'] ?></h3>
                    </div>
                    <div>
                        <a href="create-post.php" class="btn btn-sm btn-success"><?php echo $msg['Add new post'] ?></a>
                    </div>
                </div>
                <?php if (!empty($posts)) {
                ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo $msg['Title'] ?></th>
                                <th scope="col"><?php echo $msg['Published_At'] ?></th>
                                <th scope="col"><?php echo $msg['Actions'] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post) { ?>
                                <tr>
                                    <td><?php echo $post['title'] ?></td>
                                    <td><?php echo $post['created_at'] ?></td>
                                    <td>
                                        <a href="show-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-primary"><?php echo $msg['Show'] ?></a>
                                        <a href="edit-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-secondary"><?php echo $msg['Edit'] ?></a>
                                        <a href="handle/delete-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('<?php echo $msg['do you really want to delete post?'] ?>')"><?php echo $msg['Delete'] ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo $msg ['no post founded'];
                } ?>
            </div>
        </div>
    </div>
    <?php require('inc/footer.php'); ?>
<?php } ?>
<div class="continer d-flex justify-content-center mt-5">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?php if ($page == 1)  echo "disabled" ?> ">
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href=""><?php echo $page ?> <?php echo $msg['of'] ?> <?php echo $numberOfPages ?></a></li>
            <li class="page-item <?php if ($page == $numberOfPages)  echo "disabled" ?>">
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>