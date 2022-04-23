        </main>
        </div>
        </div>
        <script src="../../js/app.js"></script>
        <script type="text/javascript">
          setTimeout(function() {
            document.getElementById("notification").style.display = "none";
          }, 3000);
          //logout dropdown
          function dropdown_menu(e) {
            const dropdown_subMenu = document.querySelector(".dropdown_menu");
            const user_icon = document.querySelector(".user_icon");

            dropdown_subMenu.classList.toggle("hidden");
            user_icon.classList.toggle("outline");
          }
        </script>
        </body>

        </html>