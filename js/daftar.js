// Micro-interactions for form inputs
const inputs = document.querySelectorAll("input");
inputs.forEach((input) => {
  input.addEventListener("focus", () => {
    input.parentElement.parentElement
      .querySelector("label")
      .classList.add("text-primary");
    input.parentElement.querySelector("span").classList.add("text-primary");
    input.parentElement.querySelector("span").style.fontVariationSettings =
      "'FILL' 1";
  });
  input.addEventListener("blur", () => {
    input.parentElement.parentElement
      .querySelector("label")
      .classList.remove("text-primary");
    input.parentElement.querySelector("span").classList.remove("text-primary");
    input.parentElement.querySelector("span").style.fontVariationSettings =
      "'FILL' 0";
  });
});
