
<?php
include 'questions.php';
?>

<script>
    $(document).ready(function () {
        $('ul>li>a.active').removeClass('active');
        $('#home').addClass('active');
        $('.sidebar').removeClass('active');
    });
</script>