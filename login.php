<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <form class="w-full max-w-sm bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Anmelden</h2>

            <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="E-Mail eingeben"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder:pl-2">
            </div>

            <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Passwort</label>
            <input type="password" id="password" name="password" placeholder="Passwort eingeben"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder:pl-2">
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Absenden
            </button>
        </form>
    </div>
</body>
</html>