class Grid
{
	constructor (canvasID)
	{
		this.canvas = document.getElementById(canvasID);
		this.ctx = this.canvas.getContext("2d");
		this.squareCoord = [];
		this.squareStatus = {};
		this.squareSize;

		this.ctx.beginPath();
		this.ctx.rect(0, 0,this.canvas.width, this.canvas.height);
		this.ctx.fillStyle = 'white';
  		this.ctx.fill();

		this.grid(30);

		this.canvas.addEventListener("mousemove", function(evt) {
			let mousePos = this.getMousePos(this.canvas, evt);
		}.bind(this));

		this.canvas.addEventListener("click", function(evt){
			let mousePos = this.getMousePos(this.canvas, evt);
			// console.log(mousePos.x);
			// console.log(mousePos.y);
			this.fillRect(mousePos.x, mousePos.y, 'black');
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

		for (let x = 0 ; x < this.canvas.width ; x += squareSize)
		{
			this.ctx.beginPath();
			this.ctx.strokeStyle = "black";
			this.ctx.moveTo(x, 0);
        	this.ctx.lineTo(x, this.canvas.height);
        	this.ctx.closePath();
        	this.ctx.stroke();
        	for (let y = 0 ; y < this.canvas.height ; y += squareSize)
        	{
        		this.squareCoord.push([x, y]);
        		this.squareStatus[[x, y]] = false;
        	}
		}

		for (let y = 0 ; y < this.canvas.height ; y += squareSize)
		{
			this.ctx.beginPath();
			this.ctx.strokeStyle = "black";
			this.ctx.moveTo(0, y);
        	this.ctx.lineTo(this.canvas.width, y);
        	this.ctx.closePath();
        	this.ctx.stroke();
		}
	}

	fillRect(x, y, color)
	{
		for (let i = 0 ; i < this.squareCoord.length ; i++)
		{
			if (x >= this.squareCoord[i][0] && x < this.squareCoord[i][0] + this.squareSize && 
				y >= this.squareCoord[i][1] && y < this.squareCoord[i][1] + this.squareSize)
			{
				if(color == 'black') {this.squareStatus[this.squareCoord[i]] = true;}
				let beginX = this.squareCoord[i][0];
				let beginY = this.squareCoord[i][1];
				this.ctx.beginPath();
				this.ctx.rect(beginX+1, beginY+1,this.squareSize-2, this.squareSize-2);
				this.ctx.fillStyle = color;
				this.ctx.fill();
			}
		}
	}

	isBlack (x, y)
	{
		let pixelData = this.ctx.getImageData(x, y, 1, 1).data;
		if (pixelData[0] === 0 && pixelData[3] === 255)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	countNeighbors(coord)
	{
		let count = 0;
		for (let x = coord[0] - this.squareSize ; x <= coord[0] + this.squareSize ; x += this.squareSize)
		{
			for (let y = coord[1] - this.squareSize ; y <= coord[1] + this.squareSize ; y += this.squareSize)
			{
				if (this.squareStatus[[x, y]] && (x != coord[0] || y!= coord[1]))
				{
					count++;
				}
			}
		}
		return count;
	}

	next ()
	{
		console.log("t++");
		for (let i=0 ; i < this.squareCoordX.length ; i++)
		{
			for (let j=0 ; j < this.squareCoordY.length ; j++)
			{
				let x = this.squareCoordX[i] - this.squareSize / 2;
				let y = this.squareCoordY[j] - this.squareSize / 2;
				if (this.countNeighbors(x, y) === 3)
				{
					this.fillRect(x, y, 'black');
				}
				else if (this.isBlack(x, y))
				{
					console.log("black");
					if (this.countNeighbors(x, y) > 3 || this.countNeighbors(x, y) < 2)
					{
						this.fillRect(x, y, 'white');
					}
				}
				
			}
		}
	}
}

let grid = new Grid("canvas");
grid.fillRect(30, 60, 'black');
grid.fillRect(30, 90, 'black');
grid.fillRect(30, 120, 'black');
grid.fillRect(30, 150, 'black');
grid.fillRect(60, 150, 'black');
console.log(grid.countNeighbors([60, 210]));