<!-- <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pixi.js/4.7.1/pixi.min.js"></script>
  </head>
  <body>

  </body>
  <script type="text/javascript">
    const app = new PIXI.Application(800,480,{
      backgroundColor: 0xededed
    });
    var body = document.querySelector("body");
    body.appendChild(app.view);

    var graphic = new PIXI.Graphics();
    app.stage.addChild(graphic);

    var tris = [];
    var letters = [];
    var sequence = "abcdefghijklmnopqrstuvwxyz".split('');
    var typed = "";
    var spacing = 500;
    var speed = 3;
    var movement = 800;
    var jumpHeightLimit = 100;
    var jump = false;
    var jumpHeight = 0;
    var jumpHeightWave = 0;
    var isJumping = false;

    var playerXpos = 150;
    var renderPlayer = true;

    var score = 0;
    var scoreIncrement = 1;
    var scoreText = new PIXI.Text("",{fill:0x000000});
    scoreText.position.set(50,50);
    app.stage.addChild(scoreText);

    for(var i=0;i<sequence.length;i++){
      tris.push({
        id:i,
        x:0,y:280
      });

      letters.push(new PIXI.Text(sequence[i],{fill:0xffffff}));
      app.stage.addChild(letters[i]);
    }

    function drawTriangle(x,y,size){
      graphic.moveTo(x,y);
      graphic.lineTo(x+size,y-size);
      graphic.lineTo(x+size*2,y);
      graphic.lineTo(x,y);
    }

    function isColliding(x1,y1,x2,y2,size){
      size = size || 0
      //x1 player
      //x2 spike
      if(x1 >= x2){
        return true;
      }
    }

    var Player = {
      drawPlayer: function(x,y,size){
        graphic.drawRect(x,y,size,size);
      },
      x:150,
      y:240,
      size:40
    };

    body.onkeydown = function(e){
      if((e.key == sequence[typed.length]) && (jumpHeight == 0)){
        jump = true;
      }
    }

    app.ticker.add(function(){
      //for the kicks
      speed += 0.002;

      if(movement > -spacing*sequence.length){
        movement -= speed;
      }else{
        movement = 800;
      }

      graphic.clear();
      graphic.beginFill(0x000000);

      Player.drawPlayer(Player.x,Player.y,Player.size);
      scoreText.text = Math.floor(score) + " meters.";
      score += scoreIncrement/10

      console.log(Math.sin(jumpHeight));

      if(jump){
        jumpHeightWave += 1;
      }
      jumpHeight = Math.sin(jumpHeightWave*0.1)*100;
      if(jumpHeight <= 0){
        jumpHeight = 0;
        jumpHeightWave = 0;
        jump = false;
      }
      graphic.drawRect(0,280 + jumpHeight, 800, 100);

      tris.forEach(function(tri){
        var x = tri.x + (tri.id*spacing) + movement;
        var y = tri.y + jumpHeight;

        drawTriangle(x,y,20);
        letters[tri.id].x = x;
        letters[tri.id].y = y;
        if(tri.id == typed.length){
          if(x <= 190 && x >= 150 && y == 280){
            typed += " ";
          }
          if(x <= 190 && y >= 300){
            typed += letters[tri.id].text;
          }
        }
      });

    });

  </script>
</html> -->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pixi.js/4.7.1/pixi.min.js"></script>
    <script type="text/javascript"> //webfonts
      WebFontConfig = {
          google: {
            families: ["Fredoka One"]
          }//,
          // active: function() {
          //   // do something
          //   init();
          // }
      };
      (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();
    </script>
  </head>
  <body>

  </body>
  <script type="text/javascript">
    //simplest game script

    const app = new PIXI.Application(800,480,{backgroundColor:0xededed});
    var body = document.querySelector("body");
    body.appendChild(app.view);

    //game mechanic variables
      //obstacles
      var p1;
      var wc;
      var obstacles = [];
      var sourceLetters = "abcdefghijklmnopqrstuvwxyz".split("");
      var typed = "";
      var moveSpeed = 4;
      var moveIncrement = 0;
      var obstacleDistance = 700;

      //containers
      var groundContainer;
      var everythingContainer;

      //etc
      var background;

    //controls
    body.onkeydown = (e) => {
      if(e.key == sourceLetters[typed.length] && !wc.isJumping){
          wc.jump();
      }
    }

    class Player {
      constructor(sprite,x,y){
        this.sprite = sprite;
        this.x = x;
        this.y = y;
        this.sprite.x = this.x;
        this.sprite.y = this.y;
        this.isJump = false;
        this.jumpHeightWave = 0;
        this.jumpHeight = 0;
      }

      get isJumping(){
        return this.isJump;
      }

      set isJumping(value){
        this.isJump = value;
      }

      get getSprite(){
        return this.sprite;
      }

      get getX(){
        return this.x;
      }
      set setX(value){
        this.x = value;
      }
      get getY(){
        return this.y;
      }
      set setY(value){
        this.y = value;
      }

      jump(){
        this.isJumping = true;
      }

      update(){
        if(this.isJumping){
          this.jumpHeightWave += 1;
        }
        this.jumpHeight = Math.sin(this.jumpHeightWave*0.1)*100;
        if(this.jumpHeight <= 0){
          this.jumpHeight = 0;
          this.jumpHeightWave = 0;
          this.isJumping = false;
        }
        this.sprite.y = this.y + this.jumpHeight;
      }
    }

    class worldCamera {
      constructor(sprite,x,y){
        this.sprite = sprite;
        this.x = x;
        this.y = y;
        this.sprite.x = this.x;
        this.sprite.y = this.y;
        this.isJump = false;
        this.jumpHeightWave = 0;
        this.jumpHeight = 0;
        this._jumpSpeed = 0.05;
        this._jumpSpeedLimit = 0.1;
      }

      resetJumpSpeed(){
        this._jumpSpeed = 0.01;
      }

      set jumpSpeed(value){
        if(value>=this._jumpSpeedLimit){
          this._jumpSpeed = this._jumpSpeedLimit;
        }else{
          this._jumpSpeed = value;
        }
      }

      get jumpSpeed(){
        return this._jumpSpeed;
      }

      jump(){
        this.isJumping = true;
      }

      update(){
        if(this.isJumping){
          this.jumpHeightWave += 1;
        }
        this.jumpHeight = Math.sin(this.jumpHeightWave*this._jumpSpeed)*100;
        if(this.jumpHeight <= 0){
          this.jumpHeight = 0;
          this.jumpHeightWave = 0;
          this.isJumping = false;
        }
        this.sprite.y = this.y + this.jumpHeight;
        console.log(this._jumpSpeed);
      }
    }

    class Obstacle {
      constructor(sprite,x,y,letter,size){
        this.sprite = sprite;
        this.letter = letter;
        this.x = x;
        this.y = y;

        this.letter.anchor.set(0.35,0.35);
        this.updateLetter();
        this.updateSprite();
        this.sprite.scale.set(size,size);
      }
      get getX(){
        return this.x;
      }
      set setX(value){
        this.x = value;
      }
      get getY(){
        return this.y;
      }
      set setY(value){
        this.y = value;
      }
      get getLetter(){
        return this.letter;
      }
      get getSprite(){
        return this.sprite;
      }

      move(x,y){
        this.x = x;
        this.y = y;
        this.updateSprite();
        this.updateLetter();
      }

      updateSprite(){
        this.sprite.x = this.x;
        this.sprite.y = this.y;
      }

      updateLetter(){
        this.letter.x = this.x + 20;
        this.letter.y = this.y + 20;
      }

      checkCollision(x,y){

      }
    }

    function init(){
      p1 = new Player(new PIXI.Sprite.fromImage("img/shroom.png"),150,240);
      everythingContainer = new PIXI.Container();
      groundContainer = new PIXI.Container();
      background = new PIXI.Sprite.fromImage("img/BG.png");
      background.y -= 200;
      var groundTexture = PIXI.Texture.fromImage("img/floor.png");
      var lowerGroundTexture = PIXI.Texture.fromImage("img/lowerfloor.png");
      for(var i = 0; i < 20; i++){
        var tile = new PIXI.Sprite(groundTexture);
        var lowertile = new PIXI.Sprite(lowerGroundTexture);
        lowertile.x = 128 * i;
        lowertile.y = 128;
        tile.x = 128 * i;
        groundContainer.addChild(lowertile);
        groundContainer.addChild(tile);
      }
      groundContainer.y = 280;
      everythingContainer.addChild(background);
      everythingContainer.addChild(groundContainer);
    // everythingContainer.addChild(p1.getSprite);

      sourceLetters.forEach((letter,index)=>{
        obstacles.push(
          new Obstacle(
              new PIXI.Sprite.fromImage("img/crate.png"),
              800 + index * obstacleDistance,
              240,
              new PIXI.Text(letter,{
                fill:0xffffff,
                fontWeight: "bold",
                fontFamily: "Century Gothic",
                fontSize: 36
              }),
              0.7
            )
          );
        everythingContainer.addChild(obstacles[obstacles.length-1].getSprite);
        everythingContainer.addChild(obstacles[obstacles.length-1].getLetter);
      });

      app.stage.addChild(everythingContainer);
      app.stage.addChild(p1.getSprite);
      wc = new worldCamera(everythingContainer,0,0);

    }

    function moveObstacles(){
      moveSpeed += moveIncrement;
      obstacles.forEach((obstacle,index)=>{
        obstacle.move(obstacle.getX-moveSpeed,obstacle.getY);
      });
      if(groundContainer.x <= -1024){
        groundContainer.x = -128;
      }
      groundContainer.x -= moveSpeed;
      wc.update();
    }

    app.ticker.add(moveObstacles);

    init();

  </script>
</html>
