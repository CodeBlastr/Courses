<div class="row-fluid">
	<h3><?php echo $answer['Answer']['title']; ?></h3>
	<h6>Answer Key</h6>
	<?php
		echo $this->Form->create('Answers.Answer', array('url' => array('plugin' => 'courses', 'controller' => 'courseGrades', 'action' => 'answerkey')));
		echo $this->Form->hidden('Answer.id', array('value' => $answer['Answer']['id']));
		echo $answer['Answer']['content'];
		echo $this->Form->submit('Submit');
		echo $this->Form->end();
	?>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Forms',
		'items' => array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $form['Answer']['id']), array('class' => 'edit')),
			$this->Html->link(__('Add'), array('action' => 'add'), array('class' => 'add')),
			$this->Html->link(__('List'), array('action' => 'index'), array('class' => 'index')),
			)
		),
	))); ?>
	
<script type="text/javascript">
	
	(function($) {
		<?php if(!empty($answers_json)): ?>
			var answers = $.parseJSON('<?php echo $answers_json; ?>');
		<?php else: ?>
			var answers = '';
		<?php endif; ?>
		$.each(answers, function(input, value) {
			el = $('#'+input);
			$('input:radio[name="data[Answer]['+input+']"]').filter('[value="'+value.answer+'"]').prop('checked', true);
			el.val(value.answer);
    		$('[for='+input+']').after('<p><span class="label label-info">Current Answer: '+value.answer+'</span><p>');
		});
		
		$(document).ready(function() {
			$('.control-label').each(function(i, el) {
				var inputName = $(el).attr('for');
				$(el).after('<label style="float:right;">Points ('+inputName+'): <input type="text" required="" class="input-small" name="data[Points]['+inputName+']" id="points-'+inputName+'"></label>');
				$('#points-'+inputName).val(answers[inputName].points);
			})
		});
		
	})(jQuery);
	
</script>