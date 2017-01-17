function toggle(id){
    text='<h1 class="label label-lg label-success"><span class="glyphicon glyphicon-ok"></span> Ausgewählt</h1> <span class="glyphicon glyphicon-arrow-right"></span>&nbsp';
    text2='';
    if(document.getElementById('selectinfo'+id).innerHTML==""){
        document.getElementById('selectinfo'+id).innerHTML=text;
        document.getElementById('select'+id).innerHTML='<span class="glyphicon glyphicon-minus-sign"></span> Auswahl aufheben';
        document.getElementById('select'+id).setAttribute("class","btn btn-danger");
        document.getElementById('input'+id).setAttribute("value","1");
    }else{
        document.getElementById('selectinfo'+id).innerHTML="";
        document.getElementById('select'+id).innerHTML='<span class="glyphicon glyphicon-plus-sign"></span> Auswählen';
        document.getElementById('select'+id).setAttribute("class","btn btn-success");
        document.getElementById('input'+id).setAttribute("value","0");
    }

}
