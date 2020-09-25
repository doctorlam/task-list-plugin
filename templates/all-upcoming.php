<?php my_force_login(); ?>

 <?php /* Template Name: All Combined Task List Page Template */ 
 get_header(); 

  global $current_user;
           wp_get_current_user();
            $current = $current_user->ID;
            $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
            $args = array(
                'post_type' => 'task', 
                'post_status' => 'publish', 
                'posts_per_page' => -1, 
                  'meta_key'      => 'end_date',
                'orderby'     => 'meta_value',
                'order'       => 'ASC',
             
                'meta_query' => array(
                    'relation' => 'AND',
                     array (
                               
                            'key' => 'form_for',
                            'compare' => 'LIKE',
                            'value' => $current,
                                ),
                      array (
                          'key' => 'form_task',
                          'compare' => 'IN',
                          'value' => array('annual_review', 'quarterly_conversation'),
                      
                      ), // AND array ends here
                    ), // Entire meta query ends here  
                  'paged' => $paged, 



              ); // arguments array
        // WP_Query
        $eq_query = new WP_Query( $args );
        if ($eq_query->have_posts()) : // The Loop
        

        ?>
    <div class="container">
		<div class="title-row">
			<div class="col-1">
        		<h1 style="text-align: left">My Upcoming Conversations</h1>
			</div>
			<div class="col-2">
              <a href="/" class="back-btn">Back to Dashboard</a>
			</div>
		</div>
      <div class="whole-thing">
            <table class="task-list-table upcoming-table">
              <?php 
              while ($eq_query->have_posts()): $eq_query->the_post();
                $currentdate = date('Y-m-d');
               $deadlinecompare = date('Y-m-d', strtotime(get_field('end_date')));
                $status = get_field('confirmed_by_supervisor');
                $deadline = get_field('end_date');
              ?>
<tr>
                  <td class="left">
                     <?php if ($currentdate<$deadlinecompare && $status == false) :?>
                     
                          <div class="graystatus">Incomplete</div>
                      <?php endif; ?>
                    <?php if ($currentdate>$deadlinecompare && $status == false):?>
                      <div class="redstatus">Overdue</div>
                    <?php endif; ?>
                    <?php if ($currentdate == $deadlinecompare && $status == false) :?>
                          <div class="yellowstatus">Due Today</div>
                  <?php endif; ?>
                <?php if ($status == true) : ?>
                      <div class="greenstatus">Complete</div>

                <?php endif; ?>
               </td>
                  <td class="right">             <a href="<?php the_permalink(); ?>">
                  <?php 
             
                $tasktype = get_field('form_task');
                $supervisor = get_field('supervisor');
                $attendee = get_field('form_for');
                $reviewers = get_field('assigned_to');

               if($tasktype == 'Quarterly Conversation' && $current == $supervisor->ID) : ?>
                  <h5>Quarterly Conversation  <br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5>

              <?php elseif($tasktype == 'Quarterly Conversation' && $current == $attendee->ID) : ?><h5>Quarterly Conversation  <br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5>
                <?php elseif($tasktype == 'Annual Review' && $current == $supervisor->ID) : ?><h5>Annual Review  <br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5>
                    <?php elseif($tasktype == 'Annual Review' && $current == $attendee->ID) : ?><h5>Annual Review  <br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5>

                 <?php elseif($tasktype == 'Quarterly Conversation' || 'Annual Review' && in_array($current,$reviewers)) : ?><h5>People Analyzer  <br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5>

                <?php else : ?>

                  <h5><?php the_title(); ?>  <br>
                    <span class="deadline"><?php echo $deadline; ?></span>
                    
                  </h5>
                <?php endif; ?>

                </a>  
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
  margin: 0 auto;
  width: 100%;
}
.task-list-table {
  width: 100%;
}
</style>
<?php get_footer(); ?>


