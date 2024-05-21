document.getElementById('paystack-button').addEventListener('click', function(event) {
  event.preventDefault(); // Formun otomatik olarak gönderilmesini durdur

  // Form elemanlarına erişim
  var amountElement = document.getElementById('donation-amount');
  var emailElement = document.getElementById('donation-email');

  // Hata kontrolü
  if (amountElement && emailElement) {
      var amount = amountElement.value;
      var email = emailElement.value;

      // amount ve email değerlerini kullanarak işlemler yapın
      console.log('Donation Amount:', amount);
      console.log('Email:', email);

      // Verileri AJAX ile PHP dosyasına gönder
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "process_donation.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              console.log(xhr.responseText); // Sunucudan gelen yanıtı işleyin
              alert('Desteginiz Icin Tesekkurler....');
                        // Ana sayfaya yönlendir
                        window.location.href = 'index.html'; // Ana sayfa URL'si
          }
      };
      var data = "donation-amount=" + encodeURIComponent(amount) + "&donation-email=" + encodeURIComponent(email);
      xhr.send(data);
  } else {
      console.error('Form elemanları bulunamadı.');
  }
});
