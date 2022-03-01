//whyChoice section

const button = document.querySelectorAll("[data-tab-target]");
const globalTab = document.querySelectorAll(".tab-panel");

button.forEach((btn) => {
  btn.addEventListener("click", () => {
    const target = document.querySelector(btn.dataset.tabTarget);

    globalTab.forEach((tabPanel) => {
      tabPanel.classList.remove("visible");
    });

    button.forEach((btn) => {
      btn.classList.remove("active");
    });
    btn.classList.add("active");
    target.classList.add("visible");
  });
});

// console.log(button);
