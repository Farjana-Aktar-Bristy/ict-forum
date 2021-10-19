<?php
include 'includes/navbar.php';
?>
<!--<div class="container fixed-top" style="margin-top:65px; margin-bottom: 10px; border-top: 1px solid white;">
<?php // include 'includes/search.php' ?>
</div>-->
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="bg-light" style="align-content: center; text-align: center;">
                <!--                <div class="dropdown-divider sidebar"></div>
                                <a id="posts-sidemenu" class="dropdown-item sidebar" href="#">Posts</a>-->
                <div class="dropdown-divider sidebar"></div>
                <a id="notices-sidemenu" class="dropdown-item sidebar" href="notices.php?criteria=new">Notices</a>
                <div class="dropdown-divider sidebar"></div>
                <a id="tags-sidemenu" class="dropdown-item sidebar" href="tags.php">Tags</a>
                <div class="dropdown-divider sidebar"></div>
                <a id="users-sidemenu" class="dropdown-item sidebar" href="users.php">Users</a>
                <div class="dropdown-divider sidebar"></div>
            </div>
        </div>
        <div class="col-md-10" id="content">
            <?php
            $users = getAllUserInfo();
            if ($users == "empty") {
                echo '<h2>No users found</h2>';
            } else {
                ?>

                <table id="tags" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>About</th>
                            <th>Expert in</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($users)) {
                            ?>
                            <tr>
                                <td><a href="userDetails.php?username=<?php echo '' . $row['user_name']; ?>"><?php echo '' . $row['fullname']; ?></a></td>
                                <?php if ($row['role'] == "STUDENT") { ?>
                                    <td><?php echo 'ID: ' . $row['student_id'] . ', ICT ' . $row['batch'] . ' Batch'; ?></td>
                                <?php } else {
                                    ?>
                                    <td><?php echo $row['designation'] . ", Dept. of ICT"; ?></td>
                                    <?php
                                }
                                ?>
                                <td><?php echo '' . $row['expert_in']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>About</th>
                            <th>Expert in</th>
                        </tr>
                    </tfoot>
                </table>
                <?php
            }
            ?>
        </div>

    </div>
    <?php include 'includes/footer.php' ?>
</div>
<script>
    $(document).ready(function () {
        $('.sidebar').removeClass('active');
        $('#users-sidemenu').addClass('active');
    });
</script>

<script>
    $(document).ready(function () {
        $('#tags').DataTable();
//        $('input').addClass('form-control');
//        $('select').addClass('form-control');
    });
</script>
