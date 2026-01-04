<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <link rel="stylesheet" href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX">
    <style rel="stylesheet" href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"></style>
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <section class="{{ $sectionClass }}">
       <div class="{{ $containerClass }}">
           <div class="row">
               <div class="col-md-12">
                    <h1>Resources</h1>
                    <p>Here are some resources to help you get started.</p>
                    <ul>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXX">Laravel Documentation</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXX">Laracasts</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXX">Laravel News</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXX">Laravel Blog</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXX">Nova</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXXX">Forge</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXXX">Vapor</a></li>
                        <li><a href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX">Laravel on GitHub</a></li>
                    </ul>
               </div>

               <div class="{{ $sidebarClass }}">
                    <img src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" alt="Laravel Logo" class="img-fluid">
                    <p>Thank you for using Laravel!</p>
               </div>
           </div>
       </div>
    </section>
</body>
</html>
