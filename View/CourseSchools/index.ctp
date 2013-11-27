<div class="courseSchools index">
	<h2><?php echo __('Schools'); ?> <span class="pull-right"><?php echo $this->Html->link(__('<i class="icon icon-plus"></i> New School'), array('action' => 'add'), array('class' => 'btn', 'escape' => false)); ?></span></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('street_1'); ?></th>
			<th><?php echo $this->Paginator->sort('street_2'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('zip'); ?></th>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th><?php echo $this->Paginator->sort('phone_1'); ?></th>
			<th><?php echo $this->Paginator->sort('phone_2'); ?></th>
			<th><?php echo $this->Paginator->sort('website'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($courseSchools as $courseSchool): ?>
	<tr>
		<td><?php echo h($courseSchool['CourseSchool']['name']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['street_1']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['street_2']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['city']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['state']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['zip']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['country']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['phone_1']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['phone_2']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['website']); ?>&nbsp;</td>
		<td><?php echo h($courseSchool['CourseSchool']['owner_id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $courseSchool['CourseSchool']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $courseSchool['CourseSchool']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $courseSchool['CourseSchool']['id']), null, __('Are you sure you want to delete %s?', $courseSchool['CourseSchool']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('&laquo; ' . __('previous'), array(), null, array('class' => 'prev disabled', 'escape' => false));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' &raquo;', array(), null, array('class' => 'next disabled', 'escape' => false));
	?>
	</div>
</div>
