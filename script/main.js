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
console.log(dateModi)

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
    containerImc.style.marginRight = "2.5rem"
}
if(imc.innerHTML >=18.5 && imc.innerHTML <= 25) {
    imc.style.backgroundColor = "#109618"
    textImc.innerHTML = "Corpulence normale"
    textImc.style.marginLeft = "70px"
    containerImc.style.marginRight = "3.5rem"
}
if(imc.innerHTML > 25 && imc.innerHTML <= 30) {
    imc.style.backgroundColor = "#F90"
    textImc.innerHTML = "Surpoids"
    containerImc.style.marginRight = "2.5rem"
}
if(imc.innerHTML > 30 && imc.innerHTML <= 35) {
    imc.style.backgroundColor = "#DC3912"
    textImc.innerHTML = "Obésité modérée"
    containerImc.style.marginRight = "2.5rem"
}
if(imc.innerHTML > 35 && imc.innerHTML <= 40) {
    imc.style.backgroundColor = "#AB2A16"
    textImc.innerHTML = "Obésité sévère"
    containerImc.style.marginRight = "2.5rem"
}
if(imc.innerHTML > 40) {
    imc.style.backgroundColor = "#811313"
    textImc.innerHTML = "Obésité morbide"
    containerImc.style.marginRight = "2.5rem";
}



