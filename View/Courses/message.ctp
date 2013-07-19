<div class="messages index">
	<div class="messages form">
		<?php echo $this->Form->create('Message', array('url' => '/messages/messages/send')); ?>
		<fieldset>
			<?php
			echo __('<legend>Send a Message</legend>');
			echo $this->Form->input('Message.title', array('label' => __('Subject', true)));
			echo $this->Form->input('Message.body', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold', 'Italic', 'Underline', 'FontSize', 'TextColor', 'BGColor', '-', 'NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'Link', 'Unlink', '-', 'Image'))));
			?>
			<b>Receipients:</b>
			<div class="checkbox">
				<input id="checkAll" type="checkbox" class="checkall"/>
				<label for="checkAll">Check all</label>
			</div>
			<?php
			echo $this->Form->input('User', array(
				'multiple' => 'checkbox',
				'label' => false,
				'div' => array('style' => 'max-height: 150px; overflow-y: scroll; margin-top: 25px;')
			));
			echo '<small>Receipients will also be notified of all comments.</small>';
			echo $this->Form->input('Message.sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
			echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/courses/courses/message/' . $this->request->data['Message']['foreign_key']));
			echo $this->Form->hidden('Message.foreign_key');
			echo $this->Form->hidden('Message.model', array('value' => 'Course'));
			echo $this->Form->hidden('Message.viewPath', array('value' => '/courses/courses/message/{messageId}'));
			echo $this->Form->submit(__('Send'));
			echo $this->Form->end();
			?>
		</fieldset>
	</div>
</div>

<script type="text/javascript">
	$(function () {
		$('.checkall').on('click', function () {
			$(this).closest('fieldset').find(':checkbox').prop('checked', this.checked);
		});
	});
</script>