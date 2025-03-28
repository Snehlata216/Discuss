<?php
session_start();
include("../common/db.php");

// SIGNUP Logic
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Using prepared statement with placeholders
    $user = $conn->prepare("INSERT INTO `users` (`name`, `email`, `password`, `address`) VALUES (?, ?, ?, ?)");
    $user->bind_param("ssss", $username, $email, $password, $address);

    $result = $user->execute();

    if ($result) {
        $user_id = $conn->insert_id; // Correct way to get last inserted ID
        $_SESSION["user"] = ["username" => $username, "email" => $email, "user_id" => $user_id];
        header("Location: /discuss");
        exit();
    } else {
        echo "New user not registered";
    }

}

// LOGIN Logic
else if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query
    $query = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $query->bind_param("ss", $email, $password);
    $query->execute();

    $result = $query->get_result(); // Get query result

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc(); // Fetch user details

        $username = $row['name']; // Correct column name
        $user_id = $row['id'];

        // Set session variables
        $_SESSION["user"] = ["username" => $username, "email" => $email, "user_id" => $user_id];
        
        header("Location: /discuss");
        exit();
    } else {
        echo "Invalid email or password";
    }
}

// LOGOUT Logic
else if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: /discuss");
    exit();
}

// ASK QUESTION Logic
else if (isset($_POST["ask"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $user_id = $_SESSION['user']['user_id'];

    $question = $conn->prepare("INSERT INTO `questions` (`title`, `description`, `category_id`, `user_id`) VALUES (?, ?, ?, ?)");
    $question->bind_param("ssii", $title, $description, $category_id, $user_id);
    $result = $question->execute();

    if ($result) {
        header("Location: /discuss");
        exit();
    } else {
        echo "Error adding question";
    }
}

// ANSWER Logic
else if (isset($_POST["answer"])) {
    $answer = $_POST['answer'];
    $question_id = $_POST['question_id'];
    $user_id = $_SESSION['user']['user_id'];

    $query = $conn->prepare("INSERT INTO `answers` (`answer`, `question_id`, `user_id`) VALUES (?, ?, ?)");
    $query->bind_param("sii", $answer, $question_id, $user_id);
    $result = $query->execute();

    if ($result) {
        header("Location: /discuss?q-id=$question_id");
        exit();
    } else {
        echo "Error submitting answer";
    }
}

// DELETE QUESTION Logic
else if (isset($_GET["delete"])) {
    $qid = $_GET["delete"];
    $query = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $query->bind_param("i", $qid);
    $result = $query->execute();

    if ($result) {
        header("Location: /discuss");
        exit();
    } else {
        echo "Error deleting question";
    }
}
?>
