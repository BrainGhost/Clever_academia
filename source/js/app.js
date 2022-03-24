// VARAIBLE DECLARATION
const modalUsed = document.querySelector("#confirm-modal");
const modalClose = document.querySelector("#confirm-modal-close");
// VARAIBLE DELETE USE MODAL
const modalUsed_delete = document.querySelector("#confirm-delete-modal");
const modalClose_delete = document.querySelector("#confirm-delete-modal-close");
//Open mobile sidebar
const toggleSideMenu = document.querySelector("#toggleSideMenu");
const closeSideMenu = document.querySelector("#closeSideMenu");
const backdrop = document.querySelector("#isSideMenuOpen");

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
const openModalBtn_update = document.querySelectorAll("[data-userid]");

const modalOpen = document.querySelector(".modalOpen");
const modalOpen_update = document.querySelector(".modalOpen_update");
const myModal = document.querySelector("#my-modal");
const btnClose = document.querySelectorAll(".btn-close");
const btnClose_update = document.querySelectorAll(".btn-close-update");
const closeNotification = document.querySelector("#close-nft");

openModalBtn.addEventListener("click", () => {
  modalOpen.classList.toggle("hidden");
  myModal.classList.toggle("hidden");
});
//lemme create a hidden input and pass that e.ID
let inputField = document.createElement("input");
const formModal = document.querySelector("#modalIMP");
const updateID = document.querySelector("#updateID");
updateID.setAttribute("value", "junior");

openModalBtn_update.forEach((btn) => {
  btn.addEventListener("click", () => {
    modalOpen_update.classList.toggle("hidden");
    myModal.classList.toggle("hidden");
    inputField.remove();
  });
});
//update function
function displayModal(e) {
  modalOpen_update.classList.toggle("hidden");
  myModal.classList.toggle("hidden");

  inputField.setAttribute("type", "hidden");
  updateID.setAttribute("value", e);
  inputField.setAttribute("value", e);
  inputField.setAttribute("name", "update_id");

  inputField.setAttribute("readOnly", true);
  //apend this field to the modal
  formModal.appendChild(inputField);
}

// The modal will close when the user clicks anywhere outside the modal
window.onclick = function (event) {
  if (event.target == myModal) {
    modalOpen.classList.add("hidden");
    myModal.classList.toggle("hidden");
    modalOpen_update.classList.add("hidden");
  }

  if (event.target == modalClose) {
    modalUsed.classList.toggle("hidden");
  }
  if (event.target == modalClose_delete) {
    modalUsed_delete.classList.toggle("hidden");
  }
  if (event.target == backdrop) {
    closeSideMenu.classList.toggle("-translate-x-[16rem]");
    backdrop.classList.toggle("hidden");
    toggleSideMenu.childNodes[1].classList.toggle("hidden");
    toggleSideMenu.childNodes[3].classList.toggle("hidden");
  }
};

// The modal will close when the user clicks on the close button
btnClose.forEach((item) => {
  item.addEventListener("click", () => {
    modalOpen.classList.toggle("hidden");
    myModal.classList.toggle("hidden");
  });
});
btnClose_update.forEach((item) => {
  item.addEventListener("click", () => {
    modalOpen_update.classList.toggle("hidden");
    myModal.classList.toggle("hidden");
  });
});

//Close notification
closeNotification.addEventListener("click", (e) => {
  closeNotification.parentNode.classList.toggle("hidden");
});

//user dropdown
const dropdown_button = document.querySelector(".dropdown_button");
const dropdown_subMenu = document.querySelector(".dropdown_menu");
const user_icon = document.querySelector(".user_icon");

dropdown_button.addEventListener("click", () => {
  dropdown_subMenu.classList.toggle("hidden");
  user_icon.classList.toggle("outline");
  console.log(toggleSideMenu);
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

// i need to create a function to open modal and close them
// i will passing the respective id attribute as parameters

function alertModal(e) {
  modalUsed.classList.toggle("hidden");
}
// =====================CONFIRM MODAL============================
function displayModal_inactive(e, status) {
  modalUsed_delete.classList.toggle("hidden");

  const updateSTATUS = document.querySelector("#updateSTATUS");
  const updateSTATUS_TEXT = document.querySelector("#updateSTATUS_TEXT");
  // updateSTATUS.setAttribute("value", e);
  updateSTATUS.setAttribute("value", e);
  updateSTATUS_TEXT.setAttribute("value", status);
}
// ======================END CONFIRM MODAL===========================
//Close function notifcation modal
function close_funct(e) {
  e.parentNode.parentNode.parentNode.parentNode.parentNode.classList.toggle(
    "hidden"
  );
}

toggleSideMenu.addEventListener("click", (e) => {
  e.target.childNodes[1].classList.toggle("hidden");
  e.target.childNodes[3].classList.toggle("hidden");

  closeSideMenu.classList.toggle("-translate-x-[16rem]");
  backdrop.classList.toggle("hidden");
});
