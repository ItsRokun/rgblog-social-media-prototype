<?php
session_start();
include_once "../php/config.php";

// Check if the user is logged in
if (!isset($_SESSION['unique_id'])) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['unique_id']; // Get the logged-in user's ID

// Get the post ID from the URL
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// Fetch the post details, including the owner and image
$post_stmt = $conn->prepare("SELECT posts.*, users.fname AS username FROM posts JOIN users ON posts.user_id = users.user_id WHERE posts.post_id = ?");
$post_stmt->bind_param("i", $post_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();

if ($post_result->num_rows === 0) {
    echo "<p>Post not found.</p>";
    exit();
}

$post = $post_result->fetch_assoc();
$post_stmt->close();

// Handle post deletion if the user is the post's owner
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id === $post['user_id']) {
    // Delete the image file if it exists
    if ($post['image'] && file_exists("../php/images/" . $post['image'])) {
        unlink("../php/images/" . $post['image']);
    }

    // Delete the post
    $delete_stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
    $delete_stmt->bind_param("i", $post_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details</title>
    <link rel="stylesheet" href="../css/view.css"> <!-- Updated CSS file for this page -->
</head>
<body>

<?php include('../header.php'); ?> <br><br><br>

<div class="post-details-container">
    <h2>Post Details</h2>
    <div class="post">

        <h3><?php echo htmlspecialchars($post['username']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p> <!-- Use nl2br to preserve line breaks -->
        <?php if ($post['image']) { ?>
            <img src="../php/images/<?php echo htmlspecialchars($post['image']); ?>" class="post-image" alt="Post Image">
        <?php } ?>
        <p class="post-date">Posted on: <?php echo htmlspecialchars($post['created_at']); ?></p>

        <?php if ($user_id === $post['user_id']) { ?>
            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                <button type="submit" class="delete-button">Delete Post</button>
            </form>
        <?php } ?>
    </div>

    <!-- Display users who liked the post -->
    <div class="likes-section">
        <h4>Liked by:</h4>
        <?php
        $like_stmt = $conn->prepare("SELECT users.fname FROM likes JOIN users ON likes.user_id = users.user_id WHERE likes.post_id = ?");
        $like_stmt->bind_param("i", $post_id);
        $like_stmt->execute();
        $like_result = $like_stmt->get_result();
        
        if ($like_result->num_rows > 0) {
            while ($like_row = $like_result->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($like_row['fname']) . "</p>";
            }
        } else {
            echo "<p>No likes yet.</p>";
        }
        $like_stmt->close();
        ?>
    </div>

    <!-- Display comments on the post -->
    <div class="comments-section">
        <h4>Comments:</h4>
        <?php
        $comment_stmt = $conn->prepare("SELECT users.fname, comments.comment FROM comments JOIN users ON comments.user_id = users.user_id WHERE comments.post_id = ?");
        $comment_stmt->bind_param("i", $post_id);
        $comment_stmt->execute();
        $comment_result = $comment_stmt->get_result();
        
        if ($comment_result->num_rows > 0) {
            while ($comment_row = $comment_result->fetch_assoc()) {
                echo "<p><strong>" . htmlspecialchars($comment_row['fname']) . ":</strong> " . nl2br(htmlspecialchars($comment_row['comment'])) . "</p>"; // Use nl2br for comments
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
        $comment_stmt->close();
        ?>
    </div>
</div>

<?php include('../footer.php'); ?>

</body>
</html>

<?php
$conn->close();
?>
