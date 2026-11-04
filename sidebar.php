
			<div id="categories-3" class="widget widget_categories">
				<div class="sidebar-widget-heading">
					<h3>Categories</h3>
				</div>
				<ul>
          <?php
          $stmt = $db->query('SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
          while($row = $stmt->fetch()){
          	echo '<li class="cat-item"><a href="category-'.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
          }
          ?>
				</ul>
			</div>
			<div id="rpwe_widget-3" class="widget rpwe_widget recent-posts-extended">
				<div class="sidebar-widget-heading">
					<h3>RECENT POSTS</h3>
				</div>
				<div class="rpwe-block">
					<ul class="rpwe-ul">
            <?php
              $stmt = $db->query('SELECT postTitle, image, postDate, postSlug FROM blog_posts ORDER BY postID DESC LIMIT 2');
              while($row = $stmt->fetch()){
              	echo '<li class="rpwe-li rpwe-clearfix">';
                  echo '<h3 class="rpwe-title">';
                    echo '<a href="'.$row['postSlug'].'" rel="bookmark">'.$row['postTitle'].'</a>';
                  echo '</h3>';
                  echo '<time datetime="2018" class="rpwe-time published">'.date('d F, Y', strtotime($row['postDate'])).'</time></li>';
              }
            ?>
					</ul>
				</div>

			</div>
      <div id="categories-3" class="widget widget_categories">
				<div class="sidebar-widget-heading">
					<h3>Archives</h3>
				</div>
				<ul>
        <?php
        $stmt = $db->query("SELECT Month(postDate) as Month, Year(postDate) as Year FROM blog_posts GROUP BY Month(postDate), Year(postDate) ORDER BY postDate DESC");
        while($row = $stmt->fetch()){
        	$monthName = date("F", mktime(0, 0, 0, $row['Month'], 10));
        	$slug = 'archieve-'.$monthName.'-'.$row['Year'];
        	echo "<li class='cat-item'><a href='$slug'>$monthName</a></li>";
        }
        ?>
        </ul>
      </div>
