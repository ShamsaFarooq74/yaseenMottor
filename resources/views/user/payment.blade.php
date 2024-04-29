@extends('layouts.user.block.app')
@section('content')
@section('title', '-Payment')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid var(--color-red);
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
<!--=======================Payment Slider Section Start Here-->
<section id="contact-slider" class="p-5">
    <div class="container mx-auto text-lg-start p-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center mx-auto custom-title pt-4"><span class="d-lg-block">
                        <h1>PAYMENT</h1>
                    </span>
                </div>
                <div class="slider-p text-center mx-auto contact-title">Make Payment With Ease!</div>
            </div>
        </div>
    </div>
</section>
<!--=======================Payment Slider Section End Here-->

<!--=======================Payment Section Start Here-->
<section>
    <div class="container">
        <div class="row custom-payment-div">
            <div class="mb-2">
                <h3>We accept payments:</h3>
                <p>1. Bank Telegraphic Transfer</p>
            </div>
            <div class="mb-2">
                <!-- <h3>Order Confirmation:</h3> -->
                <p>We accept the payment via telegraphic transfer through your bank. All bank charges must be paid by the sender. Please ensure that payment is in US Dollars, and please include your Invoice & Stock number in the ‘description’ field. </p>
            </div>
            <div class="mb-4">
                <h3>Where to send the payment :</h3>
                <p>JAPAN BANK DETAILS </p>

                <table>
                    <tr>
                        <th>ACCOUNT  NAME</th>
                        <td>YASEEN MOTORS PTE LTD</td>
                    </tr>
                    <tr>
                        <th>BANK NAME</th>
                        <td>RAKUTEN BANK LTD</td>
                    </tr>
                    <tr>
                        <th>ACCOUNT NUMBER</th>
                        <td>7242348</td>
                    </tr>
                    <tr>
                        <th>BANK ADDRESS</th>
                        <td>NBF SHINAGAWA TOWER, 2-16-5 KONAN MINATO-KU, TOKYO 108-007, JAPAN.</td>
                    </tr>
                    <tr>
                        <th>SWIFT CODE</th>
                        <td>RAKTJPJT</td>
                    </tr>
                    <tr>
                        <th>BENEFICIARY</th>
                        <td>YASEEN MOTORS  CO., LTD</td>
                    </tr>
                    <tr>
                        <th>COMPANY ADDRESS</th>
                        <td>SHIMOMUDA 632-2, KISARAZU SHI, CHIBA KEN, 292-0023 JAPAN</td>
                    </tr>
                </table>
                    <br>
                <p>SINGAPORE BANK DETAILS  </p>
                <table>
                    <tr>
                        <th>ACCOUNT  NAME</th>
                        <td>YASEEN MOTORS PTE LTD</td>
                    </tr>
                    <tr>
                        <th>BANK NAME</th>
                        <td>UOB BANK LTD</td>
                    </tr>
                    <tr>
                        <th>ACCOUNT NUMBER</th>
                        <td>7341 311 1461</td>
                    </tr>
                    <tr>
                        <th>BANK ADDRESS</th>
                        <td>211 HOLLAND AVE, #01-12, SINGAPORE 278967.</td>
                    </tr>
                    <tr>
                        <th>SWIFT CODE</th>
                        <td>UOVBSGSG</td>
                    </tr>
                    <tr>
                        <th>BENEFICIARY</th>
                        <td>YASEEN MOTORS  CO., LTD</td>
                    </tr>
                    <tr>
                        <th>COMPANY ADDRESS</th>
                        <td>41 TOH GUAN ROAD EAST SINGAPORE 608605.</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</section>
<!--=======================Payment  Section Start Here-->
@endsection