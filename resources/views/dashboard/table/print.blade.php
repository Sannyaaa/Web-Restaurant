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
        color: #000;
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .header{
        font-weight: 600;
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    .item{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
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
        <div class="item">
            <span class="header font-one">{{ $table->name }}</span>
            <div>
                <img src="{{ Storage::url($table->qr_code) }}" alt="">
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>