<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Vouchers</title>
    {{--
    <link rel="stylesheet" href="{{ asset('assets/css/backend/voucher.css') }}" /> --}}

    <style>

        .print_vouchers {
            font-size: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 8pt;
            font-weight: normal;
            line-height: 1.5;
            /* -webkit-appearance: none; */
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -ms-overflow-style: scrollbar;
            -webkit-tap-highlight-color: transparent;
            background: #fff;
        }

        .print_vouchers h3 {
            margin: 0;
            font-size: 2.5em;
            font-weight: bold;
            font-size: 14pt;
        }

        :-moz-placeholder {
            font-size: 11pt;
        }

        ::-moz-placeholder {
            font-size: 11pt;
        }

        :-ms-input-placeholder {
            font-size: 11pt;
        }

        .print_vouchers p {
            margin: 1em 0;
        }

        .print_vouchers ul {
            margin: 1em 0;
            padding: 0 0 0 40px;
        }

        .print_vouchers ul li {
            list-style: none;
            list-style-image: none;
            vertical-align: middle;
        }

        .print_vouchers img {
            border: 0;
            -ms-interpolation-mode: bicubic;
        }

        button::-moz-focus-inner,
        input::-moz-focus-inner {
            border: 0;
            padding: 0;
        }

        *,
        *::before,
        *::after {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .print_vouchers .clearfix:before,
        .print_vouchers .clearfix:after {
            content: " ";
            display: table;
        }

        .print_vouchers .clearfix:after {
            clear: both;
        }

        /* .print_vouchers .clearfix {
        *zoom: 1;
        } */

        .print_vouchers .main-container,
        .print_vouchers .ctn_cell {
            position: relative;
            color: initial;
        }

        .print_vouchers .main-container {
            background: #eee;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        .print_vouchers .ctn_cell {
            background: #fff;
            width: 30%;
            margin: 5px;
            padding: 10px 5px;
            border: 1px solid #666;
            border-radius: 7px;
            display: block;
            float: left;
            height: 350px;
            margin-left: 10px;
        }

        .print_vouchers .ctn_cell div:before,
        .print_vouchers .ctn_cell div:after {
            content: " ";
            display: table;
        }

        .print_vouchers .ctn_cell div:after {
            clear: both;
        }

        .print_vouchers .ctn_cell div {
            *zoom: 1;
        }

        .print_vouchers .ctn_cell div:first-child {
            width: 75%;
            margin: 0 auto;
        }

        .print_vouchers .ctn_cell img {
            max-width: 100px;
            max-height: 40px;
            padding: 0 5px 5px 0;
            float: left;
        }

        .print_vouchers .ctn_cell h3 {
            font-size: 10pt;
            line-height: 15pt;
            letter-spacing: 2px;
            padding: 2px 0 0 5px;
            float: right;
        }

        .print_vouchers .ctn_cell h3 span {
            font-size: 14pt;
            display: block;
        }

        .print_vouchers .ctn_cell p {
            margin: 0;
            text-align: center;
        }

        .print_vouchers .ctn_cell div p {
            font-family: "Courier New", Courier, monospace;
            font-size: 12pt;
            line-height: 25pt;
        }

        .print_vouchers .ctn_cell div p.special {
            font-family: "Arial", "Courier New", Courier, monospace;
            font-size: 13pt;
            line-height: 20pt;
        }

        .print_vouchers .ctn_cell p span {
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 10pt;
            text-align: right;
        }

        .print_vouchers .ctn_cell p span:after {
            content: " : ";
        }

        .print_vouchers .ctn_cell ul {
            width: 100%;
            margin: 5px auto;
            padding: 10px 10px;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        .print_vouchers .ctn_cell li {
            font-size: 8pt;
            list-style-type: square;
            list-style-position: inside;
        }

        .print_vouchers h5,
        h5.separator {
            padding: 10px 5px;
            margin: 30px 0 10px 0;
            font-size: 18px;
            color: rgb(26, 188, 156);
            border-bottom: 1px solid rgb(190, 190, 190);
            border-bottom: 1px solid rgba(190, 190, 190, .5);
            border-top: 1px solid rgb(190, 190, 190);
            border-top: 1px solid rgba(190, 190, 190, .5);
            font-family: 'MyriadProLight', sans-serif;
            font-weight: normal;
            width: 90%;
        }

        @media print {
            * {
                background: transparent !important;
                color: #000 !important;
                /* Black prints faster: h5bp.com/s */
                -webkit-box-shadow: none !important;
                box-shadow: none !important;
                text-shadow: none !important;
            }

            a,
            a:visited {
                text-decoration: underline;
            }

            a[href]:after {
                content: " (" attr(href) ")";
            }

            abbr[title]:after {
                content: " (" attr(title) ")";
            }

            /*
        * Don't show links for images, or javascript/internal links
        */

            .ir a:after,
            a[href^="javascript:"]:after,
            a[href^="#"]:after {
                content: "";
            }

            pre,
            blockquote {
                border: 1px solid #999;
                page-break-inside: avoid;
            }

            thead {
                display: table-header-group;
                /* h5bp.com/t */
            }

            tr,
            img {
                page-break-inside: avoid;
            }

            img {
                max-width: 100% !important;
            }

            @page {
                size: A4 portrait;
                margin: 0.5cm;
            }

            p,
            h2,
            h3 {
                orphans: 3;
                widows: 3;
            }

            h2,
            h3 {
                page-break-after: avoid;
            }
        }

        .clearfix:after,
        .clearfix:before {
            display: table;
            content: " ";
        }

        .clearfix:after {
            clear: both;
        }

        .pagebreak {
            position: relative;
            display: block;
            margin: 0px 0px 0px 0px;
            height: 1px;
            width: 100%;
            page-break-before: always;
        }
    </style>
</head>

<body>
        @foreach($vouchers as $voucher)
        <div class="print_vouchers">
            <div class="main-container">
                <div class="ctn_cell ">
                    <div class="text-center mb-3">
                        @if($logo)
                        <img src="{{ asset($logo) }} " alt="Logo">
                        @endif
                        <h3 style="color: rgb(50, 50, 50);"><span>Wi-Fi</span> Internet</h3>
                    </div>
                    @if($voucherType == 'with_password')
                    <div>
                        <p class="special" style="color: rgb(50, 50, 50);"><span>Username</span> {{ $voucher->username }}</p>
                    </div>
                    <div>
                        <p class="special" style="color: rgb(50, 50, 50);"><span>Password</span> {{ $voucher->password }}</p>
                    </div>
                    @else
                    <div>
                        <p class="special" style="color: rgb(50, 50, 50);"><span>Access Code</span> {{ $voucher->username }}</p>
                    </div>
                    @endif
                    <div>
                        <p style="color: rgb(50, 50, 50);"><span>Valid until</span> {{ ($voucher->valid_until == 0) ? '-' : date('Y-m-d H:i:s', $voucher->valid_until) }}</p>
                    </div>
                    <div>
                        <p style="color: rgb(50, 50, 50);"><span>Time limit</span> {{ $timeLimit }}</p>
                    </div>

                    <ul style="color: rgb(50, 50, 50);">How to Use:
                        @foreach($invoice as $index => $item)
                        <li style="color: rgb(50, 50, 50);">{{ $item['name'] }}</li>
                        @endforeach
                    </ul>
                    <p class="p1" style="color: rgb(50, 50, 50);">S/N: {{ $voucher->serial_number }}</p>
                </div>
            </div>
        </div>
        @endforeach



</body>
<script>
    window.onload = function() {
        window.print();
    }
</script>

</html>
