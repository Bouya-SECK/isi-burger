@component('mail::message')
    # Commande confirmée ! 🍔

    Bonjour **{{ $commande->user->name }}**,

    Votre commande **#{{ $commande->id }}** a bien été reçue et est en cours de traitement.

    @component('mail::table')
        | Burger | Quantité | Prix |
        |:-------|:--------:|-----:|
        @foreach($commande->items as $item)
            | {{ $item->burger->nom }} | x{{ $item->quantite }} | {{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} F |
        @endforeach
    @endcomponent

    **Total : {{ number_format($commande->total, 0, ',', ' ') }} F CFA**

    Nous vous préviendrons dès que votre commande sera prête.

    @component('mail::button', ['url' => config('app.url'), 'color' => 'primary'])
        Suivre ma commande
    @endcomponent

    **ISI BURGER** — Le meilleur burger de Dakar
@endcomponent
