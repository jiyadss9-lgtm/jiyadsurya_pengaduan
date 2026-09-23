document.addEventListener("DOMContentLoaded", function () {

    // Ambil tema yang tersimpan
    const savedTheme = localStorage.getItem("theme");

    // Jika sebelumnya memilih mode terang
    if (savedTheme === "light") {
        document.body.classList.add("light-mode");
    }


    // Tombol toggle jika ada
    const themeToggle = document.getElementById("themeToggle");

    if (themeToggle) {

        themeToggle.addEventListener("click", function () {

            document.body.classList.toggle("light-mode");

            if (
                document.body.classList.contains("light-mode")
            ) {

                localStorage.setItem(
                    "theme",
                    "light"
                );

            } else {

                localStorage.setItem(
                    "theme",
                    "dark"
                );

            }

        });

    }

});