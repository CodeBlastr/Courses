<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet"/>
<h2><?php echo __('Editing ' . $this->request->data['CourseSeries']['name']); ?></h2>
<div class="coursesseries form">

<div id="dragDropItems" class="row-fluid">
	<div class="span6">
		<div class="available-items">
			<ul class="thumbnails">
			<?php debug($availablecourses);foreach ($availablecourses as $avail): ?>
			  <li class="draggable">
			    <a href="#" class="thumbnail">
			      <img data-src="holder.js/100x100" alt="">
			      <p><?php echo $avail['Course']['name']; ?></p>
			    </a>
			  </li>
			 <?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="span6">
		<div class="sorted-items droppable" style="min-height: 50px; border: 1px solid #000;">
			<ul class="thumbnails">
			<?php foreach ($courses as $course): ?>
			  <li class="draggable">
			    <a href="#" class="thumbnail">
			      <img data-src="holder.js/100x100" alt="">
			      <p><?php echo $course['Course.title']; ?></p>
			    </a>
			  </li>
			 <?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<?php echo $this->Form->create('CourseSeries');?>
	<fieldset>
		<legend><?php echo __('Editing Series ' . $this->request->data['CourseSeries']['name']); ?></legend>
	<?php
	
	$i = 0;
	foreach ( $courses as $course ) {
		$checked = ( $course['Course']['parent_id'] == $this->request->data['CourseSeries']['id'] ) ? true : false;
		$potentialChildren[] = array(
			$this->Form->input("Course.$i.id", array( 'type' => 'checkbox', 'label' => false, 'value' => $course['Course']['id'], 'checked' => $checked )),
			$course['Course']['name'],
			$this->Form->input("Course.$i.order", array( 'value' => $course['Course']['order'], 'min' => 1, 'max' => count($courses), 'label' => false, 'class' => 'input-mini' ))
		);
		++$i;
	}
		
	echo $this->Html->tag('div',
			
		$this->Html->tag('div',
			$this->Form->input('CourseSeries.name', array('class' => 'input-xlarge'))
			. $this->Form->input('CourseSeries.description', array('label' => 'Description', 'class' => 'input-xlarge'))
			, array('class' => 'span6')
		)
		. $this->Html->tag('label', 'Courses in this series')
		. $this->Html->tag('table',
				$this->Html->tableHeaders(array(false, 'course', 'order'))
				. $this->Html->tableCells($potentialChildren)
				, array('class' => 'span5')
		)
	
		, array('class' => 'row-fluid')
	);
	
		echo $this->Form->input('CourseSeries.is_sequential', array('label' => 'Require members to go only through the defined sequence', 'value' => '1', 'checked' => true));
		echo $this->Form->input('CourseSeries.is_private', array('label' => 'Private (public won\'t be able to view the series)', 'value' => '1', 'checked' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save'));?>
</div>

<script type="text/javascript">
	(function($){
		
		var availableitems = $('#dragDropItems available-items ul li');
		var chosenitems = $('#dragDropItems available-items ul li');
		console.log(availableitems);
		console.log(chosenitems);
		
		$('.draggable').draggable({ 
				helper: "clone",
				revert: "invalid"
			});
		$('.droppable').droppable();
	})(jQuery);
</script>

<?php
//debug( $this->request->data );
//debug( $courses );

$this->set('context_menu', array('menus' => array(
	array(
		'items' => array(
			$this->Html->link('<i class="icon-tasks"></i>' .__('Dashboard'), array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'dashboard'), array('escape' => false)),
			),
	),
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link('<i class="icon-th-list"></i>' .__('View All Series'), array('controller' => 'series', 'action' => 'index'), array('escape' => false)),
			$this->Html->link('<i class="icon-plus"></i>' .__('Create New Series'), array('controller' => 'series', 'action' => 'add'), array('escape' => false))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link('<i class="icon-th-list"></i>' .__('View All Courses'), array('controller' => 'courses', 'action' => 'index'), array('escape' => false)),
			$this->Html->link('<i class="icon-briefcase"></i>' .__('View Your Courses'), array('controller' => 'courses', 'action' => 'dashboard'), array('escape' => false)),
			$this->Html->link('<i class="icon-plus"></i>' .__('Create New Course'), array('controller' => 'courses', 'action' => 'add'), array('escape' => false))
			),
		),
	)));
