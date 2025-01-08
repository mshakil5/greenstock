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
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 10px;
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
            margin-top: 40px;
            padding-top: 80px;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 10px; /* Adjust as needed */
            left: 10px;   /* Adjust as needed */
            font-size: 12px; /* Optional: Adjust for better readability */
            text-align: left; /* Align text to the left */
        }

        @media print {
            .footer {
                position: fixed;
                bottom: 30px;
                left: 10px;
                text-align: left;
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
        <div class="header mt-5">
            <h1>Invoice</h1>
        </div>
        
        <p>{{ $order->invoiceno }}</p>
        <p>Date: {{ $order->orderdate }}</p>
        <p><strong>To:</strong><br>
            {{ $order->name }}<br>
            {{ $order->address }}</p>

        <p><strong>Subject:</strong> {{ $order->subject }}</p>
        <p>Dear Sir,<br>
            Reference to above mention subject we are pleased to submit our quotation for your kind Consideration under as follows.</p>

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
                            Capacity: {{ $orderdetail->capacity }} <br>
                            Type: {{ $orderdetail->type }} <br>
                            Power: {{ $orderdetail->power }} <br>
                            Origin: {{ $orderdetail->origin }} <br>
                            
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
                    <td style="text-align:right">{{ number_format($order->net_total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p><strong>In words:</strong> Coming Soon...</p>

        <div class="note">
            {!! $order->body !!}
        </div>


        <div class="footer">
            <p>Customer’s Signature</p>
            <p><strong>“Green Technology”</strong></p>
        </div>
    </div>
</body>
</html>
