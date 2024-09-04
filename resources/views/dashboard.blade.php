<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@php
    function formatDescription($text) {
        // Trouver la position du premier point ou point d'exclamation
        $pos = min(
            strpos($text, '.') ?: PHP_INT_MAX, // Position du premier point ou un très grand nombre si non trouvé
            strpos($text, '!') ?: PHP_INT_MAX  // Position du premier point d'exclamation ou un très grand nombre si non trouvé
        );

        // Si un point ou point d'exclamation est trouvé
        if ($pos !== PHP_INT_MAX) {
            // Extrait le texte jusqu'au premier point ou point d'exclamation (inclus)
            $formatted = substr($text, 0, $pos + 1) . '<br>';

            return $formatted;
        } else {
            // Si aucun point ou point d'exclamation n'est trouvé, retourner le texte original
            return $text;
        }
    }
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                @forelse($contests as $contest)
                    @php
                        // Vérifier s'il y a des images disponibles
                        if ($contest->images->isNotEmpty()) {
                            // Récupérer une image aléatoire parmi les images disponibles
                            $randomImage = $contest->images->random();
                        } else {
                            // Pas d'images disponibles, utiliser une image par défaut ou laisser vide
                            $randomImage = null;
                        }
                    @endphp

                    <div class="col-md-4">
                        <div class="card">
                            @if ($randomImage)
                                <a href="{{ route('contests.show', $contest->id) }}">
                                    <img src="{{ asset('storage/' . $randomImage->image_path) }}" class="card-img-top bg-gray-800" alt="Image of {{ $contest->name }}" style="border-radius: 1rem">
                                </a>
                            @else
                                <img src="{{ asset('storage/placeholder.jpg') }}" class="card-img-top" alt="Placeholder image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('contests.show', $contest->id) }}" class="text-decoration-none" style="color: #818cf8">{{ $contest->name }}</a>
                                </h5>
                                <p class="card-text">{!! formatDescription($contest->description) !!}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted text-decoration-line-through"></div>
                                    <p class="mb-0" style="color: #818cf8">{{ $contest->entry_fee }}€</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p>Aucun concours disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</x-app-layout>
