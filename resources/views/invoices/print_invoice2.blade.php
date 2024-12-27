
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>invoice</title>


    <script>
        setTimeout(function () {
            window.print();
        }, 800);
    </script>
    <style>
        @media print {
            @page {
                margin: 100px auto; /* imprtant to logo margin */
            }

            html, body {
                margin: 100 20px 20px 0;
                padding: 0
            }

            #printContainer {
                width: 250px;
                margin: auto;
                /*text-align: justify;*/
            }

            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
        }
    </style>
</head>

<body>
    <section class="container invoice" id="">
        <div class="container-fluid p-0">
            <div class="invoice-body py-5">
                <div style="  max-width: 1170px; margin: 70px 40px;">
                    @if ( $order->quotation == 1 )
                    <div class="col-lg-2" style="flex: 2; text-align: center;">
                        <h3 style="font-size: 1.5rem; margin-bottom: 5px;">QUOTATION</h3>
                    </div>

                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="4" class="" style="border :0px solid #dee2e6 ;width:70%;">
                                        <div class="col-lg-5" style="flex: 2;">
                                            <p>Customer Name : {{ $customerdtl->name }} </p>
                                            <span style="padding-left: 118px">{{ $customerdtl->address }}</span> 
                                        </div>
                                    </td>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">TRN: 100474976600003</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">INV NO: {{ $order->invoiceno }}3</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">QTN No: 000{{ $order->id }}</h5>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-5" style="flex: 2;">
                                            <i>Dear Sir, </i>
                                            <p>We are pleased to quote our best prices as follows </p>
                                        </div>
                                    </td>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-2 text-end" style="">
                                            <h5 style="font-size: .90rem; margin : 5px;">Date: {{ $order->orderdate }}</h5>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>


                        

                    @else

                        <div class="row text-center" style="text-align: center; margin: 5px 0;">
                            <h3 style="font-size: 1.1rem; margin-bottom: 5px;">BILL</h3>
                        </div>
                    @endif



                    @if ( $order->quotation == 1 )
                    @else
                        <div class=" " style="display: flex; flex-wrap: wrap; margin: 5px 0;">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="width: 90%">
                                            <div class="col-lg-12" style="flex:2;">
                                                <div>
                                                    <span><b>{{ $order->invoiceno }}</b></span><br>
                                                    <span><b>Date: {{ $order->orderdate }}</b></span><br>
                                                    <br>
                                                    <span><b>To</b></span><br>
                                                    @if ($customerdtl)
                                                    <span><b>{{ $customerdtl->name }}</b></span><br>
                                                    <span><b>{{ $customerdtl->address }}</b></span><br><br>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 10%">
                                            <div class="col-lg-12" style="flex:1;width: 5%"> </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="width: 90%">
                                            <div class="col-lg-12" style="flex:2;">
                                                <span><b>Subject: {{ $order->subject }}</b></span><br>
                                            </div>
                                        </td>
                                        <td style="width: 10%">
                                            <div class="col-lg-12" style="flex:1;width: 5%"> </div>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    @endif

                    


                    
                    <div class="row overflow">
                        <table style="width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">#</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Description</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Unit</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Unit Price</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Total Price <br> (BDT)</th>

                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($order->orderdetails as $key => $orderdetail)
                                <tr style="border-bottom:1px solid #dee2e6 ; border-right:1px solid #dee2e6 ; border-left:1px solid #dee2e6 ;">
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">{{ $key + 1 }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{ $orderdetail->product->productname ?? " " }} </td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">{{ $orderdetail->quantity }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($orderdetail->sellingprice, 2) }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($orderdetail->total_amount, 2) }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        
                                    </td>
                                    <td>
                                        <span class="float-start"> <b>Total:</b> </span>
                                    </td>
                                    
                                    <td colspan="1" style="text-align:right">
                                        <span class="float-end">{{ number_format($order->net_total, 2) }}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
                    <br>
                    <div class="row my-5" style="display: flex;">


                        @if ( $order->quotation == 1 )

                            <table style="width: 100%;">
                                <tr>
                                    <td class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-5" style="flex: 2;">
                                            <u>Terms and conditions </u><br>
                                            <i>Validity : </i><br>
                                            <i>Delivery : </i><br>
                                            <i>Payment : </i><br>
                                            <i>Other terms and conditions : </i>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        @else
                            <table style="width: 100%;">
                                <tr>
                                    <td colspan="4" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-12" style="flex: 2;">
                                            <p><b>In word: </b> </p>
                                        </div>
                                        <div class="col-lg-12" style="flex: 2;">
                                            {!! $order->body !!}
                                        </div>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr class="mt-5">
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-5" style="flex: 2;">
                                            <i>Received by : Signature & stamp</i>
                                        </div>
                                    </td>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-5" style="flex: 1;"></div>
                                    </td>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                            <span for="" style="padding-right: 30px">{{\App\Models\User::where('id', $order->created_by)->first()->name}}</span><br>
                                            Salesman Signature
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        @endif

                        

                    </div>
                </div>
            </div>
            {{-- <div  style="margin-top: 15px; display: flex;align-items: center;justify-content: center;background-color: #FF9A38;">
                <h4 class="mb-0 text-white" style="color: white; text-align: center;">Musaffa M-9 Abudhabi UAE</h4>
            </div> --}}
        </div>
    </section>


</body>

</html>

