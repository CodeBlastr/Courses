<div class="courseSchools view">
<h2><?php echo __('Course School'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street 1'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['street_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street 2'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['street_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone 1'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['phone_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone 2'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['phone_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner Id'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['owner_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator Id'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['creator_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier Id'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['modifier_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($courseSchool['CourseSchool']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course School'), array('action' => 'edit', $courseSchool['CourseSchool']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course School'), array('action' => 'delete', $courseSchool['CourseSchool']['id']), null, __('Are you sure you want to delete # %s?', $courseSchool['CourseSchool']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Schools'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course School'), array('action' => 'add')); ?> </li>
	</ul>
</div>
