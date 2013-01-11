<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <title>Raphaël · Drag-n-drop</title> 
        <link rel="stylesheet" href="demo.css" type="text/css" media="screen"> 
        <meta name="apple-mobile-web-app-capable" content="yes"> 
        <link rel="apple-touch-icon-precomposed" href="/Raphael.png"> 
        <link rel="stylesheet" href="demo-print.css" type="text/css" media="print"> 
        <script src="raphael-min.js"></script> 
        <script> 
            window.onload = function () {
                var R = Raphael(0, 0, "100%", "100%"),
                    r = R.circle(100, 100, 50).attr({fill: "hsb(0, 1, 1)", stroke: "none", opacity: .5}),
                    g = R.circle(210, 100, 50).attr({fill: "hsb(.3, 1, 1)", stroke: "none", opacity: .5}),
                    b = R.circle(320, 100, 50).attr({fill: "hsb(.6, 1, 1)", stroke: "none", opacity: .5}),
                    p = R.circle(430, 100, 50).attr({fill: "hsb(.8, 1, 1)", stroke: "none", opacity: .5});
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
                R.set(r, g, b, p).drag(move, start, up);
            };
        </script> 
    </head> 
    <body> 
        <div id="holder"></div> 
        <p id="copy">Demo of <a href="http://raphaeljs.com/">Raphaël</a>—JavaScript Vector Library</p> 
    </body> 
</html>