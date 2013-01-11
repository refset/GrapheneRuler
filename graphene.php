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
		$("#a1").text(Math.round(a1*Math.sqrt(3)*100)/100);
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

	function drawCell (R, cn, sx, sy,spike,bottom,stroke,grid)
	{
		var gspace = R.gspace;
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
	function drawGrid (R, gwidth, gheight,grid,atomtoggle,stroke) // gpsace = horizontal, single bond length
        {
                var gspace = R.gspace;
                var sx = R.sx;
                var sy = R.sy;
        	var w = 0, h = 0;
            	//var sx = 10, sy = 10; //this.attr("cx");
            	while(h < gheight)
            	{
            		w = 0;
			while(w < gwidth)
			{
				if(w+1 == gwidth)
					drawCell(R, h+"_"+w, sx + gspace*(w*3), sy + gspace*h*Math.sqrt(3),0,h+1 == gheight,stroke,grid);
				else
					drawCell(R, h+"_"+w, sx + gspace*(w*3), sy + gspace*h*Math.sqrt(3),1,h+1 == gheight,stroke,grid);
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
		wx = window.innerWidth - 2*ox;
		//oy = oy + (hy - ny*gspace*Math.sqrt(3))/2;
                //var gridc = R.set();
		var R = Raphael(ox, oy, wx, hy);  
		R.gspace =gspace;
		R.ox = ox;
		R.oy = oy;
		R.sx = sx;
		R.sy = sy;
		//R.updateruler = null;
		var grida = R.set();
                var gridb = R.set();
                var gridbrot = 0;
                var gridbx = 0
                var gridby = 0;

		drawGrid(R, nx, ny, grida,1,"#fff");
		drawGrid(R, nx, ny, gridb,0,"#33f");
		gridb.toBack();


        	$(document).mousemove(function(e){
			$("#x").text(e.pageX);
			$("#y").text(e.pageY);
		});

		$(document).keydown(function(event) {
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
			<table border="1px" style="height:35px;table-layout:fixed;overflow:hidden;width:100%;white-space:nowrap;text-align:left;td{padding:50px;}">
				<tr>
					<th style="width:25%;text-align:center;"><u>Ruler Info  (|a|)</u></th>
					<th style="text-align:center;"><u>Shell Info</u></th>
					<th style="text-align:center;"><u>Bi-Layer Info</u></th>
				</tr>
				<tr>
					<td>
						<table border="1px" style="table-layout:fixed;overflow:hidden;width:100%;white-space:nowrap;text-align:left;td{padding:50px;}">
							<tr>
								<td>R:</th>
								<th>X:</th>
								<th>Y:</th>
								<th>A1:</th>
								<th>A2:</th>
							</tr>
							<tr>
								<td><span id="r">-</span></td>
								<td><span id="xval">-</span></td>
								<td><span id="yval">-</span></td>
								<td><span id="a1">-</span></td>
								<td><span id="a2">-</span></td>
							</tr>
						</table>
					</td>

					<td>
						<table border="1px" style="table-layout:fixed;overflow:hidden;width:100%;white-space:nowrap;text-align:left;td{padding:50px;}">
							<tr>
								<th width="18%">Shell #:</th>
								<th width="12%">C<sub>12</sub>:</th>
								<th>Radius  |a|:</th>
								<th width="20%">Area:</th>
								<th style="display:none;">Cells:</th>
								<th style="display:none;">Cell Atoms:</th>
							</tr>
							<tr>
								<td><span id="shellnum">-</span></td>
								<td><span id="atoms">-</span></td>
								<td width="50px"><span id="radius">-</span></td>
								<td><span id="area">-</span> |a|<sup>2</sup></td>
								<td style="display:none;"><span id="cells">-</span></td>
								<td style="display:none;"><span id="cellatoms">-</span></td>
							</tr>
						</table>
					</td>
					
					<td>
						<table border="1px" style="table-layout:fixed;overflow:hidden;width:100%;white-space:nowrap;text-align:left;td{padding:50px;}">
							<tr>
								<th>Rotation:</th>
								<th>Relative X:</th>
								<th>Relative Y:</th>
								<th>(X<sup>2</sup>+Y<sup>2</sup>)<sup>2</sup>:</th>
							</tr>
							<tr>
								<td><span id="birot">-</span></td>
								<td><span id="bix">-</span></td>
								<td><span id="biy">-</span></td>
								<td><span id="bid">-</span></td>
							</tr>
						</table>
					</td>		
				</tr>
			</table>
			Keyboard Controls:-  Secondary Layer [WASD = move, QE = rotate, R = reset] Shell Annotations [C = clear]
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
