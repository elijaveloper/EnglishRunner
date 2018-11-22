<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Concert+One" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body class="background-color-green">
    <div class="h1" id="title">
      Register
    </div>
    <div class="container" id="register-container">
      <div class="section">
        <div class="row">
          example:
          <span class="text-color-red">y61</span>
          <span class="text-color-green">p1/1</span>
          <span class="text-color-blue">n36</span>
        </div>
      </div>
      <div class="section">
        <div class="row">
          <span class="text-color-red">Username</span>
          <input type="text" id="username" class="questions" name="username" value="" placeholder="y61p1/1n36">
        </div>
      </div>
      <div class="section">
        <div class="row">
          example: 00000000
        </div>
      </div>
      <div class="section">
        <div class="row">
          <span class="text-color-green">Password</span>
          <input type="password" class="questions" id="password" name="password" value="">
        </div>
      </div>
      <div class="container" id="personalinfo-container">
        <div class="section">
          <div class="row">
            Information
          </div>
        </div>
      </div>
    </div>
    <div class='section'>
      <div class='row'>
        <input type='button' id='submit' value='Submit'>
      </div>
    </div>
  </body>
  <script type="text/javascript">
    document.getElementById("submit").style.display = "block";
    var InfoContainer = document.querySelector("#personalinfo-container");
    var submitButton = document.getElementById("submit");
    var QuestionString = "Name:20,Nickname:20,Age:4,Level:10,Section:4,Student Number:4,Gender:7,Favourite Subject:20".split(",");

    function initQuestions(Questions,cntr){
      Questions.forEach((question,i) => {
        question = question.split(":");
        if(question[0] == "School"){
          cntr.innerHTML += "<div class='section'><div class='row'>"+question[0]+"</div>" +
            "<div class='row'><textarea class='questions' id='"+question[0].split(" ").join("")+"' name='"+question[0]+"' cols='"+question[1]+" rows=2'></textarea></div></div>";
        }else{
          cntr.innerHTML += "<div class='section'><div class='row'>"+question[0]+"</div>" +
          "<div class='row'><input class='questions' id='"+question[0].split(" ").join("")+"' type='text' name='"+question[0]+"' size='"+question[1]+"'/></div></div>";
        }
      });
    }

    function rainbowColorsByClass(className,colors){
      colors = colors || "#4285F4,#DB4437,#F4B400,#0F9D58".split(",");
      var itr = 0;
      var Sections = document.getElementsByClassName(className);
      for(var i = 0; i < Sections.length; i++){
        Sections[i].style.color = colors[itr];
        itr = itr < colors.length-1 ? itr + 1 : 0;
      }
    }

    //init

    initQuestions(QuestionString,InfoContainer);

    function sendPackage(destination,json_upload, callback){
      var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
      xmlhttp.open("POST", destination);
      xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xmlhttp.send(json_upload);
      xmlhttp.onreadystatechange = function()
      {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
          {
              callback();
          }
      };
    }

    function getJSONByInputClass(className){
      var Responses = document.getElementsByClassName(className);
      var Answers = "{";
      for(var i=0; i < Responses.length; i++){
        var value = Responses[i].value;
        var id = Responses[i].id;
        Answers += "\""+id+"\":\""+value+"\"";
        Answers += (i == Responses.length - 1) ? "" : ",";
      }
      Answers += "}";
      return JSON.parse(Answers);
    }

    //let it all be sent!
    var isSubmitted = false;
    submitButton.onclick = ()=>{
      if(!isSubmitted){
        isSubmitted = !isSubmitted;
        submitButton.value = "...";

        var temp = JSON.stringify(getJSONByInputClass("questions"));
        temp = temp.replaceAll("."," ");
        var json_upload = "package=" + temp;
        console.log(json_upload);

        sendPackage("write.php",json_upload,()=>{
          setTimeout(function(){submitButton.value = "Done!";},2000); // Another callback here
          document.getElementById("register-container").innerHTML = "";
        });

      }else{
          var finished = <?php if(isset($_GET['finished'])){echo "true";}else{echo "false";} ?>;
          if(finished){
              window.location.href = "http://enlearn.online/TypingTutor/etypinghome.php";
              //window.location.href = "http://localhost:8080/TypingTutor/etypinghome.php"
          }else{
              //window.location.href = "http://localhost:8080/views/register.php?finished=true";
              window.location = "http://enlearn.online/views/register.php?finished=true";
          }
      }
    }

    String.prototype.replaceAll = function (find, replace) {
      var str = this;
      return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };
  </script>
</html>
