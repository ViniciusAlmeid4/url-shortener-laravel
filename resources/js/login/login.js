document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form"),
        fieldEmail = document.querySelector("#email"),
        fieldPassword = document.querySelector("#password"),
        labelEmail = document.querySelector("label[for='email']"),
        labelPassword = document.querySelector("label[for='password']"),
        btnLogin = document.querySelector("#btnLogin");

    // Função para aplicar estilo de erro
    function applyErrorStyles(label) {
        label.classList.add("text-red-500");
        label.classList.remove("text-[#706f6c]", "dark:text-[#A1A09A]");
    }

    // Função para resetar estilo de erro
    function resetErrorStyles(label) {
        label.classList.remove("text-red-500");
        label.classList.add("text-[#706f6c]", "dark:text-[#A1A09A]");
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        btnLogin.setAttribute("disabled", true);

        // Resetar estilos antes de nova tentativa
        resetErrorStyles(labelEmail);
        resetErrorStyles(labelPassword);

        try {
            const response = await axios.post("/login", {
                email: fieldEmail.value,
                password: fieldPassword.value,
            }, {
                headers: {
                    "Content-Type": "application/json",
                },
            });

            window.location.href = response.data.redirect;

        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                if (errors.email) applyErrorStyles(labelEmail);
                if (errors.password) applyErrorStyles(labelPassword);

                alert(Object.values(errors).flat().join("\n"));

            } else if (error.response && error.response.status === 401) {
                if (error.response.data.errors.email) {
                    applyErrorStyles(labelEmail);
                }
                applyErrorStyles(labelPassword);

                alert("There wasn't found any accounts for the login provided.")
            } else {
                alert("Ops!! Something went wrong. Pleas, try again later.");
            }

            // Resetar estilos após 3 segundos
            setTimeout(() => {
                resetErrorStyles(labelEmail);
                resetErrorStyles(labelPassword);
                btnLogin.removeAttribute("disabled");
            }, 3000);
        }
    });
});