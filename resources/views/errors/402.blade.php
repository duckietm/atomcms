@section('title', __('Payment Required'))

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background-color: #104571;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            font-family: Arial, sans-serif;
            color: #FFFFFF;
            font-size: 24px;
            padding-bottom: 56px;
        }
        .header {
            position: absolute;
            top: 15%;
            text-align: center;
        }
        .header::before {
            content: url(/assets/images/errors/frank_unsure.png);
            display: block;
            height: 89px;
            margin: 0 auto 12px;
            width: 64px;
        }
        .text {
            position: absolute;
            top: calc(15% + 89px + 12px + 30px);
            text-align: center;
            font-size: 14px;
            max-width: 1080px;
            color: #7ecaee;
        }
        .text a {
            color: #ffffff;
            text-decoration: underline;
        }
        .text a:hover {
            color: #b3e1ff;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1f2937;
            color: #6b7280;
            font-weight: 700;
            font-size: 14px;
            transition: color 0.2s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="header">Oh bobba! Payment required.</div>
    <div class="text">Frank says this feature requires payment. Please complete the payment or return to the <a href="/">{{ setting('hotel_name') }} front page.</a></div>
</body>
<footer>
    © {{ date('Y') }} {{ setting('hotel_name') }} is a not for profit educational project & is in no way affiliated with Sulake Corporation Oy.
</footer>
</html>