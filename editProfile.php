<?php include 'includes/navbar.php'; ?>
<?php
$userId = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    header("Location:login.php?page=profile.php");
}
$result = getUserDetails($userName);
$row = NULL;
if ($result != "") {
    $row = mysqli_fetch_assoc($result);
}
?>
<div class="container">
    <div class="row d-flex justify-content-end mr-2">
        <a href="changePassword.php" class="btn btn-warning">Change Password</a>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
            <img src="<?php
            if ($row['profile_picture'] != "")
                echo 'images/' . $row['profile_picture'];
            else {
                echo 'images/avatar.png';
            }
            ?>" class="img-fluid img-thumbnail rounded-circle" height="200px;" width="200px;"/>
        </div>
    </div>
    <div class="row d-flex justify-content-center align-items-center m-2">
        <span class="btn btn-primary btn-file">
            Update profile picture <input type="file" name="upload_image" id="upload_image" accept="image/*" />
        </span>
    </div>
    <!--    <div class="row d-flex justify-content-center align-items-center m-2">
            <h3><?php //echo '' . $row['fullname'];    ?></h3>
        </div>-->
    <div class="row d-flex justify-content-center align-items-center m-2">
        <?php
        if ($row['role'] == "STUDENT") {
            echo '<h6>' . $row['student_id'] . ', ICT ' . $row['batch'] . ' Batch, MBSTU</h6>';
        }
        ?>
    </div>
    <form method="post" action="#">
        <input type="hidden" name="edit_profile"/>
        <div class="col-md-8 offset-md-2">
            <div class="alert alert-danger" id="notif-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="notif"></strong>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row m-2">
                <div class="col-md-4 col-sm-12">
                    Username:
                </div>
                <div class="col-md-8 col-sm-12">
                    <input name="username" class="form-control" value="<?php echo $row['user_name']; ?>" readonly/>
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row m-2">
                <div class="col-md-4 col-sm-12">
                    Email:
                </div>
                <div class="col-md-8 col-sm-12">
                    <input name="email" class="form-control" value="<?php echo $row['email']; ?>" readonly/>
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row m-2">
                <div class="col-md-4 col-sm-12">
                    Full name:
                </div>
                <div class="col-md-8 col-sm-12">
                    <input name="fullname" class="form-control" value="<?php echo $row['fullname']; ?>"/>
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row m-2">
                <div class="col-md-4 col-sm-12">
                    Expert in: 
                </div>
                <div class="col-md-8 col-sm-12">
                    <textarea name="expert_in" class="form-control"><?php echo '' . $row['expert_in']; ?></textarea>
                    Comma separated subject that you like most.
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row m-2">
                <div class="col-md-4 col-sm-12">
                    Bio:
                </div>
                <div class="col-md-8 col-sm-12">
                    <textarea class="form-control" name="description"><?php echo '' . $row['description']; ?></textarea>
                </div>
            </div>
            <div class="row m-4">
                <input type="submit" class="btn btn-primary" value="Submit" style="width: 100%;"/>
            </div>
        </div>
    </form>
</div>


<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div id="image_demo" class="img-fluid" style="margin:20px"></div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button class="btn btn-success crop_image">Crop & Upload Image</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['edit_profile'])) {
    $userName = $_SESSION['userName'];
    $fullname = $_POST['fullname'];
    $expertIn = $_POST['expert_in'];
    $description = $_POST['description'];
    $result = updateProfile($fullname, $expertIn, $description, $userName);
    if ($result == 'error') {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append('Error Occured!!!');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    }
}
?>

<script>
    $(document).ready(function () {

        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 300,
                height: 300,
                type: 'square' //circle
            },
            boundary: {
                width: 400,
                height: 400
            }
        });

        $('#upload_image').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        });

        $('.crop_image').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: {"image": response},
                    success: function (data)
                    {
                        $('#uploadimageModal').modal('hide');
                        window.location.href = "editProfile.php";
                    }
                });
            })
        });

    });
</script>