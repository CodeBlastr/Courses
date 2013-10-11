<script type="text/javascript" src="/js/jquery-ui/jquery-ui-1.10.3.custom.js"></script>
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet"/>
<h2><?php echo __('Editing Series: ' . $this->request->data['CourseSeries']['name']); ?></h2>
<div class="coursesseries form">

<?php echo $this->Form->create('CourseSeries');
	echo $this->Form->hidden('CourseSeries.id');
	?>
	<fieldset>
	<?php
		
	echo $this->Html->tag('div',
			
		$this->Html->tag('div',
			$this->Form->input('CourseSeries.name', array('class' => 'input-xlarge'))
			. $this->Form->input('CourseSeries.description', array('label' => 'Description', 'class' => 'input-xlarge', 'style' => 'width:100%;'))
			, array('class' => 'span12')
		)
		, array('class' => 'row-fluid')
	);
		echo $this->Form->input('CourseSeries.start', array('label' => 'Start Date'));
		echo $this->Form->input('CourseSeries.end', array('label' => 'End Date'));
		echo $this->Form->input('CourseSeries.is_sequential', array('label' => 'Require members to go only through the defined sequence', 'value' => '1', 'checked' => true));
		echo $this->Form->input('CourseSeries.is_private', array('label' => 'Private (public won\'t be able to view the series)', 'value' => '1', 'checked' => false));
	?>
	</fieldset>
	<fieldset id="attachedCourses">
		<?php 
			for ( $i = 0 ; $i < count($courses) ; $i++ ) {
				echo $this->Form->hidden('Course.'.$i.'.id', array('value' => $courses[$i]['Course']['id']));
				echo $this->Form->hidden('Course.'.$i.'.order', array('value' => $i));
				echo $this->Form->hidden('Course.'.$i.'.name', array('value' => $courses[$i]['Course']['name']));
			} 	
		?>
	</fieldset>
	<hr />
	<div id="dragDropItems" class="row-fluid">
	<div class="span6">
		<h6>Courses in Series</h6>
		<div class="sorted-items droppable" style="min-height: 50px; border: 1px solid #000;">
			<ul>
			<?php foreach ($courses as $index => $course): ?>
			  <li class="chosen-course" data-order="<?php echo $index; ?>" data-course-id="<?php echo $course['Course']['id']; ?>">
			    <a href="#" class="thumbnail clearfix">
			      <p><?php echo $course['Course']['name']; ?></p>
			      <i class="icon-minus-sign"></i>
			    </a>
			  </li>
			 <?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="span6">
		<h6>Available Courses</h6>
		<div class="available-items">
			<ul>
			<?php //debug($availablecourses); ?>
			<?php foreach ($availablecourses as $avail): ?>
			  <li class="draggable" data-course-id="<?php echo $avail['Course']['id']; ?>">
			    <a href="#" class="thumbnail clearfix">
			      <p><?php echo $avail['Course']['name']; ?></p>
			    </a>
			  </li>
			 <?php endforeach; ?>
			</ul>
		</div>
	</div>
	</div>
	<hr />
<?php echo $this->Form->end(__('Save'));?>
<?php echo  $this->Form->postlink(__('Delete'), array('contoller' => 'course_series', 'action' => 'delete', $this->request->data['CourseSeries']['id'], '?' => array('destination' => $this->Html->url(array('controller' => 'courses', 'action' => 'dashboard')))), array('class' => 'btn btn-xs'), __('Are you sure you want to delete %s', array($this->request->data['CourseSeries']['name']))); ?>

</div>

<script type="text/javascript">
	(function($){
		
		var availableitems = [];
		
		<?php foreach($availablecourses as $avail) {echo 'availableitems.push('.json_encode($avail).');';} ?>
		
		var chosenitems = [];
		
		<?php foreach($courses as $course) {echo 'chosenitems.push('.json_encode($course).');';} ?>
		
		
		$('.sorted-items').on('click', '.icon-minus-sign', function(e){
			e.preventDefault();
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
				 html += '<li class="draggable" data-course-id="'+id+'"><a href="#" class="thumbnail clearfix"><p>'+name+'</p></a></li>';
			}
			$('.available-items ul').html(html);
			
			html = '';
			for ( var i = 0; i<chosenitems.length; i++ ) {
				 var name = chosenitems[i].Course.name;
				 var id = chosenitems[i].Course.id;
				 html += '<li class="chosen-course" data-order="'+i+'" data-course-id="'+id+'"><a href="#" class="thumbnail clearfix"><i class="icon-minus-sign"></i><p>'+name+'</p></a></li>';
			}
			$('.sorted-items ul').html(html);
			renderFormItems();
			bindEvents();
		}
		
		function renderFormItems() {
			html = '';
			for ( var i = 0; i<chosenitems.length; i++ ) {
				 var name = chosenitems[i].Course.name;
				 var id = chosenitems[i].Course.id;
				 html += '<input id="Course'+i+'Id" type="hidden" value="'+id+'" name="data[Course]['+i+'][id]">';
				 html += '<input id="Course'+i+'Order" type="hidden" value="'+i+'" name="data[Course]['+i+'][order]">';
				 html += '<input id="Course'+i+'Name" type="hidden" value="'+name+'" name="data[Course]['+i+'][name]">';
			}
			$('#attachedCourses').html(html);
		}
		
		function bindEvents () {
			$('.draggable').draggable({ 
				helper: "clone",
				revert: "invalid",
				start: function( event, ui ) {
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
				},
				stop: function( event, ui ) {
					$('.droppable').droppable('destroy');
				}
			});
			$( "#dragDropItems .sorted-items ul" ).sortable({
				placeholder: "sortable-placeholder",
				forcePlaceholderSize: true,
				forceHelperSize: true,
				update: function( event, ui ) {
					var sorteditems = [];
					$('.sorted-items ul li').each(function(index, el) {
						var i = $(el).data('order');
						item = chosenitems[i];
						sorteditems.push(item);
					});
					chosenitems = sorteditems;
					rerenderitems();
				}
			 });
		}
		
	})(jQuery);
</script>

<style>
	#dragDropItems ul {
		padding: 10px;
		margin: 0;
		list-style: none;
	}
	#dragDropItems ul li a {
		padding: 20px 10px;
	}
	#dragDropItems ul li p {
		float: left;
		margin: 0;
	}
	#dragDropItems ul li .icon-minus-sign {
		float: right;
		margin-right:10px;
	}
</style>

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
