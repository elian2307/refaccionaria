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



function openModal(id) {
    document.getElementById(id).style.display = 'flex';
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