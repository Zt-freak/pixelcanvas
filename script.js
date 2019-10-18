
function createGrid () {
    const main = document.getElementById("main")
    const gridContainer = document.getElementById("gridcontainer")
    const ctx = gridContainer.getContext("2d")

    for (let x = 0; x < 50; x++)
    {
        for (let y = 0; y < 50; y++) {
            ctx.fillRect(x*10, y*10, 10, 10)
        }
    }
    main.innerHTML += `<p>Pick a colour: </p><input type="color" id="colourpicker" value="#000000">`
    main.innerHTML += `<br />`
    main.innerHTML += `<button onclick="reset()">Clear Canvas</button>`
    updateGrid()
}

function getData (url) {
    let results = fetch(url)
    return results
}

function fillGrid (gridDisplay) {
    gridDisplay
    .then((res) => {
        return res.json();
    })
    .then((data) => {
        const gridContainer = document.getElementById("gridcontainer")
        const ctx = gridContainer.getContext("2d")

        ctx.clearRect(0, 0, gridContainer.width, gridContainer.height)

        for (let x = 0; x < 50; x++)
        {
            for (let y = 0; y < 50; y++) {
                ctx.fillStyle = data.grid[y][x]
                ctx.fillRect(x*10, y*10, 10, 10)
            }
        }

        console.log(data)
        return data
    })
}

function updateGrid () {
    const gridDisplay = new getData(/* your read.php location here */)
    gridDisplay.then(
        fillGrid(gridDisplay)
    )
}

function getMousePos (canvas, evt) {
    const rect = canvas.getBoundingClientRect()
    console.log(evt.clientX - rect.left, evt.clientY - rect.top)
    return {
      x: Math.floor((evt.clientX - rect.left) / 10),
      y: Math.floor((evt.clientY - rect.top) / 10)
    }
}

function updateCell (evt) {
    const gridContainer = document.getElementById("gridcontainer")
    const mousePos = getMousePos(gridContainer, evt)
    const colour = document.getElementById('colourpicker').value
    const url /* your update.php location here */
    console.log(colour)
    let xhr = new XMLHttpRequest()
    xhr.open("POST", url, true)
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(JSON.stringify({
        x: mousePos.x,
        y: mousePos.y,
        colour: colour
    }))
    updateGrid()
}

function reset () {
    const url /* your reset.php location here */
    let xhr = new XMLHttpRequest()
    xhr.open("POST", url, true)
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(JSON.stringify({
        value: true
    }))
    updateGrid()
}

createGrid(updateGrid())

const autoload = setInterval(function(){updateGrid()}, 1000)
setTimeout(
    function() {
        clearInterval(autoload)
        alert("auto-refresh is turned off after 10 minutes, please refresh the page.")
    }, 600000
)