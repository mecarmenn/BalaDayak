function showC(str) {
        
    var res = str.replace(/\D/g, "");
    res = parseInt(res);
        
    tempOrderID = document.getElementsByClassName('OrderIDC');
    for (i=0; i < tempOrderID.length; i++){
        if (res == i){
            
            var OrderID = tempOrderID[i].value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("text").innerHTML = this.responseText;
            }
            };
            xmlhttp.open("GET", "orderDetail.php?OrderID=" + OrderID, true);
            xmlhttp.send();
            break;
            }
        }  
}

function updateC(str) {
        
    var res = str.replace(/\D/g, "");
    res = parseInt(res);
        
    tempOrderID = document.getElementsByClassName('OrderIDC');
    tempPaymentStatusDetails = document.getElementsByClassName('PaymentStatusListC');
    tempOrderStatusDetails = document.getElementsByClassName('OrderStatusListC');
    for (i=0; i < tempOrderID.length; i++){
        if (res == i){
            var OrderID = tempOrderID[i].value;
            var PaymentStatusDetails = tempPaymentStatusDetails[i].value;
            var OrderStatusDetails = tempOrderStatusDetails[i].value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("responseText").innerHTML = this.responseText;
            }
            };
            xmlhttp.open("GET", "orderUpdate.php?OrderID=" + OrderID + "&PaymentStatusDetails=" + PaymentStatusDetails + "&OrderStatusDetails=" + OrderStatusDetails, true);
            xmlhttp.send();
            break;
            }
        }  
}