class Grid
{
	constructor (canvasID)
	{
		this.canvas = document.getElementById(canvasID);
		this.ctx = this.canvas.getContext("2d");
		this.line(30);
		console.log("instanciation");

		this.canvas.addEventListener("mousemove", function(evt) {
			var mousePos = this.getMousePos(this.canvas, evt);
			console.log(mousePos.x);
			console.log(mousePos.y);
		}.bind(this));
	}

	getMousePos (canvas, evt)
	{
		let rect = canvas.getBoundingClientRect();
		return { x: (evt.clientX - rect.left) * (canvas.width  / rect.width),
			y: (evt.clientY - rect.top)  * (canvas.height / rect.height)
		};
	}

	line (squareSize)
	{
		console.log("dessin des lignes");
		let x = 0;
		let y = 0;

		for (x = squareSize ; x < this.canvas.width ; x += squareSize)
		{
			this.ctx.beginPath();
			this.ctx.moveTo(x, 0);
        	this.ctx.lineTo(x, this.canvas.height);
        	this.ctx.closePath();
        	this.ctx.stroke();
		}

		for (y = squareSize ; y < this.canvas.height ; y += squareSize)
		{
			this.ctx.beginPath();
			this.ctx.moveTo(0, y);
        	this.ctx.lineTo(this.canvas.width, y);
        	this.ctx.closePath();
        	this.ctx.stroke();
		}
	}
}

let grid = new Grid("canvas");