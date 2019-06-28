class Grid
{
	constructor (canvasID)
	{
		this.canvas = document.getElementById(canvasID);
		this.ctx = this.canvas.getContext("2d");
		this.squareCoord = [];
		this.squareStatus = {};
		this.squareSize;

		this.canvas.addEventListener("mousemove", function(evt) {
			let mousePos = this.getMousePos(this.canvas, evt);
		}.bind(this));

		this.canvas.addEventListener("click", function(evt){
			let mousePos = this.getMousePos(this.canvas, evt);
			this.fillRect(mousePos.x, mousePos.y, 'black');
		}.bind(this));
	}

	/**
	 * Fonction permettant de calculer la position de la souris dans le canvas
	 * @param  {Object} canvas 
	 * @param  {Event} evt    
	 * @return {Object} Coordonnées x et y sous forme d'objet
	 */
	getMousePos (canvas, evt)
	{
		let rect = canvas.getBoundingClientRect();
		return { x: (evt.clientX - rect.left) * (canvas.width  / rect.width),
			y: (evt.clientY - rect.top)  * (canvas.height / rect.height)
		};
	}

	/**
	 * Methode permettant de d'initialiser la grille
	 * @param {int} squareSize Taille d'un carré en pixels
	 * @param {int} nbCol Nombre de colonnes de la grille
	 * @param {int} nbRow Nombre de ligne de la grille
	 */
	grid (squareSize, nbCol, nbRow)
	{
		this.squareSize = squareSize;
		this.canvas.width = nbCol * squareSize;
		this.canvas.height = nbRow * squareSize;

		this.ctx.beginPath();
		this.ctx.rect(0, 0,this.canvas.width, this.canvas.height);
		this.ctx.fillStyle = 'white';
  		this.ctx.fill();

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

	/**
	 * Methode permettant de remplire un carré
	 * @param {int} x abscisse quelconque à l'interieur du carré que l'on veut colorier
	 * @param {int} y ordonnée du carré
	 * @param {string} color couleur avec laquelle on veut que le carré soit rempli
	 */
	fillRect(x, y, color)
	{
		for (let i = 0 ; i < this.squareCoord.length ; i++)
		{
			if (x >= this.squareCoord[i][0] && x < this.squareCoord[i][0] + this.squareSize && 
				y >= this.squareCoord[i][1] && y < this.squareCoord[i][1] + this.squareSize)
			{
				if(color == 'black') {this.squareStatus[this.squareCoord[i]] = true;}
				if(color == 'white') {this.squareStatus[this.squareCoord[i]] = false;}
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

	/**
	 * Compte le nombre de voisins noirs d'un carré
	 * @param {Array} coord Coordonnées du carré
	 * @return {int} le nombre de voisins
	 */
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

	/**
	 * Passe à l'étape suivante
	 */
	next ()
	{
		let temps = new Date();
		let setBlack = [];
		let setWhite = [];
		for (let i=0 ; i < this.squareCoord.length ; i++)
		{
			if (this.countNeighbors(this.squareCoord[i]) === 3)
			{
				setBlack.push(this.squareCoord[i]);
			}
			else if (this.squareStatus[this.squareCoord[i]])
			{
				if (this.countNeighbors(this.squareCoord[i]) > 3 || this.countNeighbors(this.squareCoord[i]) < 2)
				{
					setWhite.push(this.squareCoord[i]);
				}
			}
		}

		for (let i=0 ; i < setBlack.length ; i++)
		{
			this.fillRect(setBlack[i][0], setBlack[i][1], 'black');
		}

		for (let i=0 ; i < setWhite.length ; i++)
		{
			this.fillRect(setWhite[i][0], setWhite[i][1], 'white');
		}

		let now = new Date()
		console.log(now - temps);
	}

	/**
	 * Recharge une grille
	 */
	reload()
	{
		for (let coord of this.squareCoord)
		{
			this.fillRect(coord[0], coord[1], 'white');
		}
	}
}
