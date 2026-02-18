/**
 * Bootstrap ve Vue uygulaması
 */
import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import App from './App.vue';
import { Kernel, Router } from './kernel';
import * as jQuery from './jquery.min.js';

/**
 * Vue uygulamasını oluştur ve mount et
 */
const app = createApp(App);

// Vue uygulamasını global window'a ekle
window.vueApp = app;

app.mount('#app');

/**
 * DOM Ready'de jQuery ve Kernel başlat
 */
document.addEventListener('DOMContentLoaded', function() {
    // jQuery helpers'ı başlat
    jQuery.init();

    // Kernel'ı başlat
    const kernel = new Kernel();
    const router = kernel.getRouter();

    kernel.use(() => console.log('✓ Bootstrap tamamlandı'));
    kernel.bootstrap();

    // Global window scope'a ekle
    window.kernel = kernel;
    window.router = router;

    /**
     * Todo uygulaması
     */
    initTodoApp();
});

/**
 * Todo uygulaması
 */
function initTodoApp() {
    const formEl = document.getElementById('form');
    const inputEl = document.getElementById('input');
    const todosListEl = document.getElementById('todos');

    if (!formEl || !inputEl || !todosListEl) {
        console.warn('Todo uygulaması DOM elemanları bulunamadı');
        return;
    }

    // Kaydedilmiş todo'ları yükle
    const savedTodos = JSON.parse(localStorage.getItem('todos')) || [];
    savedTodos.forEach(todo => addTodoToDOM(todo));

    // Form gönder event'i
    formEl.addEventListener('submit', function(event) {
        event.preventDefault();

        const todoText = inputEl.value.trim();
        if (!todoText) return;

        const todo = {
            id: Date.now(),
            text: todoText,
            completed: false
        };

        addTodoToDOM(todo);
        saveTodos();
        inputEl.value = '';
        inputEl.focus();
    });

    /**
     * Todo'yu DOM'a ekle
     */
    function addTodoToDOM(todo) {
        const li = document.createElement('li');
        li.className = `todo-item ${todo.completed ? 'completed' : ''}`;
        li.dataset.id = todo.id;
        li.textContent = todo.text;

        // Todo durumunu değiştir
        li.addEventListener('click', function() {
            li.classList.toggle('completed');
            saveTodos();
        });

        // Todo'yu sil (sağ click)
        li.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            li.remove();
            saveTodos();
        });

        todosListEl.appendChild(li);
    }

    /**
     * Todo'ları localStorage'a kaydet
     */
    function saveTodos() {
        const todos = [];
        todosListEl.querySelectorAll('.todo-item').forEach(li => {
            todos.push({
                id: li.dataset.id || Date.now(),
                text: li.textContent,
                completed: li.classList.contains('completed')
            });
        });
        localStorage.setItem('todos', JSON.stringify(todos));
    }
}

/**
 * Olay dinleyicileri yönet
 */
document.addEventListener('DOMContentLoaded', function() {
    // myButton
    const myButton = document.getElementById('myButton');
    if (myButton) {
        myButton.addEventListener('click', function() {
            alert('Butona tıklandı!');
            console.log('myButton clicked');
        });
    }

    // myInput
    const myInput = document.getElementById('myInput');
    if (myInput) {
        myInput.addEventListener('input', function(event) {
            console.log('Input değer:', event.target.value);
        });
    }

    // myForm
    const myForm = document.getElementById('myForm');
    if (myForm) {
        myForm.addEventListener('submit', function(event) {
            event.preventDefault();
            console.log('Form gönderildi');
        });
    }

    // myListItem
    const myListItem = document.getElementById('myListItem');
    if (myListItem) {
        myListItem.addEventListener('contextmenu', function(event) {
            event.preventDefault();
            console.log('Liste öğesine sağ click yapıldı');
        });
    }

    // eventButton
    const eventButton = document.getElementById('eventButton');
    if (eventButton) {
        eventButton.addEventListener('click', function() {
            alert('Event butonu tıklandı!');
        });
    }

    // eventInput
    const eventInput = document.getElementById('eventInput');
    if (eventInput) {
        eventInput.addEventListener('input', function(event) {
            console.log('Event input değer:', event.target.value);
        });
    }

    // eventForm
    const eventForm = document.getElementById('eventForm');
    if (eventForm) {
        eventForm.addEventListener('submit', function(event) {
            event.preventDefault();
            console.log('Event formu gönderildi');
        });
    }

    // eventListItem
    const eventListItem = document.getElementById('eventListItem');
    if (eventListItem) {
        eventListItem.addEventListener('contextmenu', function(event) {
            event.preventDefault();
            console.log('Event liste öğesine sağ click yapıldı');
        });
    }
});

console.log('✓ Uygulama başladı');
