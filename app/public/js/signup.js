// form elements
const form = document.getElementById("signup");
const name = document.getElementById("name");
const username = document.getElementById("username");
const password = document.getElementById("password");
const password2 = document.getElementById("password2");
const email = document.getElementById("email");
const tc = document.getElementById("tc");
const submit = document.getElementById("submit");

// Error response elements
const emailtaken = document.getElementById("emailtaken");
const invalidemail = document.getElementById("invalidemail");
const usernametaken = document.getElementById("usernametaken");
const missingpassword = document.getElementById("missingpassword");
const missingpassword2 = document.getElementById("missingpassword2");
const passwordnotmatch = document.getElementById("passwordnotmatch");
const tcmodal = document.getElementById("tcmodal");
const tcopen = document.getElementById("tcopen");
const tccancel = document.getElementById("tccancel");
const tcclose = document.getElementById("tcclose");
const tcagree = document.getElementById("tcagree");

const check_username = async () => {
  const request = new Request(`/checkusername?username=${username.value}`);
  let response = await fetch(request);
  let message = await response.text();
  if (message == "username_exists") {
    usernametaken.classList.remove("is-hidden");
    username.classList.add("is-danger");
    return false;
  }
  if (message == "username_available") {
    usernametaken.classList.add("is-hidden");
    username.classList.remove("is-danger");
    return true;
  }
  return false;
};

const check_email = async () => {
  const request = new Request(`/checkemail?email=${email.value}`);
  let response = await fetch(request);
  let message = await response.text();
  if (message == "emailtaken") {
    emailtaken.classList.remove("is-hidden");
    email.classList.add("is-danger");
    return false;
  }
  if (message == "ok") {
    emailtaken.classList.add("is-hidden");
    email.classList.remove("is-danger");
    return true;
  }
  return false;
};

tcopen.addEventListener("click", () => {
  tcmodal.classList.add("is-active");
});

tcclose.addEventListener("click", () => {
  tcmodal.classList.remove("is-active");
});

tccancel.addEventListener("click", () => {
  tcmodal.classList.remove("is-active");
});

tcagree.addEventListener("click", () => {
  tcmodal.classList.remove("is-active");
  tc.checked = true;
});

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  if (password.value !== password2.value) {
    password2.classList.add("is-danger");
    passwordnotmatch.classList.remove("is-hidden");
    return;
  }
  const usernamecheck = await check_username();
  if (usernamecheck == false) return;
  const emailcheck = await check_email();
  if (emailcheck == false) return;
  const formData = new FormData();
  formData.append("name", name.value.trim());
  formData.append("username", username.value.trim());
  formData.append("password", password.value);
  formData.append("email", email.value.trim());
  formData.append("tc", tc.value);
  request = new Request("/process_signup", {
    method: "POST",
    body: formData,
  });
  fetch(request)
    .then(() => {
      location.href = "/signupconfirm";
    })
    .catch((error) => {
      console.log(error);
    });
});
