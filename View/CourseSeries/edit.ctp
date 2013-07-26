<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet"/>
<h2><?php echo __('Editing ' . $this->request->data['CourseSeries']['name']); ?></h2>
<div class="coursesseries form">

<div id="dragDropItems" class="row-fluid">
	<div class="span6">
		<div class="available-items">
			<ul class="thumbnails">
			<?php //debug($availablecourses); ?>
			<?php foreach ($availablecourses as $avail): ?>
			  <li class="draggable" data-course-id="<?php echo $avail['Course']['id']; ?>">
			    <a href="#" class="thumbnail">
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
			  <li class="draggablechosen" data-course-id="<?php echo $course['Course']['id']; ?>">
			    <a href="#" class="thumbnail">
			      <a href="#" class="remove-item"><i class="icon-minus-sign"></i></a>
			      <p><?php echo $course['Course']['name']; ?></p>
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
		
		var availableitems = [];
		
		<?php foreach($availablecourses as $avail) {echo 'availableitems.push('.json_encode($avail).');';} ?>
		
		var chosenitems = [];
		
		<?php foreach($courses as $course) {echo 'availableitems.push('.json_encode($course).');';} ?>
		
		console.log(availableitems);
		console.log(chosenitems);
			
		$('.droppable').droppable({
				drop: function( event, ui ) {
					var id = ui.draggable.data('course-id');
					for ( var i = 0; i<availableitems.length; i++ ) {
						if(availableitems[i].Course.id == id) {
							chosenitems.push(availableitems.splice(i,1)[0]);
						}	
					}
					rerenderitems();
				}
			});
		
		$( "#dragDropItems .sorted-items ul" ).sortable({ connectWith: "#dragDropItems .available-items ul" });
		
		$('.sorted-items').on('click', '.icon-minus-sign', function(e){
			var id = $(this).closest('li').data('course-id');
					for ( var i = 0; i<chosenitems.length; i++ ) {
						if(chosenitems[i].Course.id == id) {
							availableitems.push(chosenitems.splice(i,1)[0]);
						}	
					}
					rerenderitems();
		});
		
		bindEvents();
		
		function rerenderitems() {
			var html ='';
			for ( var i = 0; i<availableitems.length; i++ ) {
				 var name = availableitems[i].Course.name;
				 var id = availableitems[i].Course.id;
				 html += '<li class="draggable" data-course-id="'+id+'"><a href="#" class="thumbnail"><p>'+name+'</p></a></li>';
			}
			$('.available-items ul').html(html);
			
			html = '';
			for ( var i = 0; i<chosenitems.length; i++ ) {
				 var name = chosenitems[i].Course.name;
				 var id = chosenitems[i].Course.id;
				 html += '<li class="draggable" data-course-id="'+id+'"><a href="#" class="thumbnail"><i class="icon-minus-sign"></i><p>'+name+'</p></a></li>';
			}
			$('.sorted-items ul').html(html);
			bindEvents();
		}
		
		function bindEvents () {
			$('.draggable').draggable({ 
				helper: "clone",
				revert: "invalid"
			});
		}
		
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
