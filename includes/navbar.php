<?php
ob_start();
session_start();
include 'DatabaseConnection.php';
?>
<html>
    <head>
        <script src="jquery/jquery-3.4.1.min.js.js"></script>
        <script src="jquery/popper.min.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/jquery-ui.css">
        <script src="jquery/jquery-1.12.4.js"></script>
        <script src="jquery/jquery-ui.js"></script>
        <script src="ckeditor/ckeditor.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="ckeditor/plugins/codesnippet/lib/highlight/styles/default.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <link href="styles/croppie.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="jquery/croppie.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container fixed-top">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler mb-sm-4 mb-xs-4" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a id="home" class="nav-link btn btn-outline-primary" href="index.php">Home</a>
                        </li>
                        <!--                        <li class="nav-item">
                                                    <a id="addPost" class="nav-link btn btn-outline-primary" href="addPost.php">Add your content</a>
                                                </li>-->
                        <li class="nav-item">
                            <a id="askQuestion" class="nav-link btn btn-outline-primary" href="askQuestion.php">Ask Question</a>
                        </li>

                        <?php
                        if (isset($_SESSION['userName'])) {
                            $userDetails = getUserDetails($_SESSION['userName']);
                            $userDetailsRow = mysqli_fetch_assoc($userDetails);
                            if ($userDetailsRow['role'] == 'TEACHER') {
                                ?>
                                <li class="nav-item">
                                    <a id="addNotice" class="nav-link btn btn-outline-primary" href="addNotice.php">Add Notice</a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Public
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Posts</a>
                                <a class="dropdown-item" href="#">Questions</a>
                                <a class="dropdown-item" href="#">Tags</a>
                                <a class="dropdown-item" href="#">Users</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav">
                        <?php
                        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] == 'false') {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="signup.php" title="Signup">
                                    <i class="fa fa-user-plus">
                                        <span class="d-md-none d-lg-none d-xl-none" style="font-weight: bold;"> Signup</span>
                                    </i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="login.php" title="Login">
                                    <i class="fa fa-sign-in">
                                        <span class="d-md-none d-lg-none d-xl-none" style="font-weight: bold;"> Login</span>
                                    </i>
                                </a>
                            </li>

                            <?php
                        } elseif (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == 'true') {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="notifications.php" title="Notifications">
                                    <i id="notification" class="fa fa-bell">
                                        <span id="unviewed-notification" style="color: red; font-weight: bold;"></span>
                                    </i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="notices.php" title="Notices">
                                    <i id="notice" class="fa fa-clipboard">
                                        <span id="unviewed-notice" style="color: red; font-weight: bold;"></span>
                                    </i>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="profile.php" title="Profile">
                                    <i class="fa fa-user">
                                        <span class="d-md-none d-lg-none d-xl-none" style="font-weight: bold;"> Profile</span>
                                    </i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" data-toggle="modal" data-target="#logout-modal" title="Logout">
                                    <i class="fa fa-sign-out">
                                        <span class="d-md-none d-lg-none d-xl-none" style="font-weight: bold;"> Logout</span>
                                    </i>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == 'true') { ?>
                        <form action="searchResult.php" method="get" class="form-inline nav-item nav-link" id="nav-search">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-search"></i></div>
                                </span>
                                <input class="form-control py-2 border-left-0 border" type="search" name="search_value"
                                       placeholder="topics, tags, users" id="example-search-input"
                                       value="<?php if (isset($_GET['search_value'])) echo '' . $_GET['search_value']; ?>">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary border-left-0 border" type="submit">
                                        Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </nav>
        </div>
        <div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Logging Out !!!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you really want to logout?
                    </div>
                    <div class="modal-footer">
                        <a href="logout.php" type="button" class="btn btn-primary">Yes</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function worker() {
                $.get('notify.php', function (data) {
                    // Now that we've completed the request schedule the next one.
                    $('#unviewed-notice').empty();
                    $('#unviewed-notice').append(data);
                    setTimeout(worker, 5000);
                });
            })();
            
            (function notifWorker() {
                $.get('getNotificationCount.php', function (data) {
                    // Now that we've completed the request schedule the next one.
                    $('#unviewed-notification').empty();
                    $('#unviewed-notification').append(data);
                    setTimeout(notifWorker, 5000);
                });
            })();
        </script>
