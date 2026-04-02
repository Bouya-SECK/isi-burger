@component('mail::message')
    # Votre commande est prête ! 🍔

    Bonjour **{{ $commande->user->name }}**,

    Votre commande **#{{ $commande->id }}** est prête et vous attend !

    @component('mail::table')
        | Burger | Quantité | Prix |
        |:-------|:--------:|-----:|
        @foreach($commande->items as $item)
            | {{ $item->burger->nom }} | x{{ $item->quantite }} | {{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} F |
        @endforeach
    @endcomponent

    **Total : {{ number_format($commande->total, 0, ',', ' ') }} F CFA**

    Merci de votre confiance !


    **ISI BURGER** — Le meilleur burger de Dakar
@endcomponent
