<div style="overflow-x:auto;"> <!-- For responsive table -->
    <table class="table sortable table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>

    <tbody>

<?php
/* Getting and setting the comments from the DB */
findAllComments();
approveComments();
unapproveComments();
deleteComments();
?>

    </tbody>
</table>
</div>