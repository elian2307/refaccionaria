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
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}



// comprobar la actualizacion del usario
function showUserValidationErrors(containerId, errors) {
    const container = document.getElementById(containerId);
    if (!container) return;

    let html = '';
    Object.keys(errors).forEach(function (key) {
        errors[key].forEach(function (message) {
            html += `<p style="color: red; margin: 4px 0;">${message}</p>`;
        });
    });

    container.innerHTML = html;
}

// comprobar la actualizacion del usario
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('btn-save-user')) {
        const userId = e.target.getAttribute('data-id');
        const form = document.getElementById(`formEdit_${userId}`);
        const formData = new FormData(form);

        document.getElementById(`userEditErrors_${userId}`).innerHTML = '';

        fetch(`/dash/users/update/${userId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(async response => {
                const data = await response.json();

                if (response.status === 422) {
                    showUserValidationErrors(`userEditErrors_${userId}`, data.errors);
                    return;
                }

                if (data.success) {
                    showToast('¡Usuario actualizado con éxito!', 'success');
                    closeModal(`editModal_${userId}`);
                    document.querySelector('[data-section="users"]').click();
                } else {
                    showToast('Error al actualizar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }
});

// comprobar la eliminacion del usario
function deleteUser(id) {
    showConfirmModal('Are you sure you want to delete this user?', function () {
        fetch(`/dash/users/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('¡Usuario eliminado con éxito!', 'success');
                    closeModal(`deleteModal_${id}`);
                    document.querySelector('[data-section="users"]').click();
                } else {
                    showToast('Error al eliminar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }, 'Delete user');
}

// comprobar la eliminacion de la resena
function deleteReview(id) {
    showConfirmModal('Are you sure you want to delete this review?', function () {
        fetch(`/dash/reviews/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('¡Reseña eliminada con éxito!', 'success');
                    closeModal(`detailsModalYS${id}`);
                    document.querySelector('[data-section="reviews"]').click();
                } else {
                    showToast('Error al eliminar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }, 'Delete review');
}

// comprobar la actualizacion de la orden
function showOrderValidationErrors(containerId, errors) {
    const container = document.getElementById(containerId);
    if (!container) return;

    let html = '';
    Object.keys(errors).forEach(function (key) {
        errors[key].forEach(function (message) {
            html += `<p style="color: red; margin: 4px 0;">${message}</p>`;
        });
    });

    container.innerHTML = html;
}

// comprobar la actualizacion de la orden
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('btn-save-order')) {

        const orderId = e.target.getAttribute('data-id');
        const form = document.getElementById(`formEditOrder_${orderId}`);
        const formData = new FormData(form);

        document.getElementById(`orderEditErrors_${orderId}`).innerHTML = '';

        fetch(`/dash/orders/update/${orderId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(async response => {
                const data = await response.json();

                if (response.status === 422) {
                    showOrderValidationErrors(`orderEditErrors_${orderId}`, data.errors);
                    return;
                }

                if (data.success) {
                    showToast('¡Orden actualizada con éxito!', 'success');
                    closeModal(`editModalOrder_${orderId}`);
                    document.querySelector('[data-section="orders"]').click();
                } else {
                    showToast('Error al actualizar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }
});


// comprobar la eliminacion de la orden
function deleteOrder(id) {
    showConfirmModal('Are you sure you want to delete this order?', function () {
        fetch(`/dash/orders/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('¡Orden eliminada con éxito!', 'success');
                    closeModal(`deleteModalOrder_${id}`);
                    document.querySelector('[data-section="orders"]').click();
                } else {
                    showToast('Error al eliminar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }, 'Delete order');
}

function createOffer() {
    const form = document.getElementById('formCreateOffer');
    const formData = new FormData(form);

    document.getElementById('offerErrors').innerHTML = '';

    fetch('/dash/offers/store', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(async response => {
            const data = await response.json();

            if (response.status === 422) {
                showOfferValidationErrors('offerErrors', data.errors);
                return;
            }

            if (data.success) {
                showToast('¡Oferta creada con éxito!', 'success');
                document.querySelector('[data-section="offers"]').click();
            } else {
                showToast('Error al crear: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            showToast('Algo salió mal con el servidor.', 'error');
        });
}

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('btn-save-offer')) {
        const offerId = e.target.getAttribute('data-id');
        const form = document.getElementById(`formEditOffer_${offerId}`);
        const formData = new FormData(form);

        document.getElementById(`offerEditErrors_${offerId}`).innerHTML = '';

        fetch(`/dash/offers/update/${offerId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(async response => {
                const data = await response.json();

                if (response.status === 422) {
                    showOfferValidationErrors(`offerEditErrors_${offerId}`, data.errors);
                    return;
                }

                if (data.success) {
                    showToast('¡Oferta actualizada con éxito!', 'success');
                    closeModal(`detailsModalOffer${offerId}`);
                    document.querySelector('[data-section="offers"]').click();
                } else {
                    showToast('Error al actualizar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                alert('Algo salió mal con el servidor.');
            });
    }
});

function deleteOffer(id) {
    showConfirmModal('Are you sure you want to delete this offer?', function () {
        fetch(`/dash/offers/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('¡Oferta eliminada con éxito!', 'success');
                    closeModal(`detailsModalOffer${id}`);
                    document.querySelector('[data-section="offers"]').click();
                } else {
                    showToast('Error al eliminar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }, 'Delete offer');
}
function showToast(message, type = 'success', duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `custom-toast ${type}`;
    toast.textContent = message;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(30px)';

        setTimeout(() => {
            toast.remove();
        }, 300);
    }, duration);
}

function showConfirmModal(message, onConfirm, title = 'Confirm action') {
    const modal = document.getElementById('customConfirmModal');
    const titleEl = document.getElementById('confirmTitle');
    const messageEl = document.getElementById('confirmMessage');
    const okBtn = document.getElementById('confirmOkBtn');
    const cancelBtn = document.getElementById('confirmCancelBtn');

    if (!modal || !titleEl || !messageEl || !okBtn || !cancelBtn) return;

    titleEl.textContent = title;
    messageEl.textContent = message;

    const newOkBtn = okBtn.cloneNode(true);
    okBtn.parentNode.replaceChild(newOkBtn, okBtn);

    const newCancelBtn = cancelBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

    openModal('customConfirmModal');

    newCancelBtn.addEventListener('click', function () {
        closeModal('customConfirmModal');
    });

    newOkBtn.addEventListener('click', function () {
        closeModal('customConfirmModal');
        if (typeof onConfirm === 'function') {
            onConfirm();
        }
    });
}
function showAuctionValidationErrors(containerId, errors) {
    const container = document.getElementById(containerId);
    if (!container) return;

    let html = '';
    Object.keys(errors).forEach(function (key) {
        errors[key].forEach(function (message) {
            html += `<p style="color: red; margin: 4px 0;">${message}</p>`;
        });
    });

    container.innerHTML = html;
}

function createAuction() {
    const form = document.getElementById('formCreateAuction');
    const formData = new FormData(form);

    document.getElementById('auctionErrors').innerHTML = '';

    fetch('/dash/auctions/store', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(async response => {
            const data = await response.json();

            if (response.status === 422) {
                showAuctionValidationErrors('auctionErrors', data.errors);
                return;
            }

            if (data.success) {
                showToast('¡Subasta creada con éxito!', 'success');
                document.querySelector('[data-section="auctions"]').click();
            } else {
                showToast('Error al crear: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            showToast('Algo salió mal con el servidor.', 'error');
        });
}

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('btn-save-auction')) {
        const auctionId = e.target.getAttribute('data-id');
        const form = document.getElementById(`formEditAuction_${auctionId}`);
        const formData = new FormData(form);

        document.getElementById(`auctionEditErrors_${auctionId}`).innerHTML = '';

        fetch(`/dash/auctions/update/${auctionId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(async response => {
                const data = await response.json();

                if (response.status === 422) {
                    showAuctionValidationErrors(`auctionEditErrors_${auctionId}`, data.errors);
                    return;
                }

                if (data.success) {
                    showToast('¡Subasta actualizada con éxito!', 'success');
                    closeModal(`detailsModalAuction${auctionId}`);
                    document.querySelector('[data-section="auctions"]').click();
                } else {
                    showToast('Error al actualizar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }
});

function deleteAuction(id) {
    showConfirmModal('Are you sure you want to delete this auction?', function () {
        fetch(`/dash/auctions/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('¡Subasta eliminada con éxito!', 'success');
                    closeModal(`detailsModalAuction${id}`);
                    document.querySelector('[data-section="auctions"]').click();
                } else {
                    showToast('Error al eliminar: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showToast('Algo salió mal con el servidor.', 'error');
            });
    }, 'Delete auction');
}