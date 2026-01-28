const { listenerCount } = require("supertest/lib/test");

const kernel = new Kernel();
const router = kernel.getRouter();

document.addEventListener('DOMContentLoaded', () => {
    router.init();
});

document.adoptedStyleSheets([
    new CSSStyleSheet()
])

const button = document.getElementById('myButton');
button.addEventListener('click', () => {
    alert('Button clicked!');
});

const inputField = document.getElementById('myInput');
inputField.addEventListener('input', (event) => {
    console.log('Input changed:', event.target.value);
});

const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault();
    console.log('Form submitted');
});
