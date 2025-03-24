<?php
global $c;
require('connection.php');

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten abrufen und validieren
    $kundnr = $_POST['kundnr'] ?? '';
    $name = $_POST['name'] ?? '';
    $strasse = $_POST['strasse'] ?? '';

    if (empty($kundnr) || empty($name) || empty($strasse)) {
        $error = "❌ Bitte fülle alle Felder aus.";
    } elseif (!is_numeric($kundnr)) {
        $error = "❌ Die KundenNummer muss eine Zahl sein.";
    } else {
        // SQL INSERT Statement mit STRASSE (statt ADRESSE)
        $sql = "INSERT INTO kunde (NR, NAME, STRASSE) VALUES (:kundnr, :name, :strasse)";
        $stmt = oci_parse($c, $sql);

        // Parameter binden
        oci_bind_by_name($stmt, ":kundnr", $kundnr);
        oci_bind_by_name($stmt, ":name", $name);
        oci_bind_by_name($stmt, ":strasse", $strasse);

        // Statement ausführen und Fehler abfangen
        if (@oci_execute($stmt) === false) {
            $e = oci_error($stmt);
            if (strpos($e['message'], 'ORA-00001') !== false) {
                $error = "❌ Die KundenNr <strong>$kundnr</strong> existiert bereits.";
            } else {
                $error = "❌ Fehler: " . htmlentities($e['message']);
            }
        } else {
            $success = "✅ Kunde erfolgreich hinzugefügt!";
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
    <title>Kunden hinzufügen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Neuen Kunden hinzufügen</h2>

        <?php if ($success): ?>
            <p class="bg-green-200 text-green-800 p-2 rounded mb-4 text-center"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="bg-red-200 text-red-800 p-2 rounded mb-4 text-center"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="HinzufuegenKunden.php" class="space-y-4">
            <div>
                <label class="block text-gray-700">KundenNr</label>
                <input type="text" name="kundnr" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Straße</label>
                <input type="text" name="strasse" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-700">Kunde speichern</button>
        </form>

        <a href="index.php" class="block text-center text-blue-500 mt-4">Zurück zur Liste</a>
    </div>
</body>
</html>
