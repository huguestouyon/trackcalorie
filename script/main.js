// Date
let isDate = new Date()
let dateModi = ""
let kalDate = document.querySelector("#kaldate")
let dateSoustrait = isDate.getDate()-10
if(dateSoustrait < 9) {
    dateModi = "0"+(dateSoustrait+1)
} else {
    dateModi = dateSoustrait+1
}

// Calendar min & max element
let d = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+isDate.getDate()
let da = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+dateModi
kalDate.setAttribute("min", da)
kalDate.setAttribute("max", d)
document.querySelector("#supprdate").setAttribute("min", da)
document.querySelector("#supprdate").setAttribute("max", d)

// Modifie la couleur de fond 
let imc = document.querySelector(".title-imc")
let textImc = document.querySelector(".title-imc-text")
let containerImc = document.querySelector(".container-index-title")
if(imc.innerHTML < 18.5) {
    imc.style.backgroundColor = "#41B7D8"
    textImc.innerHTML = "Maigreur"
}
if(imc.innerHTML >=18.5 && imc.innerHTML <= 25) {
    imc.style.backgroundColor = "#109618"
    textImc.innerHTML = "Corpulence normale"
    textImc.style.marginLeft = "70px"
}
if(imc.innerHTML > 25 && imc.innerHTML <= 30) {
    imc.style.backgroundColor = "#F90"
    textImc.innerHTML = "Surpoids"
}
if(imc.innerHTML > 30 && imc.innerHTML <= 35) {
    imc.style.backgroundColor = "#DC3912"
    textImc.innerHTML = "Obésité modérée"
}
if(imc.innerHTML > 35 && imc.innerHTML <= 40) {
    imc.style.backgroundColor = "#AB2A16"
    textImc.innerHTML = "Obésité sévère"
}
if(imc.innerHTML > 40) {
    imc.style.backgroundColor = "#811313"
    textImc.innerHTML = "Obésité morbide"
}

// Profil

let profilButton = document.querySelector(".profil-button")
let profilMenu = document.querySelector(".menu-profil")
let arrow = document.querySelector(".icono")
profilButton.addEventListener("click", showProfil)
function showProfil(){
    if (profilMenu.style.display !== "flex") {
        profilMenu.style.display = "flex"
        document.querySelector('.identity-card').className = 'play1';
        arrow.style.transition = "all .5s";
        arrow.style.color ="#FFC700"
    }

    else if (profilMenu.style.display !== "none") {
        profilMenu.style.display = "none"
        document.querySelector('.play1').className = 'identity-card';
        arrow.style.transition = "all .5s";
        arrow.style.color = "#7C7C7C"
    }
}

profilButton.addEventListener("mouseover", hoverffc700)
function hoverffc700(){
        arrow.style.transition = "all .5s";
        arrow.style.color = "#FFC700"
}
profilButton.addEventListener("mouseleave", hover7c7c7c)
function hover7c7c7c(){
    if (profilMenu.style.display !== "flex"){
        arrow.style.transition = "all .5s";
        arrow.style.color = "#7C7C7C" 
    }
}

