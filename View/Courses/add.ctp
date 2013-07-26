<ol>FLOW:
	<li>Create the course</li>
	<li><a href="/media/media/add_resource">Add Classes &AMP; Resources</a></li>
	<li><a href="/courses/grades/setup">Setup Gradebook</a></li>
	<li><a href="/forms/forms/add/formanswer">Add a Quiz</a></li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
</ol>
<div class="courses form">
<?php echo $this->Form->create('Course', array('type' => 'file'));?>
	<fieldset>
		<legend><?php echo __('Add Course'); ?></legend>
	<?php
		//echo $this->Form->input('Course.parent_id');
		echo $this->Element('Media.media_selector', array('selected' => 1));
		echo $this->Html->tag('div',
			$this->Form->input('Course.parent_id', array('div' => array('class' => 'span4'), 'options' => $series, 'empty' => array(null => 'Create New...'), 'label' => 'Part of a Series?'))
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
		echo $this->Form->input('Course.is_published', array('label' => 'Publish?'));
		echo $this->Form->input('Course.is_persistant', array('label' => 'Access when Inactive?'));
		echo $this->Form->input('Course.is_private', array('label' => 'Private'));
		echo $this->Form->input('Course.is_sequential', array('label' => __('Require Sequence <i class="icon-question-sign">%s</i>', $this->Html->link('', '#', array('data-toggle' => 'tooltip', 'title' => 'first tooltip')))));
		echo $this->Form->input('Course.language', array('options' => array('English', 'Spanish')));
		echo !empty($templates) ? __('<h5>Choose a theme</h5> %s', $this->Form->input('Theme.template_id', array('type' => 'radio'))) : null;
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

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('View All Series'), array('controller' => 'series', 'action' => 'index')),
			$this->Html->link(__('Create New Series'), array('controller' => 'series', 'action' => 'add'))
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
