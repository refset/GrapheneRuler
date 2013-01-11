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
	function cancelRuler(R)
	{
		if(!R.updateruler)
			return;
		clearInterval(R.updateruler);
		R.updateruler = null;
		R.rulerline.remove();
		cc = 1
		while(cc < 10)
		{
			eval("R.r"+cc+".remove();");
			cc++;
		}
		resetInfo (R,R.gspace);
	}
	function drawRuler (R, atom)
	{
		if(R.rulerline)
			R.rulerline.remove();
		var x = $("#x").text();
		var y = $("#y").text();

		x -= R.ox;
		y -= R.oy;
		xdiff = x - atom.attr("cx");
		ydiff = y - atom.attr("cy");
		$("#r").text(Math.round(Math.pow(xdiff*xdiff+ydiff*ydiff,0.5)/R.gspace/Math.pow(3,0.5)*100)/100);
		$("#xval").text(Math.round(xdiff/R.gspace/Math.pow(3,0.5)*100)/100);
		$("#yval").text(Math.round(ydiff/R.gspace/Math.pow(3,0.5)*100)/100);
		var a1 = xdiff/R.gspace/2/2;
		var a2 = a1;
		var temp = ydiff/R.gspace/2/2;
		a1 -= temp;
		a2 += temp;
		$("#a1").text(Math.round(a1*Math.sqrt(3)*100)/100)
		$("#a2").text(Math.round(a2*Math.sqrt(3)*100)/100);

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
				/*rData = [						"1/Math.sqrt(3)",						"1",						"2/Math.sqrt(3)",						"Math.sqrt(7)/Math.sqrt(3)",						"Math.sqrt(3)",						"2",						"Math.pow(Math.pow(Math.sqrt(3)*1.5,2)+Math.pow(2.5,2),0.5)/Math.sqrt(3)",						"4/Math.sqrt(3)",						"Math.pow(Math.pow(Math.sqrt(3),2)+Math.pow(4,2),0.5)/Math.sqrt(3)"					];*/
		if(radius)
			n = radius.n - 1;
		else
			n = 100;
		radialData = [
					[1,3,"3<sup>1/2</sup>/3","1/3",0,0],
					[2,6,"1","1",0,0],
					[3,3,"2/3<sup>1/2</sup>","0",0,0],
					[4,6,"7<sup>1/2</sup>/3<sup>1/2</sup>","0",0,0],
					[5,6,"3<sup>1/2</sup>","1",0,0],
					[6,6,"2","1",0,0],
					[7,6,"((3<sup>1/2</sup>*1.5)<sup>2</sup>+2.5<sup>2</sup>)<sup>1/2</sup>/3<sup>1/2</sup>","1",0,0],
					[8,3,"4/3<sup>1/2</sup>","1",0,0],
					[9,6,"(((3<sup>1/2</sup>)<sup>2</sup>)+4<sup>2</sup>)<sup>1/2</sup>/3<sup>1/2</sup>","1",0,0],
					];
		if(n<radialData.length)
		{
			$("#shellnum").text(radialData[n][0]);
			$("#atoms").text(radialData[n][1]);
			$("#radius").html(radialData[n][2]);
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
		if(!R.updateruler)
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

		cc = 1
		while(cc < 10)
		{
				eval("R.r"+cc+".animate({'cx': atom.attr('cx'), 'cy': atom.attr('cy')},"+100*cc+",'>');");
				cc++;
		}

		R.updateruler = setInterval(drawRuler,20,R, atom);
				
	}

	function drawCell (R, gspace, cn, sx, sy,spike,bottom,stroke,grid)
	{
		var tempstr = "=R.path().attr({stroke:'"+stroke+"',path:'M";
		var tx1, ty1, tx2, ty2;
		tx1 = sx;
		ty1 = sy + gspace*Math.sqrt(3)/2;
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 - gspace*Math.sqrt(3)/2;
		eval("var lu"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		eval("grid.push(lu"+cn+");");

		tx1 = sx + gspace*0.5;
		ty1 = sy;
		tx2 = tx1 + gspace;
		ty2 = ty1;
		eval("var lt"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		eval("grid.push(lt"+cn+");");

		tx1 = sx + gspace*1.5;
		ty1 = sy;
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 + gspace*Math.sqrt(3)/2;
		eval("var ld"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		eval("grid.push(ld"+cn+");");
	
		tx1 = sx
		ty1 = sy + gspace*Math.sqrt(3)/2;
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 + gspace*Math.sqrt(3)/2;
		eval("var lbd"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		eval("grid.push(lbd"+cn+");");

		tx1 = sx + gspace*1.5;
		ty1 = sy + gspace*Math.sqrt(3);
		tx2 = tx1 + gspace*0.5;
		ty2 = ty1 - gspace*Math.sqrt(3)/2;
		eval("var lbu"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
		eval("grid.push(lbu"+cn+");");

		if(spike)
		{
			tx1 = sx + gspace*2;
			ty1 = sy + gspace*Math.sqrt(3)/2;
			tx2 = tx1 + gspace;
			ty2 = ty1;
			eval("var s"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
			eval("grid.push(s"+cn+");");
		}

		if(bottom)
		{
			tx1 = sx + gspace*0.5;
			ty1 = sy + gspace*Math.sqrt(3);
			tx2 = tx1 + gspace;
			ty2 = ty1;
			eval("var lb"+cn+ tempstr + tx1 + " "+ ty1 +"L"+ tx2 + " " + ty2 +"'});");
			eval("grid.push(lb"+cn+");");
		}
	}
	function drawGrid (R, gspace, gwidth, gheight,grid,atomtoggle,sx,sy) // gpsace = horizontal, single bond length
        {
                R.gspace = gspace;
                R.updateruler = null;
                var rulerline = null;
                var curratom = null;
        	var w = 0, h = 0;
            	//var sx = 10, sy = 10; //this.attr("cx");
            	while(h < gheight)
            	{
            		w = 0;
			while(w < gwidth)
			{
				if(w+1 == gwidth)
					drawCell(R, gspace, h+"_"+w, sx + gspace*(w*3), sy + gspace*h*Math.sqrt(3),0,h+1 == gheight,"#aaa",grid);
				else
					drawCell(R, gspace, h+"_"+w, sx + gspace*(w*3), sy + gspace*h*Math.sqrt(3),1,h+1 == gheight,"#aaa",grid);
				w++;
			}
			h++;
		}

		if(atomtoggle)
		{
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

		        		grid.push(a);
		        		grid.push(b);
		        		
					w++;
				}		
				h++;
			}
		}
	}
	$(document).ready(function(){
		var sx = 10;
		var sy = 10;
		var gspace = 60; //<---------------\/ nostalgic mannerisms - like muse! ibm practice
		var ox = 50; //this project is kind of good practice for IT Spec, ha..., nano assignment
		var wx = window.innerWidth - 2*ox;
		var oy = 155;
		var hy = window.innerHeight - oy;
		var nx = Math.floor((wx+gspace-sx*2)/(gspace*3));
		var ny = Math.floor((hy-sy*2)/(gspace*Math.sqrt(3)));
		ox = ox + (wx - nx*gspace*3 - sx*2+ gspace)/2;
		wx = window.innerWidth - 2*ox;//<---------------^
		//oy = oy + (hy - ny*gspace*Math.sqrt(3))/2;
                //var gridc = R.set();
		//drawGrid(R, 60, 4, 4);
		var R = Raphael(ox, oy, wx, hy);  
		R.ox = ox;
		R.oy = 130;//<---------------
		var grida = R.set();
                var gridb = R.set();
                var gridbrot = 0;
                var gridbx = 0
                var gridby = 0;
		drawGrid(R, gspace,  nx, ny, grida,1,sx,sy); //<---------------
		drawGrid(R, gspace, nx, ny, gridb,0,sx,sy); //<---------------
		//drawGrid(R, 60, 7, 2, gridc,1);
		//gridb.translate(60,-30);
		//gridb.rotate(20,0,0);


		//gridc.translate(30,-20);
		//gridc.rotate(60,0,0);
        	$(document).mousemove(function(e){
			$("#x").text(e.pageX);
			$("#y").text(e.pageY);
		});
		//var xTriggered = 0;
		$(document).keydown(function(event) {
			/*if (event.keyCode == '13')
			 {
				event.preventDefault();
			}
			xTriggered++;
			//var msg = 'Handler for .keydown() called ' + xTriggered + ' time(s).';
			alert(msg, 'html');
			alert(event);*/
			var t = 5;
			switch(event.keyCode)
			{
				case 83:
					gridb.translate(0,t);
					gridby+=t;
					gridb.rotate(gridbrot,0,0);
					break;
				case 87:
					gridb.translate(0,-t);
					gridby-=t;
					gridb.rotate(gridbrot,0,0);
					break;
				case 68:
					gridb.translate(t,0);
					gridbx+=t;
					gridb.rotate(gridbrot,0,0);
					break;
				case 65:
					gridb.translate(-t,0);
					gridbx-=t;
					gridb.rotate(gridbrot,0,0);
					break;
				case 81:
					gridb.rotate(gridbrot++,0,0);
					break;	
				case 69:
					gridb.rotate(gridbrot--,0,0);
					break;
				case 82:
					gridb.rotate(0,0,0);
					gridbrot=0;
					gridb.translate(-gridbx,-gridby);
					gridbx=0;
					gridby=0;
					break;
				case 67:
					cancelRuler(R);
					break;
			}
			$("#birot").text(gridbrot);
			$("#bix").text(Math.round(gridbx/gspace/Math.pow(3,0.5)*100)/100);
			$("#biy").text(Math.round(gridby/gspace/Math.pow(3,0.5)*100)/100);
			$("#bid").text(Math.round(Math.pow(Math.pow(gridbx/gspace/Math.pow(3,0.5),2)+Math.pow(gridby/gspace/Math.pow(3,0.5),2),0.5)*100)/100);
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
					<th colspan="4" style="text-align:center;"><u>Bi-Layer Info</u></th>
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
					
					<td>Absolute Rotation:</td>
					<td>Relative X:</td>
					<td>Relative Y:</td>
					<td>XY Pythag:</td>
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

					<td><span id="birot">-</td>
					<td><span id="bix">-</td>
					<td><span id="biy">-</td>
					<td><span id="bid">-</td>
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
