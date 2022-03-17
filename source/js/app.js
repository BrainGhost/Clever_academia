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
const closeNotification = document.querySelector("#close-nft");

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
  if (event.target == closeNotification) {
    closeNotification.classList.toggle("hidden");
  }
};
// The modal will close when the user clicks on the close button
btnClose.forEach((item) => {
  item.addEventListener("click", () => {
    modalOpen.classList.toggle("hidden");
    myModal.classList.toggle("hidden");
  });
});

//Close notification
// console.log(closeNotification);

//user dropdown
const dropdown_button = document.querySelector(".dropdown_button");
const dropdown_subMenu = document.querySelector(".dropdown_menu");
const user_icon = document.querySelector(".user_icon");

dropdown_button.addEventListener("click", () => {
  dropdown_subMenu.classList.toggle("hidden");
  user_icon.classList.toggle("outline");
});

//Disply image admin -> doctor profile

function displayImage(e) {
  if (e.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => {
      document
        .querySelector("#imageDisplay")
        .setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}
