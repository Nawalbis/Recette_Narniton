'use strict';

function main(){
    setInterval(ajaxRequest, 1000, 'GET', 'php/timestamp.php', displayTimestamp);
}

function ajaxRequest(type, url, callback, data=null){
    let xhr = new XMLHttpRequest(); 
    xhr.open(type, url); 
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 
    xhr.onload = () => { // callback appelé quand la réponse est reçue   
                        switch (xhr.status){      
                            case 200:     
                            case 201:
                                console.log(xhr.responseText); 
                                if (callback)
                                    callback(xhr.responseText);
                                break;     

                            default: console.log('HTTP error: ' + xhr.status);  
                        } 
                    }; // Send XML HTTP request. 
    xhr.send(data);
}

function displayTimestamp(timestamp){

    document.getElementById('timestamp').innerHTML = timestamp;
}

window.onload = main;
