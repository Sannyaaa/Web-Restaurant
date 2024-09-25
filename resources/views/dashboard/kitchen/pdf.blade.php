<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    

    <style>

    /* @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Shrikhand&display=swap');

    @font-face {
        font-family: "Noto Sans", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "wdth" 100;
    } */

    body {
        font-family:  "sans-serif";
        color: #404040;
    }

    h2{
        font-weight: 500;
        margin-bottom: 8px;
    }
    h3 {
        font-weight: 400;
        margin-bottom: 10px;
    }
    h4 {
        margin: 0;
    }
    .w-full {
        width: 100%;
    }
    .w-half {
        width: 50%;
    
    }
    .wrap-info{
        display: flex;
        width: 100%;
    }
    .w-1-3{
        min-width: 30%;
    }
    .w-1-3 div{
        margin-bottom: 3px;
    }
    .title{
        font-weight: 700;
        font-size: 4rem;
        margin-bottom: 0px;
        margin-top: -1rem;
    }
    .subtitle{
        font-weight: 400;
        margin-bottom: 6px;
        margin-top: -8px;
        font-size: 1,5rem;
        letter-spacing: 0.7rem;
    }
    .header{

    }
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .invoice {
        /* text-align: right; */
        /* font-size: 30px; */
    }
    .margin-top {
        margin-top: 1.25rem;
    }
    .footer {
        width: 100%;
        position: fixed;
        bottom: 0;
        text-align: center;
        font-size: 0.875rem;
        gap: 1rem;
        padding: 1rem;
    }
    .footer-info{
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 0.5rem;
    }
    .column{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
    table {
        width: 100%;
        border-spacing: 0;
    }
    table.products {
        font-size: 0.875rem;
    }
    table.products tr {
        background-color: #404040;
    }
    table.products th {
        color: #ffffff;
        padding: 0.5rem;
    }
    table tr.items {
        background-color: #f1f1f1;
    }
    table tr.items td {
        padding: 10px 1.5rem;
    }
    table tr.items th {
        color: #000;
        padding: 10px 1.5rem;
    }
    .total {
        text-align: right;
        margin-top: 1rem;
        margin-right: 2rem;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .info div{
        font-size: 1rem;
        margin-bottom: 0.5rem;
        font-weight: 400;
    }
    .text-left{
        text-align: left;
        color: #000;
        margin-bottom: 0.5rem;
    }
    .break{
        display: flex;
        justify-content: center;
    }
    .title-info{
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 1.5rem;
    }
    .list-disc{
        margin-left: 5px;
    }

     /* .invoice-container {
        width: 100%;
        max-width: 210mm; 
        min-height: 240mm;
        margin: 0 auto;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    } */
    
    </style>

</head>
<body>
    <div class="invoice-container">
        <div style="position: relative;">
            <div class="w-full">
                    <table>
                        <tr>
                            <th>
                                <h2 class="title">
                                    CONNYA
                                </h2>
                                <h3 class="subtitle">
                                    coffee shop
                                </h3>
                                <h3>
                                    {{ $order->table->name }}
                                </h3>
                            </th>
                        </tr>
                    </table>
                    {{-- <td class="w-half invoice">
                        <span>Invoice :
                            <br>
                            <strong>{{ $order->invoice }}</strong>
                        </span>

                    </td> --}}
            </div>
        
            <div class="margin-top">
                <div class="w-full">
                    <table>
                        <tr class="">
                            <td class="info">
                                {{-- <div><p class="title-info">Invoice :</p></div> --}}
                                <div class="invoice">{{ $order->invoice }}</div>
                                <div>{{ date('d F Y', strtotime($order->created_at)) }}</div>
                            </td>
                            <td class="info">
                                {{-- <div><p class="title-info">Pemesan :</p></div> --}}
                                <div>name : {{ $order->name }}</div>
                                <div>phone : {{ $order->phone }}</div>
                            </td>
                            <td class="info">
                                {{-- <div><p class="title-info">Order :</p></div> --}}
                                <div>payment method : {{ $order->payment_method }}</div>
                                <div>total price : Rp.{{ number_format($order->total_price) }} </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        
            <div class="margin-top">
                <div class="w-full break">
                    <span class="">
                       - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    </span>
                </div>
                <table class="products margin-top">
                    <thead>
                        <tr class="items text-left">
                            <th>Items</th>
                            <th>Quantity</th>
                            <th>Instruction</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $id => $item)
                            <tr class="items">
                                <td class="text-left">
                                    {{ $item['menu']['name'] }}
                                    <br>
                                    @if ($item->modifiers->isNotEmpty())
                                        <ul class="list-disc list-inside">
                                            @foreach ($item->modifiers as $modifier)
                                                <li class="text-gray-600 dark:text-gray-400">
                                                    {{ $modifier->name }} (x{{ $modifier->quantity }}) 
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    X {{ $item['quantity'] }}
                                </td>
                                <td>
                                    @if ($item->special_instructions != null)
                                        {{ $item->special_instructions }} 
                                    @else
                                        No instruction
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            <div class="footer margin-top">
                <div>
                    <div>Thank you, for your order</div>
                    <div>2024 &copy; Connya (Coffee Shop)</div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
        window.onafterprint = function() {
            // Perform any necessary actions after printing
            // For example, hide the print button or reset the page
            //...
        };
    </script>
</body>
</html>