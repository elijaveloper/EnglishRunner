<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Concert+One" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body class="background-color-red">
    <div class="h1" id="title">
      Registration!
    </div>
    <div class='section'><div class='row'><input type='button' id='video' value='Watch Video' style="display:block"></div></div>
    <div class='section'><div class='row'><input type='button' id='helper' value='Need help?' style="display:block"></div></div>
    <!-- <div class='section'><div class='row'><input type='button' id='initp1' value='P1'><input type='button' id='initp2' value='P2'></div></div> -->
    <div class="container" id="container-main">
    </div>
    <div class='section'><div class='row'><input type='button' id='submit' value='Submit'></div></div>
  </body>
  <script type="text/javascript">
    String.prototype.replaceAll = function (find, replace) {
      var str = this;
      return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    var videoLink = "https://youtu.be/T-tY8rsxoJA";
    var helperLink = "http://enlearn.online/r.png";

    var Container = document.querySelector(".container");
    var QuestionStringP1 = "Name:30,Nickname:30,Age:4,Level:10,Section:4,Student Number:4,Gender:7,School:30".split(",");
    var QuestionStringP2 = "Name:30,Nickname:30,Age:4,Level:10,Section:4,Student Number:4,Gender:7,School:30,Favourite Subject:30,Favourite Food:30,Favourite Teacher:30".split(",");
    var Colors = "#4285F4,#DB4437,#F4B400,#0F9D58".split(",");

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

      rainbowColorsByClass("section",Colors);
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

    //initiation starts here
    initQuestions(QuestionStringP2,Container);

    var submitButton = document.getElementById("submit");
    var videoButton = document.getElementById("video");
    var helperButton = document.getElementById("helper");
    submitButton.style.display = "inline-block";
    var isSubmitted = false;

    videoButton.onclick = ()=>{
        window.open(videoLink);
    }

    helperButton.onclick = ()=>{
        window.open(helperLink);
    }

    submitButton.onclick = ()=>{
      if(!isSubmitted){
        isSubmitted = !isSubmitted;
        submitButton.value = "...";

        var temp = JSON.stringify(getJSONByInputClass("questions"));
        temp = temp.replaceAll("."," ");
        var json_upload = "package=" + temp;
        console.log(json_upload);

        var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
        xmlhttp.open("POST", "write.php");
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(json_upload);
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                setTimeout(function(){submitButton.value = "Done!";},2000); // Another callback here
                document.getElementById("container-main").innerHTML = "";
            }
        };
      }else{
        var finished = <?php if(isset($_GET['finished'])){echo "true";}else{echo "false";} ?>;
        if(finished){
            window.location.href = "http://enlearn.online/TypingTutor/etypinghome.php";
        }else{
            window.location = "http://enlearn.online?finished=true";
        }
      }
    };

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

  </script>
</html>
