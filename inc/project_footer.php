</body>
<script type="text/javascript">


    // Instantiate the Bootstrap carousel
    $('.multi-item-carousel').carousel({
        interval: false
    });

    // for every slide in carousel, copy the next slide's item in the slide.
    // Do the same for the next, next item.
    $('.small-carousel-image').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i=0;i<2;i++) {
            next = next.next();
            if (next.length>0) {
                next.children(':first-child').clone().appendTo($(this));
            }
            else {
                $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
            } }
    });
</script>


</html>