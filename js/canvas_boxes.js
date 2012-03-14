/*
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

/*BOX_X + i*(BOX_MARGIN + BOX_WIDTH)
 * Position of wardrobe's connectors; i.e. where the line comes from
 * Array([[x][y]])
 */
//var WARDROBE_POSITION = new Array(new Array());
//WARDROBE_POSITION[0][0] = 0;
//WARDROBE_POSITION[0][1] = WAR_HEIGHT/2;
//
//WARDROBE_POSITION[1][0] = 0;
//WARDROBE_POSITION[1][1] = WAR_HEIGHT*1.5 + WAR_MARGIN*2;
//
//WARDROBE_POSITION[2][0] = 0;
//WARDROBE_POSITION[2][1] = WAR_HEIGHT*2.5 + WAR_MARGIN*3;
//
//WARDROBE_POSITION[3][0] = 0;
//WARDROBE_POSITION[3][1] = WAR_HEIGHT*3.5 + WAR_MARGIN*4;
//
//WARDROBE_POSITION[4][0] = 0;
//WARDROBE_POSITION[4][1] = WAR_HEIGHT*4.5 + WAR_MARGIN*5;
//
//WARDROBE_POSITION[5][0] = 0;
//WARDROBE_POSITION[5][1] = WAR_HEIGHT*5.5 + WAR_MARGIN*6;



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
    xmlRequest.open("GET", "logic/phases-xml.php", false);
    xmlRequest.send();
    
    var xml = xmlRequest.responseText;
    
    
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(xml, "text/xml");
    
    var connections = xmlDoc.getElementsByTagName("connection");
    
    for(i in connections) {
//        console.log(i);
//        console.log(connections.getChildNodes[i].getChildNodes[0].nodeValue);
//        console.log(getChildNodes[i].getChildNodes[1].nodeValue);
        console.log(connections[i].tagName);
        console.log(connections[i].getElementsByTagName("wardrobe")[0].childNodes[0].nodeValue);
        console.log(connections[i].getElementsByTagName("x")[0].childNodes[0].nodeValue);
        console.log(connections[i].getElementsByTagName("y")[0].childNodes[0].nodeValue);
    }
    
    
    ctx.beginPath();
    
    //Left side wardrobes
//    ctx.moveTo(0, WAR_HEIGHT/2);
//    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH*2 + BOX_MARGIN*2, BOX_Y);
    
//    ctx.moveTo(0, WAR_HEIGHT*1.5 + WAR_MARGIN*2);
//    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH + BOX_MARGIN, BOX_Y);
    
//    ctx.moveTo(0, WAR_HEIGHT*2.5 + WAR_MARGIN*3);
//    ctx.lineTo(BOX_X, VERTICAL_MID);
    
//    ctx.moveTo(0, WAR_HEIGHT*3.5 + WAR_MARGIN*4);
//    ctx.lineTo(BOX_X - BOX_WIDTH/2, VERTICAL_MID + PADDING + BOX_HEIGHT);
    
//    ctx.moveTo(0, WAR_HEIGHT*4.5 + WAR_MARGIN*5);
//    ctx.lineTo(BOX_X - BOX_WIDTH/2, VERTICAL_MID + PADDING + BOX_MARGIN + BOX_HEIGHT*2);
    
//    ctx.moveTo(0, WAR_HEIGHT*5.5 + WAR_MARGIN*6);
//    ctx.lineTo(BOX_X - BOX_WIDTH/2, VERTICAL_MID + PADDING + BOX_MARGIN*2 + BOX_HEIGHT*3);
    
    //Right side wardrobes
    ctx.moveTo(420, WAR_HEIGHT/2);
    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH*3 + BOX_MARGIN*3, BOX_Y);
    
    ctx.moveTo(420, WAR_HEIGHT*1.5 + WAR_MARGIN*2);
    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH*5 + BOX_MARGIN*4 - 6,/* -6 to adjust cause was not fitting well*/
                    VERTICAL_MID+PADDING+BOX_HEIGHT);
    
    ctx.moveTo(420, WAR_HEIGHT*2.5 + WAR_MARGIN*3);
    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH*4.5 + BOX_MARGIN*4, VERTICAL_MID);
    
    ctx.moveTo(420, WAR_HEIGHT*3.5 + WAR_MARGIN*4);
    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH*5 + BOX_MARGIN*4 - 6, VERTICAL_MID + PADDING + BOX_HEIGHT*2 + BOX_MARGIN);
    
    ctx.moveTo(420, WAR_HEIGHT*4.5 + WAR_MARGIN*5);
    ctx.lineTo(HORIZONTAL_MID + BOX_WIDTH*5 + BOX_MARGIN*4 - 6, VERTICAL_MID + PADDING + BOX_HEIGHT*3 + BOX_MARGIN*2);
    
    
    
    ctx.stroke();
    ctx.closePath();
}
