<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #ff6b00;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #ff6b00;
            font-size: 28px;
            margin: 0;
        }
        .header p {
            color: #888;
            margin: 5px 0 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        .info-box {
            width: 48%;
        }
        .info-box h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead th {
            background: #ff6b00;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 12px;
        }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        .total-row {
            text-align: right;
            margin-top: 10px;
        }
        .total-row .total-label {
            font-size: 14px;
            color: #888;
        }
        .total-row .total-value {
            font-size: 22px;
            font-weight: bold;
            color: #ff6b00;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #aaa;
            font-size: 11px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>ISI BURGER</h1>
    <p>Dakar, Sénégal — Le meilleur burger de Dakar</p>
</div>

<div style="text-align:center; margin-bottom:20px;">
    <h2 style="margin:0; font-size:18px;">FACTURE #{{ $commande->id }}</h2>
    <span class="badge">PAYÉE</span>
</div>

<div class="info-row">
    <div class="info-box">
        <h4>Client</h4>
        <p style="margin:0;"><strong>{{ $commande->user->name }}</strong></p>
        <p style="margin:0; color:#888;">{{ $commande->user->email }}</p>
    </div>
    <div class="info-box" style="text-align:right;">
        <h4>Informations</h4>
        <p style="margin:0;">Date : <strong>{{ $commande->created_at->format('d/m/Y') }}</strong></p>
        <p style="margin:0;">Commande : <strong>#{{ $commande->id }}</strong></p>
        @if($commande->paiement)
            <p style="margin:0;">Payée le : <strong>{{ \Carbon\Carbon::parse($commande->paiement->paye_le)->format('d/m/Y') }}</strong></p>
        @endif
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>Burger</th>
        <th>Prix unitaire</th>
        <th>Quantité</th>
        <th>Sous-total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($commande->items as $item)
        <tr>
            <td>{{ $item->burger->nom }}</td>
            <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
            <td>x{{ $item->quantite }}</td>
            <td><strong>{{ number_format($item->quantite * $item->prix_unitaire, 0, ',', ' ') }} F</strong></td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total-row">
    <div class="total-label">Total payé</div>
    <div class="total-value">{{ number_format($commande->total, 0, ',', ' ') }} F CFA</div>
</div>

<div class="footer">
    <p>Merci pour votre confiance ! ISI BURGER</p>
    <p>Cette facture a été générée automatiquement.</p>
</div>

</body>
</html>
