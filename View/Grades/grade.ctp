<table>
	<thead>
		<tr>
			<td><?php echo $this->Html->tag('h3', 'Question:'); ?></td>
			<td><?php echo $this->Html->tag('h3', 'Answer:'); ?></td>
		</tr>
	</thead>
	<tbody>
<?php
foreach ( $this->request->data['Form']['FormInput'] as $question ) { ?>
	<tr>
		<td><?php echo $this->Html->tag('p', $question['name']); ?></td>
		<td><?php echo $this->Html->tag('p', $question['FormAnswer'][0]['answer']); ?></td>
	</tr>
<?php
} ?>
	</tbody>
</table>
<?php
echo $this->Form->create('Grade');
echo $this->Form->input('id');
echo $this->Form->hidden('course_id');
echo $this->Form->input('grade', array('placeholder' => '100', 'min' => 0, 'max' => '100'));
echo $this->Form->submit('Save Grade');
echo $this->Form->end();
