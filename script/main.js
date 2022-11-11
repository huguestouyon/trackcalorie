function btnModal(nameModal, nameBtn) {
    var modal = document.getElementById(nameModal);

    // Get the button that opens the modal
    var btn = document.getElementById(nameBtn);

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

btnModal("modalkal","add-kal")

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
let d = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+isDate.getDate()
let da = isDate.getFullYear()+"-"+(isDate.getMonth()+1)+"-"+dateModi
kalDate.setAttribute("min", da)
kalDate.setAttribute("max", d)