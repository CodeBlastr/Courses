<?php

//debug($lessons);break;

$start = strtotime($lessons['Lesson']['start']);
$end = strtotime($lessons['Lesson']['end']);
$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
?>
<div class="lessons view">
	<h2><?php echo $lessons['Lesson']['name'] ?></h2>
	<p><?php echo $lessons['Lesson']['description'] ?></p>
	<hr />
	<p>
		<b>Starts: </b><?php echo $this->Time->niceShort($lessons['Lesson']['start']) ?> (<?php echo $lengthOfCourse ?> weeks long)
	</p>
	<p>
		<b>Location: </b><?php echo $lessons['Lesson']['location'] ?>
	</p>
	<p>
		<b>Language: </b><?php echo $lessons['Lesson']['language'] ?>
	</p>
	<p><a href="#" class="btn btn-primary">Join</a></p>
	<hr />
	<?php
	if ( !empty($lessons['Form']) ) {
		echo '<h4>Quizzes / Tests</h4>';
		foreach ( $lessons['Form'] as $form ) {
			echo '<li>'. $this->Html->link($form['name'], array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'view', $form['id'])) . '</li>';
		}
	}
	
	if ( !empty($lessons['Media']) ) {
		echo '<h4>Lesson Materials</h4>';
		foreach ( $lessons['Media'] as $media ) {
			echo '<li>'. $this->Html->link($media['title'], array('plugin' => 'media', 'controller' => 'media', 'action' => 'view', $media['id'])) . '</li>';
		}
	}
	?>
	
	
	<dl>
<!--		<dt><?php echo __('Parent Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lessons['ParentCourse']['name'], array('controller' => 'courses', 'action' => 'view', $lessons['ParentCourse']['id'])); ?>
			&nbsp;
		</dd>-->
	</dl>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course'), array('action' => 'edit', $lessons['Lesson']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course'), array('action' => 'delete', $lessons['Lesson']['id']), null, __('Are you sure you want to delete # %s?', $lessons['Lesson']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Create Quiz'), array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'add', 'formanswer', 'Course', $lessons['Lesson']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')); ?> </li>
	</ul>
</div>
<!--<div class="related">
	<h3><?php echo __('Related Lessons');?></h3>
	<?php if (!empty($lessons['Lesson'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Location'); ?></th>
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
		foreach ($lessons['Lesson'] as $childCourse): ?>
		<tr>
			<td><?php echo $childCourse['name'];?></td>
			<td><?php echo $childCourse['description'];?></td>
			<td><?php echo $childCourse['location'];?></td>
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
			<li><?php echo $this->Html->link(__('New Lesson'), array('controller' => 'lessons', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>-->
