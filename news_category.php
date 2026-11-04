<?php require('includes/config.php');
      $stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
      $stmt->execute(array(':catSlug' => $_GET['id'] ?? ''));
      $row = $stmt->fetch();

      //if post does not exists redirect user.
      if(!$row){
      header('Location: ./');
      exit;
      }
?>
<?php include 'inc/header.php' ?>
<!-- Banner -->
<section id="ABdev_main_slider" style="height: auto;padding-top: 75px;">
  <img src="images/banner/zoe_banner_news.jpg"  alt="Zoe Ventures Latest News"  width="100%">
  <div class="banner_text">
    <h1 class="dnd-animo " data-animation="fadeInUp" data-duration="1000" data-delay="0">News in <?php echo $row['catTitle'];?></h1>
  </div>
</section>
<!-- End Banner -->

<section>
	<div class="container">
		<div class="row">
			<div class="blog_category_index blog_category_index_none_mini span9 content_with_right_sidebar">
<!-- BLOG -->
        <?php
          try {

            $pages = new Paginator('3','p');

            $stmt = $db->prepare('SELECT blog_posts.postID FROM blog_posts, blog_post_cats WHERE blog_posts.postID = blog_post_cats.postID AND blog_post_cats.catID = :catID');
				$stmt->execute(array(':catID' => $row['catID']));

				//pass number of records to
				$pages->set_total($stmt->rowCount());

				$stmt = $db->prepare('
					SELECT
						blog_posts.postID, blog_posts.postTitle, blog_posts.postSlug, blog_posts.image, blog_posts.authorCreated, blog_posts.postDesc, blog_posts.postDate
					FROM
						blog_posts,
						blog_post_cats
					WHERE
						 blog_posts.postID = blog_post_cats.postID
						 AND blog_post_cats.catID = :catID
					ORDER BY
						postID DESC
					'.$pages->get_limit());
				$stmt->execute(array(':catID' => $row['catID']));
				while($row = $stmt->fetch()){
            echo '<div class="category-blog-mini-full-width category-blog-mini-with-left-sidebar category-blog-mini-with-right-sidebar category-dual-sidebars post_wrapper clearfix">';
    					echo '<div class="post_content">';
    						echo '<div class="post_main">';
    							echo '<div class="row">';
                  if($row['image']){
                    echo '<div class="span5">';
                      echo '<img src="uploads/'.$row['image'].'" class="attachment-full wp-post-image" alt="Zoe Ventures Whats News Banner"/>';
                    echo '</div>';
                    echo '<div class="span7 post_main_inner_wrapper">';
                  }
                  else{
                    echo '<div class="span12 post_main_inner_wrapper">';
                  }
    									echo '<h5><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></h5>';
    									echo '<span class="post_author">By <span>'.$row['authorCreated'].'<i class="ci_icon-moonfull"></i></span><span class="post_date_inner">'.date('d F, Y', strtotime($row['postDate'])).'</span></span>';
                      $stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
        							$stmt2->execute(array(':postID' => $row['postID']));

        							$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        							$links = array();
        							foreach ($catRow as $cat)
        							{
        							    $links[] = "<a href='category-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
        							}
        							echo implode(", ", $links);
    									echo '<div class="post_padding">';
    										echo '<p>'.$row['postDesc'].'</p>';
    									echo '</div>';
    									echo '<div class="post-readmore">';
    										echo '<a href="'.$row['postSlug'].'" class="more-link">Read More</a>';

    									echo '</div>';
    								echo '</div>';
    							echo '</div>';
    						echo '</div>';
    					echo '</div>';
    				echo '</div>';
          }
          echo $pages->page_links('c-'.htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8').'&');

				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>
<!-- end BLog -->

			</div>
			<!-- end span9 main-content -->
      <aside class="span3 sidebar sidebar_right">
        <?php require('sidebar.php'); ?>
      </aside>


		</div>
		<!-- end row -->
	</div>
</section>
<?php include 'inc/footer.php' ?>
