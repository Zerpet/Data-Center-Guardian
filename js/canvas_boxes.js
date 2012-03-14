/*
 * DO NOT TOUCH THIS TOO MUCH!!!
 *
 *Declaration of some global variables
 */
var BOX_X = 54;  //Initial X position of first box
var BOX_Y = 145; //Initial Y position of first box
var BOX_WIDTH = 40;
var BOX_HEIGHT = 40;
var BOX_MARGIN = 28;
var PADDING = 40;   //Padding between horizontal line of phases and vertical ones
var HORIZONTAL_MID = BOX_X + BOX_WIDTH/2;
var VERTICAL_MID = BOX_Y + BOX_HEIGHT/2;
var WAR_HEIGHT = 80;
var WAR_MARGIN = 5;
var maxTextWidth = 12;

/*
 * Position Y of wardrobe's connectors
 */
var WARDROBE_POSITION = new Array(6);
WARDROBE_POSITION[0] = WAR_HEIGHT*0.5;
WARDROBE_POSITION[1] = WAR_HEIGHT*1.5 + WAR_MARGIN*2;
WARDROBE_POSITION[2] = WAR_HEIGHT*2.5 + WAR_MARGIN*3;
WARDROBE_POSITION[3] = WAR_HEIGHT*3.5 + WAR_MARGIN*4;
WARDROBE_POSITION[4] = WAR_HEIGHT*4.5 + WAR_MARGIN*5;
WARDROBE_POSITION[5] = WAR_HEIGHT*5.5 + WAR_MARGIN*6;

/*
 * Trivial function to save lines of code and make it more readable
 * It basically fills and strokes a context (i.e. paints and fills a rectangle)
 */
function fill_stroke(ctx) {
    ctx.fill();
    ctx.stroke();
}

/* 
 * This box draws the boxes to represent the phases in the lab. It gets the
 * context of the target canvas element, then paints rectangles and text.
 * 
 * The first box drawn was the top left one. From its coordinates were
 * calculated the other box coordinates and the position of phases number.
 */
function drawBoxes() {
    var c=document.getElementById("boxes");
    var ctx=c.getContext("2d");
    
    ctx.font="normal 12px sans-serif"
    
    
    //Drawing first horizontal line of boxes
    ctx.fillStyle = "#CCCCCC";
    ctx.rect(BOX_X, BOX_Y, BOX_WIDTH, BOX_HEIGHT);
    fill_stroke(ctx);
    ctx.closePath();
    //Drawing now the number of the phase 4
    ctx.strokeText("4", BOX_WIDTH/2 + BOX_X, BOX_HEIGHT+15 + BOX_Y, maxTextWidth);
    
    
    ctx.beginPath();    //Gonna draw now the rest of horizontal phases
    var i;
    for(i = 1; i < 5; i++) {
        ctx.rect(BOX_X + i*(BOX_MARGIN + BOX_WIDTH), BOX_Y, BOX_WIDTH, BOX_HEIGHT);
        //Numbers from 5 to 8
        ctx.strokeText(i+4, i*(BOX_WIDTH + BOX_MARGIN) + BOX_WIDTH/2 + BOX_X, BOX_HEIGHT+15 + BOX_Y, maxTextWidth);
    }
    ctx.fillStyle = "#000000";
    fill_stroke(ctx);
    ctx.closePath();

    
    //Drawing left vertical line of boxes
    ctx.beginPath();
    
    for(i = 0; i < 3; i++) {
        ctx.rect(BOX_X - BOX_WIDTH/2, BOX_Y + BOX_HEIGHT + PADDING + i*(BOX_HEIGHT + BOX_MARGIN), BOX_WIDTH, BOX_HEIGHT);
        
        ctx.strokeText(3 - i, BOX_X + 25, BOX_Y + BOX_HEIGHT + PADDING + 25 + i*(BOX_HEIGHT + BOX_MARGIN), maxTextWidth);
    }
    ctx.fillStyle= "#CCCCCC";
    fill_stroke(ctx);
    ctx.closePath();

    //Drawing right vertical line of boxes
    ctx.beginPath();
    for(i = 0; i < 3; i++) {
        ctx.rect(BOX_X + (BOX_WIDTH + BOX_MARGIN)*4 + 14, BOX_Y + BOX_HEIGHT + PADDING + i*(BOX_HEIGHT + BOX_MARGIN), BOX_WIDTH, BOX_HEIGHT);
        
        ctx.strokeText(9+i, BOX_X + (BOX_WIDTH + BOX_MARGIN)*4, BOX_Y + BOX_HEIGHT + PADDING + 25 + i*(BOX_HEIGHT + BOX_MARGIN), maxTextWidth);
    }
    ctx.fillStyle= "#FFFFFF";
    fill_stroke(ctx);
    ctx.closePath();
}

/*
 * This function draws the lines that connect wardrobes to each phase
 */
function drawLines() {
    var c=document.getElementById("boxes");
    var ctx=c.getContext("2d");
    var xmlRequest = new XMLHttpRequest();
    xmlRequest.open("GET", "https://163.117.142.145/pfc/logic/phases-xml.php", false);
    xmlRequest.send();
    
    var xml = xmlRequest.responseText;
    
    
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(xml, "text/xml");
    
    var connections = xmlDoc.getElementsByTagName("connection");
    
//    console.log(xmlDoc.getElementsByTagName("wardrobe")[6].firstChild.nodeValue);
    ctx.beginPath();
    
    for(i = 0; i < connections.length; i++) {
        if(xmlDoc.getElementsByTagName("wardrobe")[i].firstChild.nodeValue < 200)
            ctx.moveTo(0, WARDROBE_POSITION[i % 6]);
        else 
            ctx.moveTo(420, WARDROBE_POSITION[i % 6]);
        
        ctx.lineTo(xmlDoc.getElementsByTagName("x")[i].firstChild.nodeValue, xmlDoc.getElementsByTagName("y")[i].firstChild.nodeValue);
        
    }
    
    ctx.stroke();
    ctx.closePath();
}
