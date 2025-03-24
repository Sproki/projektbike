<?php
global $c;
require('connection.php');

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten abrufen und validieren
    $auftrnr = $_POST['auftrnr'] ?? '';
    $datum = $_POST['datum'] ?? '';
    $kundnr = $_POST['kundnr'] ?? '';
    $persnr = $_POST['persnr'] ?? '';

    if (empty($auftrnr) || empty($datum) || empty($kundnr) || empty($persnr)) {
        $error = "❌ Bitte fülle alle Felder aus.";
    } elseif (!is_numeric($auftrnr) || !is_numeric($kundnr) || !is_numeric($persnr)) {
        $error = "❌ Auftragsnummer, KundenNr und PersonalNr müssen Zahlen sein.";
    } else {
        // SQL INSERT Statement vorbereiten
        $sql = "INSERT INTO auftrag (AUFTRNR, DATUM, KUNDNR, PERSNR) VALUES (:auftrnr, TO_DATE(:datum, 'YYYY-MM-DD'), :kundnr, :persnr)";
        $stmt = oci_parse($c, $sql);

        // Parameter binden
        oci_bind_by_name($stmt, ":auftrnr", $auftrnr);
        oci_bind_by_name($stmt, ":datum", $datum);
        oci_bind_by_name($stmt, ":kundnr", $kundnr);
        oci_bind_by_name($stmt, ":persnr", $persnr);

        // Statement ausführen und Fehler abfangen
        if (@oci_execute($stmt) === false) {
            $e = oci_error($stmt);
            if (strpos($e['message'], 'ORA-00001') !== false) {
                $error = "❌ Die Auftragsnummer <strong>$auftrnr</strong> existiert bereits.";
            } elseif (strpos($e['message'], 'ORA-02291') !== false) {
                $error = "❌ Ungültige KundenNr oder PersonalNr. Diese müssen in der Datenbank existieren.";
            } elseif (strpos($e['message'], 'ORA-01843') !== false) {
                $error = "❌ Falsches Datumsformat! Bitte verwende das Format: YYYY-MM-DD.";
            } else {
                $error = "❌ Unerwarteter Fehler: " . htmlentities($e['message']);
            }
        } else {
            $success = "✅ Auftrag erfolgreich hinzugefügt!";
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
    <title>Auftrag hinzufügen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Neuen Auftrag hinzufügen</h2>

        <?php if ($success): ?>
            <p class="bg-green-200 text-green-800 p-2 rounded mb-4 text-center"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="bg-red-200 text-red-800 p-2 rounded mb-4 text-center"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="insert.php" class="space-y-4">
            <div>
                <label class="block text-gray-700">Auftragsnummer</label>
                <input type="text" name="auftrnr" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Datum</label>
                <input type="date" name="datum" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">KundenNr</label>
                <input type="text" name="kundnr" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">PersonalNr</label>
                <input type="text" name="persnr" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-700">Auftrag speichern</button>
        </form>

        <a href="login.php" class="block text-center text-blue-500 mt-4">Zurück zur Liste</a>
    </div>
</body>
</html>
