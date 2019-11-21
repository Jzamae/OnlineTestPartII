<div class="row-fluid">

	<div class="alert">
		<h3>Import Form</h3>
	</div>
<?php
echo $this->Form->create('FileUpload',Array('type' => 'file'));
echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file'));
echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>

	<hr />

	<div class="alert alert-success">
		<h3><?php echo $result; ?></h3>
	</div>

</div>