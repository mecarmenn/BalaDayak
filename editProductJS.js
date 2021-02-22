
function showUser(str) {
    if(document.getElementById("editProductForm").innerHTML != ""){
        document.getElementById("editProductForm").innerHTML = "";
    }
    if (str=="") {
        document.getElementById("ProductDetails").innerHTML="No Product Was Chosen";
        return;
    }
    
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
        document.getElementById("ProductDetails").innerHTML=this.responseText;
        }
    }
    xmlhttp.open("GET","getProductDetail.php?ProductID="+str,true);
    xmlhttp.send();
}
function remove(str) {
        
    var res = str.replace(/\D/g, "");
    res = parseInt(res);
        
    tempImageName = document.getElementsByClassName('ImageName');
        
    for (i=0; i < tempImageName.length; i++){
        if (res == i){
            var ImageName = tempImageName[i].value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ProductDetails").innerHTML = this.responseText;
            }
            };
            xmlhttp.open("GET", "removeImage.php?ImageName=" + ImageName, true);
            xmlhttp.send();
            break;
        }
    }
    alert("Image Deleted");
    location.reload();
}

function change(str) { //without page reload
        
    var res = str.replace(/\D/g, "");
    res = parseInt(res);
/*
    var files = document.getElementById("fileChange").files;

    if(files.length > 0 ){

        var formData = new FormData();
        formData.append("fileChange", files[0]);

        var xhttp = new XMLHttpRequest();

        // Set POST method and ajax file path
        xhttp.open("POST", "changeImage.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

            var response = this.responseText;
            if(response == 1){
                alert("Change successfully.");
            }else{
                alert("Change Unsuccesful");
            }
            }
        };

        // Send request with data
        xhttp.send(formData);

    } */
        
    tempImageName = document.getElementsByClassName('ImageName');
        
    for (i=0; i < tempImageName.length; i++){
        if (res == i){
            var ImageName = tempImageName[i].value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ProductDetails").innerHTML = this.responseText;
            }
            };
            xmlhttp.open("GET", "removeImage.php?ImageName=" + ImageName, true);
            xmlhttp.send();
            break;
        }
    }
    alert("Image Deleted");
}
