<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>

    <tbody>

<?php
/* Getting and setting the comments from the DB */
findAllUsers();
//approveComments();
//unapproveComments();
//deleteComments();
?>

    </tbody>
</table>
