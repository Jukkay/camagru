const userinfo = document.getElementById("userconfiguration");
let form;
let nameinput;
let current_name;
let username;
let current_username;
let email;
let current_email;
let biography;
let current_biography;
let email_notification;
let current_notification;
let notification_value;
let emailtaken;
let usernametaken;
let image_input;
let upload;
let saved;
let profile_saved;
let name_saved;
let email_saved;
let username_saved;
let biography_saved;
let notification_saved;

if (user_id == 0) {
  alert("Please, login first.");
  location.href = "/";
}

const saveUserConfiguration = async () => {
  // check email and username duplicates
  const usernamecheck = await check_username();
  if (usernamecheck == false) return;
  const emailcheck = await check_email();
  if (emailcheck == false) return;

  // Add fields to formdata if changed
  const formData = new FormData();
  formData.append("user_id", user_id);
  if (current_name !== nameinput.value.trim()) {
    formData.append("name", nameinput.value.trim());
    current_name = nameinput.value.trim();
  }
  if (current_username !== username.value.trim()) {
    formData.append("username", username.value.trim());
    current_username = username.value.trim();
  }
  if (current_biography !== biography.value.trim()) {
    formData.append("biography", biography.value.trim());
    current_biography = biography.value.trim();
  }
  if (current_email !== email.value.trim()) {
    formData.append("email", email.value.trim());
    current_email = email.value.trim();
  }
  notification_value = document.querySelector(
      'input[name="email_notification"]:checked'
    ).value;
  if (current_notification !== notification_value) {
    formData.append("email_notification", notification_value);
    current_notification = notification_value;
  }

  request = new Request("/saveuserconfiguration", {
    method: "POST",
    body: formData,
  });
  fetch(request).catch((error) => {
    console.log(error);
  })
  .then((response) => {
    return response.text();
  })
  // Highlight saved fields
  .then((text) => {
    profile_saved.classList.add("is-hidden");
    biography_saved.classList.add("is-hidden");
    name_saved.classList.add("is-hidden");
    username_saved.classList.add("is-hidden");
    email_saved.classList.add("is-hidden");
    notification_saved.classList.add("is-hidden");
    const array = text.split(",");
    if (array.includes("biography"))
      biography_saved.classList.remove("is-hidden");
    if (array.includes('name'))
      name_saved.classList.remove("is-hidden");
    if (array.includes('username'))
      username_saved.classList.remove("is-hidden");
    if (array.includes('email'))
      email_saved.classList.remove("is-hidden");
    if (array.includes('email_notification'))
      notification_saved.classList.remove("is-hidden");
  })
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
    .then(() => {
      form = document.getElementById("configurationform");
      nameinput = document.getElementById("name");
      username = document.getElementById("username");
      email = document.getElementById("email");
      biography = document.getElementById("biography");
      email_notification = document.getElementById("email_notification");
      emailtaken = document.getElementById("emailtaken");
      usernametaken = document.getElementById("usernametaken");
      saved = document.getElementById("saved");
      profile_saved = document.getElementById("profilesaved");
      name_saved = document.getElementById("name_saved");
      username_saved = document.getElementById("username_saved");
      email_saved = document.getElementById("email_saved");
      biography_saved = document.getElementById("biography_saved");
      notification_saved = document.getElementById("notification_saved");
      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        await saveUserConfiguration();
      })
    })
    .then(() => {
      current_name = nameinput.value;
      current_username = username.value;
      current_biography = biography.value;
      current_email = email.value;
      current_notification = document.querySelector(
        'input[name="email_notification"]:checked'
      ).value;
    })
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
      fetch(request)
      .then(() => {
        profile_saved.classList.remove("is-hidden");
      })
    });
  }
};

const check_username = async () => {
  const request = new Request(`/checkusername?username=${username.value.trim()}`);
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
  const request = new Request(`/checkemail?email=${email.value.trim()}`);
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
