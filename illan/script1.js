// Modo noche
//--------------------------------------------------------------//
let botonModoNoche = document.querySelector('.modo_noche')
let body           = document.body
let contenedor     = document.querySelector('.contenedor')
let labels         = document.querySelectorAll('label')
let input          = document.querySelectorAll('input')[0]
let textareas      = document.querySelectorAll('textarea')

if(localStorage.getItem("modoNoche") === "activado") {
    activarModoNoche()
} else {
    desactivarModoNoche()
}

// Guardar en localStorage el último modo seleccionado
botonModoNoche.addEventListener('click', () => {
    if(botonModoNoche.textContent == "☀️") {
        activarModoNoche()
        localStorage.setItem("modoNoche", "activado")
    } else {
        desactivarModoNoche()
        localStorage.setItem("modoNoche", "desactivado")
    }
});

// Funciones modo noche
function activarModoNoche() {
    botonModoNoche.textContent = "🌙"
    contenedor.style.backgroundColor = "#f4f4f4"

    labels.forEach(label => {
        label.style.color = "#333333"
    })

    input.style.backgroundColor = "#ffffff"
    input.style.color = "#333333"

    textareas.forEach(textarea => {
        textarea.style.backgroundColor = "#ffffff"
        textarea.style.color = "#333333"
    })
}

function desactivarModoNoche() {
    botonModoNoche.textContent = "☀️"
    contenedor.style.backgroundColor = "#121212"

    labels.forEach(label => {
        label.style.color = "#e0e0e0"
    })

    input.style.backgroundColor = "#333333"
    input.style.color = "#f0f0f0"

    textareas.forEach(textarea => {
        textarea.style.backgroundColor = "#333333"
        textarea.style.color = "#f0f0f0"
    })
}

// ----------------------------------------------------------- //

// Sacar nota mediante solicitud AJAX
document.addEventListener("DOMContentLoaded", function() {
    let inputDate = document.getElementById('date')
    let textarea = document.getElementById('note')
    let form = document.querySelector('form')  // Obtener el formulario

    // Función para cargar las notas de la fecha seleccionada
    let cargarNotas = (selectDate) => {
        console.log('URL de la solicitud:', 'get_note.php?date=' + selectDate)
        let xhr = new XMLHttpRequest()
        xhr.open('GET', 'get_note.php?date=' + selectDate, true)

        xhr.onload = () => {
            if(xhr.status === 200) {
                console.log("Respuesta del servidor: ", xhr.responseText)

                // Si hay notas para la fecha, las mostramos en nuevos textarea
                let notes = JSON.parse(xhr.responseText) // Parseamos el JSON devuelto

                // Limpiar los textareas previos antes de agregar nuevos
                let notesContainer = document.getElementById('notesContainer')
                notesContainer.innerHTML = '' // Limpiar el contenedor de textareas

                // Crear un nuevo textarea por cada nota
                notes.forEach((note, index) => {
                    console.log("ID de la nota:", note.id)  // Verificar que el ID es correcto
                
                    let newTextArea = document.createElement('textarea')
                    newTextArea.name = 'note_' + index  // Nombre único para cada textarea
                    newTextArea.rows = 5
                    newTextArea.cols = 30
                    newTextArea.disabled = true  // Hacerlo de solo lectura
                    newTextArea.value = note.nota  // Asignar el valor de la nota
                
                    // Crear el botón de eliminar
                    let deleteButton = document.createElement('button')
                    deleteButton.textContent = "Eliminar"
                    deleteButton.classList.add('delete-btn')
                    deleteButton.setAttribute('data-id', note.id) // Guardar el ID de la not
                
                    console.log("ID asignado al botón de eliminar:", note.id)  // Verificar el ID asignado
                
                    // Añadir el botón de eliminar al lado del textarea
                    notesContainer.appendChild(newTextArea)
                    notesContainer.appendChild(deleteButton)
                    notesContainer.appendChild(document.createElement('br')) // Línea nueva después de cada textarea
                
                    // Event listener para el botón de eliminar
                    deleteButton.addEventListener('click', function() {
                        let noteId = this.getAttribute('data-id')  // Obtener el ID 
                        console.log("ID de la nota a eliminar:", noteId)  // Verificar que el ID correcto es el que se está eliminando
                        eliminarNota(noteId, newTextArea, deleteButton)  // Llamar a la función de eliminar
                    })
                })
                
                

                // Limpiar el textarea principal para escribir una nueva nota
                textarea.value = ""
            } else {
                console.log("Error en la solicitud AJAX: ", xhr.status)
            }
        }
        xhr.send()
    }

    // Función para eliminar una nota
    function eliminarNota(noteId, textarea, deleteButton) {
        // Realizar solicitud AJAX para eliminar la nota
        let xhr = new XMLHttpRequest()
        xhr.open('POST', 'delete_note.php', true)
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")

        // Enviar el ID de la nota para eliminarla
        xhr.send("note_id=" + noteId)

        xhr.onload = () => {
            if(xhr.status === 200) {
                console.log("Nota eliminada: ", xhr.responseText)
                
                // Eliminar el textarea y el botón de eliminar del DOM
                textarea.remove()
                deleteButton.remove()
            } else {
                console.error("Error al eliminar la nota.")
            }
        }
    }

    // Cargar la nota cuando se cambia la fecha
    inputDate.addEventListener('change', () => {
        let selectDate = inputDate.value
        cargarNotas(selectDate)
    })

    // Cargar la nota por defecto (fecha actual)
    let currentDate = new Date().toISOString().split('T')[0]
    inputDate.value = currentDate
    cargarNotas(currentDate)
});

// ------------------------------- //

// Función cargar notas
function cargarNotas() {
    // Crear una solicitud AJAX
    let xhr = new XMLHttpRequest()
    xhr.open("GET", "notes.php", true)

    xhr.onload = function() {
        if (xhr.status == 200) {
            // Si la solicitud fue exitosa, insertar el contenido en el contenedor
            document.getElementById("get_all_notes_container").innerHTML = xhr.responseText
        }
    }

    xhr.send()
}

function toggleNotas() {
    // Obtén el contenedor de notas
    let notasContainer = document.getElementById("get_all_notes_container")

    // Si las notas están ocultas, mostramos el contenedor
    if (notasContainer.style.display === "none" || notasContainer.style.display === "") {
        // Hacemos la solicitud AJAX para cargar las notas
        cargarNotas()
        notasContainer.style.display = "block"  // Mostrar las notas
        document.getElementById("toggleNotasBtn").innerText = "Ocultar Notas" // Cambiar texto del botón
    } else {
        // Si las notas están visibles, las ocultamos
        notasContainer.style.display = "none"
        document.getElementById("toggleNotasBtn").innerText = "Ver Notas"  // Volver a poner el texto original
    }
}
