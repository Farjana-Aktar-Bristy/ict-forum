
<h5 style="background-color: #f5f5f5; padding: 10px; text-align: center; color: darkblue; margin-top: 50px;">&copy; Dept of ICT, MBSTU</h5>
<script>
    $(document).ready(function () {
        $('.navbar-light .navbar-nav .nav-link').click(function () {
            $('ul>li>a.active').removeClass('active');
            $(this).addClass('active');
        });

        $('.dropdown-item').click(function () {
            $('#navbarDropdown').removeClass('active');
        });
    });
</script>