                   <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>IMG</th>
                            <th>Tags</th>
                            <th>Comments</th>
                            <th>Date</th>
                            <th colspan="2">Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        /* Getting and setting the posts from the DB */
                        findAllPosts();
                        ?>

                        </tbody>
                    </table>

                  <?php
                  deletePosts();

                  // editPosts();



                   ?>
