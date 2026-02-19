document.addEventListener("DOMContentLoaded", function () {
    console.log("System Loaded");

    /*
    |--------------------------------------------------------------------------
    | FILTER KATEGORI
    |--------------------------------------------------------------------------
    */
    const filter = document.getElementById("filterKategori");

    if (filter) {
        filter.addEventListener("change", function () {
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
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE FILE
    |--------------------------------------------------------------------------
    */
    window.deleteFile = function (id) {
        if (confirm("Hapus file ini?")) {
            let form = document.getElementById("global-delete-form");
            form.action = "/unor/zi/bukti/" + id;
            form.submit();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | AUTOSAVE NILAI (60 DETIK)
    |--------------------------------------------------------------------------
    */

    let formChanged = false;
    let autosaveInterval = 60000; // 60 detik

    const form = document.getElementById("zi-form");

    if (!form) return;

    // Tandai jika ada perubahan nilai
    form.querySelectorAll("input[type='number'], select, textarea").forEach(
        function (el) {
            el.addEventListener("input", function () {
                formChanged = true;
            });
        },
    );

    // Autosave nilai
    setInterval(function () {
        if (!formChanged) return;

        let formData = new FormData();

        // Kirim HANYA field nilai
        form.querySelectorAll("input[type='number'], select, textarea").forEach(
            function (el) {
                if (el.name && !el.disabled) {
                    formData.append(el.name, el.value);
                }
            },
        );

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "X-Requested-With": "XMLHttpRequest",
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) throw new Error("Gagal autosave");

                formChanged = false;
                showIndicator("✔ Autosave berhasil");

                console.log(
                    "Autosave nilai berhasil:",
                    new Date().toLocaleTimeString(),
                );
            })
            .catch((error) => {
                console.error("Autosave error:", error);
            });
    }, autosaveInterval);

    /*
    |--------------------------------------------------------------------------
    | AUTO UPLOAD FILE (INSTANT)
    |--------------------------------------------------------------------------
    */

    form.querySelectorAll("input[type='file']").forEach(function (fileInput) {
        fileInput.addEventListener("change", function () {
            if (!this.files.length) return;

            let formData = new FormData(form); // kirim full form karena ada file

            fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) throw new Error("Gagal upload file");

                    showIndicator("✔ File berhasil diupload");

                    console.log("File uploaded");

                    // Reload ringan agar file langsung muncul
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                })
                .catch((error) => {
                    console.error("Upload error:", error);
                    alert("Upload gagal");
                });
        });
    });
});

/*
|--------------------------------------------------------------------------
| NOTIFICATION INDICATOR
|--------------------------------------------------------------------------
*/

function showIndicator(message = "✔ Berhasil") {
    let indicator = document.getElementById("autosave-indicator");

    if (!indicator) {
        indicator = document.createElement("div");
        indicator.id = "autosave-indicator";
        indicator.style.position = "fixed";
        indicator.style.bottom = "20px";
        indicator.style.right = "20px";
        indicator.style.background = "#28a745";
        indicator.style.color = "#fff";
        indicator.style.padding = "8px 12px";
        indicator.style.borderRadius = "6px";
        indicator.style.fontSize = "12px";
        indicator.style.zIndex = "9999";
        indicator.style.boxShadow = "0 2px 6px rgba(0,0,0,0.2)";
        document.body.appendChild(indicator);
    }

    indicator.innerHTML = message;
    indicator.style.display = "block";

    setTimeout(() => {
        indicator.style.display = "none";
    }, 3000);
}
