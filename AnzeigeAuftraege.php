<?php
global $c;
require('connection.php');
require('navbar.php');

// Abfrage für Auftragsdaten
$s = oci_parse($c, "SELECT * FROM auftrag");
if (!$s) {
    $e = oci_error($c);
    trigger_error('Could not parse statement: '. $e['message'], E_USER_ERROR);
}

$r = oci_execute($s);
if (!$r) {
    $e = oci_error($s);
    trigger_error('Could not execute statement: '. $e['message'], E_USER_ERROR);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aufträge anzeigen</title>
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
    <h2 class="text-3xl font-bold text-center mb-6">Aufträge</h2>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Nr</th>
                <th class="border border-gray-300 px-4 py-2">Datum</th>
                <th class="border border-gray-300 px-4 py-2">Kunden-Nr</th>
                <th class="border border-gray-300 px-4 py-2">Personal-Nr</th>
            </tr>
            </thead>
            <tbody>
            <?php while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) !== false): ?>
                <tr class="bg-white hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlentities($row['AUFTRNR']) ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= htmlentities($row['DATUM']) ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= htmlentities($row['KUNDNR']) ?></td>
                    <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlentities($row['PERSNR']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
oci_free_statement($s);
oci_close($c);
?>
</body>
</html>
