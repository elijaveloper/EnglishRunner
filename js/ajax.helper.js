class AjaxUtil{
  constructor(){
    this.ajax = new XMLHttpRequest();
  }

  sendJSON(file,json,callback){
    callback = callback || (){};
    this.ajax.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            callback();
        }
    }
    this.ajax.open("POST", file);
    this.ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    this.ajax.send(json);
  }

  getJSON(file,callback){
    callback = callback || (){};
    this.ajax.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            callback();
        }
    }
    this.ajax.open("GET", file);
    this.ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    this.ajax.send(json);
  }
}
