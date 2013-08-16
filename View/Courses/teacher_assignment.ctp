<div class="tasks form">
<?php echo $this->Form->create('Task', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __('Edit Assignment');?></legend>
	<?php
		//echo $this->Form->input('Category', array('div' => array('class' => 'span4'), 'type' => 'select', 'label' => 'Assignment Category', 'empty' => '-- Choose Category --'));
		echo $this->Form->input('Task.name');
		if(isset($this->request->data['Task']['id'])) {
			echo $this->Form->input('Task.id');
		}
	?>
	<div class="row-fluid">
	<div class="span6">
		<?php echo $this->Form->input('Task.start_date', array('type' => 'text', 'class' => 'datepicker')); ?>
	</div>
	<div class="span6">
		<?php echo $this->Form->input('Task.due_date', array('type' => 'text', 'class' => 'datepicker')); ?>
	</div>
	</div>
	
<?php
		//echo $this->Form->input('Task.parent_id', array('empty' => true, 'label' => 'Which task list should this be on?'));

		echo $this->Form->input('Task.foreign_key', array('options' => $parentCourses, 'empty' => '- Select Course -', 'label' => 'Course Assingment Belongs to', 'class' => 'required'));

		echo $this->Form->input('Task.description', array('type' => 'richtext'));

//		echo $this->Form->input('Task.order');
		echo $this->Form->input('Task.assignee_id', array('label' => 'Privacy', 'options' => array(0 => 'All Course Members', $this->userId => 'Just Me')));

		echo $this->Form->hidden('Task.model', array('value' => 'Course'));
	?>
	</fieldset>
	
	<fieldset>
		<div class="accordion" id="attachablesContainer">
		<?php foreach($attachables as $name => $attachment): ?>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#attachablesContainer" href="#collapse<?php echo $name; ?>">
		        <h5>Attach a Test or Quiz</h5>
		      </a>
		    </div>
		    <div id="collapse<?php echo $name; ?>" class="accordion-body collapse">
		      <div class="accordion-inner">
		      	<div class="row-fluid">
		      		
		      		<div class="control-group">
					  <div class="controls">
					
		        <?php 
		        	$i = 0;
					$j = 0;
		        	foreach($attachment as $item): 
		        	?>
		        	
		   			<?php 
		   				if ($j == 0){
		   					echo '<div class="span4">';
						} ?>
						
					<label class="radio" label for='<?php echo $name.'-'.$i; ?>'>
					<input type="radio" name="data[TaskAttachment][foreign_key]" id="<?php echo  $name.'-'.$i; ?>" value="<?php echo $item['id']; ?>">
						<?php echo $item['title']; ?>
					</label>
    				
    				<?php 
    					echo $this->Form->hidden('TaskAttachment.model', array('value' => $name));
    					$i++; 
						$j++;
						if($j > 3 && $i < count($attachment)) { 
							$j = 0;
							echo '</div>';
						}
    					?>
		        	
		        	
		        <?php endforeach; ?>
			        <label class="radio" for='<?php echo $name.'-'.$i; ?>'>
						<input type="radio" name="data[TaskAttachment][foreign_key]" id="<?php echo $name.'-'.$i; ?>" value="">
							None
					</label>
				  </div>
				 </div>
		        </div>
		      </div>
		    </div>
		  </div>
		  <?php endforeach; ?>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#attachablesContainer" href="#collapseGrading">
		        <h5>Grading Options for this assignment</h5>
		      </a>
		    </div>
		    <div id="collapseGrading" class="accordion-body collapse">
		      <div class="accordion-inner">
		      	<div class="row-fluid">
		        <div style="margin-bottom: 14px;">
						<label>Will this be for a grade? <?php echo $this->Form->checkbox('Task.is_gradeable', array('style' => 'margin:3px 5px;')); ?></label>
					</div>
					
					<div class="gradingOptions">
						<?php echo $this->Element('Courses.gradingOptions'); ?>
					</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

	</fieldset>
		
		
	
<?php echo $this->Form->end('Submit');?>

</div>

<div class="clearfix"></div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Create a Task',
		'items' => array(
			  $this->Html->link('<i class="icon-backward"></i>'.__('Back to Course Dashboard', true), array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'dashboard'), array('escape' => false)),
			  ),
		),
	)));
