<?php
include("db.php");
session_start();

// انتقال کوکی به سشن اگر سبد خرید خالیه ولی کوکی موجوده
if (!isset($_SESSION['cart']) && isset($_COOKIE['cart'])) {
  $_SESSION['cart'] = unserialize($_COOKIE['cart']);
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <title>سبد خرید شما</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
<link rel="stylesheet" href="css/cart.css">
</head>
<body>

  <div class="cart-container">
    <h3>سبد خرید</h3>

    <?php if (!empty($_SESSION['cart'])):
      $total = 0; ?>
      <ul class="list-group">
     <?php foreach ($_SESSION['cart'] as $id): 
    $id = (int)$id;
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    if ($p = mysqli_fetch_assoc($result)) {
        $total += $p['price'];
        ?>
        <li class="list-group-item" data-product-id="<?= $id ?>">
            <?= htmlspecialchars($p['title']) ?>

            <div style="display:flex; align-items:center; gap: 10px;">
              <button class="btn-quantity btn-decrease" title="کم کردن تعداد">−</button>
              <span class="quantity">1</span>
              <button class="btn-quantity btn-increase" title="زیاد کردن تعداد">+</button>
            </div>

            <span class="price"><?= number_format($p['price']) ?> تومان</span>

            <a href="remove_from_cart.php?id=<?= $id ?>" class="btn-remove" title="حذف از سبد خرید">حذف</a>
        </li>
<?php
    } else {
        echo "<li class='list-group-item'>محصولی با شناسه $id پیدا نشد.</li>";
    }
endforeach; ?>
      </ul>

      <div class="total-price">مبلغ کل: <?= number_format($total) ?> تومان</div>
<form id="discount-form" style="margin-bottom: 25px; text-align: center; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; align-items: center;">
  <input type="text" id="discount-code" name="discount_code" placeholder="کد تخفیف را وارد کنید" style="padding:8px 12px; border-radius:8px; border:1px solid #ccc; width: 250px; max-width: 80%;">
  <button type="submit" class="btn" style="background:#0984e3; color:#fff; padding: 8px 20px; width: auto; white-space: nowrap;">اعمال کد تخفیف</button>
  <div id="discount-message" style="margin-top:10px; color: #d63031; font-weight: 700; flex-basis: 100%; text-align: center;"></div>
</form>


      <a href="checkout.php" class="btn btn-checkout" title="نهایی‌سازی خرید">نهایی‌سازی خرید</a>
      <a href="clear_cart.php" class="btn btn-back" style="background:#d63031; margin-top:10px;" title="حذف همه محصولات">حذف همه محصولات</a>
      <br>
      <a href="index.php" class="btn btn-back" title="بازگشت به صفحه اصلی">بازگشت به صفحه اصلی</a>

    <?php else: ?>
      <div class="empty-message">سبد خرید شما خالی است.</div>
      <a href="index.php" class="btn btn-back" title="بازگشت به صفحه اصلی">بازگشت به صفحه اصلی</a>
    <?php endif; ?>
  </div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // تمام دکمه‌های افزایش تعداد
  const increaseButtons = document.querySelectorAll('.btn-increase');
  // تمام دکمه‌های کاهش تعداد
  const decreaseButtons = document.querySelectorAll('.btn-decrease');

  increaseButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const li = btn.closest('li.list-group-item');
      const productId = li.getAttribute('data-product-id');
      updateQuantity(productId, 'increase', li);
    });
  });

  decreaseButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const li = btn.closest('li.list-group-item');
      const productId = li.getAttribute('data-product-id');
      updateQuantity(productId, 'decrease', li);
    });
  });

  function updateQuantity(productId, action, listItem) {
    fetch('update_cart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${productId}&action=${action}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        // بروزرسانی تعداد داخل span.quantity
        const quantitySpan = listItem.querySelector('.quantity');
        let quantity = parseInt(quantitySpan.textContent);

        if(action === 'increase') {
          quantity++;
        } else if(action === 'decrease' && quantity > 1) {
          quantity--;
        } else if(action === 'decrease' && quantity === 1) {
          // اگر تعداد به صفر رسید، محصول را از لیست حذف کن
          listItem.remove();
          updateTotalPrice();
          return;
        }

        quantitySpan.textContent = quantity;
        updateTotalPrice();
      } else {
        alert('خطا در بروزرسانی سبد خرید: ' + data.message);
      }
    })
    .catch(() => alert('خطا در ارتباط با سرور!'));
  }

  function updateTotalPrice() {
    // بعد از هر تغییر تعداد، مبلغ کل را مجدد حساب می‌کنیم
    let total = 0;
    document.querySelectorAll('li.list-group-item').forEach(li => {
      const priceText = li.querySelector('.price').textContent;
      const price = parseInt(priceText.replace(/[^0-9]/g, ''));
      const quantity = parseInt(li.querySelector('.quantity').textContent);
      total += price * quantity;
    });
    document.querySelector('.total-price').textContent = 'مبلغ کل: ' + total.toLocaleString() + ' تومان';
  }
});
const discountForm = document.getElementById('discount-form');
const discountCodeInput = document.getElementById('discount-code');
const discountMessage = document.getElementById('discount-message');

let discountPercent = 0;

discountForm.addEventListener('submit', e => {
  e.preventDefault();
  const code = discountCodeInput.value.trim().toLowerCase();

  // تعریف کدهای تخفیف و درصدها
  const discounts = {
    sharifi1: 10,
    sharifi2: 20,
    sharifi3: 30,
    sharifi4: 40,
    sharifi5: 50
  };

  if (code in discounts) {
    discountPercent = discounts[code];
    discountMessage.style.color = 'green';
    discountMessage.textContent = `کد تخفیف معتبر است. ${discountPercent}% تخفیف اعمال شد.`;
    applyDiscount();
  } else {
    discountPercent = 0;
    discountMessage.style.color = '#d63031';
    discountMessage.textContent = 'کد تخفیف نامعتبر است.';
    applyDiscount();
  }
});

function applyDiscount() {
  let total = 0;
  document.querySelectorAll('li.list-group-item').forEach(li => {
    const priceText = li.querySelector('.price').textContent;
    const price = parseInt(priceText.replace(/[^0-9]/g, ''));
    const quantity = parseInt(li.querySelector('.quantity').textContent);
    total += price * quantity;
  });

  let discountedTotal = total;
  if (discountPercent > 0) {
    discountedTotal = total - (total * discountPercent / 100);
  }

  document.querySelector('.total-price').textContent = 
    `مبلغ کل: ${total.toLocaleString()} تومان` + 
    (discountPercent > 0 ? ` - پس از تخفیف: ${Math.round(discountedTotal).toLocaleString()} تومان` : '');
}

</script>


</body>
</html>
