const cakeTabBtn = document.getElementById("cakes-tab-btn");
const drinksTabBtn = document.getElementById("drinks-tab-btn");
const merchTabBtn = document.getElementById("merch-tab-btn");
const otherTreatsTabBtn = document.getElementById("other-treats-tab-btn");

const cakesSection = document.getElementById("cakes-section");
const drinksSection = document.getElementById("drinks-section");
const merchSection = document.getElementById("merch-section");
const otherTreatsSection = document.getElementById("other-treats-section");

const page = document.getElementById("post-67");

page.addEventListener("click", function (e) {
    if (e.target.id === "cakes-tab-btn") {
        document.querySelector(".active").classList.remove("active");
        document
            .querySelector(".current-menu-tab")
            .classList.remove("current-menu-tab");
        cakesSection.classList.add("active");
        cakeTabBtn.classList.add("current-menu-tab");
        console.log("uwu");
    } else if (e.target.id === "drinks-tab-btn") {
        document.querySelector(".active").classList.remove("active");
        document
            .querySelector(".current-menu-tab")
            .classList.remove("current-menu-tab");

        drinksSection.classList.add("active");
        drinksTabBtn.classList.add("current-menu-tab");
    } else if (e.target.id === "merch-tab-btn") {
        document.querySelector(".active").classList.remove("active");
        document
            .querySelector(".current-menu-tab")
            .classList.remove("current-menu-tab");

        merchSection.classList.add("active");
        merchTabBtn.classList.add("current-menu-tab");
    } else if (e.target.id === "other-treats-tab-btn") {
        document.querySelector(".active").classList.remove("active");
        document
            .querySelector(".current-menu-tab")
            .classList.remove("current-menu-tab");

        otherTreatsSection.classList.add("active");
        otherTreatsTabBtn.classList.add("current-menu-tab");
    }
});

function defaultActiveClass() {
    cakesSection.classList.add("active");
    cakeTabBtn.classList.add("current-menu-tab");
    console.log("hi");
}

defaultActiveClass();
