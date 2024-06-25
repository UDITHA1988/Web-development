const hamburger = document.querySelector(".hamburger");
const hamMenu = document.querySelector(".ham-menu");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    hamMenu.classList.toggle("active");
})

document.querySelectorAll(".nav - link").forEach(n => n.
    addEventListener("click", () => {
        hamburger.classList.remove("active");
        hamMenu.classList.remove("active");
    }))