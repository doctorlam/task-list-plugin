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
			 get_currentuserinfo();
			  $current = $current_user->ID;
			  $post_author_id = get_post_field( 'post_author', $post_id );
			  $assigned = get_field('assigned_to');
			  if ( in_array($current, $assigned ) || $post_author_id == $current ) :?>
			<div class="grid-70">

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="white-bg">
				<div style="display:flex; align-items: center">
					<h1 style="margin-right: 24px"><?php the_title(); ?></h1>
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
	                    <?php if ($status == true && $confirmed == true ) : ?>
	                    		<div class="greenstatus button">Complete</div>

	                    
	                    <?php endif;?>
	            </div><!-- d-flex-->
				<?php
		$user = get_field('assigned_to');
		
		if( $user ): ?>
		<h3>Assigned to:
				
		     <?php echo $user['display_name']; ?>
		   
		        
		</h3>

		<?php endif; ?>
		<p><span style="font-weight: 700">Start Date:</span> <?php the_date(); ?></p>
		<p><span style="font-weight: 700">Deadline:</span> <?php the_field('end_date') ;?></p>
		<br>
		<?php the_content(); ?>
				
			</header>

	</article> <!-- /#post -->	
</div> <!-- /.grid-70 -->

		      

		        
	<div class="grid-30">
		<?php 
			 global $current_user;
			 get_currentuserinfo();
			  $current = $current_user->ID;
			  $post_author_id = get_post_field( 'post_author', $post_id );
			  $assigned = get_field('assigned_to');
			  if ( $post_author_id != $current ) :?>
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

	<?php 
	    global $current_user;
		wp_get_current_user();
		$post_author_id = get_post_field( 'post_author', $post_id );
		$user = get_field('assigned_to');

	if ($current_user->ID == $post_author_id) :?>
		<div class="blue-bg">
			<h3>Has <?php echo $user['display_name']; ?> completed this task?</h3>

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
