<?php
include "includes/header.php";

include "config/Db.php";
include "classes/Task.php";

session_start();
?>

<?php



$database = new Db();
$db = $database->connect();
$todo = new Task($db);

if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    if(isset($_POST["add_task"])) {
        $todo->task_name = mysqli_real_escape_string($db, $_POST['task']);
        $todo->createTask();
        $_SESSION['success'] = "Task added successfully";
        $_SESSION['message_type'] = "success";

    } elseif(isset($_POST["complete_task"])) {
        $todo->completeTask($_POST['id']);
        $_SESSION['success'] = "Task marked completed";
        $_SESSION['message_type'] = "success";

    } elseif(isset($_POST["undo_complete_task"])) {
        $todo->undoCompleteTask($_POST['id']);
        $_SESSION['success'] = "Task undone successfully";
        $_SESSION['message_type'] = "success";

    }elseif(isset($_POST["delete_task"])) {
        $todo->deleteTask($_POST['id']);
        $_SESSION['success'] = "Task deleted successfully";
        $_SESSION['message_type'] = "success";
    }

}

$tasks = $todo->readTasks()

?>

<!-- Notifications -->
<?php if(isset($_SESSION['success'])): ?>
    <div class="notification-container <?php echo isset($_SESSION['success']) ? "show": ''  ?>">
        <div class="notification <?php echo $_SESSION['message_type'] ?>">
            <?php echo $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    </div>
<?php endif; ?>


<!-- Main Content Container -->
<div class="container">
    <h1>Tasks Manager</h1>

    <!-- Add Task Form -->
    <form method="POST">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="add_task">Add Task</button>
    </form>

    <!-- Display Tasks -->
    <ul>
        <?php while($task = $tasks->fetch_assoc()): ?>
        <li class="completed">
            <span class="<?php echo $task['completion'] ? 'completed' : '' ?>"><?php echo $task['task'] ?></span>
            <div>
                <?php if(!$task['completion']): ?>
                <!-- Complete Task -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo($task['id']) ?>">
                    <button class="complete" type="submit" name="complete_task">Complete</button>
                </form>
                <?php else: ?>
                <!-- Undo Completed Task -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo($task['id']) ?>">
                    <button class="undo" type="submit" name="undo_complete_task">Undo</button>
                </form>

                <!-- Delete Task -->
                <form onsubmit="return confirmDelete()" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo($task['id']) ?>">
                    <button class="delete" type="submit" name="delete_task">Delete</button>
                </form>
                <?php endif; ?>
            </div>
            <script>
                function confirmDelete(){
                    return confirm('Are you sure?');
                }
            </script>

        </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php
include "includes/footer.php";
?>
