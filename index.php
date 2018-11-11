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
      input{
        font-family: 'Concert One';
        font-size: 1em;
        border-radius: 15px;
        border: 3px solid #ededed;
        padding: 10px;
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
        cursor: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/9632/happy.png"), auto;
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
    <div class="container">
    </div>

  </body>
  <script type="text/javascript">
    console.log("here");
    var Container = document.querySelector(".container");
    var Questions = "Name:30,Nickname:30,Age:4,Level:8,Section:4,Student Number:4,Gender:4,School:30,Favourite Subject:30,Favourite Food:30,Favourite Teacher:30".split(",");
    var Colors = "#4285F4,#DB4437,#F4B400,#0F9D58".split(",");
    Questions.forEach((question,i) => {
      question = question.split(":");
      Container.innerHTML += "<div class='section'><div class='row'>"+question[0]+"</div>" +
      "<div class='row'><input type='text' name='"+question[0]+"' size="+question[1]+"/></div></div>";
    });
    Container.innerHTML += "<div class='section'><div class='row'><input type='button' id='submit' value='submit'></div></div>"
    var itr = 0;
    var Sections = document.getElementsByClassName("section");
    for(var i = 0; i < Sections.length; i++){
      Sections[i].style.color = Colors[itr];
      itr = itr < 3 ? itr + 1 : 0;
    }
  </script>
</html>
