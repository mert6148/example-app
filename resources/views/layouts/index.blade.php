<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            empty-cells: show;
        }

        html,
        body{
            height: 100%;
            width: 100%;
        }

        .content{
            width: 100%;
            height: 100%;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        div{
            display: block;
            user-select: none;
        }
        </style>
</head>
<body>
    @section
        <div class="content">
            <h1>ini adalah halaman about</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>

            <div class="title m-b-md">
                <h1>Tester</h1>
            </div>

            <div class="section" idate="">
                   <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">Dashboard</div>

                                <div class="panel-body">
                                    You are logged in!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>

            </div>

        </div>
    @endsection
</body>
</html>
