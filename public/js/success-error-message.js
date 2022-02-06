
function init(){
    const croix = document.querySelector('.croix')
    const message = document.querySelector('.message-flash')

    if(message){
        setTimeout(() => {
            disappear(message)
            setTimeout(() => {
                displayNone(message)
            },3000)
        },3000)
    }
    if(croix){
        croix.addEventListener("click", function(){
            displayNone(message)
        })
    }
    
    function disappear(element){
        element.classList.add('message-disappear')
    }
    function displayNone(element){
        element.classList.add('message-display')
    }
}

window.addEventListener('DOMContentLoaded', init)