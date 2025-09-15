document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form"),
        fieldEmail = document.querySelector("#email"),
        fieldPassword = document.querySelector("#password"),
        fieldConfirm = document.querySelector("#confirmPassword"),
        labelEmail = document.querySelector("label[for='email']"),
        labelPassword = document.querySelector("label[for='password']"),
        labelConfirm = document.querySelector("label[for='confirmPassword']"),
        btnRegister = document.querySelector("#btnRegister");

    function applyErrorStyles(label) {
        label.classList.add("text-red-500");
        label.classList.remove(
            "text-[#706f6c]",
            "dark:text-[#A1A09A]",
            "text-white"
        );
    }

    function resetErrorStyles(label) {
        label.classList.remove("text-red-500");
        label.classList.add("text-white");
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        btnRegister.setAttribute("disabled", true);

        // Resetar estilos antes da tentativa
        resetErrorStyles(labelEmail);
        resetErrorStyles(labelPassword);
        resetErrorStyles(labelConfirm);

        try {
            if (fieldConfirm.value != fieldPassword.value) {
                alert("The 2 passwords are not equal!!");
                applyErrorStyles(labelPassword);
                applyErrorStyles(labelConfirm);

                setTimeout(() => {
                    resetErrorStyles(labelEmail);
                    resetErrorStyles(labelPassword);
                    resetErrorStyles(labelConfirm);
                    btnRegister.removeAttribute("disabled");
                }, 3000);
                return;
            }

            const response = await axios.post(
                "/register",
                {
                    email: fieldEmail.value,
                    password: fieldPassword.value,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );

            window.location.href = response.data.redirect;
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                if (errors.email) applyErrorStyles(labelEmail);
                if (errors.password) applyErrorStyles(labelPassword);
                if (errors.confirmPassword) applyErrorStyles(labelConfirm);

                alert(Object.values(errors).flat().join("\n"));
            } else {
                alert("Ops!! Something went wrong. Pleas, try again later.");
            }

            setTimeout(() => {
                resetErrorStyles(labelEmail);
                resetErrorStyles(labelPassword);
                resetErrorStyles(labelConfirm);
                btnRegister.removeAttribute("disabled");
            }, 3000);
        }
    });
});
