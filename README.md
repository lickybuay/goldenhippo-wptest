# WordPress Coding Test

## Build
We would like you to create a simple, functional WordPress plugin. The plugin will reside at the top level in the WordPress admin dashboard sidebar. The plugin should include the following fields:

- Text Field
- URL Field
- Checkbox
- Radio Buttons
- Select Dropdown
- TinyMCE Editor (Rich Text Editor)

The plugin should store the entered data in the WordPress database when saved, and display a confirmation message upon successful saving.

## Requirements
### 1. Plugin Structure
- This repository contains a plugin.php file to get you started. You should follow WordPress coding standards and best practices to complete this coding test.
- The plugin should be organized into modular files where appropriate (e.g., separate functions for form handling, sanitization, etc.).

### 2. Fields
You must implement one field of each type listed below:
- **Text Field**: A simple input for text.
- **URL Field**: A field that accepts a valid URL.
- **Checkbox:** A checkbox for a binary choice (true/false).
- **Radio Buttons**: A set of radio buttons to choose one option from multiple.
- **Select Dropdown**: A dropdown list with multiple options.
- **TinyMCE Editor**: A rich text editor for formatted text.

### 3. Form Handling and Storage
- When the user submits the form, save the entered data in the WordPress database.
- Ensure that the form data is sanitized and validated before saving to the database.
- The plugin should display a success message after the form is saved, indicating that the data has been successfully stored.

### 4. Confirmation Message
- After the form is submitted and the data is saved, display a clear success message to confirm that the settings were saved.

## Optional Enhancements (Bonus)
If you feel adventurous, have time, and wish to go above and beyond, here are a few optional enhancements:
- **AJAX Form Submission**: Use AJAX to submit the form without reloading the page, improving the user experience.
- **Advanced Validation**: Implement more sophisticated validation, like checking if the URL is valid or if the checkbox is required.

## Submission
Complete the coding test and email your solution at sarah.zacharia@goldenhippo.com and vikas.bhavsar@goldenhippo.com

---

Good luck! We look forward to reviewing your submission


## Comments
Added the .env to make easier to deploy and check the test, for dev or another env will be in the .gitignore.
