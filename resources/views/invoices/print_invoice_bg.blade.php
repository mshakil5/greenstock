<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        setTimeout(function () {
            window.print();
        }, 400);
    </script>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
    
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('{{asset('bg_invoice.png')}}') no-repeat center center fixed;
            background-size: cover;
            background-position: center 3px; /* Adjust the vertical position of the background */
        }
    
        .invoice-container {
            width: 100%;
            height: 100%;
            padding: 20mm;
            box-sizing: border-box;
        }
    
        .header, .footer {
            position: fixed;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.8);
        }
    
        .header {
            top: 0;
            height: 50mm; /* Adjust if needed */
        }
    
        .footer {
            bottom: 0;
            height: 50mm; /* Adjust if needed to cover the gap */
        }
    
        .content {
            padding: 70mm 20mm 70mm; /* Adjust for header and footer */
        }
    
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
    
</head>
<body>
    

    <div class="invoice-container">
        
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
    </div>
</body>
</html>
