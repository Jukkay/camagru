const userinfo = document.getElementById("userconfiguration");
let form;
let name;
let username;
let email;
let biography;
let email_notification;
let emailtaken;
let usernametaken;
let image_input;
let upload;

if (user_id == 0) {
  alert("Please, login first.");
  location.href = "/";
}

const saveUserConfiguration = async () => {
  const usernamecheck = await check_username();
  if (usernamecheck == false) return;
  const emailcheck = await check_email();
  if (emailcheck == false) return;
  notification = document.querySelector(
    'input[name="email_notification"]:checked'
  ).value;
  const formData = new FormData();
  formData.append("user_id", user_id);
  formData.append("name", name.value);
  formData.append("username", username.value);
  formData.append("biography", biography.value);
  formData.append("email", email.value);
  formData.append("email_notification", notification);
  request = new Request("/saveuserconfiguration", {
    method: "POST",
    body: formData,
  });
  fetch(request).catch((error) => {
    console.log(error);
  });
};

const getUserConfiguration = async () => {
  fetch(`/getuserconfiguration?user_id=${user_id}`)
    .then((response) => {
      return response.text();
    })
    .then((text) => {
      userinfo.innerHTML = text;
      image_input = document.getElementById("image-input");
      upload = document.getElementById("upload");
      upload.addEventListener("click", () => {
        image_input.click();
      });
      image_input.addEventListener("change", save_image);
    })
    .then(function () {
      form = document.getElementById("configurationform");
      name = document.getElementById("name");
      username = document.getElementById("username");
      email = document.getElementById("email");
      biography = document.getElementById("biography");
      email_notification = document.getElementById("email_notification");
      emailtaken = document.getElementById("emailtaken");
      usernametaken = document.getElementById("usernametaken");
      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        saveUserConfiguration();
      });
    });
};

const save_image = (event) => {
  if (event.target.files) {
    let inputImg = event.target.files[0];
    let fileReader = new FileReader();
    fileReader.readAsDataURL(inputImg);
    fileReader.addEventListener("load", (event) => {
      let formData = new FormData();
      formData.append("user_id", user_id);
      formData.append("img", event.target.result);
      request = new Request("/saveprofilepicture", {
        method: "POST",
        body: formData,
      });
      fetch(request).then(() => {
        getUserConfiguration();
      });
    });
  }
};

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

getUserConfiguration();
