window.copyToClipboard = async (text, elId) => {
    try {
        await navigator.clipboard.writeText(text);
        const el = document.getElementById(elId);
        if (el) {
            const old = el.innerText;
            el.innerText = "Copied!";
            setTimeout(() => (el.innerText = old), 1200);
        }
    } catch {}
};

function formatDateByLocale(timestamp, locale = "UTC", options = {}) {
    const defaultOptions = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
    };

    const date = new Date(timestamp);
    return date.toLocaleString(locale, { ...defaultOptions, ...options });
}

// init datatable after page loads
document.addEventListener("DOMContentLoaded", () => {
    const urlInput = document.querySelector("#urlInput"),
        passwordInput = document.querySelector("#passwordInput"),
        forUrlInput = document.querySelector('label[for="urlInput"]');
    let dataTable;

    const table = document.querySelector("#urlsTable");
    if (table && window.simpleDatatables) {
        dataTable = new simpleDatatables.DataTable(table, {
            searchable: true,
            fixedHeight: true,
            perPage: 10,
            labels: {
                placeholder: "Search URLs…",
                perPage: "per page",
                noRows: "No URLs found",
                info: "Showing {start}–{end} of {rows}",
            },
        });
    }

    document
        .querySelector("#addNewUrl")
        .addEventListener("click", async (e) => {
            e.preventDefault();
            e.target.setAttribute("disabled", true);

            try {
                const response = await axios.post("/shorten", {
                    urlInput: urlInput.value,
                    password: passwordInput.value,
                    headers: {
                        "Content-Type": "application/json",
                    },
                });
                const data = response.data;
                if (dataTable) {
                    console.log(data);
                    const copyId = `copy-${data.id}`;

                    const newRow = [
                        `<a href="${data.shortened}" target="_blank" class="underline underline-offset-2 decoration-dotted">${data.shortened}</a>`,
                        `<div class="truncate" title="${data.original}">${data.original}</div>`,
                        `${data.clicks ?? 0}`,
                        `${formatDateByLocale(data.created_at)}`, // Already formatted
                        `<div class="flex items-center gap-2">
                            <button id="${copyId}"
                                class="btnCopy px-3 py-1.5 rounded-md text-sm border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]"
                                onclick="copyToClipboard('${data.shortened}', '${copyId}')">
                                Copy
                            </button>
                            <a href="${data.shortened}" target="_blank"
                                class="px-3 py-1.5 rounded-md text-sm border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]">
                                Open
                            </a>
                            <button type="button"
                                class="btnDelete px-3 py-1.5 rounded-md text-sm border border-red-500 text-red-600 hover:bg-red-50 dark:hover:bg-red-900 dark:text-red-400"
                                data-code="${data.code}">
                                Delete
                            </button>
                        </div>`,
                    ];

                    dataTable.rows.add(newRow);
                    dataTable.update(true);
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;

                    if (errors.url) {
                        forUrlInput.classList.remove(
                            "text-[#706f6c]",
                            "dark:text-[#A1A09A]"
                        );

                        forUrlInput.classList.add("text-red-500");
                    }

                    alert(Object.values(errors).flat().join("\n"));
                } else {
                    console.log(error);

                    alert("Something went wrong, try again later.");
                }
            }

            setTimeout(() => {
                forUrlInput.classList.remove("text-red-500");
                forUrlInput.classList.add(
                    "text-[#706f6c]",
                    "dark:text-[#A1A09A]"
                );

                e.target.removeAttribute("disabled");
            }, 3000);
        });

    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btnDelete");
        if (!btn) return;

        e.preventDefault();
        btn.setAttribute("disabled", true);

        const code = btn.dataset.code;

        if (!confirm("Are you sure you want to delete this URL?")) {
            btn.removeAttribute("disabled");
            return;
        }

        try {
            const response = await axios.delete(`/shorten/${code}`, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });

            const row = btn.closest("tr");
            dataTable.rows.remove(Number(row.dataset.index));
            dataTable.update(true);
        } catch (error) {
            if (error.response) {
                alert(error.response.data.message || "Failed to delete.");
            } else {
                console.log(error);
                alert("Something went wrong, try again later.");
            }
        }
        btn.removeAttribute("disabled");
    });
});
