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
            var headers = document.querySelectorAll(".unor-group-header");
            var rows = document.querySelectorAll(".unor-row");

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
        if (!confirm("Hapus file ini?")) return;

        let form = document.getElementById("global-delete-form");

        // 🔥 pastikan _method DELETE ada
        let methodInput = form.querySelector('input[name="_method"]');

        if (!methodInput) {
            methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            form.appendChild(methodInput);
        }

        methodInput.value = "DELETE";

        form.action = "/unor/bukti/" + id;
        form.submit();
    };

    /*
    |--------------------------------------------------------------------------
    | AUTOSAVE CLICK PENILAIAN 
    |--------------------------------------------------------------------------
    */
    let formChanged = false;

    const form = document.getElementById("unor-form");
    if (!form) return;

    form.querySelectorAll("input[type='number'], select, textarea").forEach(
        function (el) {
            el.addEventListener("input", function () {
                formChanged = true;
            });

            el.addEventListener("blur", function () {
                if (!formChanged) return;

                let formData = new FormData(form); // 🔥 penting

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
                        showIndicator("✔ Autosave tersimpan");
                    })
                    .catch((error) => {
                        console.error("Autosave error:", error);
                    });
            });
        },
    );
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

document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.querySelector(".table-responsive-unor");
    if (!wrapper) return;

    // Buat sticky scrollbar fixed di bawah layar
    const stickyBar = document.createElement("div");
    stickyBar.className = "sticky-scrollbar";

    const stickyInner = document.createElement("div");
    stickyInner.className = "sticky-scrollbar-inner";
    stickyBar.appendChild(stickyInner);

    document.body.appendChild(stickyBar);

    function syncWidth() {
        // Lebar inner = lebar scroll content tabel
        stickyInner.style.width = wrapper.scrollWidth + "px";

        // Posisi & lebar sticky bar ikut posisi wrapper di layar
        const rect = wrapper.getBoundingClientRect();
        stickyBar.style.left = rect.left + "px";
        stickyBar.style.width = rect.width + "px";
    }

    syncWidth();
    window.addEventListener("resize", syncWidth);
    window.addEventListener("scroll", syncWidth);

    // Sembunyikan jika tabel tidak visible di viewport
    function checkVisibility() {
        const rect = wrapper.getBoundingClientRect();
        const inView = rect.top < window.innerHeight && rect.bottom > 0;
        stickyBar.style.display = inView ? "block" : "none";
    }

    window.addEventListener("scroll", checkVisibility);
    checkVisibility();

    // Sync scroll dua arah
    let syncing = false;

    stickyBar.addEventListener("scroll", function () {
        if (syncing) return;
        syncing = true;
        wrapper.scrollLeft = stickyBar.scrollLeft;
        syncing = false;
    });

    wrapper.addEventListener("scroll", function () {
        if (syncing) return;
        syncing = true;
        stickyBar.scrollLeft = wrapper.scrollLeft;
        syncing = false;
    });
});
