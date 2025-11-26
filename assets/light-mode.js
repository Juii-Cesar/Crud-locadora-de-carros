const html = document.querySelector("html");
const trilho = document.getElementById("trilho");


const temaSalvo = localStorage.getItem("tema");

if (temaSalvo === "light") {
    html.classList.add("light-mode");
    trilho.classList.add("light-mode");
}


trilho.addEventListener("click", function () {
    html.classList.toggle("light-mode");
    trilho.classList.toggle("light-mode");

 
    if (html.classList.contains("light-mode")) {
        localStorage.setItem("tema", "light");
    } else {
        localStorage.setItem("tema", "dark");
    }
});