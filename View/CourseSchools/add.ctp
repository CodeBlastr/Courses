<div class="courseSchools form">
<?php echo $this->Form->create('CourseSchool'); ?>
	<fieldset>
		<legend><?php echo __('Add School'); ?></legend>
		
		<div class="row-fluid">
			<div class="span6">
				<?php echo $this->Form->input('name', array('class' => 'span11')); ?>
				<?php echo $this->Form->input('street_1', array('class' => 'span11')); ?>
				<?php echo $this->Form->input('street_2', array('label' => array('class' => 'muted'), 'class' => 'span11')); ?>
				<div class="row-fluid">
					<div class="span6">
						<?php echo $this->Form->input('city'); ?>
					</div>
					<div class="span6">
						<?php echo $this->Form->input('state', array('empty' => '- choose -', 'options' => states())); ?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<?php echo $this->Form->input('zip'); ?>
					</div>
					<div class="span6">
						<?php echo $this->Form->input('country'); ?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<?php echo $this->Form->input('phone_1', array('label' => 'Main Phone')); ?>
					</div>
					<div class="span6">
						<?php echo $this->Form->input('phone_2', array('label' => array('class' => 'muted', 'text' => 'Alt. Phone'))); ?>
					</div>
				</div>
				<?php echo $this->Form->input('website'); ?>
				<?php echo $this->Form->input('owner_id', array('options' => $users, 'empty' => '- choose -')); ?>
			</div>
			<div class="span6">
				<label>Logo</label>
				<?php echo CakePlugin::loaded('Media') ? $this->Element('Media.selector', array('media' => $this->request->data['Media'], 'multiple' => false, 'bootstrap' => 2)) : null; ?>
			</div>
		</div>
		
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
