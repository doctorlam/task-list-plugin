<?php
/*
  Plugin Name: Custom Task manager for AM
  Description: Custom Task manager for AM
  Version: 3.0
  Author: Chris Lam Design
*/

function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style1', $plugin_url . 'css/style.css' );

}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css' );

function enqueue_my_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_script( 'admin',  $plugin_url . 'js/admin.js', false );

}
add_action( 'admin_enqueue_scripts', 'enqueue_my_scripts' );


define('PLUGIN_DIR_PATH','templates');
function cptui_register_my_cpts_task() {

	/**
	 * Post Type: Tasks.
	 */

	$labels = [
		"name" => __( "Tasks", "discoveram" ),
		"singular_name" => __( "Task", "discoveram" ),
	];

	$args = [
		"label" => __( "Tasks", "discoveram" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
    'menu_icon'   => 'dashicons-editor-ol',
		"rewrite" => [ "slug" => "task", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "custom-fields", "comments", "revisions", "author" ],
	];

	register_post_type( "task", $args );
}

add_action( 'init', 'cptui_register_my_cpts_task' );

 
// function cptui_register_my_taxes_list() {

	/**
	 * Taxonomy: Lists.
	 */

//	$labels = [
 //		"name" => __( "Lists", "discoveram" ),
//		"singular_name" => __( "List", "discoveram" ),
//	];

//	$args = [
//		"label" => __( "Lists", "discoveram" ),
//		"labels" => $labels,
//		"public" => true,
//		"publicly_queryable" => true,
//		"hierarchical" => true,
//		"show_ui" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"query_var" => true,
//		"rewrite" => [ 'slug' => 'list', 'with_front' => true, ],
//		"show_admin_column" => false,
//		"show_in_rest" => true,
//		"rest_base" => "list",
//		"rest_controller_class" => "WP_REST_Terms_Controller",
//		"show_in_quick_edit" => false,
//		];
//	register_taxonomy( "list", [ "task" ], $args );
//}
//add_action( 'init', 'cptui_register_my_taxes_list' );

add_action( 'init', function() {
remove_post_type_support( 'task', 'editor' );
}, 99);


// Add custom fields
function my_acf_add_local_field_groups_tasks() {


acf_add_local_field_group(

  array(
  'key' => 'task_list_fields',
  'title' => 'Task List Fields',
  'fields' => array (
  	  array (
      'key' => 'form_task',
      'label' => 'What type of task is this?',
      'name' => 'form_task',
      'type' => 'radio',
      'layout' => 'vertical',
      'return_format' => 'label',
      'choices' => array(
      		'none' => 'Standard Task',
          'quarterly_conversation' => 'Quarterly Conversation',
          'annual_review' => 'Annual Review',
          'net_promoter_score' => 'Net Promoter Score',
      ),
      'wrapper' => array (
        'width' => '33%',
          'class' => '',
        'id' => '',
      ),
      'default_value' => 'none',
      
    ),
  	 array (
      'key' => 'supervisor',
      'label' => 'Supervisor',
      'name' => 'supervisor',
      'type' => 'user',
      'return_format'=> 'object',
     // 'role' => 'supervisor',
      'conditional_logic' => 
      array(
      	array(
	        'field' => 'form_task',
	        'value' => 1,
	        'operator' => '!=',
	        'value' => 'none',
	       ),
      	array(
	         'field' => 'form_task',
	        'value' => 1,
	        'operator' => '!=',
	        'value' => 'net_promoter_score',
    	),

      ),
       'wrapper' => array (
        'width' => '33%',
          'class' => '',
        'id' => '',
      ),
      
    ),
  	   array (
      'key' => 'form_for',
      'label' => 'Attendee?',
      'name' => 'form_for',
      'type' => 'user',
       'return_format'=> 'object',


      'conditional_logic' => 
      array(
      	array(
	        'field' => 'form_task',
	 
	        'operator' => '!=',
	        'value' => 'none',
	       ),
      	array(
	         'field' => 'form_task',
	  
	        'operator' => '!=',
	        'value' => 'net_promoter_score',
    	),

      ),
       'wrapper' => array (
        'width' => '33%',
          'class' => '',
        'id' => '',
      ),
      
    ),

    array (
      'key' => 'assigned_to',
      'label' => 'Assign Task to User(s)',
      'name' => 'assigned_to',
      'type' => 'user',
      'multiple' => 1, 
      'return_format' => 'ID',
      
    ),
       array (
      'key' => 'task_description',
      'label' => 'Task Description',
      'name' => 'task_description',
      'type' => 'wysiwyg',
       
  ),
    
    array (
      'key' => 'end_date',
      'label' => 'Deadline',
      'name' => 'end_date',
      'type' => 'date_time_picker',
      'display_format' => 'F j, Y g:i a',
      'return_format' => 'F j, Y g:i a',
      
    ),
    array (
      'key' => 'completed',
      'label' => 'Completed?',
      'name' => 'completed',
      'type' => 'true_false',
       'ui' => 1,
        'ui_on_text' => 'Complete',
        'ui_off_text' => 'Incomplete',
      
    ),
    array (
      'key' => 'confirmed_by_supervisor',
      'label' => 'Confirmed By Supervisor',
      'name' => 'confirmed_by_supervisor',
      'type' => 'true_false',
         'ui' => 1,
        'ui_on_text' => 'Yes',
        'ui_off_text' => 'No',

      
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'task',
      ),
    ),
  ) // close main group array
)); // close acf_add_local_field_group


}
add_action('acf/init', 'my_acf_add_local_field_groups_tasks');


function my_force_login() {
global $post;

if (!is_user_logged_in()   ) {
    wp_redirect('/login');
    }
}   


function user_task_list_upcoming() {
      ob_start();
    global $paged;

        global $current_user;
           wp_get_current_user();
            $assigned = $current_user->ID;
  

            $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
            $args = array(
                'post_type' => 'task', 
                'post_status' => 'publish', 
                'posts_per_page' => 4, 
                'meta_key'			=> 'end_date',
				        'orderby'			=> 'meta_value',
				        'order'				=> 'ASC',
               
                   'meta_query' => array(
                      array(
                          'key' => 'form_for',
                          'compare' => 'LIKE',
                          'value' => $assigned,
                      ),
                    ), // end tax query
                  'paged' => $paged, 



              ); // arguments array
        // WP_Query
        $eq_query = new WP_Query( $args );
        if ($eq_query->have_posts() && is_user_logged_in() ) : // The Loop
        ?>
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

                  <td class="right"> 
                       <a href="<?php the_permalink(); ?>">
                <?php 
                 global $current_user;
                wp_get_current_user();
                $current = $current_user->ID;
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
         
  <!--   <div class="upcoming-table-link">
    <?php next_posts_link('&laquo; Older Tasks', $eq_query->max_num_pages) ?>
    <?php previous_posts_link('Newer Tasks &raquo;', $eq_query->max_num_pages) ?>
      
    </div>-->
  </div> <!-- whole -->


     <?php elseif (is_user_logged_in() ) :?>
        <p style="font-size: 14px;">There are no tasks currently assigned to you.</p>
       <?php else :?>
       	        <p style="font-size: 14px;">You must be logged in to view your tasks.</p>

<?php endif; ?> 
<?php
$content2 = ob_get_clean();
        return $content2;
}


add_shortcode('user_task_list_upcoming', 'user_task_list_upcoming');

function user_task_list_people() {
    ob_start();
        global $current_user;
           wp_get_current_user();
            $assigned = $current_user->ID;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
            $args = array(
                'post_type' => 'task', 
                'post_status' => 'publish', 
                'posts_per_page' => 4, 
                'paged' => $paged, 
                 'meta_key'			=> 'end_date',
				        'orderby'			=> 'meta_value',
				        'order'				=> 'ASC',
               
                   'meta_query' => array(
                    'relation' => 'OR',
                      array(
                          'key' => 'assigned_to',
                          'compare' => 'LIKE',
                          'value' => $assigned
                      ),
                      array(
                          'key' => 'supervisor',
                          'compare' => 'LIKE',
                          'value' => $assigned
                      )
                    ), // end tax query


              ); // arguments array
        // WP_Query
        $eq_query = new WP_Query( $args );
        if ($eq_query->have_posts() && is_user_logged_in() ) : // The Loop
        ?>
            <table class="task-list-table people-table">
              <?php 
              while ($eq_query->have_posts()): $eq_query->the_post();
                $currentdate = date('Y-m-d');
               $deadlinecompare = date('Y-m-d', strtotime(get_field('end_date')));
                $status = get_field('completed');
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
                  <td class="right">  
                       <a href="<?php the_permalink(); ?>">
                <?php 
                 global $current_user;
                wp_get_current_user();
                $current = $current_user->ID;
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
      <!-- <div class="people-table-link">

            <?php include(EQ_PAGING); ?>
        </div> -->
            <?php elseif (is_user_logged_in() ) :?>
        <p style="font-size: 14px;">There are no tasks currently assigned to you.</p>
       <?php else :?>
       	        <p style="font-size: 14px;">You must be logged in to view your tasks.</p>

<?php endif; ?> 

<?php
$content = ob_get_clean();
        return $content;
}

add_shortcode('user_task_list_people', 'user_task_list_people'); ?>

<?php 
function user_task_list_combined() {
    ob_start();
        global $current_user;
           wp_get_current_user();
            $assigned = $current_user->ID;
            $supervisor = get_field('supervisor');
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
            $args = array(
                'post_type' => 'task', 
                'post_status' => 'publish', 
                'posts_per_page' => 4, 
                'paged' => $paged, 
                 'meta_key'     => 'end_date',
                'orderby'     => 'meta_value',
                'order'       => 'ASC',
                  
                   'meta_query' => array(
                    'relation' => 'OR',
                      array(
                          'key' => 'assigned_to',
                          'compare' => 'LIKE',
                          'value' => $assigned
                      ), 
                      array (
                      
                          'key' => 'supervisor',
                          'compare' => 'LIKE',
                          'value' => $assigned,
                      ),

                      array(
                          'key' => 'form_for',
                          'compare' => 'LIKE',
                          'value' => $assigned
                      ),

                    ), // end tax query


              ); // arguments array
        // WP_Query
        $eq_query = new WP_Query( $args );
        if ($eq_query->have_posts() && is_user_logged_in() ) : // The Loop
        ?>
            <table class="task-list-table people-table">
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
                <td class="right">
                     <a href="<?php the_permalink(); ?>">
                <?php 
                 global $current_user;
                wp_get_current_user();
                $current = $current_user->ID;
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

            <?php endwhile; 
wp_reset_query();

             ?> 
            </table>
      <!-- <div class="people-table-link">

            <?php include(EQ_PAGING); ?>
        </div> -->
            <?php elseif (is_user_logged_in() ) :?>
        <p style="font-size: 14px;">There are no tasks currently assigned to you.</p>
       <?php else :?>
                <p style="font-size: 14px;">You must be logged in to view your tasks.</p>

<?php endif; ?> 

<?php
$content = ob_get_clean();
        return $content;
}

add_shortcode('user_task_list_combined', 'user_task_list_combined'); ?>

<?php

 function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );


add_action('acf/save_post', 'notify_growers');

function notify_growers( $post) {
    //if NOT post type 'grower_posts' then exit;
    if(( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' ) && get_post_type($post_id) == 'task')  {   
 
 global $post;
      $author_id = $post->post_author;
     $reviewers = get_field('assigned_to', $post_id);
      $tasktype = get_field('form_task', $post_id);
         
            $subject = 'New Task created for you in the AM Culture Portal ';
            $message .= '<p>This is an automatic notification that you have been assigned a new task.</p>';
            $message .= '<p><strong>Task Name: </strong>' . get_the_title($post_id) . '</p>';
      if ($task_type == "Quarterly Conversation" || "Annual Review") {
          $message .= '<p><strong>Task Type: </strong>People Analyzer</p>';
       }   else {
             $message .= '<p><strong>Task Type: </strong>' . get_field('form_task', $post_id) . '</p>';
          }
            $message .= '<p><strong>Deadline:</strong>' . get_field('end_date', $post_id) . '</p>';
            $message .= '<p><a href="' . get_permalink($post_id) . '"><strong>View Task &raquo;</strong></a></p>';
        
             foreach ( $reviewers as $reviewer ) {
              $user_info = get_userdata( $reviewer );
              $email = $user_info->user_email;

                wp_mail( $email, $subject, $message );
            }
        
    }
}
add_action('acf/save_post', 'notify_admin');

function notify_admin( $post) {
    //if NOT post type 'grower_posts' then exit;
 if(( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' ) && get_post_type($post_id) == 'task')  {    

    //if email not sent then get an array of users to email
   
      global $post;
     // $author_id = $post->post_author;
     // $author_email = get_the_author_meta( 'user_email', $author_id );
     // $completed = get_field('completed', $post_id);
     // $approved = get_field('confirmed_by_supervisor', $post_id);
    // if ($completed == 'true' && $approved != 'true') {
       $users = get_field('assigned_to', $post_id);
       $supervisor = get_field('supervisor', $post_id);
       $super_email = $supervisor->user_email;
   
    //if $specific_users is an array and is not empty then send email. 
       
            $to = $super_email;

            $subject = 'You have been set as the Supervisor in the AM Culture Portal';
            $message .= '<p>This is an automatic notification that you have been selected as the supervisor for the task below.</p>';
            $message .= '<p><strong>Task Name: </strong>' . get_the_title($post_id) . '</p>';
            $message .= '<p><strong>Task Type: </strong>' . get_field('form_task', $post_id) . '</p>';

            $message .= '<p><strong>Deadline:</strong>' . get_field('end_date', $post_id) . '</p>';
            $message .= '<p><strong>Task Details:</strong>' . get_field('task_description', $post_id) . '</p>';
             $message .= '<p><a href="' . get_permalink($post_id) . '"><strong>View Task &raquo;</strong></a></p>';
           
            wp_mail($to, $subject, $message );
        
      
    // }
  }
}

add_action('acf/save_post', 'notify_attendee');

function notify_attendee( $post) {
    //if NOT post type 'grower_posts' then exit;
 if(( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' ) && get_post_type($post_id) == 'task')  {    

    //if email not sent then get an array of users to email
   
      global $post;
     // $author_id = $post->post_author;
     // $author_email = get_the_author_meta( 'user_email', $author_id );
     // $completed = get_field('completed', $post_id);
     // $approved = get_field('confirmed_by_supervisor', $post_id);
    // if ($completed == 'true' && $approved != 'true') {
       $users = get_field('assigned_to', $post_id);
       $attendee = get_field('form_for', $post_id);
       $attendee_email = $attendee->user_email;
   
    //if $specific_users is an array and is not empty then send email. 
       
            $to = $attendee_email;

            $subject = 'You were assigned as attendee in the AM Culture Portal';
            $message .= '<p>This is an automatic notification that you have been selected as the attendee for the task below.</p>';
            $message .= '<p><strong>Task Name: </strong>' . get_the_title($post_id) . '</p>';
            $message .= '<p><strong>Task Type: </strong>' . get_field('form_task', $post_id) . '</p>';

            $message .= '<p><strong>Deadline:</strong>' . get_field('end_date', $post_id) . '</p>';
            $message .= '<p><strong>Task Details:</strong>' . get_field('task_description', $post_id) . '</p>';
             $message .= '<p><a href="' . get_permalink($post_id) . '"><strong>View Task &raquo;</strong></a></p>';
           
            wp_mail($to, $subject, $message );
        
      
    // }
  }
}

class PageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class. 
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new PageTemplater();
		} 

		return self::$instance;

	} 

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();


		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data', 
			array( $this, 'register_project_templates' ) 
		);


		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
		add_filter(
			'template_include', 
			array( $this, 'view_project_template') 
		);


		// Add your templates to this array.
		$this->templates = array(
				
				'templates/all-upcoming.php' => 'All Upcoming (Created by Custom Task List Plugin)',
        'templates/all-people.php' => 'All People (Created by Custom Task List Plugin)',
        'templates/all-combined.php' => 'All Combined Tasks (Created by Custom Task List Plugin)',

		);
			
	} 

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		} 

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	} 

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {
		
		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 

		$file = plugin_dir_path( __FILE__ ). get_post_meta( 
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}

} 
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );



/* Filter the single_template with our custom function*/
add_filter('single_template', 'my_custom_template');

function my_custom_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'task' ) {
      return plugin_dir_path( __FILE__ ) . 'templates/single-task.php';
    }

    return $single;

}

