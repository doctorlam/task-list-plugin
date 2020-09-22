<?php my_force_login(); ?>

<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Discover AM
 * @since Discover AM 1.0
 */
acf_form_head();
get_header(); ?>


<div id="maincontentcontainer">

	<div id="primary" class="grid-container site-content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
				<?php 
			 global $current_user;
			 wp_get_current_user();
			  $current = $current_user->ID;
			  $post_author_id = get_post_field( 'post_author', $post_id );
  				$users = get_field('assigned_to');
  				$attendee = get_field('form_for');
  				$supervisor = get_field('supervisor');
  			
  		
			  if ( in_array($current, $users) || $supervisor[ID] == $current  || $attendee[ID] == $current ):?>
  			


			<div class="grid-70">

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="white-bg">
				<div style="display:flex; align-items: center">
					<?php  $current_date = date('Y-m-d');
	               $deadlinecompare = date('Y-m-d', strtotime(get_field('end_date')));
	                $status = get_field('completed');
	                $deadline = get_field('end_date');
	                $confirmed = get_field('confirmed_by_supervisor');
	                ?>

	                <?php if ($current_date<$deadlinecompare && $confirmed == false) :?>
	                     
	                          <div class="graystatus button">Incomplete</div>
	                      <?php endif; ?>
	                    <?php if ($current_date>$deadlinecompare && $confirmed == false):?>
	                      <div class="redstatus button">Overdue</div>
	                    <?php endif; ?>
	                    <?php if ($current_date == $deadlinecompare && $confirmed == false) :?>
	                          <div class="yellowstatus button">Due Today</div>
	                  <?php endif; ?>
	                <?php if ($status == true && $confirmed == false)  : ?>
	                    
	                      <p style="font-size:12px;margin-left: 10px">Awaiting Supervisor Confirmation</p>
	                    <?php endif;?>
	                    <?php if ( $confirmed == true ) : ?>
	                    		<div class="greenstatus button">Complete</div>

	                    
	                    <?php endif;?>
	            </div><!-- d-flex-->

	              <?php 
                 global $current_user;
                wp_get_current_user();
                $current = $current_user->ID;
                $tasktype = get_field('form_task');
                $supervisor = get_field('supervisor');
                $attendee = get_field('form_for');
                $reviewers = get_field('assigned_to');

               if($tasktype == 'Quarterly Conversation' && $current == $supervisor[ID]) : ?>
                   <h1 style="margin-right: 24px">Quarterly Conversation</h1>

              <?php elseif($tasktype == 'Quarterly Conversation' && $current == $attendee[ID]) : ?> <h1 style="margin-right: 24px">Quarterly Conversation</h1>
                <?php elseif($tasktype == 'Annual Review' && $current == $supervisor[ID]) : ?> <h1 style="margin-right: 24px">Annual Review</h1>
                    <?php elseif($tasktype == 'Annual Review' && $current == $attendee[ID]) : ?> <h1 style="margin-right: 24px">Annual Review</h1>

                 <?php elseif($tasktype == 'Quarterly Conversation' || 'Annual Review' && in_array($current,$reviewers)) : ?> <h1 style="margin-right: 24px">People Analyzer</h1>

                <?php else : ?>

                <h1 style="margin-right: 24px"><?php the_title(); ?></h1>

                <?php endif; ?>

				<?php
		$user = get_field('assigned_to');
		
		if( $user ): ?>
		<h3>Assigned to:
				
		     <?php
$users = get_field("assigned_to");

if( $users ): ?>
<ul class="volunteers-list">
    <?php foreach( $users as $user ): 
    $user_info = get_userdata( $user );

    	?>
    	
        <li>
		       <?php echo $user_info->display_name; ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
		   
		        
		</h3>

		<?php endif; ?>
		<p><span style="font-weight: 700">Start Date:</span> <?php the_date(); ?></p>
		<p><span style="font-weight: 700">Deadline:</span> <?php the_field('end_date') ;?></p>
		<br>
		<?php the_field('task_description'); ?>
		<?php 
		$attendee = get_field('form_for');
		$attendeeid = $attendee[ID];
 		 $user_id = $attendeeid;
  		$key = 'dept_multidropdown';
  			$departments = get_user_meta( $user_id, $key, true ); 
 			foreach( $departments as $department ) {
 				if ($department == 'Customer Service') {
 					echo 'CS';
 				}
 				elseif ($department == 'Accounting') {
 					echo 'Accounting';
 				}
 				elseif ($department == 'Billing') {
 					echo 'Billing';
 				}
 				elseif ($department == 'Window Coverings') {
 					echo 'Window';
 				}
 				elseif ($department == 'Designers') {
 					echo 'Designers';
 				}
 				elseif ($department == 'Wood FS') {
 					echo 'Wood';
 				}
 				elseif ($department == 'Purchasing') {
 					echo 'Purchase';
 				}
 				elseif ($department == 'Resolution') {
 					echo 'Resolution';
 				}
 				elseif ($department == 'Warehouse') {
 					echo 'Warehouse';
 				}
 				elseif ($department == 'Digitizing') {
 					echo 'Dig';
 				}
 				elseif ($department == 'Sales') {
 					echo 'Sales';
 				}
 				elseif ($department == 'Field Service') {
 					echo 'Field';
 				}
 			}


		?>


				
			</header>

	</article> <!-- /#post -->	
</div> <!-- /.grid-70 -->

		      

		        
	<div class="grid-30">
		<?php 
			 global $current_user;
			 wp_get_current_user();
			  $current = $current_user->ID;
			  $post_author_id = get_post_field( 'post_author', $post_id );
			  $assigned = get_field('assigned_to');
			  if ( $post_author_id != $current || $superid != $current ) :?>
	<?php 
		$tasktype = get_field('form_task');
		if ($tasktype == 'net_promoter_score') : ?>
		<div class="white-bg">
			<h3>Have you completed this task?</h3>
				
				<?php acf_form(array(
				    'post_id'   => $post_id,
				    'post_title'    => false,
				    'fields' => array('completed'),
				    'submit_value'  => 'Submit'
				)); ?>
		</div><!-- white-bg-->
	<?php endif; ?>
	<?php endif; ?>

	<?php 
	    global $current_user;
		wp_get_current_user();
		$post_author_id = get_post_field( 'post_author', $post_id );
		$supervisor = get_field('supervisor');

	if ($current_user->ID == $supervisor[ID]) :?>
		<div class="blue-bg">
			<h3>Has everyone assigned completed this task?</h3>

	   		<?php acf_form(array(
				    'post_id'   => $post_id,
				    'post_title'    => false,
				    'fields' => array('confirmed_by_supervisor'),
				    'submit_value'  => 'Submit'
				)); ?>
		</div>

<?php endif; ?>



	</div><!-- grid-30-->

	<?php else :?>
		<p>This task is not associated with your account.</p>
	
		<?php endif; ?>

		<?php endwhile; // end of the loop. ?>
		


	</div> <!-- /#primary.grid-container.site-content -->
</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
