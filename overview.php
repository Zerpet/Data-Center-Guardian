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
            
                <canvas id="boxes" width="420" height="522">Your browser does not support canvas element</canvas>
                <script type="text/javascript">
                    var c=document.getElementById("boxes");
                    var ctx=c.getContext("2d");
                    var boxX = 54;
                    var boxY = 145;
                    
                    //Drawing first horizontal line of boxes
                    ctx.fillStyle = "#CCCCCC";
                    ctx.rect(boxX, boxY, 40, 40);
                    ctx.fill();
                    ctx.stroke();
                    ctx.closePath();
                    
                    ctx.beginPath();
                    var i;
                    for(i = 1; i < 5; i++) {
                        ctx.rect(boxX + i*68, boxY, 40, 40);
                    }
                    ctx.fillStyle = "#000000"
                    ctx.fill();
                    ctx.stroke();
                    ctx.closePath();
                    
                    //Drawing left vertical line of boxes
                    ctx.beginPath();
                    var padding = 40;
                    for(i = 0; i < 3; i++) {
                        ctx.rect(boxX - 20, boxY + 40 + padding + i*54, 40, 40);
                    }
                    ctx.fillStyle= "#CCCCCC";
                    ctx.fill();
                    ctx.stroke();
                    ctx.closePath();
                    
                    //Drawing right vertical line of boxes
                    ctx.beginPath();
                    for(i = 0; i < 3; i++) {
                        ctx.rect(boxX + 68*4+14, boxY + 40 + padding + i*54, 40, 40);
                    }
                    ctx.fillStyle= "#FFFFFF";
                    ctx.fill();
                    ctx.stroke();
                    ctx.closePath();
                    
                </script>
            
        </div>
        <br style="clear: both;" />
        <?php include("footer.php"); ?>
    </body>
</html>
