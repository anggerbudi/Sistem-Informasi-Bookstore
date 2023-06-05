@extends('layouts.main')
<style>
    container{
        margin-bottom: 50px;
    }
    .container img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        pointer-events: none;
    }

    .tulisan {
        text-align: center;
        color: white;
        font-size: 20px;
        overflow: hidden;
        font-family: itc-avant-garde-gothic-std-book, serif;
        margin-top: 90px;
        margin-left: 0;
        margin-right: 0;

    }

    .footer {
        display: inline-block;
        overflow: hidden;
        margin-right: 0px;
        margin-left: 10px;
    }

    .footer:first-of-type {
        animation: appear 6s infinite;
    }

    .footer:last-of-type {
        animation: reveal 6s infinite;
    }

    .footer:last-of-type span {
        font-size: 20px;
        color: #E4BC7F;
        animation: slide 6s infinite;
        font-family: itc-avant-garde-gothic-std-book, serif
    }

    @keyframes appear {
        0% {
            opacity: 0;
        }
        20% {
            opacity: 1;
        }
        80% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    @keyframes slide {
        0% {
            margin-left: -800px;
        }
        20% {
            margin-left: -800px;
        }
        35% {
            margin-left: 0px;
        }
        100% {
            margin-left: 0px;
        }
    }

    @keyframes reveal {
        0% {
            opacity: 0;
            width: 0px;
        }
        20% {
            opacity: 1;
            width: 0px;
        }
        30% {
            width: 665px;
        }
        80% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            width: 665px;
        }
    }


</style>
@section('main')

    @guest()
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to Our Bookstore</h1>
                <p class="col-md-8 fs-4">Discover a world of knowledge and adventure</p>
            </div>
        </div>
    @endguest

    @auth()
        <div class="text-center">

            <div class="container">
                <img src="{{asset('images/svg/Dashboard.svg')}}" alt="dashboard image" width="500px">
            </div>
            <div class="tulisan">
                    <div class="footer" style="margin-right: 225px; margin-left: 225px">&nbspWelcome, {{Auth::user()->name}}</div>
                <div class="footer" id="text2">
                    <span >Hope u are having a great day!</span>
                </div>
            </div>
        </div>


        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                data-bs-target="#popUpUler">
            Uler
        </button>

        <!-- Modal -->
        <div class="modal fade" id="popUpUler" tabindex="-1"
             aria-labelledby="popupFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="popupFormLabel">
                            Game Uler</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <style>
                                #game-container {
                                    position: relative;
                                    width: 400px;
                                    height: 400px;
                                    border: 1px solid #000;
                                }

                                .snake-segment {
                                    position: absolute;
                                    width: 20px;
                                    height: 20px;
                                }

                                .snake-head {
                                    background-color: green;
                                }

                                .snake-body-1 {
                                    background-color: #86bf88;
                                }

                                .snake-body-2 {
                                    background-color: #69a769;
                                }

                                .snake-body-3 {
                                    background-color: #4c9650;
                                }

                                .snake-body-4 {
                                    background-color: #318b38;
                                }

                                .snake-body-5 {
                                    background-color: #19711f;
                                }

                                .snake-eyes {
                                    position: absolute;
                                    width: 4px;
                                    height: 4px;
                                    background-color: red;
                                    border-radius: 50%;
                                }

                                #food {
                                    position: absolute;
                                    width: 20px;
                                    height: 20px;
                                    background-color: red;
                                }

                                #score {
                                    margin-top: 10px;
                                }
                            </style>
                            <div>
                                <label for="difficulty">Difficulty:</label>
                                <select id="difficulty">
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                    <option value="extreme">Extreme</option>
                                    <option value="mcqueen">Uler MCQueen</option>
                                </select>
                            </div>
                            <div id="game-container"></div>
                            <button id="start-button">Start Game</button>
                            <div id="score">Score: 0</div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const gameContainer = document.getElementById("game-container");
                                    const startButton = document.getElementById("start-button");
                                    const scoreElement = document.getElementById("score");
                                    const difficultySelect = document.getElementById("difficulty");
                                    let snake;
                                    let food;
                                    let direction;
                                    let score;
                                    let intervalId;
                                    let gameRunning;

                                    function startGame() {
                                        if (gameRunning) return;

                                        snake = [{x: 0, y: 0}];
                                        food = {x: 0, y: 0};
                                        direction = "right";
                                        score = 0;
                                        gameRunning = true;

                                        generateFood();
                                        const selectedDifficulty = difficultySelect.value;
                                        let intervalDuration;

                                        switch (selectedDifficulty) {
                                            case "easy":
                                                intervalDuration = 200;
                                                break;
                                            case "medium":
                                                intervalDuration = 150;
                                                break;
                                            case "hard":
                                                intervalDuration = 100;
                                                break;
                                            case "extreme":
                                                intervalDuration = 50;
                                                break;
                                            case "mcqueen":
                                                intervalDuration = 25;
                                                break;
                                            default:
                                                intervalDuration = 150;
                                        }

                                        intervalId = setInterval(moveSnake, intervalDuration);

                                        drawSnake();
                                        updateScore();
                                    }

                                    function generateFood() {
                                        const maxX = Math.floor(gameContainer.clientWidth / 20) * 20;
                                        const maxY = Math.floor(gameContainer.clientHeight / 20) * 20;

                                        const foodX = Math.floor(Math.random() * (maxX / 20)) * 20;
                                        const foodY = Math.floor(Math.random() * (maxY / 20)) * 20;

                                        food = {x: foodX, y: foodY};
                                    }

                                    function drawSnake() {
                                        gameContainer.innerHTML = "";

                                        snake.forEach((segment, index) => {
                                            const snakeSegment = document.createElement("div");
                                            snakeSegment.className = "snake-segment snake-body-" + ((index % 5) + 1);
                                            snakeSegment.style.left = segment.x + "px";
                                            snakeSegment.style.top = segment.y + "px";

                                            if (index === 0) {
                                                snakeSegment.className = "snake-segment snake-head";
                                                snakeSegment.style.transform = getHeadRotation();
                                                const leftEye = createEyeElement("left");
                                                const rightEye = createEyeElement("right");
                                                snakeSegment.appendChild(leftEye);
                                                snakeSegment.appendChild(rightEye);
                                            }

                                            gameContainer.appendChild(snakeSegment);
                                        });

                                        const foodElement = document.createElement("div");
                                        foodElement.id = "food";
                                        foodElement.style.left = food.x + "px";
                                        foodElement.style.top = food.y + "px";
                                        gameContainer.appendChild(foodElement);
                                    }

                                    function moveSnake() {
                                        const head = {x: snake[0].x, y: snake[0].y};

                                        switch (direction) {
                                            case "up":
                                                head.y -= 20;
                                                break;
                                            case "down":
                                                head.y += 20;
                                                break;
                                            case "left":
                                                head.x -= 20;
                                                break;
                                            case "right":
                                                head.x += 20;
                                                break;
                                        }

                                        snake.unshift(head);

                                        if (head.x === food.x && head.y === food.y) {
                                            score++;
                                            generateFood();
                                        } else {
                                            snake.pop();
                                        }

                                        if (checkCollision()) {
                                            gameOver();
                                        } else {
                                            drawSnake();
                                            updateScore();
                                        }
                                    }

                                    function checkCollision() {
                                        const head = snake[0];

                                        // Check if the snake collides with the boundaries of the game container
                                        if (
                                            head.x < 0 ||
                                            head.x >= gameContainer.clientWidth ||
                                            head.y < 0 ||
                                            head.y >= gameContainer.clientHeight
                                        ) {
                                            return true;
                                        }

                                        // Check if the snake collides with itself
                                        for (let i = 1; i < snake.length; i++) {
                                            if (head.x === snake[i].x && head.y === snake[i].y) {
                                                return true;
                                            }
                                        }

                                        return false;
                                    }

                                    function gameOver() {
                                        clearInterval(intervalId);
                                        gameRunning = false;
                                        alert("Game Over. Your score: " + score);
                                    }

                                    function handleKeyDown(event) {
                                        if (!gameRunning) return;

                                        if (event.key === "ArrowUp" && direction !== "down") {
                                            direction = "up";
                                        } else if (event.key === "ArrowDown" && direction !== "up") {
                                            direction = "down";
                                        } else if (event.key === "ArrowLeft" && direction !== "right") {
                                            direction = "left";
                                        } else if (event.key === "ArrowRight" && direction !== "left") {
                                            direction = "right";
                                        }
                                    }

                                    function createEyeElement(side) {
                                        const eye = document.createElement("div");
                                        eye.className = "snake-eyes";
                                        if (side === "left") {
                                            eye.style.left = "5px";
                                        } else {
                                            eye.style.right = "5px";
                                        }
                                        return eye;
                                    }

                                    function getHeadRotation() {
                                        switch (direction) {
                                            case "up":
                                                return "rotate(0deg)";
                                            case "down":
                                                return "rotate(180deg)";
                                            case "left":
                                                return "rotate(270deg)";
                                            case "right":
                                                return "rotate(90deg)";
                                        }
                                    }

                                    function updateScore() {
                                        scoreElement.textContent = "Score: " + score;
                                    }

                                    startButton.addEventListener("click", startGame);
                                    document.addEventListener("keydown", handleKeyDown);
                                });
                            </script>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @endauth
@endsection
