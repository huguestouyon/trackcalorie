// Chart 
let chart = document.querySelectorAll("span")
let row = document.querySelectorAll("td")
let i = 0
chart.forEach(element => {
    console.log(element.length)
    if(element.innerHTML <= 6000) {
        row[i].style.background = "#32CD32";
    }
    if(element.innerHTML > 6000 && element.innerHTML <= 8000) {
        row[i].style.background = "#FF8000";
    }
    if(element.innerHTML > 8000) {
        row[i].style.background = "#F80000";
    }
    i++
});
let column = document.querySelector(".column")
column.style.maxWidth = row.length*120+"px"

