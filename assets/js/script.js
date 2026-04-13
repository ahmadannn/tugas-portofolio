document.addEventListener("DOMContentLoaded", () => {
    console.log("Website Portfolio siap dan berjalan! - Dynamic features loaded.");

    // Implementasi AJAX untuk Formulir Kontak
    const contactForm = document.getElementById("contact-form");
    const submitBtn = document.getElementById("submit-btn");
    const notification = document.getElementById("form-notification");

    if (contactForm) {
        contactForm.addEventListener("submit", async function(e) {
            // Mencegah halaman dari proses reload (Perilaku Default Form)
            e.preventDefault(); 
            
            // Ubah keadaan tombol pengiriman
            const originalBtnText = submitBtn.innerText;
            submitBtn.innerText = "Mengirim...";
            submitBtn.disabled = true;
            notification.className = "hidden"; // Sembunyikan notifikasi jika masih ada sisa
            
            try {
                // Ambil semua data pada form sebagai payload
                const formData = new FormData(this);
                
                // Memicu koneksi ke Backend AJAX Endpoint (Fetch API) tanpa reload browser
                const response = await fetch('api/process_contact.php', {
                    method: 'POST',
                    body: formData
                });
                
                // Parsing response dari Backend (yang berupa text JSON) menjadi Object di JS
                const data = await response.json();
                
                // Tentukan warna notifikasi (Hijau / Merah)
                notification.className = data.status === 'success' ? 'notif-success' : 'notif-error';
                notification.innerText = data.message;

                // Jika sukses dari server, kita bersihkan input formulir
                if(data.status === 'success'){
                    this.reset();
                }

            } catch (error) {
                console.error("Kesalahan Jaringan AJAX:", error);
                notification.className = 'notif-error';
                notification.innerText = "Terjadi kesalahan koneksi antara Frontend ke Backend Server.";
            } finally {
                // Kembalikan ke keadaan tombol awal
                submitBtn.innerText = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    }
});
