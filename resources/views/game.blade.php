@extends('layouts.app')

@section('title', 'PISAH - Game Pemilahan Sampah')

@section('styles')
<style>
    .game-container {
        position: relative;
        width: 100%;
        height: 80vh;
        background-color: #f8f9fa;
        overflow: hidden;
    }
    .bins {
        display: flex;
        justify-content: space-around;
        position: absolute;
        bottom: 20px;
        width: 100%;
    }
    .bin {
        width: 100px;
        height: 120px;
        background-color: #e9ecef;
        border: 2px solid #ced4da;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #6c757d;
    }
    .trash-item {
        position: absolute;
        width: 60px;
        height: 60px;
        background-color: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        cursor: move;
        user-select: none;
        border-radius: 50%;
    }
    .score-board {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 1.2rem;
    }
    .life-board {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.2rem;
    }
    .start-menu {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .start-menu button {
        display: block;
        margin: 10px auto;
        padding: 10px 20px;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
    }
    .start-menu button:hover {
        background-color: #0056b3;
    }
    .hidden {
        display: none;
    }

    .popup {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }
    .popup button {
        margin-top: 10px;
        padding: 5px 15px;
        font-size: 1rem;
        cursor: pointer;
    }
    .score-board, .life-board {
        z-index: 100;
    }
    .bins {
        z-index: 50;
    }
    .trash-item {
        z-index: 10;
    }
</style>
@endsection

@section('content')
<div class="game-container" id="gameContainer">
    <div class="start-menu" id="startMenu">
        <h2>Game Pemilahan Sampah</h2>
        <button id="startGameButton">Start Game</button>
        <button id="highScoreButton">High Scores</button>
        <button id="settingsButton">Settings</button>
        <button id="exitButton">Exit</button>
    </div>
    <div class="score-board hidden">Score: <span id="score">0</span></div>
    <div class="life-board hidden">Lives: <span id="lives">3</span></div>
    <div class="bins hidden">
        <div class="bin" data-type="organic">Organik</div>
        <div class="bin" data-type="anorganik">Anorganik</div>
        <div class="bin" data-type="residu">Residu</div>
    </div>
    <div id="gameOverPopup" class="popup hidden">
        <h2>Game Over!</h2>
        <p>Skor akhir Anda: <span id="finalScore"></span></p>
        <button id="restartButton">Main Lagi</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let gameInterval;
    let isGameRunning = false;
    document.addEventListener('DOMContentLoaded', () => {
        const gameContainer = document.getElementById('gameContainer');
        const bins = document.querySelectorAll('.bin');
        const scoreElement = document.getElementById('score');
        const livesElement = document.getElementById('lives');
        const startMenu = document.getElementById('startMenu');
        const startGameButton = document.getElementById('startGameButton');
        const scoreBoard = document.querySelector('.score-board');
        const lifeBoard = document.querySelector('.life-board');

        let score = 0;
        let lives = 3;
        let gameSpeed = 5000; // Time in milliseconds between trash items
        let fallingSpeed = 3; // Falling speed of trash items (pixels per frame)
        let gameInterval;
        let isGameRunning = false;

        const trashTypes = [
            { type: 'organic', name: 'Sisa Makanan' },
            { type: 'organic', name: 'Daun' },
            { type: 'anorganik', name: 'Botol Plastik' },
            { type: 'anorganik', name: 'Kertas' },
            { type: 'residu', name: 'Popok' },
            { type: 'residu', name: 'Puntung Rokok' }
        ];

        startGameButton.addEventListener('click', () => {
            startMenu.classList.add('hidden');
            scoreBoard.classList.remove('hidden');
            lifeBoard.classList.remove('hidden');
            bins.forEach(bin => bin.classList.remove('hidden'));
            startGame();
        });

        function startGame() {
            document.querySelector('.bins').classList.remove('hidden');
            isGameRunning = true;
            gameInterval = setInterval(createTrashItem, gameSpeed);
        }

        function createTrashItem() {
            if (!isGameRunning) return;
            const trash = trashTypes[Math.floor(Math.random() * trashTypes.length)];
            const trashElement = document.createElement('div');
            trashElement.className = 'trash-item';
            trashElement.textContent = trash.name;
            trashElement.dataset.type = trash.type;
            trashElement.style.left = `${Math.random() * (gameContainer.offsetWidth - 60)}px`;
            trashElement.style.top = '-60px';
            gameContainer.appendChild(trashElement);

            let falling = setInterval(() => {
                if (!isGameRunning) {
                    clearInterval(falling);
                    if (trashElement.parentNode === gameContainer) {
                        gameContainer.removeChild(trashElement);
                    }
                    return;
                }
                let top = parseInt(trashElement.style.top);
                if (top >= gameContainer.offsetHeight - 180) {
                    clearInterval(falling);
                    gameContainer.removeChild(trashElement);
                    decreaseLife();
                } else {
                    trashElement.style.top = `${top + fallingSpeed}px`;
                }
            }, 50);

            trashElement.addEventListener('mousedown', startDragging);
        }

        function startDragging(e) {
            const trashElement = e.target;
            let shiftX = e.clientX - trashElement.getBoundingClientRect().left;
            let shiftY = e.clientY - trashElement.getBoundingClientRect().top;

            moveAt(e.pageX, e.pageY);

            function moveAt(pageX, pageY) {
                trashElement.style.left = pageX - shiftX + 'px';
                trashElement.style.top = pageY - shiftY + 'px';
            }

            function onMouseMove(e) {
                moveAt(e.pageX, e.pageY);
            }

            document.addEventListener('mousemove', onMouseMove);

            trashElement.onmouseup = function() {
                document.removeEventListener('mousemove', onMouseMove);
                trashElement.onmouseup = null;
                checkCollision(trashElement);
            };
        }

        function checkCollision(trashElement) {
            let isDroppedInBin = false;
            for (let bin of bins) {
                if (isCollision(trashElement, bin)) {
                    isDroppedInBin = true;
                    console.log(`Sampah tipe: ${trashElement.dataset.type}, Tong tipe: ${bin.dataset.type}`);
                    if (trashElement.dataset.type === bin.dataset.type) {
                        console.log('Sampah dibuang ke tong yang benar');
                        increaseScore();
                    } else {
                        console.log('Sampah dibuang ke tong yang salah');
                        decreaseLife();
                    }
                    gameContainer.removeChild(trashElement);
                    break;
                }
            }
            if (!isDroppedInBin) {
                console.log('Sampah tidak dibuang ke tong manapun');
                gameContainer.removeChild(trashElement);
                decreaseLife(); // Decrease life if trash is not dropped in any bin
            }
        }

        function isCollision(element1, element2) {
            const rect1 = element1.getBoundingClientRect();
            const rect2 = element2.getBoundingClientRect();
            return !(rect1.right < rect2.left || 
                     rect1.left > rect2.right || 
                     rect1.bottom < rect2.top || 
                     rect1.top > rect2.bottom);
        }

        function increaseScore() {
            score += 10;
            scoreElement.textContent = score;
            if (score % 50 === 0) {
                increaseGameSpeed();
            }
        }

        function decreaseLife() {
            lives--;
            livesElement.textContent = lives;
            if (lives <= 0) {
                endGame();
            }
        }

        function increaseGameSpeed() {
            gameSpeed = Math.max(1000, gameSpeed - 500);
            fallingSpeed += 0.5;
        }

        function endGame() {
            isGameRunning = false;
            clearInterval(gameInterval);
            
            const gameOverPopup = document.getElementById('gameOverPopup');
            const finalScoreElement = document.getElementById('finalScore');
            const restartButton = document.getElementById('restartButton');

            finalScoreElement.textContent = score;
            gameOverPopup.classList.remove('hidden');

            restartButton.addEventListener('click', () => {
                gameOverPopup.classList.add('hidden');
                resetGame();
            });
        }

        function resetGame() {
            document.getElementById('gameOverPopup').classList.add('hidden');
            score = 0;
            lives = 3;
            scoreElement.textContent = score;
            livesElement.textContent = lives;
            scoreBoard.classList.add('hidden');
            lifeBoard.classList.add('hidden');
            bins.forEach(bin => bin.classList.add('hidden'));
            startMenu.classList.remove('hidden');
        }
    });
</script>
@endsection
