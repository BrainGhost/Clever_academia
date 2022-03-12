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
//openModal
const openModalBtn = document.querySelector(".openModalBtn");
const modalOpen = document.querySelector(".modalOpen");
const myModal = document.querySelector("#my-modal");
const btnClose = document.querySelectorAll(".btn-close");

console.log(btnClose);
openModalBtn.addEventListener("click", () => {
  modalOpen.classList.toggle("hidden");
  myModal.classList.toggle("hidden");
});
// The modal will close when the user clicks anywhere outside the modal
window.onclick = function (event) {
  if (event.target == myModal) {
    modalOpen.classList.toggle("hidden");
    myModal.classList.toggle("hidden");
  }
};
// The modal will close when the user clicks on the close button
btnClose.forEach((item) => {
  item.addEventListener("click", () => {
    modalOpen.classList.toggle("hidden");
    myModal.classList.toggle("hidden");
  });
});
