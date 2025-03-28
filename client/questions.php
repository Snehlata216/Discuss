<div class="container">

    <div class="row">
        <div class="col-8">
            <h1 class="heading">Questions</h1>
            <?php
            include("./common/db.php");
            // Define variables properly
            $cid = isset($_GET["c-id"]) ? $_GET["c-id"] : null;
            $uid = isset($_GET["u-id"]) ? $_GET["u-id"] : null;
            $search = isset($_GET["search"]) ? $_GET["search"] : null;

            if (isset($_GET["c-id"])) {
                $query = "SELECT * FROM questions WHERE category_id=$cid";
            } else if (isset($_GET["u-id"])) {
                $query = "SELECT * FROM questions WHERE user_id=$uid";
            } else if (isset($_GET["latest"])) {
                $query = "SELECT * FROM questions ORDER BY id DESC";
            } else if (isset($_GET["search"])) {
                $query = "SELECT * FROM questions WHERE `title` LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM questions";
            }

            $result = $conn->query($query);
            foreach ($result as $row) {
                $title = $row['title'];
                $id = $row['id'];

                echo "<div class='row question-list'>
                <h4 class='my-question'><a href='?q-id=$id'>$title</a>";
                
                // Only show 'Delete' option if $uid is defined and not null
                echo ($uid) ? " <a href='./server/requests.php?delete=$id'>Delete</a>" : "";
                echo "</h4></div>";
            }
                        ?>
        </div>
        <div class="col-4">
            <?php include('categorylist.php'); ?>
        </div>
    </div>
</div>