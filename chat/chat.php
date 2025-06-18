<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = strtolower(trim($_POST['message']));

    $responses = [
        "halo" => "Hai juga! Ada yang bisa saya bantu?",
        "cara daftar" => "Kamu bisa klik menu 'Daftar' lalu isi data lengkap kamu ya.",
        "cara ikut lelang" => "Login dulu, lalu pilih lelang yang tersedia dan klik tombol 'Ikut Lelang'.",
        "kapan lelang dibuka" => "Lelang dibuka sesuai jadwal masing-masing barang. Cek di halaman 'Lelang Aktif'.",
        "bidcar itu apa" => "BidCar adalah platform lelang mobil online yang mudah dan terpercaya.",
    ];

    $response = "Maaf, saya belum mengerti pertanyaan itu. Coba tanya hal lain ya.";

    foreach ($responses as $key => $value) {
        if (strpos($message, $key) !== false) {
            $response = $value;
            break;
        }
    }

    echo $response;
}
?>
<div style="position: fixed; bottom: 20px; right: 20px; width: 300px; background: #fff; border: 1px solid #ccc; border-radius: 8px; padding: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index:999;">
  <div id="chat-messages" style="height: 200px; overflow-y: auto; font-size: 14px;"></div>
  <input type="text" id="userInput" placeholder="Tanya di sini..." style="width: 80%;" />
  <button onclick="sendMessage()">Kirim</button>
</div>

<script>
function sendMessage() {
  const userInput = document.getElementById("userInput");
  const message = userInput.value.trim();
  if (message === "") return;

  const chatBox = document.getElementById("chat-messages");
  chatBox.innerHTML += `<p><strong>Kamu:</strong> ${message}</p>`;

  fetch("/bidcar/chat/chat.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "message=" + encodeURIComponent(message)
  })
  .then(res => res.text())
  .then(reply => {
    chatBox.innerHTML += `<p><strong>Bot:</strong> ${reply}</p>`;
    chatBox.scrollTop = chatBox.scrollHeight;
  });

  userInput.value = "";
}
</script>
