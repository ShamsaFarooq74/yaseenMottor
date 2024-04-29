<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <title>template</title>
    <style>
        body{
            margin: 0 auto;
            font-family: 'Inter', sans-serif;
        }
        body, body *{box-sizing: border-box;}
        h1,h2,h3,h4,h5,h6{
            padding: 0;
            margin: 0;
        }
        p{
            margin: 0;
        }
        h1{
            font-size: 22px;
            line-height: 25px;
            font-weight: 700;
            color: #000000;
            margin-right: 15px;
        }
        h2{
            font-size: 18px;
            line-height: 21px;
            font-weight: 500;
            color: #818181;
            margin-left: 15px;
        }
        h3{
            font-size: 18px;
            line-height: 21px;
            font-weight: 600;
            color: #535353;
        }
        h4{
            font-size: 18px;
            line-height: 21px;
            font-weight: 700;
            color: #FFFFFF;

        }
        h5{
            font-size: 15px;
            line-height: 18px;
            font-weight: 500;
            color: #4B4B4B;
        }
        table{
            border-collapse: collapse;

        }
        td{
            font-size: 15px;
            line-height: 18px;
            font-weight: 600;
            color: #5E5E5E;
        }
        img{
            display: block;
            max-width: 100%;
        }
        .main{
            margin: 0 auto;
            background-color: #fff;
        }
        .header{
            background: #E02329;
        }
        .order-data{
            background-color: #F1F6F9;
        }
        .para p{
            color: #5E5E5E;
            font-size: 15px;
            line-height: 18px;
            font-weight: 400;
        }
        .p-10{
            padding: 6px 35px;
        }
        .content-data tr td{
            padding: 15px 0 10px 20px;
            color: #515151;
            font-weight: 400;
            font-size: 15px;
            line-height: 18px;
        }
        .footer-head, .footer-para, tfoot{
            background-color: #f9f9f9;
        }
        .footer-head p{
            color: #424242;
            font-weight: 700;
            font-size: 15px;
            line-height: 18px;
        }
        .footer-para p{
            color: #515151;
            font-weight: 400;
            font-size: 13px;
            line-height: 16px;
        }
        .header-content thead th{
            background: #E02329;
            padding: 15px 10px 15px 20px;
            text-align: left;
            font-weight: normal;
            color: #FFFFFF;
        }
        .header-content tbody td{background: #f9f9f9;}
        .pb-10{
            padding-bottom: 10px !important;
        }
        .logo{
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
<table class="main" width="550" align="center">
    <tbody>
    <tr>
        <td align="center" class="header" style="padding: 25px 0;">
            <img class="logo" src="https://ntc.viion.net/assets/images/logo.png" alt="">
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%;">
                <tbody>
                <tr class="order-data">
                    <td align="center" style="padding: 20px  0; width:50%;">
                        <h1>Order Number # {{$data[0]->id}}</h1>
                    </td>
{{--                    <td align="left" style="padding: 20px  0; width: 50%;">--}}
{{--                        <h2></h2>--}}
{{--                    </td>--}}
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 0 20px;">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td align="center" class="header" style="padding: 15px 0;">
                                    <h4>Customer Details</h4>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0 30px 0;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td align="left" style="padding: 6px 35px;">
                                                <h5>Name</h5>
                                            </td>
                                            <td class="para" align="right" style="padding: 6px 35px;">
                                                <p>{{$data[0]->username}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="width:50%; padding: 6px 35px;" >
                                                <h5>Contact</h5>
                                            </td>
                                            <td class="para" align="right" style="padding: 6px 35px;">
                                                <p>{{$data[0]->phone}}</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 100%;"  class="header-content">
                                        <thead>
                                        <tr>
                                            <th style="padding: 15px 10px 15px 20px;">Item</th>
                                            <th style="padding: 15px 10px 15px 20px;">Price</th>
                                            <th style="padding: 15px 10px 15px 20px;">Quantity</th>
                                            <th style="padding: 15px 10px 15px 20px;">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody class="content-data">
                                        @foreach($data as $parts)
                                            <tr>
                                                <td>{{$parts->ref_no}}</td>
                                                <td>Rs {{number_format($parts->price)}}</td>
                                                <td>{{$parts->quantity}}</td>
                                                <td>Rs {{number_format($parts->quantity * $parts->price)}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot style="border-top:1px solid #A7A7A7; border-bottom: 1px solid #A7A7A7;">
                                        <tr>
                                            <td style="color: #515151; font-weight: 700; padding: 10px 20px;">Total</td>
                                            <td></td>
                                            <td></td>
                                            <td style="color: #515151; font-weight: 700; padding: 10px 20px;">Rs {{number_format($parts->total_amount)}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td align="left" class="footer-head" style="padding: 25px 0 0 20px;">--}}
{{--                                    <p></p>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td align="left" class="footer-para" style="padding: 10px 0 20px 20px;">--}}
{{--                                    <p></p>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
