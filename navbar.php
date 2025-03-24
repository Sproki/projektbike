<nav class="bg-primary p-4 shadow-md w-full block">
<div class="container mx-auto flex items-center">
        <a href="#" class="text-white text-xl font-bold">BikeDB</a>
        <ul class="hidden md:flex space-x-8 items-center ml-10">
            <li class="relative group">
                <a href="#" class="text-white hover:text-secondary">Aufträge</a>
                <ul class="submenu absolute left-0 mt-2 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-48 py-2 z-50">
                    <li><a href="AnzeigeAuftraege.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Aufträge anzeigen</a></li>
                    <li><a href="AuftraegeHizufuegen.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Auftrag hinzufügen</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-secondary">Kunden</a>
                <ul class="submenu absolute left-0 mt-2 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-48 py-2 z-50">
                    <li><a href="AnzeigeKunden.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Kunden anzeigen</a></li>
                    <li><a href="HinzufuegenKunden.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Kunde hinzufügen</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-secondary">Mitarbeiter</a>
                <ul class="submenu absolute left-0 mt-2 hidden group-hover:flex flex-col bg-white shadow-lg rounded-md w-48 py-2 z-50">
                    <li><a href="AnzeigenMitarbeiterVorgesetzte.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Mitarbeiter anzeigen</a></li>
                    <li><a href="HinzufuegenPersonal.php" class="block px-4 py-2 hover:bg-secondary hover:text-white">Mitarbeiter hinzufügen</a></li>
                </ul>
            </li>
        </ul>

        <!-- Mobile Toggle Button -->
        <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none ml-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden flex-col bg-white text-primary md:hidden shadow-lg mt-2">
        <a href="anzeigen_auftraege.php" class="px-4 py-2 border-b hover:bg-secondary hover:text-white">Aufträge anzeigen</a>
        <a href="hinzufuegen_auftrag.php" class="px-4 py-2 border-b hover:bg-secondary hover:text-white">Auftrag hinzufügen</a>
        <a href="anzeigen_kunden.php" class="px-4 py-2 border-b hover:bg-secondary hover:text-white">Kunden anzeigen</a>
        <a href="hinzufuegen_kunde.php" class="px-4 py-2 border-b hover:bg-secondary hover:text-white">Kunde hinzufügen</a>
        <a href="anzeigen_mitarbeiter.php" class="px-4 py-2 border-b hover:bg-secondary hover:text-white">Mitarbeiter anzeigen</a>
        <a href="hinzufuegen_mitarbeiter.php" class="px-4 py-2 border-b hover:bg-secondary hover:text-white">Mitarbeiter hinzufügen</a>
    </div>
</nav>

<script>
    // Mobile Menü umschalten
    document.getElementById("mobile-menu-button").addEventListener("click", function () {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });

    // Dropdowns auf Desktop anzeigen/verstecken
    document.querySelectorAll('.group').forEach(item => {
        item.addEventListener('mouseenter', function () {
            document.querySelectorAll('.submenu').forEach(submenu => {
                submenu.classList.add('hidden');
            });
            this.querySelector('.submenu').classList.remove('hidden');
        });
    });

    document.addEventListener('click', function (event) {
        let isClickInside = event.target.closest('.group');
        if (!isClickInside) {
            document.querySelectorAll('.submenu').forEach(submenu => {
                submenu.classList.add('hidden');
            });
        }
    });

    document.querySelectorAll('.group').forEach(item => {
        item.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    });
</script>
