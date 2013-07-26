<div class="lessons index">
	<h2><?php echo __('Lessons');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('location');?></th>
			<th><?php echo $this->Paginator->sort('language');?></th>
			<th><?php echo $this->Paginator->sort('start');?></th>
			<th><?php echo $this->Paginator->sort('end');?></th>
			<th><?php echo $this->Paginator->sort('is_published');?></th>
			<th><?php echo $this->Paginator->sort('is_private');?></th>
			<th><?php echo $this->Paginator->sort('is_persistant');?></th>
			<th><?php echo $this->Paginator->sort('is_sequential');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($lessons as $lesson): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($lesson['Course']['name'], array('controller' => 'courses', 'action' => 'view', $lesson['Course']['id'])); ?>
		</td>
		<td><?php echo h($lesson['CourseLesson']['name']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['description']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['location']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['language']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['start']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['end']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['is_published']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['is_private']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['is_persistant']); ?>&nbsp;</td>
		<td><?php echo h($lesson['CourseLesson']['is_sequential']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $lesson['CourseLesson']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $lesson['CourseLesson']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $lesson['CourseLesson']['id']), null, __('Are you sure you want to delete # %s?', $lesson['CourseLesson']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} lessons out of {:count} total, starting on lesson {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Lesson'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Lessons'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
