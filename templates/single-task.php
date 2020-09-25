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
			 $post_author_id = get_post_field( 'post_author', $post_id );

			  $current = $current_user->ID;
  				$reviewers = get_field('assigned_to');
  				$attendee = get_field('form_for');
  				$supervisor = get_field('supervisor');
  				$currentdate = date('Y-m-d');
	               $deadlinecompare = date('Y-m-d', strtotime(get_field('end_date')));
	                $status = get_field('completed');
	                $deadline = get_field('end_date');
	                $confirmed = get_field('confirmed_by_supervisor');
                $tasktype = get_field('form_task');


  				 ?>
  	
			 <?php if ( in_array($current, $reviewers) || $supervisor->ID == $current  || $attendee->ID == $current || $post_author_id == $current ):?>
  			


			<div class="grid-70">

						<article id="post-<?php the_ID(); ?>">
			<header class="white-bg">
				<div style="display:flex; align-items: center">


	                <?php if ($currentdate<$deadlinecompare && $confirmed == false) :?>
	                     
	                          <div class="graystatus button">Incomplete</div>
	                      <?php endif; ?>
	                    <?php if ($currentdate>$deadlinecompare && $confirmed == false):?>
	                      <div class="redstatus button">Overdue</div>
	                    <?php endif; ?>
	                    <?php if ($currentdate == $deadlinecompare && $confirmed == false) :?>
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
             
       

               if($tasktype == 'Quarterly Conversation' && $current == $supervisor->ID) : ?>
                   <h1 style="margin-right: 24px">Quarterly Conversation</h1>

              <?php elseif($tasktype == 'Quarterly Conversation' && $current == $attendee->ID) : ?> <h1 style="margin-right: 24px">Quarterly Conversation</h1>
                <?php elseif($tasktype == 'Annual Review' && $current == $supervisor->ID) : ?> <h1 style="margin-right: 24px">Annual Review</h1>
                    <?php elseif($tasktype == 'Annual Review' && $current == $attendee->ID) : ?> <h1 style="margin-right: 24px">Annual Review</h1>

                 <?php elseif($tasktype == 'Quarterly Conversation' || 'Annual Review' && in_array($current,$reviewers)) : ?> <h1 style="margin-right: 24px">People Analyzer</h1>

                <?php else : ?>

                <h1 style="margin-right: 24px"><?php the_title(); ?></h1>

                <?php endif; ?>
               <?php if ($tasktype == 'Annual Review' || $tasktype == 'Quarterly Conversation') :?>
               			<p><span style="font-weight: 700">Supervisor:</span> <?php $supervisor = get_field('supervisor'); echo $supervisor->display_name; ?></p>
               			<p><span style="font-weight: 700">Attendee:</span> <?php $attendee = get_field('form_for'); echo $attendee->display_name; ?></p>
               			<?php $attendee = get_field('form_for');
					$attendeeid = $attendee->ID;
 		
  					$key = 'dept_multidropdown';
  					$tasktype = get_field('form_task');
  					$departments = get_user_meta( $attendeeid, $key, true ); ?>
  			  <?php if ($departments) :?>
				<p><span style="font-weight: 700">Attendee Department:</span> 
					<ul>
			  		<?php
				 			foreach( $departments as $department ) : ?>
				 			 <li><?php echo $department; ?></li>

			 		<?php endforeach; ?>
			 		 </ul>
			 	</p>
			

			 <?php endif; ?>

               <?php endif; ?>


				<?php
		$user = get_field('assigned_to');
		
		if( $user ): ?>
	 <?php if ($tasktype == 'Annual Review' || $tasktype == 'Quarterly Conversation') :?>
		<p><span style="font-weight: 700">Reviewers:</span>
	<?php else :?>
		<p><span style="font-weight: 700">Assigned to:</span>
	<?php endif; ?>
				
		     <?php

if( $reviewers ): ?>
<ul class="volunteers-list">
    <?php foreach( $reviewers as $reviewer ): 
    $user_info = get_userdata( $reviewer );

    	?>
    	
        <li>
		       <?php echo $user_info->display_name; ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
		   
		        
		</p>

		<?php endif; ?>
		<p><span style="font-weight: 700">Start Date:</span> <?php the_date(); ?></p>
		<p><span style="font-weight: 700">Deadline:</span> <?php the_field('end_date') ;?></p>
		<br>

			<?php  the_field('task_description'); ?>

		<?php 
 		 $user_id = $attendee->ID;
  		$key = 'dept_multidropdown';
  			$departments = get_user_meta( $user_id, $key, true ); ?>
  <?php if ($departments) :?>
  		<?php
 			foreach( $departments as $department ) : ?>
 				<?php if ($department == 'Customer Service') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/customer-service-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/customer-service-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Accounting') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/accounting-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/accounting-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php elseif ($department == 'Billing') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/billing-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/billing-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>

 				
 			
 				<?php elseif ($department == 'Window Coverings') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/window-coverings-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/window-coverings-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>

 			<?php
 				elseif ($department == 'Design Studio') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/designers-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/designers-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Wood FS') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/wood-fs-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/wood-fs-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Purchasing') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/purchasing-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/purchasing-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Resolution') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/resolution-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/resolution-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Warehouse') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/warehouse-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/warehouse-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Digitizing') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/digitizing-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/digitizing-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Sales') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/sales-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/sales-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php
 				elseif ($department == 'Field Services') :?>
 					<?php if ($tasktype == 'Annual Review') :?>
 						<a href="https://allin.southwesterninteriors.com/field-services-annual-review/?coworker_name=<?php echo $attendee->display_name; ?>">Annual Review Link</a>
 					<?php elseif($tasktype == 'Quarterly Conversation') :?>
 							<a href="https://allin.southwesterninteriors.com/field-services-people-analyzer/?coworker_name=<?php echo $attendee->display_name; ?>">People Analyzer Link</a>

 					<?php endif; ?>
 				<?php endif; ?>
 			<?php endforeach; ?>
 		<?php endif; ?>




				
			</header>

	</article> <!-- /#post -->	
</div> <!-- /.grid-70 -->

		      

		        
	<div class="grid-30">
		<?php 
			
			  if ( $post_author_id != $current || $supervisor->ID != $current ) :?>
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
	   
	if ($current == $supervisor->ID) :?>
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
