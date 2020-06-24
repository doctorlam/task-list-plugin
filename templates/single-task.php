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

	                <?php if ($current_date<$deadlinecompare && $status == false) :?>
	                     
	                          <div class="graystatus button">Incomplete</div>
	                      <?php endif; ?>
	                    <?php if ($current_date>$deadlinecompare && $status == false):?>
	                      <div class="redstatus button">Overdue</div>
	                    <?php endif; ?>
	                    <?php if ($current_date == $deadlinecompare && $status == false) :?>
	                          <div class="yellowstatus button">Due Today</div>
	                  <?php endif; ?>
	                <?php if ($status == true && $confirmed == false)  : ?>
	                      <div class="greenstatus button">Complete</div>
	                      <p style="font-size:12px;margin-left: 10px">Awaiting Supervisor Confirmation</p>
	                    <?php endif;?>
	                    <?php if ($status == true && $confirmed == true ) : ?>
	                    		<div class="greenstatus button">Complete</div>

	                    	<div style="margin-left:10px" class="greenstatus button">Confirmed by Supervisor</div>
	                    <?php endif;?>
	            </div><!-- d-flex-->
				<?php
		$users = get_field('assigned_to');
		if( $users ): ?>
		<h3>Assigned to:
		    <?php foreach( $users as $user ): ?>
		        
		       <?php echo $user->display_name; ?>
		       &nbsp;  &nbsp;

		        
		    <?php endforeach; ?>
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
		
		<div class="white-bg">
			<h3>Take Action on this Task</h3>
				
				<?php acf_form(array(
				    'post_id'   => $post_id,
				    'post_title'    => false,
				    'fields' => array('completed'),
				    'submit_value'  => 'Submit'
				)); ?>
		</div><!-- white-bg-->
	

	<?php $args = array(
		    'post_type'  => 'task',
		    'author'     => get_current_user_id(),
		);

		$wp_posts = get_posts($args);

	if (count($wp_posts)) :?>
		<div class="white-bg">
			<h3>Confirm Task has been Completed</h3>

	   		<?php acf_form(array(
				    'post_id'   => $post_id,
				    'post_title'    => false,
				    'fields' => array('confirmed_by_supervisor'),
				    'submit_value'  => 'Submit'
				)); ?>
		</div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>



	</div><!-- grid-30-->
		<?php endwhile; // end of the loop. ?>

			

	</div> <!-- /#primary.grid-container.site-content -->
</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
