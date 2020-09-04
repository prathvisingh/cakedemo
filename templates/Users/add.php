<h1>Add User</h1>
<?php 

$options = array(
 array('name' => 'Enabled', 'value' => 1),
 array('name' => 'Disabled', 'value' => 0),
);

echo $this->Form->create(NULL,array('url'=>'/users/add'));
echo $this->Form->control('username');
echo $this->Form->control('password');
echo $this->Form->control('email');
echo $this->Form->label('Status');
echo $this->Form->select('status', $options);
echo $this->Form->button('Submit');
echo $this->Form->end();

?>