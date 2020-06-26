<?php my_force_login(); ?>

 <?php /* Template Name: All People analyzers and reviews Task List Template */ 
 get_header(); 

  global $current_user;
           get_currentuserinfo();
            $assigned = $current_user->ID;
            $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
            $args = array(
                'post_type' => 'task', 
                'post_status' => 'publish', 
                'posts_per_page' => -1, 
                  'meta_key'      => 'end_date',
                'orderby'     => 'meta_value',
                'order'       => 'ASC',
                'tax_query' => array(
                      array(
                          'taxonomy' => 'list',
                          'field' => 'slug',
                          'terms' => 'people-analyzers-reviews'
                      )
                    ), // end tax query
                   'meta_query' => array(
                      array(
                          'key' => 'assigned_to',
                          'compare' => 'LIKE',
                          'value' => $assigned
                      )
                    ), // end tax query
                  'paged' => $paged, 



              ); // arguments array
        // WP_Query
        $eq_query = new WP_Query( $args );
        if ($eq_query->have_posts()) : // The Loop
        

        ?>
    <div class="container">
    <div class="title-row">
      <div class="col-1">
            <h1 style="text-align: left">My People Analyzers & Reviews</h1>
      </div>
      <div class="col-2">
              <a href="/" class="back-btn">Back to Dashboard</a>
      </div>
    </div>
      <div class="whole-thing">
            <table class="task-list-table upcoming-table">
              <?php 
              while ($eq_query->have_posts()): $eq_query->the_post();
                $current_date = date('Y-m-d');
               $deadlinecompare = date('Y-m-d', strtotime(get_field('end_date')));
                $status = get_field('completed');
                $deadline = get_field('end_date');
              ?>
<tr>
                  <td class="left">
                     <?php if ($current_date<$deadlinecompare && $status == false) :?>
                     
                          <div class="graystatus">Incomplete</div>
                      <?php endif; ?>
                    <?php if ($current_date>$deadlinecompare && $status == false):?>
                      <div class="redstatus">Overdue</div>
                    <?php endif; ?>
                    <?php if ($current_date == $deadlinecompare && $status == false) :?>
                          <div class="yellowstatus">Due Today</div>
                  <?php endif; ?>
                <?php if ($status == true) : ?>
                      <div class="greenstatus">Complete</div>

                <?php endif; ?>
               </td>
                  <td class="right"><a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?><br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5></a>  
               
                 </td>
                   
                </tr>             
            <?php endwhile; wp_reset_query(); ?> 
           
            </table>
         

  </div><!-- whole -->

</div><!-- container-->

<?php endif; ?> 
<style>
a {
  text-decoration: none;
}  
.whole-thing {
  max-width: 480px;
    width: 100%;
  margin: 0 auto;
}
.task-list-table {
  width: 100%;
}

</style>
<?php get_footer(); ?>


