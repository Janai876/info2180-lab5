<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if(isset($_GET['lookup']))
{
  $lookup=filter_var($_GET['lookup'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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


if(isset($lookup)=="cities")
{
  $search="cities";
  if(isset($country))
  {
    $stmt = $conn->query("SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code=countries.code WHERE countries.name LIKE '%$country%'");
  }
  else
  {
    $stmt = $conn->query("SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code = countries.code;"); 
  }
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
          <th>Independence</th>
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

<?php if ($search == "cities"):?>
<table>
  <thead>
      <tr>
        <th>Name</th>
        <th>District</th>
        <th>Population</th>
      </tr>
  </thead>
  <tbody>
  <?php foreach ($results as $row): ?>
      <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['district'] ?></td>
        <td><?= $row['population'] ?></td>
      </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>