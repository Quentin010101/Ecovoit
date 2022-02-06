function init(){

    const croix = document.getElementById('croix')
    const messagerie = document.getElementById('messagerie')
    const buttonMessagerie = document.querySelector('.button-messagerie')

    if(croix){
        croix.addEventListener('click', function(){
            messagerie.classList.remove('messagerie-visible')
        })
    }
    if(buttonMessagerie){
        buttonMessagerie.addEventListener('click', function(){
            messagerie.classList.add('messagerie-visible')
        }) 
    }

}

window.addEventListener('DOMContentLoaded', init)