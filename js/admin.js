// Hide video URL field unless video category is checked
jQuery(document).ready(function($){


	$(".acf-field-form-task input").change(function(){
	  if ($("#acf-form_task-quarterly_conversation, #acf-form_task-annual_review").is(':checked')) {
	  	$('label[for=acf-assigned_to]').html('<span style="font-weight:700">Assign People Analyzers (choose 4)</span>');
	  	$('label[for=acf-task_description]').html('<span style="font-weight:700">Task Description (Form Link is automated. You do not need to add it here.)</span>')
	  }
	  else {
	  	$('label[for=acf-assigned_to]').html('<span style="font-weight:700">Assign Task to User(s)</span>');
	  	$('label[for=acf-task_description]').html('<span style="font-weight:700">Task Description')

	  }


});
	});