<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <script>
        setTimeout(function () {
            window.print();
        }, 800);
    </script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background-image: url('{{asset('bg_invoice.png')}}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            font-size: 10px; /* Optional: Adjust for better readability */
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 10px;
        }
        h1, h2, h3, p {
            margin: 5px 0;
        }
        .header {
            margin-top: 20px;
            padding-top: 40px;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 70px; /* Adjust as needed */
            left: 10px;   /* Adjust as needed */
            font-size: 12px; /* Optional: Adjust for better readability */
            display: flex;
            justify-content: space-between;
            width: 95%;
        }

        @media print {
            .footer {
                position: fixed;
                bottom: 70px;
                left: 10px;
                display: flex;
                justify-content: space-between;
                width: 95%;
            }
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        .note, .warranty {
            margin-top: 10px;
        }
        @media print {
            body {
                margin: 0;
            }
            .container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header mt-3">
            <h1>Invoice</h1>
        </div>
        
        <p>{{ $order->invoiceno }}</p>
        <p>Date: {{ $order->orderdate }}</p>
        <p><strong>To:</strong><br>
            {{ $order->customer->name ?? "" }}<br>
            {{ $order->customer->address ?? ""  }}</p>

        <p><strong>Subject:</strong> {{ $order->subject }}</p>
        {{-- <p>Dear Sir,<br>
            Reference to above mention subject we are pleased to submit our quotation for your kind Consideration under as follows.</p> --}}

            

        <br><br>
        <table>
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderdetails as $key => $orderdetail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if ($orderdetail->product)
                            {{ $orderdetail->product->productname ?? " "}}<br>
                            @if (isset($orderdetail->capacity))
                            Capacity: {{ $orderdetail->capacity }} <br>
                            @endif
                            @if ($orderdetail->type)
                            Type: {{ $orderdetail->type }} <br>
                            @endif
                            @if ($orderdetail->power)
                            Power: {{ $orderdetail->power }} <br>
                            @endif
                            @if ($orderdetail->origin)
                            Origin: {{ $orderdetail->origin }} <br>
                            @endif
                            
                        @else
                            {{ $orderdetail->service->name ?? " "}}<br>
                        @endif
                    </td>
                    <td>{{ $orderdetail->quantity }}</td>
                    <td style="text-align:right">{{ number_format($orderdetail->sellingprice, 2) }}</td>
                    <td style="text-align:right">{{ number_format($orderdetail->total_amount, 2) }}</td>
                </tr>
                @endforeach

                
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Total</td>
                    <td style="text-align:right">{{ number_format($order->grand_total, 2) }}</td>
                </tr>
                @if ($order->discount_amount > 0)
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Discount</td>
                    <td style="text-align:right">{{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                @endif

                @if ($order->adv_amount > 0)
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Advance Received</td>
                    <td style="text-align:right">{{ number_format($order->adv_amount, 2) }}</td>
                </tr>
                @endif

                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Received Amount</td>
                    <td style="text-align:right">{{ number_format($order->bank_amount + $order->cash_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Due Amount</td>
                    <td style="text-align:right">{{ number_format($order->due, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- <p><strong>In words:</strong> {{ ucwords(\NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format($order->net_total)) }}</p> --}}

        <p><strong>In words:</strong> {{$amountInWords}}</p>

        <div class="note">
            {!! $order->body !!}
        </div>

        <div class="footer" style="bottom: 120px;">
            <p>Customer’s Signature</p>
            <p><strong>“Green Technology”</strong></p>
        </div>
    </div>
</body>
</html>
