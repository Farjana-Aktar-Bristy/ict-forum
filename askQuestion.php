
<?php
include 'includes/navbar.php';
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    header("Location:login.php?page=askQuestion.php");
}
?>

<script>
    $('ul>li>a.active').removeClass('active');
    $('#askQuestion').addClass('active');
</script>
<?php
$allTag = getAllTag();
$allTagArray = array();
if ($allTag != "") {
    
    while ($row = mysqli_fetch_assoc($allTag)) {
        array_push($allTagArray, $row['tag_name']);
    }
}
?>
<script>
    var availableTags = <?php echo ''.  json_encode($allTagArray).';'; ?>
    $(function () {
        $("#tag-input").autocomplete({
            source: availableTags
        });
    });
</script>

<div class="container">
    <div class="col-lg-10 col-md-10 offset-lg-1 offset-md-1">
        <form id="question-form" action="saveQuestion.php" method="post">
            <input type="hidden" name="question-submitted"/>
            <input id="tags-form-input" type="hidden" name="tags-form-input"/>
            <div class="alert alert-danger" id="error-div" style="margin: 5px; display: none;">
                <!--                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>-->
                <strong id="error-msg"></strong>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-pencil-square-o"></i></div>
                </span>
                <input id="title" class="form-control py-2 border-left-0 border" type="text" name="title" 
                       value="<?php if (isset($_GET['title'])) echo '' . $_GET['title']; ?>" placeholder="Title" required/>
            </div>
            <div class="row">
                <ul id="tag-list"></ul> 
            </div>

            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-tag"></i></div>
                </span>
                <input id="tag-input" class="form-control py-2 border-left-0 border" type="text" placeholder="Tags" />
            </div>
            <div class="row m-1">
                <label style="font-weight: bold;">Question body:</label>
                <textarea name="editor1" required></textarea>    
            </div>
            <div class="alert alert-danger" id="error-div2" style="margin: 5px; display: none;">
                <!--                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>-->
                <strong id="error-msg2"></strong>
            </div>
            <div class="row mt-2 m-1">
                <button type="button" onclick="saveQuestion()" class="btn btn-primary" style="width: 100%;">Post your question</button>   
            </div>
        </form>
    </div>

<?php include 'includes/footer.php' ?>
</div>


<script>
    CKEDITOR.replace('editor1', {
        height: 300,
        filebrowserUploadUrl: 'ckeditor/ckImageUpload.php',
        filebrowserUploadMethod: 'form'
    });
</script>

<script type="text/javascript">
    var unsaved = false;

    $('#tag-input').keypress(function (event) {
        var tagValue = $(this).val();
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            event.preventDefault();
            if ($.trim(tagValue).length != 0) {
                $('#tag-list').append('<li class="tag-item">' + $.trim(tagValue) + '<span class="tag-span"><button class="remove-tag-button" onclick="deleteTag(\'' + $.trim(tagValue) + '\')"><i class="fa fa-times" aria-hidden="true"></i></button></span></li>');
                $('#tag-input').val('');
            }
        }
    });


    $(document).on("click", ".ui-menu-item-wrapper", function () {
        var tagValue = $(this).text();
        $('#tag-list').append('<li class="tag-item" name=tags[]>' + $.trim(tagValue) + '<span class="tag-span"><button class="remove-tag-button" onclick="deleteTag(\'' + $.trim(tagValue) + '\')"><i class="fa fa-times" aria-hidden="true"></i></button></span></li>');
        $('#tag-input').val('');

    });


    function deleteTag(tagValue) {
        $('li.tag-item:contains(\'' + tagValue + '\')').remove();
    }

    function saveQuestion() {
        var title = $.trim($('#title').val());
        var tags = $.trim($('#tag-list').text());
        if (title == "" || tags == "") {
            $('#error-msg2').empty();
            $('#error-msg2').append("Please fill up all the fields");
            $('#error-div2').fadeIn(500).delay(5000).fadeOut(500)
        } else {
            unsaved = false;
            var listItemAsString = '';
            $("li.tag-item").each(function (index) {
                listVal = $(this).text();
                listItemAsString = listItemAsString + listVal.substring(0, listVal.length);
                if (index != $("li.tag-item").length - 1) {
                    listItemAsString = listItemAsString + ',';
                }
            });
            $('#tags-form-input').val(listItemAsString);
            $('#question-form').submit();
        }
    }

    $('#output-tag-button').click(function () {
        var listItemAsString = "";
        $("li.tag-item").each(function (index) {
            listVal = $(this).text();
            listItemAsString = listItemAsString + listVal.substring(0, listVal.length);
            if (index != listVal.length) {
                listItemAsString = listItemAsString + ',';
            }
        });
        console.log(listItemAsString);
    });
    $(":input").change(function () { //triggers change in all input fields including text type
        unsaved = true;
    });
    var txtareaval = $.trim($("#editor1").val());
    if (txtareaval != "") {
        unsaved = true;
    }
    function unloadPage() {
        if (unsaved) {
            return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
        }
    }
    window.onbeforeunload = unloadPage;
</script>
<?php if (isset($_GET['error'])) { ?>

    <script>
        $('#error-msg').empty();
        $('#error-msg').append("You must add question body.");
        $('#error-div').fadeIn(500).delay(10000).fadeOut(500);
    </script>   
    <?php
}
?>
</body>