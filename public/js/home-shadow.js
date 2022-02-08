function init(){
    
    const section = document.querySelectorAll('section')

    function aplyShadow(){
        section.forEach(function(element){
            let top = element.getBoundingClientRect().top
            let bottom = element.getBoundingClientRect().bottom
            let middle = window.innerHeight/2

            if(top < middle && bottom > middle){
                element.querySelector('.container-text').classList.add('shadowShow')
            }else{
                element.querySelector('.container-text').classList.remove('shadowShow') 
            }
        })
    }
    window.addEventListener('scroll', aplyShadow)
}

window.addEventListener('DOMContentLoaded', init)