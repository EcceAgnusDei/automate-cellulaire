let save;

window.addEventListener("load", main);

function main()
{
	let grid = new Grid("canvas");
	grid.canvas.width = 1000;
	grid.canvas.height = 700;
	let countdown = setInterval (function() {}, 9999999);

	let cols = document.getElementById("cols");
	let rows = document.getElementById("rows");
	let squareSize = document.getElementById("square-size");
	let speed = document.getElementById("speed");
	let isPlaying = false;
	grid.grid(parseInt(squareSize.value), parseInt(cols.value), parseInt(rows.value));


	$('#reload').click(function(){
		console.log('reload');
		stop();
		grid.clear();
	});
	$('#next').click(function(){
		console.log('next');
		grid.next();
	});
	$('#set-grid').click(function() {
		let nbCols = parseInt(cols.value);
		let nbRows = parseInt(rows.value);
		let size = parseInt(squareSize.value);
		if (isNaN(nbCols) || isNaN(nbRows) || isNaN(size))
		{
			alert("Veuillez entrer des valeurs valides !");
		}
		else if (nbCols > 100 || nbRows > 100 || size > 50)
		{
			alert("Les valeurs rentrées sont trop grandes !");
		}
		else if (nbCols < 5 || nbRows < 5 || size < 5)
		{
			alert('Les valeurs sont trop petites !')
		}
		else
		{
			grid.grid(parseInt(squareSize.value), parseInt(cols.value), 
				parseInt(rows.value));
		}
	});
	$('#play').click(function(){
		play(1000/speed.value);
	});
	$('#stop').click(function(){
		stop();
	});
	$('#load').click(function(){
		grid.load(save);
	});
	$('#save').click(function(){
		save = grid.save();
		$('#grid-json').val(JSON.stringify(grid.save()));
	});
	$('#speed').change(function(){
		if(isPlaying)
		{
			stop();
			play(1000/speed.value);
		}
	});
}

function play(interval)
{
	console.log("play");
	isPlaying = true;
	countdown = setInterval(function(){
		grid.next() }, interval);
}

function stop()
{
	console.log("stop");
	isPlaying = false;
	clearInterval(countdown);
}