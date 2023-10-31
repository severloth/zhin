


    function showLikes(){
        const overlay = document.getElementById('overlay');
        const liked_by = document.getElementById('liked_by');
        overlay.style.display = 'flex';
        liked_by.style.display = 'flex';
    }

    function closeOverlay(){
        const overlay = document.getElementById('overlay');
        const liked_by = document.getElementById('liked_by');
        overlay.style.display = 'none';
        liked_by.style.display = 'none';
    }



$(document).ready(function () {
    $('.like-button').click(function () {
        var button = $(this);
        var postSlug = button.data('post-slug');
        
        $.ajax({
            url: '{{ url('/post/like') }}/' + postSlug,
            type: 'GET',
            success: function (response) {
                // Cambia la clase del botón de like según la respuesta del servidor
                if (response.liked) {
                    button.find('i').removeClass('far').addClass('fas text-danger');
                    
                    // Muestra la notificación solo cuando se da like
                    showNotification('Has likeado un post');
                } else {
                    button.find('i').removeClass('fas text-danger').addClass('far');
                }
                
                // Actualiza el contador de likes en la vista
                $('#like-count-' + postSlug).text(response.likeCount);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});


// Función para mostrar la notificación
function showNotification(message) {
    const notification = document.getElementById('like-notification');
    notification.innerText = message;
    notification.style.display = 'block';

    // Ocultar la notificación después de un tiempo (por ejemplo, 3 segundos)
    setTimeout(function() {
        notification.style.display = 'none';
    }, 3000); // 3000 milisegundos = 3 segundos
}


