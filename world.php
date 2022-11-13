<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if(isset($_GET['context']))
{
  $context=filter_var($_GET['context'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
}
$country=filter_var($_GET['country'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

$search="countries";
if(isset($country))
{
  $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%';");
}
else
{
  $stmt = $conn->query("SELECT * FROM countries");
}


$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!--
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
-->

<?php if ($search == "countries"):?>
<table>
  <thead>
      <tr>
          <th>Name</th>
          <th>Continent</th>
          <th>Idependence</th>
          <th>Head of State</th>
      </tr>
  </thead>
  <tbody>
  <?php foreach ($results as $row): ?>
      <tr>
          <td><?= $row['name']; ?></td>
          <td><?= $row['continent']; ?></td>
          <td><?= $row['independence_year']; ?></td>
          <td><?= $row['head_of_state']; ?></td>
      </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>