class Grid
{
	constructor (canvasID)
	{
		this.canvas = document.getElementById(canvasID);
		this.ctx = this.canvas.getContext("2d");
		this.squareCoordX = [];
		this.squareCoordY = [];
		this.squareSize;
		this.grid(30);
		console.log("instanciation");
		console.log(this.squareCoordX);

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

	grid (squareSize)
	{
		this.squareSize = squareSize;
		console.log("dessin des lignes");
		let x = 0;
		let y = 0;

		this.squareCoordX.push(0);
		this.squareCoordY.push(0);

		for (x = squareSize ; x < this.canvas.width ; x += squareSize)
		{
			this.squareCoordX.push(x);
			this.ctx.beginPath();
			this.ctx.moveTo(x, 0);
        	this.ctx.lineTo(x, this.canvas.height);
        	this.ctx.closePath();
        	this.ctx.stroke();
		}

		for (y = squareSize ; y < this.canvas.height ; y += squareSize)
		{
			this.squareCoordY.push(y);
			this.ctx.beginPath();
			this.ctx.moveTo(0, y);
        	this.ctx.lineTo(this.canvas.width, y);
        	this.ctx.closePath();
        	this.ctx.stroke();
		}
	}

	fillRect(x, y)
	{
		var beginX = 0;	
		var beginY = 0;

		for (let i=0 ; i < this.squareCoordX.length ; i++)
		{
			if (this.squareCoordX[i] + this.squareSize <= x)
			{
				beginX = this.squareCoordX[i];
				console.log('coucou i');
			}
		
			for (let j=0 ; j < this.squareCoordY.length ; j++)
			{
				if (this.squareCoordY[j] + this.squareSize <= y)
				{
					beginY = this.squareCoordX[j];
					console.log('coucou j');
				}
			}
		}
		
		this.ctx.beginPath();
		this.ctx.rect(beginX, beginY,this.squareSize, this.squareSize);
		this.ctx.fillStyle="black";
  		this.ctx.fill();
  		console.log(beginX);
  		console.log(beginY);
	}
}

let grid = new Grid("canvas");
grid.fillRect(30, 60);