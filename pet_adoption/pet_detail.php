<?php
include 'db.php';

$pet_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();
$pet = $result->fetch_assoc();
?>

<h2><?= htmlspecialchars($pet['name']) ?></h2>
<img src="uploads/<?= htmlspecialchars($pet['image']) ?>" width="200"><br>
Species: <?= htmlspecialchars($pet['species']) ?><br>
Breed: <?= htmlspecialchars($pet['breed']) ?><br>
Age: <?= htmlspecialchars($pet['age']) ?><br>
Medical Condition: <?= htmlspecialchars($pet['medical_condition']) ?><br>
Vaccination: <?= htmlspecialchars($pet['vaccination']) ?><br>

<a href="request_visit.php?pet_id=<?= $pet_id ?>">Adopt This Pet</a>
