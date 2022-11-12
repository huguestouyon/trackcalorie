// Champs disable force > 10
let messLogError = document.querySelector(".log-error")
let inputPass = document.querySelector("#pass")
let inputEmail = document.querySelector("#email")
let inputBtn = document.querySelector(".btn-confirm")
if(messLogError !== null) {
    messLogError.style.color = "red";
    if(messLogError.innerHTML === "Trop de tentatives de connexions échoués") {
        inputEmail.setAttribute("disabled", "")
        inputPass.setAttribute("disabled", "")
        inputBtn.setAttribute("disabled", "")
    }
}
