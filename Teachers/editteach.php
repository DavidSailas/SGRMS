<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM teachers WHERE t_id = $id");
$teacher = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $level = $_POST['level'];
    $stmt = $conn->prepare("UPDATE teachers SET level = ? WHERE t_id = ?");
    $stmt->bind_param("si", $level, $id);
    $stmt->execute();
    header("Location: teacher.php");
}
?>

<form method="post">
    Level: <input type="text" name="level" value="<?php echo $teacher['level']; ?>">
    <button type="submit">Update</button>
</form>
