async function sendFormValues() {
  try {
    const form = document.getElementById('hippo-form');
    const responseMessage = document.getElementById('response-message');
    const endpoint = form.dataset.endpoint;
    if (typeof tinyMCE !== 'undefined' && tinyMCE.get('rich_text_field')) {
      tinyMCE.triggerSave();
    }
    const payload = {
      method: 'POST',
      body: new FormData(form),
    };
    const response = await fetch(endpoint, payload);
    responseMessage.style.display = 'block';
    responseMessage.className = response.ok ? 'updated notice' : 'error notice';
    responseMessage.textContent = response.ok
      ? 'Updated Successful'
      : 'An error occurred';
  } catch (error) {
    responseMessage.style.display = 'block';
    responseMessage.className = 'error notice';
    responseMessage.textContent = 'Error connecting to the server';
  } finally {
    window.scrollTo(0, 0);
    setTimeout(() => {
      responseMessage.style.display = 'none';
    }, 3000);
  }
}

function isCheckboxChecked() {
  const checkbox = document.querySelector('#checkbox_field');
  const invalidFeedback = checkbox
    .closest('.input-group')
    .querySelector('.invalid-feedback');
  if (!checkbox.checked) {
    invalidFeedback.style.display = 'block';
    return false;
  } else {
    invalidFeedback.style.display = 'none';
    return true;
  }
}

function isValidUrl() {
  const urlField = document.querySelector('#url_field');
  const url = urlField.value.trim();
  const urlRegex =
    /^(https?:\/\/)?([\w\-]+\.)+[\w\-]+(\/[\w\-._~:\/?#[\]@!$&'()*+,;=]*)?$/;
  const invalidFeedback = urlField.nextElementSibling;
  if (url && !urlRegex.test(url)) {
    invalidFeedback.style.display = 'block';
    urlField.classList.add('is-invalid');
    return false;
  } else {
    invalidFeedback.style.display = 'none';
    urlField.classList.remove('is-invalid');
    return true;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const dropdownItems = document.querySelectorAll(
    '.dropdown-menu .dropdown-item'
  );
  const hiddenInput = document.querySelector('input[name="dropdown_field"]');
  const dropdownButton = document.querySelector('.dropdown-toggle');
  const submitButton = document.getElementById('submit-hippo-form');
  dropdownItems.forEach((item) => {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      dropdownItems.forEach((el) => {
        el.classList.remove('active');
      });
      this.classList.add('active');
      const selectedValue = this.getAttribute('data-value');
      const selectedText = this.textContent;
      hiddenInput.value = selectedValue;
      dropdownButton.textContent = selectedText;
    });
  });

  submitButton.addEventListener('click', async function (e) {
    e.preventDefault();
    if (!isValidUrl() || !isCheckboxChecked()) {
      return null;
    }
    sendFormValues();
  });
});
