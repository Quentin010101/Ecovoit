function init() {
    const cityStart = document.getElementById('post_ride_startingPlace')
    const distanceHidden = document.getElementById('post_ride_tripDistance')
    const timeHidden = document.getElementById('post_ride_tripDuration')
    const cityEnd = document.getElementById('post_ride_endingPlace')
    
    let arrStockage = []
    let arrStartTemp =[]
    let arrEndTemp =[]

    if(cityStart && cityEnd){
        [cityStart, cityEnd].forEach(function(element){

            element.addEventListener('input', function(){
                let search = element.value
                if(search != ''){
                    request(search, element)
                }else{
                    supressChild()
                }
            })

            element.addEventListener('change', function(){
                setTimeout(() => {
                    if(arrEndTemp.length !== 0 && arrStartTemp !== 0 ){
                        findDistance(arrStartTemp[0],arrStartTemp[1], arrEndTemp[0],arrEndTemp[1])
                    }
                }, 500);
            })
        })


        
    }
    // Requete fetch
    function request(search, element){
        let adresse = "https://api-adresse.data.gouv.fr/search/?q=" + search + "&limit=5&type=municipality"
        fetch(adresse).then(
            function (response) {
                return response.json()
            }).then(
                function (data) {
                    analyse(data, element)
                }
            )       
    }
    //Stockage des informations recu dans un tableau
    function analyse(parm, element){
       let data = parm.features
       arrStockage = []
       for(let i = 0; i< data.length; i++){
            let cityName = data[i].properties.city
            let longitude = data[i].geometry.coordinates[0]
            let latitude = data[i].geometry.coordinates[1]
            let city = [cityName, [latitude, longitude]]

            arrStockage.push(city)
       }
       supressChild()
       showResult(arrStockage, element) 
    }
    //Affichage des resultat dans un menu sous l'input ciblé
    function showResult(parm, element){
        let nbLine = parm.length
        let liste = document.createElement('ul')
        //récupération du menu
        menu = element.parentElement.nextElementSibling
        liste.id = 'ul'
        menu.appendChild(liste)
        for(let i = 0; i< nbLine; i++){
            const line = document.createElement('li')
            line.innerText = arrStockage[i][0]
            liste.appendChild(line)

            line.addEventListener('click', function(){
                saveValue(i, element)
                element.value = line.innerText                   
                supressChild()
            })
        }
        document.body.addEventListener('click', function(e){
            if(e.target !== menu){
                supressChild()
            }
        })
    }
    //Suppression du menu
    function supressChild(){
        let liste = document.querySelector('#ul')
        if(liste){
            liste.remove()
        }
    }
    function findDistance(originLat, originLong, endLat, endLong){
        console.log('u')
        if(originLat !== '' && originLong !== '' && endLat !== '' && endLong !== ''){
            let key = '700137fa0413a4b536748e0dcd1a2927'
            fetch('https://maps.open-street.com/api/route/?origin=' + originLat + ',' + originLong + '&destination=' + endLat + ',' + endLong + '&mode=driving&key=' + key)
            .then(function(response){ return response.json()}).then(function(data){ analyseDistance(data)})
        }
    }
    //Enregistrer les valeur 
    function saveValue(parm, element){
        if(element == cityStart){
            arrStartTemp = []
            arrStartTemp = arrStockage[parm][1]
        }
        else if(element == cityEnd){
            arrEndTemp = []
            arrEndTemp = arrStockage[parm][1]
        }
    }
    //analyser la distance
    function analyseDistance(data){
        console.log('r')
        let distance = data.total_distance
        let time = data.total_time
        console.log(distance)
        saveDistance(distance, time)
    }
    //enregistrer dans les champs hidden
    function saveDistance(distance, time){
        let d = Math.round(distance/1000)
        let t = Math.round(time)

        distanceHidden.value = d
        timeHidden.value = t
    }


    

}

window.addEventListener('DOMContentLoaded', init)