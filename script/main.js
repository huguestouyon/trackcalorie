// Date
let isDate = new Date()
let dateModi = ""
let kalDate = document.querySelector("#kaldate")
let dateSoustrait = isDate.getDate()-10
if(dateSoustrait < 10) {
    dateModi = "0"+(dateSoustrait+1)
} else {
    dateModi = dateSoustrait+1
}


// Calendar min & max element
let d = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+isDate.getDate()
let da = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+dateModi
kalDate.setAttribute("min", da)
kalDate.setAttribute("max", d)

// Modifie la couleur de fond 
let imc = document.querySelector(".title-imc")
let textImc = document.querySelector(".title-imc-text")
if(imc.innerHTML < 18.5) {
    imc.style.backgroundColor = "#41B7D8"
    textImc.innerHTML = "Maigreur"
}
if(imc.innerHTML >=18.5 && imc.innerHTML <= 25) {
    imc.style.backgroundColor = "#109618"
    textImc.innerHTML = "Corpulence normale"
    textImc.style.marginLeft = "70px";
}
if(imc.innerHTML > 25 && imc.innerHTML <= 30) {
    imc.style.backgroundColor = "#F90"
    textImc.innerHTML = "Surpoids"
}
if(imc.innerHTML > 30) {
    imc.style.backgroundColor = "#DC3912"
    textImc.innerHTML = "Obésité modérée"
}


