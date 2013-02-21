<div class="courses view">
<h2><?php  echo __('Course');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($course['Course']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($course['ParentCourse']['name'], array('controller' => 'courses', 'action' => 'view', $course['ParentCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lft'); ?></dt>
		<dd>
			<?php echo h($course['Course']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rght'); ?></dt>
		<dd>
			<?php echo h($course['Course']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($course['Course']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($course['Course']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($course['Course']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('School'); ?></dt>
		<dd>
			<?php echo h($course['Course']['school']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Grade'); ?></dt>
		<dd>
			<?php echo h($course['Course']['grade']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language'); ?></dt>
		<dd>
			<?php echo h($course['Course']['language']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd>
			<?php echo h($course['Course']['start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End'); ?></dt>
		<dd>
			<?php echo h($course['Course']['end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Published'); ?></dt>
		<dd>
			<?php echo h($course['Course']['is_published']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Private'); ?></dt>
		<dd>
			<?php echo h($course['Course']['is_private']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Persistant'); ?></dt>
		<dd>
			<?php echo h($course['Course']['is_persistant']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Sequential'); ?></dt>
		<dd>
			<?php echo h($course['Course']['is_sequential']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course'), array('action' => 'edit', $course['Course']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete # %s?', $course['Course']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Courses');?></h3>
	<?php if (!empty($course['ChildCourse'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('School'); ?></th>
		<th><?php echo __('Grade'); ?></th>
		<th><?php echo __('Language'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('End'); ?></th>
		<th><?php echo __('Is Published'); ?></th>
		<th><?php echo __('Is Private'); ?></th>
		<th><?php echo __('Is Persistant'); ?></th>
		<th><?php echo __('Is Sequential'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($course['ChildCourse'] as $childCourse): ?>
		<tr>
			<td><?php echo $childCourse['id'];?></td>
			<td><?php echo $childCourse['parent_id'];?></td>
			<td><?php echo $childCourse['lft'];?></td>
			<td><?php echo $childCourse['rght'];?></td>
			<td><?php echo $childCourse['name'];?></td>
			<td><?php echo $childCourse['description'];?></td>
			<td><?php echo $childCourse['location'];?></td>
			<td><?php echo $childCourse['school'];?></td>
			<td><?php echo $childCourse['grade'];?></td>
			<td><?php echo $childCourse['language'];?></td>
			<td><?php echo $childCourse['start'];?></td>
			<td><?php echo $childCourse['end'];?></td>
			<td><?php echo $childCourse['is_published'];?></td>
			<td><?php echo $childCourse['is_private'];?></td>
			<td><?php echo $childCourse['is_persistant'];?></td>
			<td><?php echo $childCourse['is_sequential'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'courses', 'action' => 'view', $childCourse['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'courses', 'action' => 'edit', $childCourse['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'courses', 'action' => 'delete', $childCourse['id']), null, __('Are you sure you want to delete # %s?', $childCourse['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Course'), array('controller' => 'courses', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
