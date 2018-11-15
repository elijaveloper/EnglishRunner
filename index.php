<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Concert+One" rel="stylesheet">
    <style media="screen">
      body{
        background-color: #DB4437;
        padding: 40px;
        text-align:center;
      }
      .section{
        display: inline-block;
        margin: 20px;
        padding: 2em;
        /* background-color: #f9f9f9; */
        text-align: center;
      }
      .row{
        font-family: 'Concert One';
        font-size: 4em;
      }
      #title{
        font-family: 'Concert One';
        font-size: 4em;
        text-align: center;
        margin: 40px;
        color:#ffffff;
      }
      input,textarea{
        font-family: 'Concert One';
        font-size: 1em;
        border-radius: 15px;
        border: 3px solid #ededed;
        padding: 10px;
        cursor: url("img/hand.png"), auto;
        background-color: #f0f0f0;
      }
      input[type=text]:focus, textarea:focus {
        outline:none;
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
        border: 3px solid rgba(81, 203, 238, 1);
        /* padding: 3px 0px 3px 3px;
        margin: 5px 1px 3px 0px;
        border: 1px solid rgba(81, 203, 238, 1); */
      }

      #submit{
        /* border: 3px solid rgba(81, 203, 238, 1); */
        display:none;
        outline:none;
        border: 1px solid #4285F4;
        background-color: #4285F4;
        color: #FFFFFF;
        padding: 25px;
        cursor: url("img/hand.png"), auto;
        box-shadow: 0px 9px 0px #2142a2, 0px 9px 25px rgba(0,0,0,.7);
      }

      #submit:active {
          box-shadow: 0px 3px 0px #2142a2, 0px 3px 6px rgba(0,0,0,.9);
          position: relative;
          top: 6px;
      }

      .container{
        text-align: center;
        margin: auto;
        background-color: #ffffff;
        max-width: 80%;
        box-shadow: 0px 9px 25px rgba(0,0,0,.3);
      }
    </style>
  </head>
  <body>
    <div class="h1" id="title">
      Registration!
    </div>
    <!-- <div class='section'><div class='row'><input type='button' id='initp1' value='P1'><input type='button' id='initp2' value='P2'></div></div> -->
    <div class="container" id="container-main">
    </div>
    <div class='section'><div class='row'><input type='button' id='submit' value='Submit'></div></div>
  </body>
  <script type="text/javascript">


    var Container = document.querySelector(".container");
    var QuestionStringP1 = "Name:30,Nickname:30,Age:4,Level:10,Section:4,Student Number:4,Gender:7,School:30".split(",");
    var QuestionStringP2 = "Name:30,Nickname:30,Age:4,Level:10,Section:4,Student Number:4,Gender:7,School:30,Favourite Subject:30,Favourite Food:30,Favourite Teacher:30".split(",");
    var Colors = "#4285F4,#DB4437,#F4B400,#0F9D58".split(",");

    function initQuestions(Questions){
      Questions.forEach((question,i) => {
        question = question.split(":");
        if(question[0] == "School"){
          Container.innerHTML += "<div class='section'><div class='row'>"+question[0]+"</div>" +
            "<div class='row'><textarea class='questions' id='"+question[0].split(" ").join("")+"' name='"+question[0]+"' cols='"+question[1]+" rows=2'></textarea></div></div>";
        }else{
          Container.innerHTML += "<div class='section'><div class='row'>"+question[0]+"</div>" +
          "<div class='row'><input class='questions' id='"+question[0].split(" ").join("")+"' type='text' name='"+question[0]+"' size='"+question[1]+"'/></div></div>";
        }
      });

      var itr = 0;
      var Sections = document.getElementsByClassName("section");
      for(var i = 0; i < Sections.length; i++){
        Sections[i].style.color = Colors[itr];
        itr = itr < 3 ? itr + 1 : 0;
      }
    }

    initQuestions(QuestionStringP1);
    var submitButton = document.getElementById("submit");
    submitButton.style.display = "inline-block";
    var isSubmitted = false;

    submitButton.onclick = ()=>{
      if(!isSubmitted){
        isSubmitted = !isSubmitted;
        submitButton.value = "...";
        var json_upload = "package=" + JSON.stringify(getJSONByInputClass("questions"));
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
