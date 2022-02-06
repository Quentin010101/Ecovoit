function init() {

    // user Account
    const button1 = document.getElementById('button-info')
    const button2 = document.getElementById('button-pref')
    const button3 = document.getElementById('button-trajet')
    const button4 = document.getElementById('button-message')

    const section1 = document.getElementById('section-info')
    const section2 = document.getElementById('section-pref')
    const section3 = document.getElementById('section-trajet')
    const section4 = document.getElementById('section-message')

    // moderator Account
    const buttonM1 = document.getElementById('button-signalement')
    const buttonM2 = document.getElementById('button-bannissement')

    const sectionM1 = document.getElementById('section-signalement')
    const sectionM2 = document.getElementById('section-bannissement')


    if (button1 && button2 && button3 && button4) {
        var tabButton = [button1, button2, button3, button4]
        var tabSection = [section1, section2, section3, section4]
    }
    else if (buttonM1 && buttonM2) {
        var tabButton = [buttonM1, buttonM2]
        var tabSection = [sectionM1, sectionM2]

    }
    tabButton.forEach(function (element) {
        element.addEventListener('click', function () {
            let elementNb = nbElement(element)
            for (let i = 0; i < tabSection.length; i++) {
                if (i == elementNb) {
                    tabButton[i].classList.add('button3-show')
                    tabSection[i].classList.add('show-section')
                    tabSection[i].classList.remove('hide-section')
                }
                else {
                    tabButton[i].classList.remove('button3-show')
                    tabSection[i].classList.add('hide-section')
                    tabSection[i].classList.remove('show-section')
                }

            }
        })
    });

    function nbElement(element) {
        return tabButton.indexOf(element)
    }
}

window.addEventListener('DOMContentLoaded', init)