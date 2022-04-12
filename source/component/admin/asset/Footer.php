        </main>
      </div>
    </div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!-- <script src="../../js/app.js"></script> -->
    <Script>
      //logout dropdown
      function dropdown_menu(e) {
        const dropdown_subMenu = document.querySelector(".dropdown_menu");
        const user_icon = document.querySelector(".user_icon");

        dropdown_subMenu.classList.toggle("hidden");
        user_icon.classList.toggle("outline");
      }
      //hamburger btn
      function toggleSideMenu(e) {
        const closeSideMenu = document.querySelector("#closeSideMenu");
        const backdrop = document.querySelector("#isSideMenuOpen");

        e.childNodes[1].classList.toggle("hidden");
        e.childNodes[3].classList.toggle("hidden");

        closeSideMenu.classList.toggle("-translate-x-[16rem]");
        backdrop.classList.toggle("hidden");
      }
      //displayModal_inactive
      const modalUsed_delete = document.querySelector("#confirm-delete-modal");
      function displayModal_inactive(e, status) {
        modalUsed_delete.classList.toggle("hidden");

        const updateSTATUS = document.querySelector("#updateSTATUS");
        const updateSTATUS_TEXT = document.querySelector("#updateSTATUS_TEXT");
        // updateSTATUS.setAttribute("value", e);
        updateSTATUS.setAttribute("value", e);
        updateSTATUS_TEXT.setAttribute("value", status);
      }
      // window events
      const modalClose_delete = document.querySelector("#confirm-delete-modal-close");
      window.onclick = function (event) {
        if (event.target == modalClose_delete) {
          modalUsed_delete.classList.toggle("hidden");
        }
      };
      //display image in the imageholder
      function displayImage(e) {
        if (e.files[0]) {
          const reader = new FileReader();
          reader.onload = (e) => {
            document
              .querySelector("#imageDisplay")
              .setAttribute("src", e.target.result);
            document
              .querySelector("#imageDisplayer")
              .setAttribute("src", e.target.result);
          };
          reader.readAsDataURL(e.files[0]);
        }
      }
      //Close notification
      function closeNFT(e) {
        e.parentNode.classList.toggle("hidden");
      }
      //update function
      const modalOpen_update = document.querySelector(".modalOpen_update");
      const updateID = document.querySelector("#updateID");

      function displayModal(e) {
        modalOpen_update.classList.toggle("hidden");
        myModal.classList.toggle("hidden");

        updateID.setAttribute("value", e);

      }
      //openModal
      const myModal = document.querySelector("#my-modal");
      function openModalBtn(e) {
        const modalOpen = document.querySelector(".modalOpen");

        modalOpen.classList.toggle("hidden");
        myModal.classList.toggle("hidden");
        console.log(e);
      }
    </Script>
  </body>
</html>