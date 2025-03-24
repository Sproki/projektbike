<?php
require('connection.php'); // Datenbankverbindung

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $persnr = $_POST['persnr'] ?? '';
    $name = $_POST['name'] ?? '';
    $strasse = $_POST['strasse'] ?? '';
    $plz = $_POST['plz'] ?? '';
    $ort = $_POST['ort'] ?? '';
    $gebdatum = $_POST['gebdatum'] ?? '';
    $stand = $_POST['stand'] ?? '';
    $vorgesetzt = $_POST['vorgesetzt'] ?? null;
    $gehalt = $_POST['gehalt'] ?? '';
    $beurteilung = $_POST['beurteilung'] ?? '';
    $aufgabe = $_POST['aufgabe'] ?? '';
    $permission = $_POST['permission'] ?? '';

    // Validation: Alle Pflichtfelder prüfen
    if (empty($persnr) || empty($name) || empty($gebdatum)) {
        $error = "❌ Bitte fülle alle Pflichtfelder aus.";
    } elseif (!is_numeric($persnr) || !is_numeric($plz) || !is_numeric($gehalt) || !is_numeric($permission)) {
        $error = "❌ Personalnummer, PLZ, Gehalt und Permission müssen Zahlen sein.";
    } elseif ($gehalt > 5000) {
        $error = "❌ Fehler: Gehalt darf maximal 5000 Euro betragen!";
    } elseif ($permission < 1 || $permission > 99) {
        $error = "❌ Fehler: Permission muss zwischen 1 und 99 liegen!";
    } else {
        // SQL INSERT Statement
        $sql = "INSERT INTO Personal (PERSNR, NAME, STRASSE, PLZ, ORT, GEBDATUM, STAND, VORGESETZT, GEHALT, BEURTEILUNG, AUFGABE, PERMISSION) 
                VALUES (:persnr, :name, :strasse, :plz, :ort, TO_DATE(:gebdatum, 'YYYY-MM-DD'), :stand, :vorgesetzt, :gehalt, :beurteilung, :aufgabe, :permission)";
        
        $stmt = oci_parse($c, $sql);

        // Parameter binden
        oci_bind_by_name($stmt, ":persnr", $persnr);
        oci_bind_by_name($stmt, ":name", $name);
        oci_bind_by_name($stmt, ":strasse", $strasse);
        oci_bind_by_name($stmt, ":plz", $plz);
        oci_bind_by_name($stmt, ":ort", $ort);
        oci_bind_by_name($stmt, ":gebdatum", $gebdatum);
        oci_bind_by_name($stmt, ":stand", $stand);
        oci_bind_by_name($stmt, ":vorgesetzt", $vorgesetzt);
        oci_bind_by_name($stmt, ":gehalt", $gehalt);
        oci_bind_by_name($stmt, ":beurteilung", $beurteilung);
        oci_bind_by_name($stmt, ":aufgabe", $aufgabe);
        oci_bind_by_name($stmt, ":permission", $permission);

        // Statement ausführen und Fehler abfangen
        if (@oci_execute($stmt) === false) {
            $e = oci_error($stmt);
            $error = "❌ Fehler: " . htmlentities($e['message']);
        } else {
            $success = "✅ Personal erfolgreich hinzugefügt!";
        }

        oci_free_statement($stmt);
    }
}
oci_close($c);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal hinzufügen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Neues Personal hinzufügen</h2>

        <?php if ($success): ?>
            <p class="bg-green-200 text-green-800 p-2 rounded mb-4 text-center"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="bg-red-200 text-red-800 p-2 rounded mb-4 text-center"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="HinzufuegenPersonal.php" class="space-y-4">
            <input type="text" name="persnr" placeholder="PersonalNr" class="w-full border p-2 rounded" required>
            <input type="text" name="name" placeholder="Name" class="w-full border p-2 rounded" required>
            <input type="text" name="strasse" placeholder="Straße" class="w-full border p-2 rounded">
            <input type="text" name="plz" placeholder="PLZ" class="w-full border p-2 rounded">
            <input type="text" name="ort" placeholder="Ort" class="w-full border p-2 rounded">
            <input type="date" name="gebdatum" class="w-full border p-2 rounded" required>
            <input type="text" name="stand" placeholder="Stand" class="w-full border p-2 rounded">
            <input type="text" name="vorgesetzt" placeholder="Vorgesetzter" class="w-full border p-2 rounded">
            <input type="text" name="gehalt" placeholder="Gehalt" class="w-full border p-2 rounded">
            <input type="text" name="beurteilung" placeholder="Beurteilung (1-6)" class="w-full border p-2 rounded">
            <input type="text" name="aufgabe" placeholder="Aufgabe" class="w-full border p-2 rounded">
            <input type="text" name="permission" placeholder="Permission (1-99)" class="w-full border p-2 rounded">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-700">Speichern</button>
        </form>

        <a href="index.php" class="block text-center text-blue-500 mt-4">Zurück zur Liste</a>
    </div>
</body>
</html>
