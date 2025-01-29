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
                <tr class="bg-white hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                    <td class="border border-gray-300 px-4 py-2">Max Mustermann</td>
                    <td class="border border-gray-300 px-4 py-2">Musterstraße 1</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">12345</td>
                    <td class="border border-gray-300 px-4 py-2">Musterstadt</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">Nein</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>