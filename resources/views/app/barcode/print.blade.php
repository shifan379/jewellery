<!DOCTYPE html>
<html>
<head>
    <title>Print Barcode</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @media print {
            @page {
                margin: 0;
                size: 63mm 22mm; /* Label Size */

            }

          body {
            margin: 0;
            padding: 0;
            font-family: inherit;
            font-size: 16px;
            font-weight: bold;   /* makes text bold */
            font-style: italic;  /* makes text italic */
        }
            .label-container {
                width: 63mm;
                height: 22mm;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: flex-start;

                page-break-after: always;
                padding: 2mm; /* small padding */
            }

            .top-section {
                width: 28mm;
                height: 5.5mm;
                display: flex;
                align-items: center;
                justify-content: flex-start; /* left align */
            }
            .code-section {
                width: 28mm;
                height: 5.5mm;
                display: flex;
                align-items: center;
                justify-content: flex-start; /* left align */
            }

            .bottom-section {
                width: 28mm;
                height: 11mm;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: flex-start;
                font-size: 17px;
                line-height: 1.2;
            }

            .barcode {
                max-height: 7mm;
                max-width: 28mm ;
            }
        }

        /* Preview with dashed border */

    </style>
</head>
<body>
    <div class="label-container">
        <!-- First 11mm barcode (left aligned) -->
        <div class="top-section">
            <img class="barcode"
                 src="data:image/png;base64,{{ $barcode }}"
                 alt="barcode" />
        </div>

        <div class="code-section">
           <strong>{{ $product['item_code'] }}</strong>
            &nbsp;
        </div>

        <!-- Next 11mm text fields (left aligned) -->

        <div class="bottom-section">
            <strong>{{ $product['product_name'] }}</strong>
            {{ $product['weight'] }}g<br>
            {{ $product['shop_name'] }}
        </div>
    </div>

    <script>
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 200);
        };
    </script>
</body>
</html>
