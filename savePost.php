<?php
    include 'includes/navbar.php'; ?>
<div class="container">
<?php
    if(isset($_POST['post-submitted'])) {
        $content = $_POST['editor1'];
        if(trim($content," ") == "") {
            header("Location: askQuestion.php?error=no_content&&title=".$_POST['title']);
        }  else {
            echo ''.$content;
        }
    }
?>
    <script>hljs.initHighlightingOnLoad();</script>
</div>

