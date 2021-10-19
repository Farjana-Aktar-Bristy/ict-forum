<?php
include 'includes/navbar.php';
if (!isset($_SESSION['userName'])) {
    header("Location: login.php");
}
?>

<div class="container">
    <div class="col-lg-10 col-md-10 col-sm-12 offset-lg-1 offset-md-1" style="border: 1px solid darkblue; padding: 25px;">

        <form id="notice-form" action="saveNotice.php" method="post" role="form">
            <input type="hidden" name="notice-submitted"/>
            <h5 style="background-color: lightgray; padding: 10px; text-align: center; color: darkblue; margin: -25px -25px 25px -25px;">Notify Students</h5>
            <div class="alert alert-danger" id="notif-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="notif"></strong>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-pencil-square-o"></i></div>
                </span>
                <input id="title" class="form-control py-2 border-left-0 border" type="text" name="title" 
                       value="<?php if (isset($_GET['title'])) echo '' . $_GET['title']; ?>" placeholder="Title" required/>
            </div>
            <h5>Select which batch to be notified:</h5>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-graduation-cap"></i></div>
                </span>
                <select id="batch" class="form-control border-left-0 border" name="batch" required>
                    <option value="">Select Batch..</option>
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
            <h5 style="margin-top: 20px;">Notice body:</h5>
            <div class="row mt-3">
                <textarea name="notice" required rows="10" cols="250"></textarea>
            </div>
            <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php' ?>
</div>
<!--<script>
    CKEDITOR.replace('notice', {
        height: 300,
        filebrowserUploadUrl: 'ckeditor/ckImageUpload.php',
        filebrowserUploadMethod: 'form',
        removeButtons: 'Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,BidiLtr,BidiRtl,Language,Flash,PageBreak,Iframe,About,Save,Templates,NewPage,Preview,Print,Checkbox,Image'
    });
</script>-->
<?php
if (isset($_GET['error'])) {
    ?>
    <script>
        $('#notif').empty();
        $('#notif').append('Empty notice body');
        $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
    </script>

    <?php
}
?>
