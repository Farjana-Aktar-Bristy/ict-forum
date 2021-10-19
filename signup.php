<?php include 'includes/navbar.php'; ?>

<div class="container">
    <div class="col-md-8 offset-md-2" style="border: 1px solid darkblue; padding: 25px 25px 0px 25px;">
        <h3 style="text-align: center; margin-bottom: 25px; font-weight: bold;">Registration</h3>
        <div class="row">
            <div class="col-md-6" style="padding-right: 0px;">
                <a href="#" class="active btn btn-info" id="student-form-link" style="width: 100%; border-radius: 10px 0px 0px 10px;">Student</a>
            </div>
            <div class="col-md-6" style="padding-left: 0px;">
                <a href="#" class="btn btn-success" id="teacher-form-link" style="width: 100%; border-radius: 0px 10px 10px 0px;">Teacher</a>
            </div>
        </div>
        <div class="alert alert-danger" id="notif-div" style="margin: 5px; display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong id="notif"></strong>
        </div>
        <form id="student-form" action="#" method="post" role="form" style="display: block;">
            <input type="hidden" name="studentForm"/>
            <h5 class="mt-3" style="background-color: lightblue; padding: 10px; text-align: center; color: darkblue">Student registration form</h5>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-pencil-square-o"></i></div>
                </span>
                <input id="fullname" class="form-control py-2 border-left-0 border" type="text" name="fullname" value="<?php if(isset($_POST['fullname'])) echo ''.$_POST['fullname']; ?>"
                       placeholder="Full Name" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-graduation-cap"></i></div>
                </span>
                <select id="batch" class="form-control border-left-0 border" name="batch" required>
                    <option value="">Select your batch..</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
                    <option value="4th">4th</option>
                    <option value="5th">5th</option>
                    <option value="6th">6th</option>
                    <option value="7th">7th</option>
                    <option value="8th">8th</option>
                    <option value="9th">9th</option>
                    <option value="10th">10th</option>
                    <option value="11th">11th</option>
                    <option value="12th">12th</option>
                    <option value="13th">13th</option>
                    <option value="14th">14th</option>
                    <option value="15th">15th</option>
                    <option value="16th">16th</option>
                    <option value="17th">17th</option>
                    <option value="18th">18th</option>
                    <option value="19th">19th</option>
                    <option value="20th">20th</option>
                </select>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-graduation-cap"></i></div>
                </span>
                <input id="studentId" class="form-control py-2 border-left-0 border" type="text" name="studentId" value="<?php if(isset($_POST['studentId'])) echo ''.$_POST['studentId']; ?>"
                       placeholder="Student ID (ex: IT-16060)" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input id="username" class="form-control py-2 border-left-0 border" type="text" name="username" value="<?php if(isset($_POST['username'])) echo ''.$_POST['username']; ?>"
                       placeholder="Username" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-envelope"></i></div>
                </span>
                <input id="email" class="form-control py-2 border-left-0 border" type="email" name="email" value="<?php if(isset($_POST['email'])) echo ''.$_POST['email']; ?>"
                       placeholder="Email" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-lock"></i></div>
                </span>
                <input id="password" class="form-control py-2 border-left-0 border" type="password" name="password" 
                       placeholder="Password" required/>
            </div>
            <div class="input-group mt-3">
                <button id="student-submit" type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </div>
        </form>

        <form id="teacher-form" action="#" method="post" role="form" style="display: none;">
            <input type="hidden" name="teacherForm"/>
            <h5 class="mt-3" style="background-color: lightblue; padding: 10px; text-align: center; color: darkblue">Teacher registration form</h5>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-pencil-square-o"></i></div>
                </span>
                <input id="fullname" class="form-control py-2 border-left-0 border" type="text" name="tc-fullname" value="<?php if(isset($_POST['tc-fullname'])) echo ''.$_POST['tc-fullname']; ?>"
                       placeholder="Full Name" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-graduation-cap"></i></div>
                </span>
                <select id="designation" class="form-control border-left-0 border" name="designation" required>
                    <option value="">Select your designation...</option>
                    <option value="Professor">Professor</option>
                    <option value="Associate Professor">Associate Professor</option>
                    <option value="Assistant Professor">Assistant Professor</option>
                    <option value="Lecturer">Lecturer</option>
                </select>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input id="username" class="form-control py-2 border-left-0 border" type="text" name="tc-username" value="<?php if(isset($_POST['tc-username'])) echo ''.$_POST['tc-username']; ?>"
                       placeholder="Username" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-envelope"></i></div>
                </span>
                <input id="email" class="form-control py-2 border-left-0 border" type="email" name="tc-email" value="<?php if(isset($_POST['tc-email'])) echo ''.$_POST['tc-email']; ?>"
                       placeholder="Email" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-lock"></i></div>
                </span>
                <input id="password" class="form-control py-2 border-left-0 border" type="password" name="tc-password" 
                       placeholder="Password" required/>
            </div>
            <div class="input-group mt-3">
                <button id="teacher-submit" type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php' ?>
</div>

<script>
    $(function () {

        $('#student-form-link').click(function (e) {
            $("#student-form").delay(100).fadeIn(100);
            $("#teacher-form").fadeOut(100);
            $('#teacher-form-link').removeClass('active');
            $(this).addClass('active');
            $("#notif-div").css("display", "none");
            e.preventDefault();
        });
        $('#teacher-form-link').click(function (e) {
            $("#teacher-form").delay(100).fadeIn(100);
            $("#student-form").fadeOut(100);
            $('#student-form-link').removeClass('active');
            $(this).addClass('active');
            $("#notif-div").css("display", "none");
            e.preventDefault();
        });

    });

</script>

<?php
if (isset($_POST['studentForm'])) {
    $fullname = $_POST['fullname'];
    $studentId = $_POST['studentId'];
    $batch = $_POST['batch'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'STUDENT';
    $designation = "";
    $result = register($fullname, $studentId, $username, $email, $password, $role, $batch, $designation);
    if ($result == "userNameExist") {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append('Username Exist. Try new one');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    } elseif ($result == "emailExist") {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append('Email Exist. Try new one');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    } elseif ($result == "error") {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append('Error Occured!!!');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    }
} elseif (isset($_POST['teacherForm'])) {
    $fullname = $_POST['tc-fullname'];
    $studentId = "";
    $batch = "";
    $username = $_POST['tc-username'];
    $email = $_POST['tc-email'];
    $password = $_POST['tc-password'];
    $designation = $_POST['designation'];
    $role = 'TEACHER';
    $result = register($fullname, $studentId, $username, $email, $password, $role, $batch, $designation);
    if ($result == "userNameExist") {
        ?>
        <script>
            $("#teacher-form").delay(100).fadeIn(100);
            $("#student-form").fadeOut(100);
            $('#student-form-link').removeClass('active');
            $('#teacher-form-link').addClass('active');
            $('#notif').empty();
            $('#notif').append('Username Exist. Try new one');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    } elseif ($result == "emailExist") {
        ?>
        <script>
            $("#teacher-form").delay(100).fadeIn(100);
            $("#student-form").fadeOut(100);
            $('#student-form-link').removeClass('active');
            $('#teacher-form-link').addClass('active');
            $('#notif').empty();
            $('#notif').append('Email Exist. Try new one');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    } elseif ($result == "error") {
        ?>
        <script>
            $("#teacher-form").delay(100).fadeIn(100);
            $("#student-form").fadeOut(100);
            $('#student-form-link').removeClass('active');
            $('#teacher-form-link').addClass('active');
            $('#notif').empty();
            $('#notif').append('Error Occured!!!');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    }
}
?>
