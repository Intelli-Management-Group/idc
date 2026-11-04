<?php require('includes/config.php');

$stmt = $db->prepare('SELECT postID, postTitle, postCont, image, imageCaption, authorCreated, postDate FROM blog_posts WHERE postSlug = :postSlug');
$stmt->execute(array(':postSlug' => $_GET['id'] ?? ''));
$row = $stmt->fetch();

//if post does not exists redirect user.
if(!$row){
	header('Location: ./');
	exit;
}
?>
<html>
<head>
    <title>Intelli Group</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="keywords" content="Intelli,Intellidt,Intelli group,business development,investment,design,solutions,marketing,technology,business solutions,leading provider">
    <meta name="description" property="og:description" content="The Intelli Group is a full-service businessconsulting and project managementfirm. Intelli Group dedicate to help our clientsto substantiate their ideas, improve their businesses, and bring their visions to life. Our specialists provide industry expertise and excellent support to local and oversea clients in the areas of business development, investment, and project management.">
    <meta name="description" property="og:description" content="Intelli Group generates and attracts local and overseas investments, guiding clients to make wise decisions in their regional and transnational markets.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Montserrat:300,400,700,900|Lato:200,300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <script src="assets/script.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAvUBoPeckAfX9BZYcjOfP4TiXHoD7Q9A&callback=initMap">
    </script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-10237768-7', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>
<div class="blog-page-background">
    <div class="container-fluid modal-wrapper" style="min-height:70%">
        <a href="news.php"><span class="close cursor">&times;</span></a>
        <div class="row">
            <div class="col-sm-12">


                <?php
                    echo '<div class="title-block">';
                    echo '<p class="home-intro-txt"><center>'.date('F d, Y', strtotime($row['postDate'])).'</center></p>';
                    echo '<h2>'.$row['postTitle'].'</h2>';
                    echo '</div>';
                    if($row['image'] != NULL){
                        echo '<img src="uploads/'.$row['image'].'" class="attachment-full wp-post-image" alt="Intelli Development Corporation" width="100%"><br><br/>';
                    }
                    print $row['postCont'];

                 ?>


            </div>

        </div>
    </div>
</div>
</body>
</html>