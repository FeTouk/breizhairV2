<footer class="bg-gray-800 text-gray-300">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            
            {{-- Partie Gauche: Copyright --}}
            <div class="text-center md:text-left mb-4 md:mb-0">
                <p>&copy; {{ date('Y') }} Breizh'Air - Tous droits réservés.</p>
            </div>

            {{-- Partie Droite: Menu de navigation --}}
            <div class="text-center md:text-right">
                <ul class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                    <li>
                        <a href="/" class="hover:text-white transition duration-300">Accueil</a>
                    </li>
                    <li>
                        <a href="/reglement" class="hover:text-white transition duration-300">Réglement</a>
                    </li>
                    <li>
                        <a href="/mentions-legales" class="hover:text-white transition duration-300">Mentions Légales</a>
                    </li>
                    <li>
                        <a href="/contact" class="hover:text-white transition duration-300">Contact</a>
                    </li>
                    <li>
                        <a href="#" id="dyslexia-toggle" class="hover:text-white transition duration-300">Accessibilité (Dyslexie)</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>