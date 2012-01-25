
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
    var boxX = 54;  //Initial X position of first box
    var boxY = 145; //Initial Y position of first box
    var maxTextWidth = 12;
    var boxWidth = 40;
    var boxHeight = 40;
    var boxMargin = 28;
    var padding = 40;   //Padding between horizontal line of phases and vertical ones
    ctx.font="normal 12px sans-serif"
    
    
    //Drawing first horizontal line of boxes
    ctx.fillStyle = "#CCCCCC";
    ctx.rect(boxX, boxY, boxWidth, boxHeight);
    fill_stroke(ctx);
    ctx.closePath();
    //Drawing now the number of the phase 4
    ctx.strokeText("4", boxWidth/2 + boxX, boxHeight+15 + boxY, maxTextWidth);
    
    
    ctx.beginPath();    //Gonna draw now the rest of horizontal phases
    var i;
    for(i = 1; i < 5; i++) {
        ctx.rect(boxX + i*(boxMargin + boxWidth), boxY, boxWidth, boxHeight);
        //Numbers from 5 to 8
        ctx.strokeText(i+4, i*(boxWidth + boxMargin) + boxWidth/2 + boxX, boxHeight+15 + boxY, maxTextWidth);
    }
    ctx.fillStyle = "#000000";
    fill_stroke(ctx);
    ctx.closePath();

    
    //Drawing left vertical line of boxes
    ctx.beginPath();
    
    for(i = 0; i < 3; i++) {
        ctx.rect(boxX - boxWidth/2, boxY + boxHeight + padding + i*(boxHeight + boxMargin), boxWidth, boxHeight);
        
        ctx.strokeText(3 - i, boxX + 25, boxY + boxHeight + padding + 25 + i*(boxHeight + boxMargin), maxTextWidth);
    }
    ctx.fillStyle= "#CCCCCC";
    fill_stroke(ctx);
    ctx.closePath();

    //Drawing right vertical line of boxes
    ctx.beginPath();
    for(i = 0; i < 3; i++) {
        ctx.rect(boxX + (boxWidth + boxMargin)*4 + 14, boxY + boxHeight + padding + i*(boxHeight + boxMargin), boxWidth, boxHeight);
        
        ctx.strokeText(9+i, boxX + (boxWidth + boxMargin)*4, boxY + boxHeight + padding + 25 + i*(boxHeight + boxMargin), maxTextWidth);
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
    var boxX = 54;  //Initial X position of first box
    var boxY = 145; //Initial Y position of first box
    var boxWidth = 40;
    var boxHeight = 40;
    var boxMargin = 28;
    var padding = 40;   //Padding between horizontal line of phases and vertical ones
    var hmid = boxX + boxWidth/2;
    var vmid = boxY + boxHeight/2;
    
    var warWidth = 100;
    var warHeight = 80;
    var warMargin = 5;
    
    ctx.beginPath();
    
    //Left side wardrobes
    ctx.moveTo(0, warHeight/2);
    ctx.lineTo(hmid + boxWidth*2 + boxMargin*2, boxY);
    
    ctx.moveTo(0, warHeight*1.5 + warMargin*2);
    ctx.lineTo(hmid + boxWidth + boxMargin, boxY);
    
    ctx.moveTo(0, warHeight*2.5 + warMargin*3);
    ctx.lineTo(boxX, vmid);
    
    ctx.moveTo(0, warHeight*3.5 + warMargin*4);
    ctx.lineTo(boxX - boxWidth/2, vmid + padding + boxHeight);
    
    ctx.moveTo(0, warHeight*4.5 + warMargin*5);
    ctx.lineTo(boxX - boxWidth/2, vmid + padding + boxMargin + boxHeight*2);
    
    ctx.moveTo(0, warHeight*5.5 + warMargin*6);
    ctx.lineTo(boxX - boxWidth/2, vmid + padding + boxMargin*2 + boxHeight*3);
    
    //Right side wardrobes
    ctx.moveTo(420, warHeight/2);
    ctx.lineTo(hmid + boxWidth*3 + boxMargin*3, boxY);
    
    //TODO fix this two lines
    ctx.moveTo(420, warHeight*1.5 + warMargin*2);
    ctx.lineTo(hmid + boxWidth*3 + boxMargin*3, boxY);
    
    ctx.stroke();
    ctx.closePath();
}
