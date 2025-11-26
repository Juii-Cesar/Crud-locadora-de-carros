const html = document.querySelector("html");
const trilho = document.getElementById("trilho");

trilho.addEventListener("click",function(){
    html.classList.toggle("light-mode")
    trilho.classList.toggle("light-mode")
})