<?php echo
"<!-- game.php -->

<div class=stats>
  <div class=score>
    <h2>Score: </h2>
    <p id=score>0</p>
  </div>
  <div class=lives>
    <h2>Lives Left: </h2>
    <p id=lives>1</p>
  </div>
  <div class=pb>
    <h2>High Score: </h2>
    <p id=pb>0</p>
  </div>
</div>

<div id=h2p>
  <pre>
  Press the

      W
    A S D

Keys to Play!
  </pre>
</div>

<div class=game>
  <canvas id=gc width=400 height=400></canvas>
</div>

<script>
  px = py = 10;
  gs = tc = 20;
  ax = ay = 15;
  xv = yv = 0;

  trail = [];
  tail = 5;

  speed = 10;
  score = 0;
  lives = 2;
  totallives = 2;
  gameStart = 0;
  run = 0;

  window.onload = function() {
    canv = document.getElementById('gc');
    ctx = canv.getContext('2d');
    document.addEventListener('keydown', keyPush);

    rungame(speed, lives);
  }

  function applySettings() {
    score = 0;
    if (document.getElementById('easy').checked) {
      runSettings(5, 3);
    } else if (document.getElementById('normal').checked) {
      runSettings(10, 2);
    } else {
      runSettings(15, 1);
    }
    document.getElementById('h2p').style.display = 'block';
    document.getElementById('pb').innerHTML = 0;
  }

  function runSettings(s, t) {
    speed = s;
    totallives = t;
    rungame(speed, totallives);
    document.getElementById('totallives').innerHTML = totallives;
  }

  function rungame(speed, li) {
    gameStart = 1;
    lives = li;

    px = py = 10;
    gs = tc = 20;
    ax = ay = 15;
    xv = yv = 0;

    trail = [];
    tail = 5;

    score = 0;

    clearInterval(run);

    document.getElementById('speed').innerHTML = speed;
    document.getElementById('score').innerHTML = score;
    document.getElementById('lives').innerHTML = lives;

    run = setInterval(function() {
      game()
    }, 1000 / speed);
  }

  function game() {
    px += xv;
    py += yv;
    if (px < 0) {
      px = tc - 1;
    }
    if (px > tc - 1) {
      px = 0;
    }
    if (py < 0) {
      py = tc - 1;
    }
    if (py > tc - 1) {
      py = 0;
    }
    ctx.fillStyle = 'black';
    ctx.fillRect(0, 0, canv.width, canv.height);

    ctx.fillStyle = 'lime';
    for (var i = 0; i < trail.length; i++) {
      ctx.fillRect(trail[i].x * gs, trail[i].y * gs, gs - 2, gs - 2);
      if (trail[i].x == px && trail[i].y == py && (xv != 0 || yv != 0)) {
        tail = 0;

        px = py = 10;
        gs = tc = 20;
        lives -= 1;
        if (lives <= 0) {
          clearInterval(run);
          gameStart = 0;
          tail = 0;
        } else {
          document.getElementById('lives').innerHTML = lives;
          tail = 5;
        }

        if (gameStart === 0) {
          document.getElementById('lives').innerHTML = 'GAME OVER';
          document.getElementById('h2p').style.display = 'block';
        }
      }
    }

    trail.push({
      x: px,
      y: py
    });

    while (trail.length > tail) {
      trail.shift();
    }

    // if snake is eating an apple
    if (ax == px && ay == py) {
      tail++;
      score += 5;
      document.getElementById('score').innerHTML = score;

      // if the current score is larger than the high score
      var pb = document.getElementById('pb').innerHTML;
      if (score > pb) {
        document.getElementById('pb').innerHTML = score;
      }

      ax = Math.floor(Math.random() * tc);
      ay = Math.floor(Math.random() * tc);
    }

    ctx.fillStyle = 'red';
    ctx.fillRect(ax * gs, ay * gs, gs - 2, gs - 2);
  }

  function keyPush(evt) {
    if (gameStart === 0) {
      rungame(speed, totallives);
    } else {
      switch (evt.keyCode) {
        case 65:
          if (xv != 1) {
            xv = -1;
            yv = 0;
          }
          break;
        case 87:
          if (yv != 1) {
            xv = 0;
            yv = -1;
          }
          break;
        case 68:
          if (xv != -1) {
            xv = 1;
            yv = 0;
          }
          break;
        case 83:
          if (yv != -1) {
            xv = 0;
            yv = 1;
          }
          break;
      }
      document.getElementById('h2p').style.display = 'none';
    }
  }
</script>

<div class=options>
  <h1>Options: </h1>

  <h2>Difficulty: </h2>
  <form onclick='applySettings()'>
    <input id=easy type='radio' name='difficulty'> easy<br>
    <input id=normal type='radio' name='difficulty' checked> normal<br>
    <input id=hard type='radio' name='difficulty'> hard
  </form>

  <h2>Speed: </h2>
  <p id=speed>1</p>

  <br>
  <h2>Total Lives: </h2>
  <p id=totallives>2</p>
</div>"
?>
