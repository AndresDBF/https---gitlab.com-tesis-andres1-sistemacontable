<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .block-container {
            overflow: hidden;
        }

        .block-ini {
            float: left;
            border: 1px solid gray;
            padding: 10px;
            margin-right: 20px;
        }

        .block-img img {
            width: 120px;
            height: 120px;
        }

        .block-title {
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="block-container">
        <div class="block-ini">
            <div class="block-img">
                <img src="data:image/png;base64,{{$image}}">
            </div>
            <div class="block-title">
                <h1>FIX4U SOLUTIONS</h1>
            </div>
        </div>
        <!-- Agrega más bloques aquí -->
        <div class="block-ini">
            <div class="block-img">
                <img src="data:image/png;base64,{{$image}}">
            </div>
            <div class="block-title">
                <h1>FIX4U SOLUTIONS</h1>
            </div>
        </div>
    </div>
</body>
</html>
