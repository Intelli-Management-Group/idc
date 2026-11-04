<?php require('includes/config.php'); ?>
<?php include 'inc/header.php' ?>
<div class="container-fluid home_banner no-margin no-pad" >
    <img src="images/news/banner_news.jpg" width="100%"  alt="Intelli Develpement Corporation News">
</div>

<div class="container-fluid content-wrapper">
    <div class="container">

        <div class="title-block">
            <h2>News</h2>
            <div class="small-border"><hr></div>
        </div>

                <?php
                try {

                    $pages = new Paginator('10','page');

                    $stmt = $db->query('SELECT postID FROM blog_posts');
                    $count = 1 ;
                    //pass number of records to
                    $pages->set_total($stmt->rowCount());

                    $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc, postDate, image, authorCreated FROM blog_posts ORDER BY postDate DESC '.$pages->get_limit());
                    while($row = $stmt->fetch()){
                        //echo '<div class="category-blog-mini-full-width category-blog-mini-with-left-sidebar category-blog-mini-with-right-sidebar category-dual-sidebars post_wrapper clearfix">';
                        //echo '<div class="post_content">';
                        //echo '<div class="post_main">';
                        echo '<div class="row news-row">';
                        //if($row['image']){
                            echo '<div class="news-col-1">';
                            if($count%2==0) {
                                echo '<div class="date_block">';
                            }
                            else{
                                echo '<div class="date_block_back">';
                            }
                            $count++;
                            $temp = strtotime($row['postDate']);
                            echo '<span class="post_date_inner">'.date('d', $temp).'</span><br>';
                            echo '<span class="post_month">'.date('M Y', $temp).'</span>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="news-col-2">';
                       // }
                       // else{
                         //   echo '<div class="span12 post_main_inner_wrapper">';
                        //}
                        echo '<h5><a href="'.$row['postSlug'].'" class="post_title">'.$row['postTitle'].'</a></h5>';
                       // echo '<span class="post_author">By <span>'.$row['authorCreated'].'<i class="ci_icon-moonfull"></i></span><span class="post_date_inner">'.date('d F, Y', strtotime($row['postDate'])).'</span></span>';
                      //  $stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                        //$stmt2->execute(array(':postID' => $row['postID']));

                        //$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        //$links = array();
                        //foreach ($catRow as $cat)
                       // {
                        //    $links[] = "<a href='category-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                        //}
                        //echo implode(", ", $links);
                        //echo '<div class="post_padding">';
                        //echo '<p>'.$row['postDesc'].'</p>';
                        //echo '</div>';
                      //  echo '</div>';
                       // echo '</div>';
                        echo '<br><br>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo $pages->page_links();

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                ?>
                <!-- end BLog -->

            </div>



        </div>
        <!-- end row -->
    </div>
</section>
<?php include 'inc/footer.php' ?>
