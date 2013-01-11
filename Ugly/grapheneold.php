<!-- 

pls 1 to finish cellls, red blue laternating, snap x, snapy 
redo draw function so it tesselates without overlap
draw triangles and skip lines??
draw 2 rows seperately,
draw tri-sticks

two tops

aahhhhh only draw alternating heaxagons, the holes don't look like holes!! and draw lines to complete

horseshoe, hole at the bottom, bar sticking out to the right(apart from the last one)

recursion spanning from 1 point

http://www.rdwarf.com/lerickson/hex/irregular/
http://zvold.blogspot.com/2010/01/bresenhams-line-drawing-algorithm-on_26.html
http://webcache.googleusercontent.com/search?q=cache:eyqfjRs5NdcJ:forums.sun.com/thread.jspa%3FthreadID%3D386860+draw+hexagonal+grid&cd=10&hl=en&ct=clnk&gl=uk

-->

<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <title>Jeremy's Graphene Ruler</title> 
        <link rel="stylesheet" href="demo.css" type="text/css" media="screen"> 
        <link rel="stylesheet" href="demo-print.css" type="text/css" media="print"> 
	<script src="jquery-1.4.3.min.js"></script> 
        <script src="raphael-min.js"></script> 
        <script> 
        //l = R.path().attr({stroke: "#fff"}),
	//l.attr({path: "M295.186,122.908L" + "100" + "," + "100" + "z"})
	//console.log ( "var l"+c+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
	//M10 20L50 40

	function drawRuler (R, atom)
	{
		if(R.rulerline)
			R.rulerline.remove();
		var x = $("#x").text();
		var y = $("#y").text();

		x -= 50;
		y -= 130;
		xdiff = x - atom.attr("cx");
		ydiff = y - atom.attr("cy");
		$("#r").text(Math.round(Math.pow(xdiff*xdiff+ydiff*ydiff,0.5)/R.gspace*100)/100);
		$("#xval").text(Math.round(xdiff/R.gspace*100)/100);
		$("#yval").text(Math.round(ydiff/R.gspace*100)/100);

		var tempstr = "=R.path().attr({stroke:'hsb(1,1,1)',path:'M";
		var tx1, ty1, tx2, ty2;
		tx1 = atom.attr("cx");
		ty1 = atom.attr("cy");
		tx2 = x;
		ty2 = y;
		eval("R.rulerline"+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		R.rulerline.toBack();

	}
	
	function resetInfo (R, gspace, radius)
	{
				/*rData = [
						"1/Math.sqrt(3)",
						"1",
						"2/Math.sqrt(3)",
						"Math.sqrt(7)/Math.sqrt(3)",
						"Math.sqrt(3)",
						"2",
						"Math.pow(Math.pow(Math.sqrt(3)*1.5,2)+Math.pow(2.5,2),0.5)/Math.sqrt(3)",
						"4/Math.sqrt(3)",
						"Math.pow(Math.pow(Math.sqrt(3),2)+Math.pow(4,2),0.5)/Math.sqrt(3)"
					];*/
		n = radius.n - 1;
		radialData = [
					[1,3,"3^.5/3","1/3",0,0],
					[2,6,"1","1",0,0],
					[3,3,"2/3^.5","0",0,0],
					[4,6,"7^.5/3^.5","0",0,0],
					[5,6,"3^.5","1",0,0],
					[6,6,"2","1",0,0],
					[7,6,"Math.pow(Math.pow(Math.sqrt(3)*1.5,2)+Math.pow(2.5,2),0.5)/Math.sqrt(3)","1",0,0],
					[8,3,"4/Math.sqrt(3)","1",0,0],
					[9,6,"Math.pow(Math.pow(Math.sqrt(3),2)+Math.pow(4,2),0.5)/Math.sqrt(3)","1",0,0],
					];
		if(n<radialData.length)
		{
			$("#shellnum").text(radialData[n][0]);
			$("#atoms").text(radialData[n][1]);
			$("#radius").text(radialData[n][2]);
			$("#area").text(radialData[n][3]);
			$("#cells").text(radialData[n][4]);
			$("#cellatoms").text(radialData[n][5]);
		}
		else
		{
			$("#shellnum").text("-");
			$("#atoms").text("-");
			$("#radius").text("-");
			$("#area").text("-");
			$("#cells").text("-");
			$("#cellatoms").text("-");
		}
	}
	function resetRuler (R, gspace, atom)
	{
		if(R.curratom == atom)
			return;

		if(R.updateruler)
			clearInterval(R.updateruler);

		var fillstr = "hsb(1,1,1)";

		if(R.curratom)
			R.curratom.animate({fill: R.curratom.stdfill}, 1000, ">");
		R.curratom = atom;
		R.curratom.stdfill = atom.attr("fill");
		atom.animate({fill: fillstr}, 1000, ">");
		sw = 4;
		sw2 = 7;
		op = 0.05;
		if(!R.r1)
		{

			rData = [
						"1",
						"Math.sqrt(3)",
						"2",
						"Math.sqrt(7)",
						"3",
						"Math.sqrt(3)*2",
						"Math.pow(Math.pow(Math.sqrt(3)*1.5,2)+Math.pow(2.5,2),0.5)",
						"4",
						"Math.pow(Math.pow(Math.sqrt(3),2)+Math.pow(4,2),0.5)"
					];
			cc = 1
			while(cc < 10)
			{
					eval("R.r"+cc+" = R.circle(atom.attr('cx'), atom.attr('cy'), gspace*"+rData[cc-1]+").attr({fill: 'none', stroke: '#ddd', 'stroke-width': "+sw+", opacity: "+op+"});");
					eval("R.r"+cc+".n ="+cc+";");
					eval("R.r"+cc+".toBack();");
					eval("R.r"+cc+".mouseover(function(){this.animate({'stroke-width': sw2, stroke: 'hsb(1, 1, 1)',opacity: .7}, 100, '>');resetInfo(R, gspace, this);});");
		        		eval("R.r"+cc+".mouseout(function(){ this.animate({'stroke-width': sw, stroke: '#ddd',opacity: op}, 800, '>');});");
		        		cc++;
			}
			
		}
		
		R.r1.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},100,">");
		R.r2.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},200,">");
		R.r3.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},300,">");
		R.r4.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},400,">");
		R.r5.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},500,">");
		R.r6.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},600,">");
		R.r7.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},700,">");
		R.r8.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},800,">");
		R.r9.animate({"cx": atom.attr("cx"), "cy": atom.attr("cy")},800,">");

		R.updateruler = setInterval(drawRuler,20,R, atom);
				
	}
	function drawCell (R, gspace, cn, sx, sy,spike,bottom)
	{
		var tempstr = "=R.path().attr({stroke:'#fff',path:'M";
		var tx1, ty1, tx2, ty2;
		tx1 = sx;
		ty1 = sy + gspace*Math.sqrt(3)/2;
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 - gspace*Math.sqrt(3)/2;
		eval("var lu"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");

		tx1 = sx + gspace*0.5;
		ty1 = sy;
		tx2 = tx1 + gspace;
		ty2 = ty1;
		eval("var lt"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");

		tx1 = sx + gspace*1.5;
		ty1 = sy;
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 + gspace*Math.sqrt(3)/2;
		eval("var ld"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
	
		tx1 = sx
		ty1 = sy + gspace*Math.sqrt(3)/2;
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 + gspace*Math.sqrt(3)/2;
		eval("var lbd"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");

		tx1 = sx + gspace*1.5;
		ty1 = sy + gspace*Math.sqrt(3);
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 - gspace*Math.sqrt(3)/2;
		eval("var lbu"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");

		if(spike)
		{
			tx1 = sx + gspace*2;
			ty1 = sy + gspace*Math.sqrt(3)/2;
			tx2 = tx1 + gspace;
			ty2 = ty1;
			eval("var s"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		}

		if(bottom)
		{
			tx1 = sx + gspace*0.5;
			ty1 = sy + gspace*Math.sqrt(3);
			tx2 = tx1 + gspace;
			ty2 = ty1;
			eval("var lb"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		}

	}
	function drawGrid (R, gspace, gwidth, gheight) // gpsace = horizontal, single bond length
        {
        	var start = function () {
                    this.ox = this.attr("cx");
                    this.oy = this.attr("cy");
                    this.animate({r: 70, opacity: .25}, 500, ">");
                },
                move = function (dx, dy) {
                    this.attr({cx: this.ox + dx, cy: this.oy + dy});
                },
                up = function () {
                    this.animate({r: 50, opacity: .5}, 500, ">");
                };
                R.gspace = gspace;
                var updateruler = null;
                var rulerline = null;
                var curratom = null;
        	var w = 0, h = 0;
            	var sx = 40, sy = 20; //this.attr("cx");
            	while(h < gheight)
            	{
            		w = 0;
			while(w < gwidth)
			{
				if(w+1 == gwidth)
					drawCell(R, gspace, h+"_"+w, sx + gspace*(w*3), sy + gspace*h*Math.sqrt(3),0,h+1 == gheight);
				else
					drawCell(R, gspace, h+"_"+w, sx + gspace*(w*3), sy + gspace*h*Math.sqrt(3),1,h+1 == gheight);
				w++;
			}
			h++;
		}

		h = 0;
		var a, b, r = 6, fillstr1 = "hsb(0.6, 1, 1)", fillstr2 = "hsb(0.3, 0.7, 1)";
            	while(h < (gheight*2 +1))
            	{
            		w = 0;
			while(w < gwidth)
			{
				if(h%2==0)
				{
					a = R.circle(sx + gspace*(w*3 + 0.5), sy + gspace*(h*0.5)*Math.sqrt(3), r).attr({fill: fillstr1, stroke: "none", opacity: .9});
					b = R.circle(sx + gspace*(w*3 + 1.5), sy + gspace*(h*0.5)*Math.sqrt(3), r).attr({fill: fillstr2, stroke: "none", opacity: .9});
				}
				else
				{
					a = R.circle(sx + gspace*(w*3), sy + gspace*(h*0.5)*Math.sqrt(3), r).attr({fill: fillstr2, stroke: "none", opacity: .9});
					b = R.circle(sx + gspace*(w*3 + 2), sy + gspace*(h*0.5)*Math.sqrt(3), r).attr({fill: fillstr1, stroke: "none", opacity: .9});
				}
       				a.mouseover(function(){this.animate({r: 10, opacity: 0.7}, 100, ">");});
                		a.mouseout(function(){this.animate({r: 6, opacity: 0.9}, 100, ">");});
                		a.mousedown(function(){resetRuler(R, gspace, this);});

				b.mouseover(function(){this.animate({r: 10, opacity: 0.7}, 100, ">");});
                		b.mouseout(function(){this.animate({r: 6, opacity: 0.9}, 100, ">");});
                		b.mousedown(function(){resetRuler(R, gspace, this);});
                		
				w++;
			}		
			h++;
		}
	}
	$(document).ready(function(){
                var R = Raphael(50, 130, "90%", "90%");
		drawGrid(R, 60, 4, 4);

        	$(document).mousemove(function(e){
			$("#x").text(e.pageX);
			$("#y").text(e.pageY);
		});
	});
        </script> 
    </head> 
    <body> 
    	<div id="info" style="width:100%;height:100%;float:left;padding:0px;">
		<div style="width:auto;margin:0px;padding:0px;margin-left:auto; margin-right:auto;">
			<table border="1px" style="white-space:nowrap;text-align:left;td{padding:50px;}">
				<tr>
					<th colspan="5" style="text-align:center;"><u>Ruler Info  (|a|)</u></th>
					<th colspan="4" style="text-align:center;"><u>Radial Info</u></th>
				</tr>
				<tr>
					<td>R:</td>
					<td>X:</td>
					<td>Y:</td>
					<td>A1:</td>
					<td>A2:</td>
					
					<td>Shell #:</td>
					<td>Atoms:</td>
					<td>Radius  |a|:</td>
					<td>Area  &Pi;*|a|<sup>2</sup>:</td>
					<td style="display:none;">Cells:</td>
					<td style="display:none;">Cell Atoms:</td>
				</tr>
				<tr>			
					<td width="20px"><span id="r">-</td>
					<td width="20px"><span id="xval">-</td>
					<td width="20px"><span id="yval">-</td>
					<td><span id="a1">-</td>
					<td><span id="a2">-</td>

					<td><span id="shellnum">-</td>
					<td><span id="atoms">-</td>
					<td><span id="radius">-</td>
					<td><span id="area">-</td>
					<td style="display:none;"><span id="cells">-</td>
					<td style="display:none;"><span id="cellatoms">-</td>
				</tr>
			</table>
		</div>
	</div>
	<span id="x" style="display:none;"></span>
	<span id="y" style="display:none;"></span>
        <div id="holder"></div> 
        <p id="copy">
        	by Jeremy Taylor
        </p> 
    </body> 
</html>
