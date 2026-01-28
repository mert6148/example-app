const app = document.getElementById('app');
console.log(app.innerHTML);

const dataElements = document.querySelectorAll('data');
dataElements.forEach(dataEl => {
    console.log(`Data value: ${dataEl.getAttribute('value')}`);
    console.log(`Content: ${dataEl.innerHTML}`);
});

const newDiv = document.createElement('div');
newDiv.innerHTML = `
    <h4>Dynamic Content</h4>
    <strong>This content was added dynamically using JavaScript.</strong>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum.</p>
    <div>
        <h5>Nested Dynamic Content</h5>
        <strong>Even nested elements can be created dynamically.</strong>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum.</p>
        <nav>
            <ul>
                <li>Home</li>
                <li>About</li>
                <li>Contact</li>
            </ul>
        </nav>
        <footer>
            <p>&copy; 2024 Laravel Application</p>
        </footer>
    </div>
`;
document.body.appendChild(newDiv);

const name = "Laravel User";
const greetingDiv = document.createElement('div');
greetingDiv.innerHTML = `<h1>Hello, ${name}!</h1>`;
document.body.appendChild(greetingDiv);

const items = ['Item 1', 'Item 2', 'Item 3'];
const listDiv = document.createElement('div');
let listHTML = '<ul>';
items.forEach(item => {
    listHTML += `<li>${item}</li>`;
    listHTML += `<p>Added ${item} to the list.</p>`;
});
listHTML += '</ul>';
listDiv.innerHTML = listHTML;
document.body.appendChild(listDiv);

const button = document.createElement('button');
button.textContent = 'Click Me';
button.addEventListener('click', () => {
    alert('Button was clicked!');
});
document.body.appendChild(button);

const currentDate = new Date();
const dateDiv = document.createElement('div');
dateDiv.innerHTML = `<p>Current Date and Time: ${currentDate.toString()}</p>`;
document.body.appendChild(dateDiv);

const tempUrlDiv = document.createElement('div');
tempUrlDiv.innerHTML = `<p>Temporary URL created.</p>`;
document.body.appendChild(tempUrlDiv);

// Simulate creating and revoking a temporary URL
const tempUrl = webkitURL.createObjectURL(new Blob(['Temporary content']));
const revokeUrl = webkitURL.revokeObjectURL('some-temporary-url');

const tempUrlInfoDiv = document.createElement('div');
tempUrlInfoDiv.innerHTML = `<p>Temporary URL: ${tempUrl}</p><p>Revoked URL: ${revokeUrl}</p>`;
document.body.appendChild(tempUrlInfoDiv);

const finalDiv = document.createElement('div');
finalDiv.innerHTML = `
    <h2>Final Dynamic Section</h2>
    <p>This is the final section added dynamically to the page.</p>
`;
document.body.appendChild(finalDiv);
