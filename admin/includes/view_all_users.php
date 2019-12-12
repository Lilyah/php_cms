

<div class="page-header">
<?php
/* Users Online counteer showing */
echo "Users Online (with PHP, need refresh of the page): ".usersOnline();
echo "<br>";
echo "Users Online Instant (with AJAX):"?> <span class="usersonline"></span>
</div>



<table class="sortable table table-striped table-bordered table-hover table-condensed">
<thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th colspan="4">Action</th>
    </tr>

    <!-- Search form -->
    <tr>
        <th colspan="6">
            <!-- Search Field -->
                <form action="users.php?source=search" method="post">
                        <input name="search" type="text" style="width:100%;">
                </form>
        </th>
        <th colspan="4"></th>
    </tr>
    </thead>

    <tbody>

<?php
/* Getting and setting the comments from the DB */
findAllUsers();
changeToAdminUsers();
changeTosubscriberUsers();
deleteUsers();
?>

    </tbody>
</table>
