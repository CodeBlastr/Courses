<div class="courses form">
<?php echo $this->Form->create('Course', array('type' => 'file'));?>
	<fieldset>
		<legend><?php echo __('Add Course'); ?></legend>
	<?php
		//echo $this->Form->input('Course.parent_id');
		echo $this->Element('Media.media_selector');
		echo $this->Html->tag('div',
			$this->Form->input('Course.parent_id', array('div' => array('class' => 'span4'), 'options' => $series, 'empty' => array(null => '- existing series -'), 'label' => 'Part of a Series? <a href="#toggleSeriesAdd" class="toggleSeriesAdd">(create new series)</a>'))
			. $this->Form->input('Category', array('div' => array('class' => 'span4'), 'type' => 'select', 'label' => 'Subject', 'empty' => '-- Choose Subject --'))
			);			
		echo $this->Form->input('Course.name', array('class' => 'required', 'placeholder' => 'Course Name', 'label' => false, 'class' => 'input-xxlarge'));
		echo $this->Form->input('Course.start', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'Start Date'));
		echo $this->Form->input('Course.end', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'End Date'));
		echo $this->Html->tag('div',
			$this->Form->input('Course.location', array('div' => array('class' => 'span3'), 'class' => 'required', 'placeholder' => 'Location', 'label' => false))
			. $this->Form->input('Course.school', array('div' => array('class' => 'span4'), 'class' => 'required span12', 'placeholder' => 'School', 'label' => false))
			. $this->Form->input('Course.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12'), 'empty' => 'Grade', 'label' => false, 'class' => 'input-small required', 'div' => array('class' => 'span5')))
		);
		echo $this->Form->input('Course.description', array('label' => 'Description', 'class' => 'input-xxlarge required', 'placeholder' => 'Description', 'label' => false));

		echo '<span>Course Availability</span>';
		echo $this->Form->input('Course.is_published', array('label' => false, 'class' => 'checkboxToggle', 'data-yes' => 'Active', 'data-no' => 'Inactive', 'data-width' => 105));

		echo '<span>Allow access after End Date?</span>';
		echo $this->Form->input('Course.is_persistant', array('label' => false, 'class' => 'checkboxToggle'));

		echo '<span>Course Visibility</span>';
		echo $this->Form->input('Course.is_private', array('label' => false, 'class' => 'checkboxToggle', 'data-yes' => 'Private', 'data-no' => 'Public', 'data-width' => 105));

		echo '<span>Require members to go only through the defined sequence?</span>';
		echo $this->Form->input('Course.is_sequential', array('label' => false, 'class' => 'checkboxToggle'));
		
		echo $this->Form->input('Course.language', array('options' => array('English', 'Spanish')));

		echo !empty($layouts) ? __('<h5>Choose a theme</h5> %s', $this->Form->input('Template.layout', array('type' => 'radio'))) : null;
	?>
	</fieldset>
	<fieldset>
		<div class="gradingOptions">
			<?php //echo $this->Element('Courses.gradingOptions', array('course_id' => $this->request->course['Course']['id'])); ?>
		</div>
	</fieldset>
<?php
echo $this->Form->submit(__('Save'), array('class' => 'btn-primary'));
echo $this->Form->end();
?>
</div>


<div class="courses form" id="seriesAdd" style="display:none; background: #fff; position: fixed; top: 33%; padding: 25px 50px; box-shadow: 5px 5px 10px #999; border: 1px solid #999; border-radius: 5px;">
	<?php
	echo $this->Form->create('Series', array('url' => '/courses/series/add'));
	?>
	<fieldset>
		<legend><?php echo __('Create Series'); ?></legend>
		<?php
		echo $this->Form->input('CourseSeries.name');
		echo $this->Form->input('CourseSeries.description', array('label' => 'Description'));
		echo $this->Js->submit('Save', array(
			'update' => '#content',
			'url'=>'/courses/course_series/add',
			'success' => 'setNewSeries(data);'
			));
		echo '<a href="#toggleSeriesAdd" class="toggleSeriesAdd close">cancel</a>';
		echo $this->Form->end();
		echo $this->Js->writeBuffer();
		?>
	</fieldset>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".toggleSeriesAdd").click(function(){
			$("#seriesAdd").toggle();
		});
		function setNewSeries(data) {
			$("<option/>").val(data).text($("#SeriesName").val()).appendTo("#CourseParentId");
			$("#MediaForeignKey").val(data);
			$("#seriesAdd").hide();
		}
	});
</script>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('View All Series'), array('controller' => 'course_series', 'action' => 'index')),
			$this->Html->link(__('Create New Series'), array('controller' => 'course_series', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('action' => 'dashboard')),
			),
		),
	)));
