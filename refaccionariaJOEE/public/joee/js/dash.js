//No le muevan esto porfa, creen otro js si es posible, o si le mueven comentenle que le movieron

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.icanchangejiji').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // esperar seleccion en las secciones
            const section = this.getAttribute('data-section');
            const contentArea = document.getElementById('hereNeiga');

            // Basura para mostraropcion seleccionafd
            document.querySelector('.selectedf')?.classList.remove('selectedf');
            this.classList.add('selectedf');

            const maintitle = document.getElementById('thetitle');

            // Cambiar titulo de la pa pagina
            const title = this.getAttribute('data-title');

            if (title) {
                document.title = `${title} | JOEE Mechanics`;

                // Cambiar el H1 de cada opcion elegida
                if (maintitle) {
                    maintitle.innerText = `${title}`;
                }
            }

            // Cambiar el p de cada opcion elegida
            const descElement = document.getElementById('descri');
            const desc = this.getAttribute('data-desc');

            if (descElement && desc) {
                descElement.innerText = desc;
            }

            // basura del ajax
            fetch(`/dash/${section}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })

                .then(response => {

                    // Arreglar flickering del perro laravel, mugre basura fastidiosa
                    if (!response.ok) {
                        throw new Error('Error: ' + response.status);
                    }
                    return response.text();
                })
                .then(html => {
                    contentArea.innerHTML = html;
                })
                .catch(error => {
                    console.error('error:', error);
                });
            window.location.hash = section;
        });
    });

    const gohomeBut = document.getElementById('gohome')
    gohomeBut.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = '/';
    });

    const logoutBut = document.getElementById('logout')
    logoutBut.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = '/logout';
            document.getElementById('logout-form').submit();
    });
    
});


// para acceder a la seccion directa con /dash#pagina
document.addEventListener('DOMContentLoaded', function () {

    // verificar si tiene algo
    const hash = window.location.hash.substring(1);

    if (hash) {
        // agarrar data-section
        const target = document.querySelector(`[data-section="${hash}"]`);
        if (target) {
            document.title = `${target.getAttribute('data-title')} | JOEE Mechanics`;
            target.click(); // simular evento del click en la seccion, aplica el link
        }
    } else {
        // cargar el por defecto
        document.querySelector('[data-section="dashboard"]').click();
    }
});


// Basura del modal
let zIndexCounter = 1000;

function openModal(id) {
    const modal = document.getElementById(id);

    zIndexCounter++;
    modal.style.zIndex = zIndexCounter;
    
    modal.style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Cerrar si hacen clic fuera del modal
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}



// comprobar la actualizacion del usario
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('btn-save-user')) {
        
        const userId = e.target.getAttribute('data-id');
        const form = document.getElementById(`formEdit_${userId}`);
        const formData = new FormData(form); 

        fetch(`/dash/users/update/${userId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('¡Usuario actualizado con éxito!');
                closeModal(`editModal_${userId}`);
                document.querySelector('[data-section="users"]').click();
            } else {
                alert('Error al actualizar: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            alert('Algo salió mal con el servidor.');
        });
    }
});