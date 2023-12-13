@extends('layouts.default')

@section('title')asdf @endsection

@section('main')

<style>
  #information {
    display: none;
  }

  #information.started {
    display: block;
  }
</style>

@php
  $user = auth()->user();
@endphp

<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
  <button id="btnShowGame" class="hover:animate-shake2">
    <x-icon-logo />
  </button>
</div>

<div class="game container mx-auto p-6 px-4 sm:px-6 lg:px-8 flex flex-col hidden bg-gray-50 rounded-lg shadow-lg">
  <div class="relative mx-auto">
    <canvas id="gameCanvas" class="border border-gray-100 bg-white shadow-md" width="800" height="600"></canvas>
    <div id="information" class="absolute top-0 left-0 w-full h-full">
      <div id="gameInfo" class="absolute right-2 top-2 text-gray-600">
        <div id="currentScore"> 
          점수: 
          <span class="font-bold"></span>
        </div>
        <div id="timeLeft">   
          남은 시간: 
          <span class="font-bold"></span>
        </div>
      </div>

      <div id="combo" class="absolute top-1/2 left-1/2 text-3xl opacity-20 text-yellow-500"> 
        <span class="font-bold"></span>   
      </div>

      <div id="playerInfo" class="absolute left-1/2 bottom-4 -translate-x-1/2 opacity-30 text-white">
        <div id="speed"> 
          속도: 
          <span class="font-bold"></span>
        </div>
        <div id="acceleration">   
          가속도: 
          <span class="font-bold"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="h-fit mt-4">
    <h1 class="text-2xl font-bold text-center">Yuzu Game</h1>
    <div id="bestScore" class="text-center mt-2">최고 점수: 
      <span class="font-bold">
        @if (isset($user) && isset($user->gameScore))
          {{$user->gameScore->score}}
        @endif
      </span>
    </div>
    <div id="gameControl" class="flex justify-center mt-4">
      <button id="startGame" class="px-4 py-2 bg-green-500 text-white rounded mr-2">Start Game</button>
      <button id="endGame" class="px-4 py-2 bg-red-500 text-white rounded">End Game</button>
    </div>
  </div>
</div>

<script>
  class YuzuGame {
    gameDuration = 60000;
    gameStart = null;
    score = 0;

    canvas = null;
    width = 800;
    height = 600;

    keys = {
      left: false,
      right: false,
      brake: false,
      shift: false
    };

    constructor({canvas, width, height, yuzuBitmap, playerBitmap}) {
      this.canvas = canvas;
      this.width = width;
      this.height = height;
      this.yuzus = Array.from({length: 3}, () => new Yuzu({initX: Math.random() * this.width, initY: 200, bitmap: yuzuBitmap, speed: 2, gameWidth: this.width, gameHeight: this.height}));
      this.player = new Player({initX: this.width / 2, initY: this.height - playerBitmap.height, bitmap: playerBitmap, speed: 5, gameWidth: this.width, gameHeight: this.height});
      window.addEventListener('keydown', this.onKeyDown.bind(this));
      window.addEventListener('keyup', this.onKeyUp.bind(this));
      this.scoreElement = document.getElementById('currentScore').querySelector('span');

      this.timeLeftElement = document.getElementById('timeLeft').querySelector('span');
      this.comboElement = document.getElementById('combo').querySelector('span');
      this.speedElement = document.getElementById('speed').querySelector('span');
      this.accelerationElement = document.getElementById('acceleration').querySelector('span');
      this.information = document.getElementById('information');

      this.init();
    }

    init() {
      this.ctx = this.canvas.getContext('2d');
      this.canvas.width = this.width;
      this.canvas.height = this.height;
      this.canvas.addEventListener('keydown', this.onKeyDown.bind(this));
      this.canvas.tabIndex = 1000;
      this.canvas.style.outline = 'none';
      this.canvas.focus();

      this.score = 0;

      this.keys = {
        left: false,
        right: false,
        brake: false,
        shift: false
      };

      this.scoreElement.textContent = this.score;
      this.comboElement.textContent = this.score;

      this.yuzus.forEach(yuzu => yuzu.initPosition());
      this.player.initPosition();
    }

    startGame() {
      alert('Game Start!');
      this.gameStart = Date.now();
      this.information.classList.add('started');
      this.init();
      this.draw();
    }

    draw() {
      if (Date.now() - this.gameStart >= this.gameDuration) {
        this.endGame();
        return;
      }

      this.ctx.clearRect(0, 0, this.width, this.height);
  
      this.yuzus.forEach(yuzu => {
        yuzu.move();
        this.ctx.drawImage(yuzu.bitmap, yuzu.x, yuzu.y, yuzu.width, yuzu.height);

        if (this.player.isCollidingWith(yuzu)) {
          this.score++;
          yuzu.resetPosition();
          this.scoreElement.textContent = this.score;
          this.comboElement.textContent = this.score;

          if (this.score % 10 === 0) {
            this.comboElement.parentElement.classList.add('animate-combo');

            // Remove the animation class after 3 seconds
            setTimeout(() => {
              this.comboElement.parentElement.classList.remove('animate-combo');
            }, 1001);
          }
        }
      });
      const timeLeft = this.gameDuration - (Date.now() - this.gameStart);
      this.timeLeftElement.textContent = Math.round(timeLeft / 1000);

      this.speedElement.textContent = this.player.speed.toFixed(2);
      this.accelerationElement.textContent = this.player.acceleration.toFixed(2);

      if (this.keys.left) this.player.moveLeft();
      if (this.keys.right) this.player.moveRight();
      if (this.keys.brake) this.player.limitSpeed();
      if (this.keys.shift) this.player.speedUp();

      this.ctx.drawImage(this.player.bitmap, this.player.x, this.player.y, this.player.width, this.player.height);

      requestAnimationFrame(this.draw.bind(this));
    }

    async endGame() {
      this.gameStart = null;
      this.information.classList.remove('started');
      alert(`Game Over! 점수: ${this.score}`);

      @if(!isset($user))
        const select = confirm("로그인 후 점수를 저장할 수 있습니다. 저장하시겠습니까");
        if (select) {
          sessionStorage.setItem('score', this.score);
          window.location.href = "/login";
        }
      @else 
        const res = await fetch("{{route('score', $user->id)}}");
        const {score: prevScore} = await res.json();

        if (this.score > prevScore) {
          fetch("{{route('record')}}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
              score: this.score,
              user_id: {{$user->id}}
            })
          }).then((res) => {
            if (res.ok) {
              alert('점수가 저장되었습니다.');
              window.location.reload();
            }
          }).catch((err) => {
            alert('점수 저장에 실패했습니다.');
            console.error(err);
          })
        }
      @endif

      this.init();
    }

    onKeyDown(e) {
      if (e.key === 'ArrowLeft') this.keys.left = true;
      if (e.key === 'ArrowRight') this.keys.right = true;
      if (e.key === ' ') this.keys.brake = true;
      if (e.key === 'Shift') this.keys.shift = true;
    }

    onKeyUp(e) {
      if (e.key === 'ArrowLeft') this.keys.left = false;
      if (e.key === 'ArrowRight') this.keys.right = false;
      if (e.key === ' ') this.keys.brake = false;
      if (e.key === 'Shift') {
        this.keys.shift = false;
        this.player.resetAcceleration();
      }
    }
  }

  class Yuzu {
    resetPending = false;
    constructor({initX, initY, bitmap, speed, acceleration, gameWidth, gameHeight}) {
      this.x = initX;
      this.y = initY;
      this.bitmap = bitmap;
      this.speed = speed;
      this.acceleration = acceleration || Math.random() * 0.03 + 0.07; 
      this.size = Math.random() * 3 + 0.8; // Random size between 0.5 and 1
      this.width = bitmap.width * this.size; 
      this.height = bitmap.height * this.size; 
      this.gameWidth = gameWidth;
      this.gameHeight = gameHeight;
    }

    initPosition() {
      this.x = Math.random() * this.gameWidth;
      this.y = 0;
      this.speed = 0;
    }

    move() {
      if (this.resetPending) {
        this.resetPosition();
        this.resetPending = false;
      } else {
        this.speed += this.acceleration;
        this.y += this.speed;
        if (this.y > game.height) {
          this.resetPosition();
        }
      }
    }

    resetPosition() {
      this.x = Math.random() * this.gameWidth;
      this.y = 0;
      this.size = Math.random() * 3 + 0.8;
      this.width = this.bitmap.width * this.size;
      this.height = this.bitmap.height * this.size;
      this.speed = 0; 
    }
  }

  class Player {
    constructor({initX, initY, bitmap, speed, acceleration, maxSpeed, gameWidth, gameHeight}) {
      this.x = initX;
      this.y = initY;
      this.bitmap = bitmap;
      this.initSpeed = speed;
      this.speed = this.initSpeed;
      this.initAcceleration = acceleration || 0.01;
      this.acceleration = this.initAcceleration;
      this.maxSpeed = maxSpeed || 7;
      this.width = bitmap.width; 
      this.height = bitmap.height; 
      this.gameWidth = gameWidth;
      this.gameHeight = gameHeight; 
    }

    initPosition() {
      this.x = this.gameWidth / 2;
      this.y = this.gameHeight - this.bitmap.height;
      this.speed = this.initSpeed;
    }

    limitSpeed() {
      if (this.speed > this.maxSpeed) {
        this.speed = this.maxSpeed;
      }
    }

    resetAcceleration() {
      this.acceleration = this.initAcceleration;
    }

    speedUp() {
      this.acceleration += 0.003;
    }

    moveLeft() {
      this.speed += this.acceleration;
      if (this.x - this.speed >= 0) {
        this.x -= this.speed;
      } else {
        this.x = 0;
      }
    }

    moveRight() {
      this.speed += this.acceleration;
      if (this.x + this.width + this.speed <= game.width) {
        this.x += this.speed;
      } else {
        this.x = game.width - this.width;
      }
    }

    isCollidingWith(yuzu) {
      return this.x < yuzu.x + yuzu.width &&
        this.x + this.width > yuzu.x &&
        this.y < yuzu.y + yuzu.height &&
        this.y + this.height > yuzu.y;
    }
  }

  let game;

  const canvas = document.getElementById('gameCanvas');
  const yuzuBitmap = new Image();
  const playerBitmap = new Image();

  const yuzuBitmapPromise = new Promise((resolve) => {
    yuzuBitmap.onload = resolve;
    yuzuBitmap.src = "{{URL::asset('/assets/image/yuzu.png')}}";
  });

  const playerBitmapPromise = new Promise((resolve) => {
    playerBitmap.onload = resolve;
    playerBitmap.src = "{{URL::asset('/assets/image/basket.png')}}";
  });

  const information = document.getElementById('information');
  const btnStartGame = document.getElementById('startGame');
  const btnEndGame = document.getElementById('endGame');
  const container = document.querySelector('.game');
  const bestScore = document.getElementById('bestScore').querySelector('span');

  Promise.all([yuzuBitmapPromise, playerBitmapPromise]).then(() => {
    game = new YuzuGame({canvas, width: 800, height: 600, yuzuBitmap, playerBitmap});

    btnStartGame.addEventListener('click', () => {
      if (!game.gameStart) game.startGame()
    });

    btnEndGame.addEventListener('click', () => {
      if (game.gameStart) {
        alert('Game End!');
        game.endGame();
      }
    });
  });

  document.getElementById('btnShowGame').addEventListener('click', function() {
    this.classList.add('animate-showGame');
    this.classList.remove('hover:animate-shake2');

    setTimeout(() => {
      this.classList.remove('animate-showGame');
      this.classList.add('hidden');
      container.classList.remove('hidden');
    }, 1000); // Remove the class after 1 second
  });

  @if(isset($user))
    const score = sessionStorage.getItem('score');
    if(score) {
      const select = confirm(`이전 게임에서 흭득한 점수가 있습니다. (${score} 점), 등록하시겠습니까?`);
      if (select) {
        // fetch()
        console.log('fetch');
        fetch('{{route('record')}}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json', // 이 행을 추가하세요
          },
          body: JSON.stringify({
            score: score,
            user_id: {{$user->id}}
          })
        }).then(res => {
          if (res.ok) {
            alert('점수가 저장되었습니다.');
            window.location.reload();
          }
        }).catch(err => {
          alert('점수 저장에 실패했습니다.');
          console.error(err);
        })


        sessionStorage.removeItem('score');
      } else {
        sessionStorage.removeItem('score');
      }
    }
  @else 
    const score = sessionStorage.getItem('score');

    if(score) {
      const select = confirm(`이전 게임에서 흭득한 점수가 있습니다. (${score} 점), 로그인 후 등록하시겠습니까?`);
      if (select) {
        window.location.href = "/login";
      } else {
        sessionStorage.removeItem('score');
      }
    }
  @endif

  

</script>

@endsection
