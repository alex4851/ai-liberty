const menuHamburger = document.querySelector(".nav .menu-hamburger")
const navBar = document.querySelector(".nav .nav-bar")

menuHamburger.addEventListener('click',()=>{
navBar.classList.toggle('mobile-menu')
})