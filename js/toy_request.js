document.getElementById('toy-request-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Formun otomatik olarak gönderilmesini durdur

    // Form verilerini al
    var formData = new FormData(this);

    // Form elemanlarına erişim
    var firstName = document.getElementById('first-name').value;
    var lastName = document.getElementById('last-name').value;
    var address = document.getElementById('address').value;
    var phone = document.getElementById('phone').value;
    var email = document.getElementById('email').value;
    
    // Hata kontrolü
    if (!firstName || !lastName || !address || !phone || !email) {
        alert('Lütfen tüm alanları doldurun.');
        return;
    }else{

    
            // Verileri AJAX ile PHP dosyasına gönder
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process_toy_request.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Sunucudan gelen yanıtı işleyin
            alert('Başarıyla kaydedildi!');
                        // Form elemanlarını temizle
                        document.getElementById('toy-request-form').reset();

                        // Ana sayfaya yönlendir
                        window.location.href = 'index.html'; // Ana sayfa URL'si
            
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            alert('Hata: ' + xhr.responseText);
        }
    };
    xhr.send(formData);
    }


});
