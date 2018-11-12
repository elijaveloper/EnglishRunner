<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Concert+One" rel="stylesheet">
    <style media="screen">
      body{
        background-color: #f9f9f9;
      }
      .section{
        margin: 40px;
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
        color:#4285F4;
      }
      input,textarea{
        font-family: 'Concert One';
        font-size: 1em;
        border-radius: 15px;
        border: 3px solid #ededed;
        padding: 10px;
        cursor: url("img/hand.png"), auto;
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
    </style>
  </head>
  <body>
    <div class="h1" id="title">
      Registration!
    </div>
    <div class="container">
    </div>

  </body>
  <script type="text/javascript">
    var Container = document.querySelector(".container");
    var Questions = "Name:30,Nickname:30,Age:4,Level:10,Section:4,Student Number:4,Gender:7,School:30,Favourite Subject:30,Favourite Food:30,Favourite Teacher:30".split(",");
    var Answers = "{";
    var Colors = "#4285F4,#DB4437,#F4B400,#0F9D58".split(",");
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
    var school = document.getElementById("School");
    Container.innerHTML += "<div class='section'><div class='row'><input type='button' id='submit' value='submit'></div></div>"
    var itr = 0;
    var Sections = document.getElementsByClassName("section");
    for(var i = 0; i < Sections.length; i++){
      Sections[i].style.color = Colors[itr];
      itr = itr < 3 ? itr + 1 : 0;
    }

    var Responses = document.getElementsByClassName("questions");
    var submitButton = document.getElementById("submit");
    submitButton.onclick = ()=>{
      for(var i=0; i < Responses.length; i++){
        var value = Responses[i].value;
        var id = Responses[i].id;
        Answers += "\""+id+"\":\""+value+"\"";
        Answers += (i == Responses.length - 1) ? "" : ",";
      }
      Answers += "}";
      var AnswersJSON = JSON.parse(Answers);
      console.log(AnswersJSON);
    };

  </script>
</html>
