<ol>FLOW:
	<li>Create the course</li>
	<li><a href="/media/media/add_resource">Add Classes &AMP; Resources</a></li>
	<li><a href="/courses/grades/setup">Setup Gradebook</a></li>
	<li><a href="/forms/forms/add/formanswer">Add a Quiz</a></li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
</ol>
<div class="courses form">
<?php echo $this->Form->create('Course');?>
	<fieldset>
		<legend><?php echo __('Add Course'); ?></legend>
	<?php
		//echo $this->Form->input('Course.parent_id');
		echo $this->Form->input('Course.parent_id', array('options' => $parentCourses, 'empty' => array('false' => 'No', 'true' => 'Create New...'), 'label' => 'Make Part of a Series?'));
		echo $this->Form->input('Course.name', array('class' => 'required', 'placeholder' => 'Course Name', 'label' => false, 'class' => 'input-xxlarge'));
		echo $this->Form->input('Course.start', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'Start Date'));
		echo $this->Form->input('Course.end', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'End Date'));
		echo $this->Html->tag('div',
			$this->Form->input('Course.location', array('div' => array('class' => 'span3'), 'class' => 'required', 'placeholder' => 'Location', 'label' => false))
			. $this->Form->input('Course.school', array('div' => array('class' => 'span4'), 'class' => 'required span12', 'placeholder' => 'School', 'label' => false))
			. $this->Form->input('Course.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12'), 'empty' => 'Grade', 'label' => false, 'class' => 'input-small required', 'div' => array('class' => 'span5')))
		);
		echo $this->Form->input('Course.description', array('label' => 'Description', 'class' => 'input-xxlarge required', 'placeholder' => 'Description', 'label' => false));
		echo $this->Form->input('Course.is_published', array('label' => 'Active / Inactive'));
		echo $this->Form->input('Course.is_persistant', array('label' => 'Allow access when Inactive'));
		echo $this->Form->input('Course.is_private', array('label' => 'Public / Private'));
		echo $this->Form->input('Course.is_sequential', array('label' => 'Require members to go only through the defined sequence'));
		echo $this->Form->input('Course.language', array('options' => array('English', 'Spanish')));
	?>
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
		echo $this->Form->input('Series.name');
		echo $this->Form->input('Series.description', array('label' => 'Description'));
		echo $this->Js->submit('Save', array(
			'update' => '#content',
			'url'=>'/courses/series/add',
			'success' => 'setNewSeries(data);'
			));
		echo $this->Form->end();
		echo $this->Js->writeBuffer();
		?>
	</fieldset>
</div>




<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Courses'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Add Series'), array('action' => 'add', 'series'));?></li>
		<li><?php echo $this->Html->link(__('Add Lesson'), array('action' => 'add', 'lesson'));?></li>
	</ul>
</div>



<script type="text/javascript">
	$("#CourseParentId").change(function(){
		if ( $(this).val() === 'true' ) {
			$("#seriesAdd").show();
		} else {
			$("#seriesAdd").hide();
		}
	});
	function setNewSeries(data) {
		$("<option/>").val(data).text($("#SeriesName").val()).appendTo("#CourseParentId");
		$("#MediaForeignKey").val(data);
		$("#seriesAdd").hide();
	}

</script>