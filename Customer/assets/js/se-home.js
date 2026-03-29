document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("searchInput");
  const resultBox = document.getElementById("searchResult");

  if (!input) return;

  input.addEventListener("input", async () => {
    const q = input.value.trim();

    // ถ้าพิมพ์น้อยกว่า 2 ตัวอักษรให้ซ่อนกล่องผลลัพธ์
    if (q.length < 2) {
      resultBox.style.display = "none";
      resultBox.innerHTML = "";
      return;
    }

    try {
      const res = await fetch(`search.php?q=${encodeURIComponent(q)}`);
      const data = await res.json();

      resultBox.innerHTML = "";

      if (data.length === 0) {
        resultBox.innerHTML = "<div class='search-item'>ไม่พบเกมที่ค้นหา</div>";
      } else {
        // สร้างหัวข้อเล็กๆ ให้ดูเหมือน Steam
        const header = document.createElement('div');
        header.className = 'search-header';
        header.innerText = 'ผลการค้นหา';
        resultBox.appendChild(header);

        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'search-item';
            div.onclick = () => goGame(item.id);

            /* วิธีแก้เรื่อง Path:
              ใน DB เก็บ: "uploads/rov.jpg"
              เราต้องการ: "admin/uploads/rov.jpg"
              
              ดังนั้นเราจะใช้ .replace() เพื่อลบ "uploads/" ออกก่อน 
              แล้วค่อยใส่ "admin/uploads/" เข้าไปข้างหน้าให้ถูกต้อง
            */
            const imagePath = `../admin/${item.image}`;

            div.innerHTML = `
                <img src="${imagePath}" alt="${item.name}" onerror="this.src='../admin/uploads/default.png'">
                <div class="search-item-info">
                    <div class="search-item-name">${item.name}</div>
                    <div class="search-item-tag">Game</div>
                </div>
            `;
            resultBox.appendChild(div);
        });
      }
      resultBox.style.display = "block";
    } catch (err) {
      console.error("Search error:", err);
    }
  });

  // ปิดกล่องค้นหาเมื่อคลิกที่อื่น
  document.addEventListener("click", (e) => {
    if (!input.contains(e.target) && !resultBox.contains(e.target)) {
      resultBox.style.display = "none";
    }
  });
});

function goGame(id) {
  // แก้ไข path ให้กระโดดเข้าไปในโฟลเดอร์ customer
  window.location.href = `product.php?game_id=${id}`;
}