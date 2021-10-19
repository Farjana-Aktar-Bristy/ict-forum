<div class="row m-1 mt-1">
    <div class="btn-group" role="group">
        <button id="new-posts" type="button" class="btn btn-secondary border-dark">New</button>
        <button id="top-posts" type="button" class="btn btn-secondary border-dark">Top</button>
        <button id="week-posts" type="button" class="btn btn-secondary border-dark">Week</button>
        <button id="month-posts" type="button" class="btn btn-secondary border-dark">Month</button>
    </div>
</div>
<div class="dropdown-divider sidebar"></div>
<?php
if (isset($_GET['criteria'])) {
    echo '<h1>' . $_GET['criteria'] . '</h1>';
}
?>
<h4>This is the title of the post or question</h4>

<script>
    $('#new-posts').click(function () {
        $('#content').load('posts.php?criteria=new');
    });
    $('#top-posts').click(function () {
        $('#content').load('posts.php?criteria=top');
    });
    $('#week-posts').click(function () {
        $('#content').load('posts.php?criteria=week');
    });
    $('#month-posts').click(function () {
        $('#content').load('posts.php?criteria=month');
    });
</script>