<h1>All Users <a href="<?php echo $this->Url->build("/users/add");?>">Add User</a><h1>
<table>
<tr>
<td>Username</td>
<td>Email</td>
<td>Status</td>
<td>Created</td>
</tr>

<?php 
foreach ($users as $row) {
	echo '<tr><td>'.$row->username.'</td><td>'.$row->email.'</td><td>'.$row->status.'</td><td>'.$row->insert_time.'</td></tr>';
}
?>
</table>