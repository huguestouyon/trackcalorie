// Date
let isDate = new Date()
let dateModi = ""
let kalDate = document.querySelector("#kaldate")
let dateSoustrait = isDate.getDate()-10
if(dateSoustrait < 10) {
    dateModi = "0"+dateSoustrait
} else {
    dateModi = dateSoustrait
}


// Calendar min & max element
let d = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+isDate.getDate()
let da = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+dateModi
kalDate.setAttribute("min", da)
kalDate.setAttribute("max", d)

