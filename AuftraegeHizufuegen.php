<?php
global $c;
require('connection.php');
require('navbar.php');

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auftrnr = $_POST['auftrnr'] ?? '';
    $datum = $_POST['datum'] ?? '';
    $kundnr = $_POST['kundnr'] ?? '';
    $persnr = $_POST['persnr'] ?? '';

    if (empty($auftrnr) || empty($datum) || empty($kundnr) || empty($persnr)) {
        $error = "❌ Bitte fülle alle Felder aus.";
    } elseif (!is_numeric($auftrnr) || !is_numeric($kundnr) || !is_numeric($persnr)) {
        $error = "❌ Auftragsnummer, KundenNr und PersonalNr müssen Zahlen sein.";
    } else {
        $sql = "INSERT INTO auftrag (AUFTRNR, DATUM, KUNDNR, PERSNR) VALUES (:auftrnr, TO_DATE(:datum, 'YYYY-MM-DD'), :kundnr, :persnr)";
        $stmt = oci_parse($c, $sql);

        oci_bind_by_name($stmt, ":auftrnr", $auftrnr);
        oci_bind_by_name($stmt, ":datum", $datum);
        oci_bind_by_name($stmt, ":kundnr", $kundnr);
        oci_bind_by_name($stmt, ":persnr", $persnr);

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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#1E3A8A",
                        secondary: "#3B82F6"
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">

<main class="container mx-auto p-6 mt-6">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-lg mx-auto">
        <h2 class="text-2xl font-bold text-center mb-6">Neuen Auftrag hinzufügen</h2>

        <?php if ($success): ?>
            <p class="bg-green-200 text-green-800 p-2 rounded mb-4 text-center"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="bg-red-200 text-red-800 p-2 rounded mb-4 text-center"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="AuftraegeHizufuegen.php" class="space-y-4">
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

        <a href="anzeigen_auftraege.php" class="block text-center text-blue-500 mt-4">Zurück zur Auftragsliste</a>
    </div>
</main>
</body>
</html>
