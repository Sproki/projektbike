<?php
global $c;
require('connection.php');
require('navbar.php');

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kundnr = $_POST['kundnr'] ?? '';
    $name = $_POST['name'] ?? '';
    $strasse = $_POST['strasse'] ?? '';

    if (empty($kundnr) || empty($name) || empty($strasse)) {
        $error = "❌ Bitte fülle alle Felder aus.";
    } elseif (!is_numeric($kundnr)) {
        $error = "❌ Die KundenNr muss eine Zahl sein.";
    } else {
        $sql = "INSERT INTO kunde (NR, NAME, STRASSE) VALUES (:kundnr, :name, :strasse)";
        $stmt = oci_parse($c, $sql);

        oci_bind_by_name($stmt, ":kundnr", $kundnr);
        oci_bind_by_name($stmt, ":name", $name);
        oci_bind_by_name($stmt, ":strasse", $strasse);

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

        <a href="anzeigen_kunden.php" class="block text-center text-blue-500 mt-4">Zurück zur Kundenliste</a>
    </div>
</main>
</body>
</html>
