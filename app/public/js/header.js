let hamburger = document.getElementsByClassName("navbar-burger")[0];
let mobile = document.getElementById("navbar-mobile");

hamburger.addEventListener("click", () => {
  if (hamburger.classList.contains("is-active")) {
    hamburger.classList.remove("is-active");
    mobile.classList.remove("is-active");
    mobile.classList.add("is-hidden");
  } else {
    hamburger.classList.add("is-active");
    mobile.classList.add("is-active");
    mobile.classList.remove("is-hidden");
  }
});
