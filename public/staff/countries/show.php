<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = $_GET['id'];
$country_result = find_country_by_id($id);
// No loop, only one result
$country = db_fetch_assoc($country_result);
?>

<?php $page_title = 'Staff: Country of ' . $country['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Countries List</a><br />

  <h1>Country: <?php echo h($country['name']); ?></h1>

  <?php
    echo "<table id=\"country\">";
    echo "<tr>";
    echo "<td>Name: </td>";
    echo "<td>" . h($country['name']) . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Code: </td>";
    echo "<td>" . h($country['code']) . "</td>";
    echo "</tr>";
    echo "</table>";
?>
    <br />
    <a href="edit.php?id=<?php echo u($country['id']); ?>">Edit</a><br />
    <hr />

    <h2>States</h2>

<?php
    $states_result = find_states_for_country_id($country['id']);

    echo "<ul id=\"states\">";
    while($state = db_fetch_assoc($states_result)) {
      echo "<li>";
      echo "<a href=\"../states/show.php?id=" . u($state['id']) . "\">";
      echo h($state['name']);
      echo "</a>";
      echo "</li>";
    } // end while $territory
    db_free_result($states_result);
    echo "</ul>"; // #territories

    db_free_result($country_result);
  ?>

  <a href="../states/new.php?country_id=<?php echo u($country['id']); ?>">Add a State</a><br />

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
