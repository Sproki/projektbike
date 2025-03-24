<?php
$con = oci_pconnect("BIKEDB", "BIKEDB", "localhost/orcl");
if (!$con) {
    $e = oci_error();
    trigger_error('Could not connect to database: ' . $e['message'], E_USER_ERROR);
}

if (isset($_POST["submit"])) {
    $name = $_POST["name"];

    if (empty($name)) {
        die("Bitte Feld ausfüllen.");
    }

    $stmt = oci_parse($con, 'SELECT * FROM PERSONAL WHERE NAME = :name');
    oci_bind_by_name($stmt, ":name", $name);
    oci_execute($stmt);

    if (!$stmt) {
        die("Fehler beim Prepare: " . oci_error()['message']);
    }

    if (!oci_execute($stmt)) {
        die("Fehler beim Ausführen: " . oci_error($stmt)['message']);
    }

    $user = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS);
    var_dump($user);

    oci_free_statement($stmt);

    echo($user["name"]);

    // User nicht gefunden
    if (!$user) {
        die("Login fehlgeschlagen, Benutzer nicht gefunden.<br>DEBUG: Gesuchtr Name: $name");
    }

    session_start();
    $_SESSION["permission_level"] = $user["PERMISSION"];
    $_SESSION["user_id"] = $user["ID"];

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <body class="bg-gray-100">
        <div class="flex items-center justify-center min-h-screen">
            <form class="w-full max-w-sm bg-white p-6 rounded-lg shadow-lg" method="POST" action="">
                <h2 class="text-2xl font-bold text-center mb-6">Anmelden</h2>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="name" id="name" name="name" placeholder="Vollständigen Namen eingeben"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder:pl-2" required>
                </div>
                <button type="submit" name="submit"
                        class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Anmelden
                </button>
            </form>
        </div>
    </body>
</html>
