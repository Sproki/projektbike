<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navi</title>
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
  <nav class="bg-primary p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" class="text-white text-xl font-bold">Meine Seite</a>
      <ul class="flex space-x-6 relative">
        <li class="relative group">
          <a href="#" class="text-white hover:text-secondary transition">Aufträge</a>
          <ul class="submenu absolute left-0 mt-2 hidden flex-col bg-white shadow-lg rounded-md overflow-hidden w-48 py-2">
            <li><a href="AnzeigeAuftraege.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Aufträge anzeigen</a></li>
            <li><a href="insert.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Auftrag hinzufügen</a></li>
          </ul>
        </li>
        <li class="relative group">
          <a href="#" class="text-white hover:text-secondary transition">Kunden</a>
          <ul class="submenu absolute left-0 mt-2 hidden flex-col bg-white shadow-lg rounded-md overflow-hidden w-48 py-2">
            <li><a href="AnzeigeKunden.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Kunden anzeigen</a></li>
            <li><a href="HinzufuegenKunden.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Kunde hinzufügen</a></li>
          </ul>
        </li>
        <li class="relative group">
          <a href="#" class="text-white hover:text-secondary transition">Mitarbeiter</a>
          <ul class="submenu absolute left-0 mt-2 hidden flex-col bg-white shadow-lg rounded-md overflow-hidden w-48 py-2">
            <li><a href="AnzeigenMitarbeiterVorgesetzte.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Mitarbeiter anzeigen</a></li>
            <li><a href="HinzufuegenPersonal.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Mitarbeiter hinzufügen</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <script>
    document.querySelectorAll('.group').forEach(item => {
      item.addEventListener('mouseenter', function() {
        // Schließe alle anderen Dropdowns, bevor das aktuelle geöffnet wird
        document.querySelectorAll('.submenu').forEach(submenu => {
          submenu.classList.add('hidden');
        });
        this.querySelector('.submenu').classList.remove('hidden');
      });
    });

    // Wenn der Benutzer irgendwo außerhalb des Dropdowns klickt, schließe es
    document.addEventListener('click', function(event) {
      let isClickInside = event.target.closest('.group');
      if (!isClickInside) {
        document.querySelectorAll('.submenu').forEach(submenu => {
          submenu.classList.add('hidden');
        });
      }
    });

    // Verhindert das Schließen des Dropdowns, wenn der Benutzer innerhalb eines Dropdowns klickt
    document.querySelectorAll('.group').forEach(item => {
      item.addEventListener('click', function(event) {
        event.stopPropagation(); // Verhindert das Schließen beim Klicken auf den Dropdown-Bereich
      });
    });
  </script>
</body>
</html>
