import './bootstrap';
import '../css/app.css'
import App from './App.vue';

createApp (App).mount('#app');

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const input = document.getElementById('input');
    const todosUL = document.getElementById('todos');
    const todos = JSON.parse(localStorage.getItem('todos'));

    if (todos) {
        todos.forEach(todo => addTodo(todo));
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        addTodo();
    });

    function addTodo(todo) {
        let todoText = input.value;

        if (todo) {
            todoText = todo.text;
        }

        if (todoText) {
            const todoEl = document.createElement('li');
            if (todo && todo.completed) {
                todoEl.classList.add('completed');
            }

            todoEl.innerText = todoText;

            todoEl.addEventListener('click', () => {
                todoEl.classList.toggle('completed');
                updateLS();
            });

            todoEl.addEventListener('contextmenu', (e) => {
                e.preventDefault();
                todoEl.remove();
                updateLS();
            });

            todosUL.appendChild(todoEl);
            input.value = '';
            updateLS();
        }
    }

    function updateLS() {
        const todosEl = document.querySelectorAll('li');
        const todos = [];
        todosEl.forEach(todoEl => {
            todos.push({
                text: todoEl.innerText,
                completed: todoEl.classList.contains('completed')
            });
        });

        localStorage.setItem('todos', JSON.stringify(todos));
    }
});

document.getElementById("form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting

    // Get the input value
    var input = document.getElementById("input").value;

    // Create a new list item
    var li = document.createElement("li");
    li.textContent = input;

    // Append the new list item to the todo list
    document.getElementById("todos").appendChild(li);

    // Clear the input field
    document.getElementById("input").value = "";
});
