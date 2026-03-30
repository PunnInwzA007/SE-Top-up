const payments = document.querySelectorAll(".se-payment-card");
const packages = document.querySelectorAll(".se-package-card");

const productPriceEl = document.getElementById("productPrice");
const totalPriceEl   = document.getElementById("totalPrice");
const continueBtn    = document.getElementById("continueBtn");
const discountEl     = document.getElementById("discountPrice");

const discountInput = document.getElementById("discountInput");
const applyBtn      = document.getElementById("applyDiscount");

let selectedPrice = 0;
let selectedPayment = null;
let selectedPackageId = null;
let discount = 0;

// ===== FORMAT =====
function formatMoney(num){
  return num.toLocaleString("th-TH");
}

// ===== UPDATE =====
function updateTotal(){
  const total = Math.max(0, selectedPrice - discount);

  if(productPriceEl) productPriceEl.innerText = formatMoney(selectedPrice);
  if(totalPriceEl) totalPriceEl.innerText = formatMoney(total);
  if(discountEl) discountEl.innerText = formatMoney(discount);

  // ✅ เปิดปุ่มตลอด
  continueBtn?.removeAttribute("disabled");
}

// ===== PAYMENT =====
payments.forEach(card=>{
  card.addEventListener("click",()=>{
    payments.forEach(c=>c.classList.remove("active"));
    card.classList.add("active");

    selectedPayment = card.dataset.payment;
    updateTotal();
  });
});

// ===== PACKAGE =====
packages.forEach(card=>{
  card.addEventListener("click",()=>{
    packages.forEach(c=>c.classList.remove("active"));
    card.classList.add("active");

    selectedPrice = parseInt(card.dataset.price);
    selectedPackageId = card.dataset.id;

    document.getElementById("selectedPackageId").value = selectedPackageId;

    // 🔥 RESET DISCOUNT
    discount = 0;

    const discountInput = document.getElementById("discountInput");
    if(discountInput){
      discountInput.value = "";
    }
    updateTotal();
    packages.forEach(c=>c.classList.remove("active"));
    card.classList.add("active");

    selectedPrice = parseInt(card.dataset.price);
    selectedPackageId = card.dataset.id;

    document.getElementById("selectedPackageId").value = selectedPackageId;

    updateTotal();
  });
});

// ===== DISCOUNT =====
applyBtn?.addEventListener("click",()=>{
  if(discount > 0){
    alert("คุณใช้โค้ดไปแล้ว");
    return;
  }
  const value = discountInput.value.trim();

  if(!value || selectedPrice <= 0){
    return;
  }

  fetch(`check_discount.php?code=${value}&price=${selectedPrice}`)
    .then(res => res.json())
    .then(data => {

      const errorBox = document.getElementById("discountError");
      if(data.success){
          discount = parseInt(data.amount);

          if(errorBox){
              errorBox.innerText = ""; // ลบ error
          }

      }else{
          discount = 0;

          if(errorBox){
              errorBox.innerText = data.message; // 🔥 แสดงใต้ input
          }
      }
      updateTotal();
    });

});

// ===== CONTINUE =====
continueBtn?.addEventListener("click",()=>{

  const uid = document.getElementById("uidInput")?.value;

  if(!uid){
    alert("⚠️ กรุณากรอก UID");
    return;
  }

  if(!selectedPackageId){
    alert("⚠️ กรุณาเลือกแพ็กเกจ");
    return;
  }

  if(!selectedPayment){
    alert("⚠️ กรุณาเลือกช่องทางชำระเงิน");
    return;
  }

  const form = document.createElement("form");
  form.method = "POST";
  form.action = "checkout.php";

  form.innerHTML = `
  <input type="hidden" name="package_id" value="${selectedPackageId}">
  <input type="hidden" name="uid" value="${uid}">
  <input type="hidden" name="discount" value="${discount}"> 
  `;

  document.body.appendChild(form);
  form.submit();
});

const saveBtn = document.getElementById("saveUidBtn");

saveBtn?.addEventListener("click", () => {
  const uid = document.getElementById("uidInput").value;
  const gameId = new URLSearchParams(window.location.search).get("game_id");

  if(!uid){
    alert("กรอก UID ก่อน");
    return;
  }

  fetch("add_uid.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `uid=${encodeURIComponent(uid)}&game_id=${gameId}`
  })
  .then(() => {
    alert("บันทึก UID เป็น ID หลักแล้ว");
  });
});

const manageBtn = document.getElementById("manageUidBtn");
const uidModal = document.getElementById("uidModal");
const uidList = document.getElementById("uidList");

function closeUidModal(){
  uidModal.style.display = "none";
}

manageBtn?.addEventListener("click", () => {

  const gameId = new URLSearchParams(window.location.search).get("game_id");

  fetch(`get_uids.php?game_id=${gameId}`)
    .then(res => res.json())
    .then(data => {

      const tbody = document.querySelector("#uidModal table tbody");

      if(!tbody) return;

      tbody.innerHTML = "";

      if(data.length === 0){
        tbody.innerHTML = "<tr><td colspan='3'>ยังไม่มี UID</td></tr>";
      }

      data.forEach(item => {
        const tr = document.createElement("tr");

        tr.innerHTML = `
          <td>-</td>
          <td style="cursor:pointer;color:blue;">${item.uid}</td>
          <td>-</td>
        `;

        tr.addEventListener("click", () => {
          document.getElementById("uidInput").value = item.uid;
          updateTotal();
          
          const modal = bootstrap.Modal.getInstance(document.getElementById("uidModal"));
          modal.hide();
        });

        tbody.appendChild(tr);
      });

      const modal = new bootstrap.Modal(document.getElementById("uidModal"));
      modal.show();

    });

});

// ===== UID INPUT =====
document.getElementById("uidInput")?.addEventListener("input", updateTotal);