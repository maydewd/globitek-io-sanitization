<?php
require_once('../../../private/initialize.php');

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['id'])) { $id = $_POST['id']; }

  delete_user($id);
  redirect_to('index.php');
  exit;
}

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = $_GET['id'];
$users_result = find_user_by_id($id);
// No loop, only one result
$user = db_fetch_assoc($users_result);
db_free_result($users_result);
?>

<?php $page_title = 'Staff: Delete User ' . $user['first_name'] . " " . $user['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="show.php?id=<?php echo u($user['id']); ?>">Back to Users Details</a><br />

  <h1>Delete User: <?php echo h($user['first_name'] . " " . $user['last_name']); ?></h1>
  <h3>Are you sure you wish to delete user: <?php echo h($user['first_name'] . " " . $user['last_name']); ?>?</h3>
  <br />

  <form action="delete.php" method="post">
    <input type="hidden" name="id" value="<?php echo h($user['id']); ?>">
    <input type="submit" name="submit" value="Confirm">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
