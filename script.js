var jsValue = document.getElementById('review').value

      

var stars= document.querySelector('.stars');




    for( var i=1;i<=5;i++){

        if(i <= jsValue){
            var newElement = document.createElement('h4');
            newElement.innerHTML= "&starf;";
               stars.appendChild(newElement);

        }

        else{
            var newElement = document.createElement('h4');
            newElement.innerHTML = "&star;";
          stars.appendChild(newElement);

        }

    }


