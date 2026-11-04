<?php include 'inc/project_header.php' ?>
    <div class="project-page-background">
        <div class="container-fluid modal-wrapper ">
            <a href="projects.php"><span class="close cursor">&times;</span></a>
            <div class="row">
                <div class="col-sm-7">
                    <div class="modal-image-display">
                        <div class="residential-3 modal-image">
                            <img src="images/projects/renovation/ren_nan_rest_1.jpg" width="100%" class="img-responsive" alt="Intelli Develpement Corporation Projects">
                        </div>

                        <div class="residential-3 modal-image">
                            <img src="images/projects/renovation/ren_nan_rest_2.jpg" width="100%" class="img-responsive" alt="Intelli Develpement Corporation Projects">
                        </div>

                        <div class="residential-3 modal-image">
                            <img src="images/projects/renovation/ren_nan_rest_3.jpg" width="100%" class="img-responsive" alt="Intelli Develpement Corporation Projects">
                        </div>

                        <div class="residential-3 modal-image">
                            <img src="images/projects/renovation/ren_nan_rest_4.jpg" width="100%" class="img-responsive" alt="Intelli Develpement Corporation Projects">
                        </div>
                        <div class="residential-3 modal-image">
                            <img src="images/projects/renovation/ren_nan_rest_5.jpg" width="100%" class="img-responsive" alt="Intelli Develpement Corporation Projects">
                        </div>
   
                        
                        <a class="prev" onClick="plusSlides(7,-1)">&#10094;</a>
                        <a class="next" onClick="plusSlides(7,1)">&#10095;</a>

                    </div>
                    <div class="caption-container">&nbsp;
                       <!-- <p id="residential-3-caption"></p>-->
                    </div>
                    
                    

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="carousel slide multi-item-carousel" id="theCarousel">
                                <div class="carousel-inner small-carousel-inner">
                                    <div class="item small-carousel-image active">
                                        <div class="col-xs-3 gallery"><img class="residential-3-demo cursor" src="images/projects/renovation/ren_nan_rest_1.jpg" style="width:100%" onClick="currentSlide(7,1)" alt="Intelli Develpement Corporation Projects"></div>
                                    </div>
                                    <div class="item small-carousel-image">
                                        <div class="col-xs-3 gallery"><img class="residential-3-demo cursor" src="images/projects/renovation/ren_nan_rest_2.jpg" style="width:100%" onClick="currentSlide(7,2)" alt="Intelli Develpement Corporation Projects"></div>
                                    </div>
                                    <div class="item small-carousel-image">
                                        <div class="col-xs-3 gallery"><img class="residential-3-demo cursor" src="images/projects/renovation/ren_nan_rest_3.jpg" style="width:100%" onClick="currentSlide(7,3)" alt="Intelli Develpement Corporation Projects"></div>
                                    </div>
                                    <div class="item small-carousel-image">
                                        <div class="col-xs-3 gallery"><img class="residential-3-demo cursor" src="images/projects/renovation/ren_nan_rest_4.jpg" style="width:100%" onClick="currentSlide(7,4)" alt="Intelli Develpement Corporation Projects"></div>
                                    </div>
                                    <div class="item small-carousel-image">
                                        <div class="col-xs-3 gallery"><img class="residential-3-demo cursor" src="images/projects/renovation/ren_nan_rest_5.jpg" style="width:100%" onClick="currentSlide(7,5)" alt="Intelli Develpement Corporation Projects"></div>
                                    </div>

                                    <!-- add  more items here -->
                                </div>
                                <a class="left carousel-control small-carousel" href="#theCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                <a class="right carousel-control small-carousel" href="#theCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-sm-5">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr valign="middle" aligh="left" height="40px">
                            <td>PROJECT TYPE</td>
                            <td>RENOVATION</td>
                        </tr>
                        <tr valign="top" aligh="left" height="1">
                            <td colspan="2"><img src="images/projects/line_grey.png" width="100%" height="1" alt="Intelli Develpement Corporation Projects" /></td>
                        </tr>
                        <tr valign="middle" aligh="left" height="40">
                            <td>FLOOR AREA</td>
                            <td>1350 SQ.FT.</td>
                        </tr>
                        <tr valign="top" aligh="left" height="1">
                            <td colspan="2"><img src="images/projects/line_grey.png" width="100%" height="1" alt="Intelli Develpement Corporation Projects" /></td>
                        </tr>
                        <tr valign="middle" aligh="left" height="40">
                            <td>STATUS</td>
                            <td>COMPLETED</td>
                        </tr>
                        <tr valign="top" aligh="left" height="1">
                            <td colspan="2"><img src="images/projects/line_grey.png" width="100%" height="1" alt="Intelli Develpement Corporation Projects" /></td>
                        </tr>
                    </table>
                    
                    <BR />
                    
                    <h2 class="project-title">Nanaimo - Japanese Restuarant</h2>
                   
                    <p>This is a renovation project for a traditional Japanese restaurant. We were able to give it a complete makeover with short turnaround time, adding traditional custom-made bamboo with a sleek wood-constructed interior. A full sushi bar is built right alongside the intimate and spacious dining spaces. This new development puts together thoughtful traditional touches with contemporary needs to create a modern fusion look.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            currentSlide(7,1);
        });
    </script>

<?php include 'inc/project_footer.php' ?>