<template>
    <div class="min-h-screen bg-gray-100 text-gray-900">

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">
                    Laravel Vue Editor
                </h1>

                <button
                    @click="clearEditor"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
                >
                    Temizle
                </button>
            </div>
        </header>

        <!-- Content -->
        <main class="container mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Editor -->
            <section class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-medium mb-2">Editor</h2>

                <textarea
                    v-model="code"
                    class="w-full h-80 p-3 border rounded font-mono text-sm focus:outline-none focus:ring"
                    placeholder="Kodunu buraya yaz..."
                ></textarea>
            </section>

            <!-- Output -->
            <section class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-medium mb-2">Output</h2>

                <pre class="bg-gray-900 text-green-400 p-4 rounded h-80 overflow-auto">
{{ code }}
                </pre>
            </section>

        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const code = ref('')

const clearEditor = () => {
    code.value = ''
}
</script>

<style scoped>
pre {
    white-space: pre-wrap;
    word-break: break-word;
}
</style>
