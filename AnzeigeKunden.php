<?php 
$c = oci_pconnect("BIKE", "BIKE", "localhost/orcl"); 
if (!$c) { 
    $e = oci_error(); 
    trigger_error('Could not connect to database: '. $e['message'], E_USER_ERROR); 
} 

// Abfrage für Kundendaten
$s = oci_parse($c, "Select * From kunde"); 
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
    <title>Kundentabelle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Kundendaten</h2>
       
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Nr</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Strasse</th>
                    <th class="border border-gray-300 px-4 py-2">PLZ</th>
                    <th class="border border-gray-300 px-4 py-2">Ort</th>
                    <th class="border border-gray-300 px-4 py-2">Sperre</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) !== false): ?>
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlentities($row['NR']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlentities($row['NAME']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlentities($row['STRASSE']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlentities($row['PLZ']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlentities($row['ORT']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= ($row['SPERRE'] == 'J' ? 'Ja' : 'Nein') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</body>
</html>

<?php 
oci_free_statement($s); 
oci_close($c); 
?>
