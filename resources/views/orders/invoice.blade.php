<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@300;400&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            background: #F5F4F0;
            font-family: 'DM Sans', sans-serif;
            font-size: 10px;
            color: #1A1A18;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* screen: centered card */
        @media screen {
            body { padding: 28px 16px; }
            .bill { max-width: 480px; margin: 0 auto; }
        }

        /* print: A4 full page */
        @media print {
            html, body { background: #fff; padding: 0; width: 210mm; }
            .bill { width: 210mm; padding: 14mm 16mm 10mm; page-break-after: avoid; }
            .print-bar { display: none; }
        }

        .print-bar {
            max-width: 480px;
            margin: 0 auto 12px;
            display: flex;
            justify-content: flex-end;
        }

        .print-bar button {
            background: #1A1A18;
            color: #F5F4F0;
            border: none;
            border-radius: 5px;
            padding: 7px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            cursor: pointer;
        }

        .print-bar button:hover { opacity: 0.75; }

        .bill {
            background: #fff;
            border: 1px solid #bbb;
            padding: 18px 20px 14px;
        }

        /* ── TOP ── */
        .bill-top {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .bill-top-left  { display: table-cell; vertical-align: middle; }
        .bill-top-right { display: table-cell; vertical-align: middle; text-align: right; width: 58px; }

        .bill-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 400;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            line-height: 1;
        }

        .logo-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 1px solid #bbb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 7px;
            font-weight: 300;
            color: #6B6A66;
            line-height: 1.5;
            letter-spacing: 0.04em;
        }

        /* ── META ── */
        .bill-meta {
            display: table;
            width: 100%;
            border-top: 1px solid #bbb;
            border-bottom: 1px solid #bbb;
            padding: 5px 0;
            margin-bottom: 8px;
        }

        .meta-l, .meta-r {
            display: table-cell;
            font-size: 9px;
            color: #6B6A66;
        }

        .meta-r { text-align: right; }
        .meta-l .v, .meta-r .v {
            font-family: 'DM Mono', monospace;
            color: #1A1A18;
            margin-left: 3px;
        }

        /* ── PARTIES ── */
        .bill-parties {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .party-l, .party-r {
            display: table-cell;
            width: 50%;
            border: 1px solid #bbb;
            padding: 7px 8px;
            vertical-align: top;
            font-size: 9.5px;
            line-height: 1.6;
        }

        .party-r { border-left: none; text-align: right; }

        .party-lbl {
            font-size: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 3px;
        }

        .party-val { font-weight: 300; color: #3a3a38; }

        /* ── ITEMS TABLE ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            table-layout: fixed;
        }

        .items-table thead tr { background: #1A1A18; color: #F5F4F0; }

        .items-table thead th {
            padding: 6px 6px;
            font-size: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            text-align: left;
        }

        .items-table thead th.r { text-align: right; }
        .items-table thead th.c { text-align: center; }

        .items-table tbody td {
            padding: 5px 6px;
            border-bottom: 1px solid #E8E6E0;
            border-left: 1px solid #bbb;
            border-right: 1px solid #E8E6E0;
            font-size: 9.5px;
            vertical-align: middle;
        }

        .items-table tbody td:last-child  { border-right: 1px solid #bbb; }
        .items-table tbody tr:last-child td { border-bottom: 1px solid #bbb; }

        .items-table tbody td.c {
            text-align: center;
            color: #6B6A66;
            font-family: 'DM Mono', monospace;
            font-size: 9px;
        }

        .items-table tbody td.r {
            text-align: right;
            font-family: 'DM Mono', monospace;
        }

        .empty-row td { height: 20px; }

        /* ── BOTTOM ── */
        .bill-bottom {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .pay-cell, .tot-cell {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .pay-cell {
            border: 1px solid #bbb;
            padding: 7px 8px;
            font-size: 9.5px;
            line-height: 1.7;
        }

        .box-lbl {
            font-size: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }

        .pay-line { font-weight: 300; color: #3a3a38; }
        .pay-line b { font-weight: 500; color: #1A1A18; }

        .tot-cell { border: 1px solid #bbb; border-left: none; }

        .tot-row {
            display: table;
            width: 100%;
            border-bottom: 1px solid #E8E6E0;
        }

        .tot-row:last-child { border-bottom: none; }

        .tl, .tv {
            display: table-cell;
            padding: 5px 8px;
            font-size: 9px;
        }

        .tl { color: #6B6A66; text-transform: uppercase; letter-spacing: 0.06em; font-size: 8px; }
        .tv { text-align: right; font-family: 'DM Mono', monospace; }

        .tot-row.grand { background: #1A1A18; }
        .tot-row.grand .tl { color: #F5F4F0; font-weight: 500; font-size: 8.5px; }
        .tot-row.grand .tv { color: #F5F4F0; font-size: 11px; }

        /* ── NOTES ── */
        .notes-box {
            border: 1px solid #bbb;
            padding: 7px 8px;
            margin-bottom: 8px;
        }

        .notes-text {
            font-size: 9px;
            font-weight: 300;
            color: #6B6A66;
            line-height: 1.6;
        }

        /* ── FOOTER ── */
        .bill-footer {
            text-align: center;
            font-size: 8.5px;
            font-weight: 300;
            color: #6B6A66;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-top: 1px solid #E8E6E0;
            padding-top: 8px;
        }

        .logo > * {
            font-size: 24px;
            font-weight: 500;
            letter-spacing: -0.04em;
        }

        .aura-text {
            color:#F04A20;
        }

        .dot {
            color: black;     
            font-size: 10px;    
            margin: 0 1px
        }

    </style>
</head>
<body>

    
    <div class="bill">

        {{-- TOP: title left, logo right --}}
        <div class="bill-top">
            <div class="bill-top-left">
                <div class="bill-title">Invoice</div>
            </div>
            <div class="bill-top-right">
                <div class="logo">
                 <span class="aura-text">Aura</span><span class="dot">.</span>
                </div>
            </div>
        </div>

        {{-- META --}}
        <div class="bill-meta">
            <span class="meta-l">Invoice No.<span class="v">#{{ $order->order_number }}</span></span>
            <span class="meta-r">Date:<span class="v">{{ $order->created_at->format('d M Y') }}</span></span>
        </div>

        {{-- PARTIES --}}
        <div class="bill-parties">
            <div class="party-l">
                <div class="party-lbl">Bill to:</div>
                <div class="party-val">
                    {{ $order->user->name ?? 'Customer' }}<br>
                    @php($clean = e(strip_tags($order->shipping_address)))
{!! preg_replace('/^([^:]+):/m', '<strong>$1</strong>:', nl2br($clean)) !!}
                </div>
            </div>
            <div class="party-r">
                <div class="party-lbl">Aura Studio</div>
                <div class="party-val">
                    123 Craft Lane<br>
                    Marrakech, Morocco<br>
                    hello@aurastudio.co
                </div>
            </div>
        </div>

        {{-- ITEMS --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th class="c" style="width:26px;">No.</th>
                    <th>Description</th>
                    <th class="r" style="width:32px;">Qty</th>
                    <th class="r" style="width:68px;">Unit Cost</th>
                    <th class="r" style="width:68px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $i => $item)
                <tr>
                    <td class="c">{{ $i + 1 }}</td>
                    <td>{{ $item->product_name ?? $item->product->name }}</td>
                    <td class="r">{{ $item->quantity }}</td>
                    <td class="r">${{ number_format($item->unit_price ?? $item->price, 2) }}</td>
                    <td class="r">${{ number_format(($item->unit_price ?? $item->price) * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
                @for($e = $order->items->count(); $e < 8; $e++)
                <tr class="empty-row">
                    <td class="c"></td><td></td><td></td><td></td><td></td>
                </tr>
                @endfor
            </tbody>
        </table>

        {{-- BOTTOM: payment + totals --}}
        <div class="bill-bottom">
            <div class="pay-cell">
                <div class="box-lbl">Payment Details:</div>
                <div class="pay-line"><b>Method: </b>
                    @if($order->payment_method === 'cod') Cash on Delivery
                    @elseif($order->payment_method === 'cc') Credit Card
                    @else PayPal
                    @endif
                </div>
                <div class="pay-line"><b>Status: </b>{{ ucfirst($order->payment_status) }}</div>
            </div>
            <div class="tot-cell">
                <div class="tot-row">
                    <span class="tl">Subtotal</span>
                    <span class="tv">${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="tot-row">
                    <span class="tl">Discount</span>
                    <span class="tv">—</span>
                </div>
                <div class="tot-row">
                    <span class="tl">Shipping</span>
                    <span class="tv">Free</span>
                </div>
                <div class="tot-row grand">
                    <span class="tl">Total Amount</span>
                    <span class="tv">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- NOTES --}}
        <div class="notes-box">
            <div class="box-lbl">Special Notes &amp; Terms:</div>
            <p class="notes-text">Thank you for shopping with Aura Studio. For any questions about your order, please contact us within 14 days of delivery.</p>
        </div>

        <div class="bill-footer">Thank you for your purchase!</div>

    </div>

</body>
</html>