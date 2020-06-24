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

        <h1 style="text-align: center">All of <?php echo $current_user->display_name; ?>'s People Analyzers & Reviews</h1>
          <a href="/"><< Go Back Home</a>
      <div class="whole-thing" style="box-shadow: 5px 7px 25px -2px rgba(0, 0, 0, 0.12);
    transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
    margin: 12px 12px 12px 18px;
    padding: 50px 50px 50px 50px; background-color: white; ">
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
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  justify-content: center;

}
</style>
<?php get_footer(); ?>


