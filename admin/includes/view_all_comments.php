<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th colspan="4">Action</th>
    </tr>
    </thead>

    <tbody>

    <?php
    /* Getting and setting the comments from the DB */
    findAllComments();
    ?>

    </tbody>
</table>

<?php
deletePosts();



?>
