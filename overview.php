<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Overview</title>
        <script type="text/javascript" src="js/jquery-1.6.3.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/header_footer.css" />
        <link rel="stylesheet" type="text/css" href="css/overview.css" />
    </head>
    <body>
        <?php include("header.php"); ?>
        <div class="subheader">
            <p>Home</p>
        </div>
        <?php include("leftmenu.php"); ?>
        <div class="content">
            <div id="left" style="float: left;">
                <!-- Left side of wardrobes -->
                <div class="wardrobe">
                    <br/>Común<br/>
                    6 -> ___<br/>
                    67 -> ___<br/>
                    156 -> ___<br/>
                </div>
                <div class="wardrobe">
                    <br/>Arcade<br/>
                    5 -> ___<br/>
                    9 -> 147<br/>
                    2 -> 149<br/>
                </div>
                <div class="wardrobe">
                    <br/>Scalab<br/>
                    4 -> 164<br/>
                </div>
                <div class="wardrobe">
                    <br/>Sintonía<br/>
                    3 -> 129<br/>
                    10 -> 154<br/>
                </div>
                <div class="wardrobe" style="background-color: #999999">
                <!-- Git working now -->
                </div>
                <div class="wardrobe" style="background-color: #999999">
                    <br/>1 -> ___<br/>
                </div>
            </div>
            <div id="right" style="float:right;">
                <!-- Right side of wardrobes position: relative; left: 521px; top: -175px-->
                <div class="wardrobe">
                    <br/>Arcos A<br/>
                </div>
                <div class="wardrobe">
                    <br/>Arcos B<br/>
                    7 -> 148<br/>
                </div>
                <div class="wardrobe">
                    <br/>Donación_arcos<br/>
                    8 -> ___<br/>
                </div>
                <div class="wardrobe">
                    <br/>Evannai<br/>
                    11 -> 164<br/>
                </div>
                <div class="wardrobe" style="background-color: #999999">
                    <br/>
                </div>
            </div>
            
            <canvas id="myCanvas" width="420" heigth="522">Hola Mundo!!</canvas>
            <script type="text/javascript">
                var c=document.getElementById("myCanvas");
                var ctx=c.getContext("2d");
                ctx.rect(60, 150, 50, 50);
                ctx.stroke();
            </script>
            
        </div>
        <br style="clear: both;" />
        <?php include("footer.php"); ?>
    </body>
</html>
