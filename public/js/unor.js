document
    .getElementById("filterKategori")
    .addEventListener("change", function () {
        var selected = this.value;

        var headers = document.querySelectorAll(".zi-group-header");
        var rows = document.querySelectorAll(".zi-row");

        if (selected === "all") {
            headers.forEach((el) => (el.style.display = ""));
            rows.forEach((el) => (el.style.display = ""));
            return;
        }

        headers.forEach(function (el) {
            el.style.display =
                el.getAttribute("data-kategori") === selected ? "" : "none";
        });

        rows.forEach(function (el) {
            el.style.display =
                el.getAttribute("data-kategori") === selected ? "" : "none";
        });
    });

document.querySelectorAll(".auto-upload").forEach((input) => {
    input.addEventListener("change", function () {
        if (this.files.length > 0) {
            this.closest("form").submit();
        }
    });
});
