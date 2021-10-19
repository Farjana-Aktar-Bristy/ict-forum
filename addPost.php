
<?php
include 'includes/navbar.php';
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    header("Location:login.php?page=addPost.php");
}
?>

<script>
    $('ul>li>a.active').removeClass('active');
    $('#addPost').addClass('active');
</script>

<script>
    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];
    $(function () {
        $("#tag-input").autocomplete({
            source: availableTags
        });
    });
</script>

<div class="container">
    <div class="col-lg-10 col-md-10 offset-lg-1 offset-md-1">
        <form id="post-form" action="savePost.php" method="post">
            <input type="hidden" name="post-submitted"/>
            <div id="error-div" class="row"></div>
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input id="author" class="form-control py-2 border-left-0 border" type="text" name="author" 
                       value="<?php if (isset($_GET['author'])) echo '' . $_GET['author']; ?>" placeholder="Author Name" required/>
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
                <textarea name="editor1" required></textarea>    
            </div>
            <div class="row mt-2 m-1">
                <button type="button" onclick="savePost()" class="btn btn-primary" style="width: 100%;">Add Post</button>   
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php' ?>
</div>


<script>
    CKEDITOR.replace('editor1');
</script>

<script type="text/javascript">
    $('#tag-input').keypress(function (event) {
        var tagValue = $(this).val();
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            event.preventDefault();
            if ($.trim(tagValue).length != 0 && availableTags.includes(tagValue) == true) {
                $('#tag-list').append('<li class="tag-item">' + $.trim(tagValue) + '<span class="tag-span"><button class="remove-tag-button" onclick="deleteTag(\'' + $.trim(tagValue) + '\')"><i class="fa fa-times" aria-hidden="true"></i></button></span></li>');
                $('#tag-input').val('');
            }
        }
    });


    $(document).on("click", ".ui-menu-item-wrapper", function () {
        var tagValue = $(this).text();
        $('#tag-list').append('<li class="tag-item">' + $.trim(tagValue) + '<span class="tag-span"><button class="remove-tag-button" onclick="deleteTag(\'' + $.trim(tagValue) + '\')"><i class="fa fa-times" aria-hidden="true"></i></button></span></li>');
        $('#tag-input').val('');

    });


    function deleteTag(tagValue) {
        $('li.tag-item:contains(\'' + tagValue + '\')').remove();
    }

    function savePost() {
        var title = $.trim($('#title').val());
        var author = $.trim($('#author').val());
        var tags = $.trim($('#tag-list').text());
        if (title == "" || author == "" || tags == "") {
            $('#error-div').empty();
            $('#error-div').append("Please fill up all the fields");
            $('#error-div').addClass("bg-danger");
        } else {
            $('#post-form').submit();
        }
    }

    $('#output-tag-button').click(function () {
        var listItemAsString = "";
        $("li.tag-item").each(function (index) {
            listVal = $(this).text();
            listItemAsString = listItemAsString + listVal.substring(0, listVal.length - 1) + ',';
        });
        console.log(listItemAsString);
    });

</script>
<?php if (isset($_GET['error'])) { ?>

    <script>
        $('#error-div').empty();
        $('#error-div').append("You must add post body");
        $('#error-div').addClass("bg-danger");
    </script>   
    <?php
}
?>
</body>