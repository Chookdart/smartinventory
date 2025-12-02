<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

?>
<!DOCTYPE html> 
<html>
<head>
    <title>Cashier</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
     <link rel="stylesheet" href="css/cashier.css" />
</head>

  <body>
    <div class="cashier-wrapper">
        <div class="cashier-header">
            <div class="button-group">
                <button class="scan-btn" onclick="startScanner()">SCAN</button>
                <button class="scan-btn" onclick="stopScanner()">STOP SCAN</button>
            </div>
            <div class="big-total" id="bigTotal">0.00</div>
        </div>

        <div class="main-transaction-area">
            <div class="input-scanner-area">
                <input type="text" id="manual_code" class="input-code" placeholder="INPUT PRODUCT CODE">
                <button class="btn-add" onclick="manualAdd()">ADD</button> <div class="reader-wrapper">
                    <div id="reader"></div>
                </div>
            </div>

            <table class="items-table" id="cartTable">
                <tr>
                    <th>PRODUCT NAME</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>SUBTOTAL</th>
                    <th>ACTIONS</th>
                </tr>
            </table>

            <div class="summary-box">
                <div class="line"><span>SUBTOTAL</span><span id="subtotal">0.00</span></div>
                <div class="line"><span>VAT</span><span id="vat">0.00</span></div>
                <div class="line"><span>DISCOUNT</span><span id="discount">0.00</span></div>
                <div class="line"><span>TOTAL</span><span id="total">0.00</span></div>
            </div>

            <button class="checkout-btn" onclick="checkout()">CHECKOUT</button>
        </div>
        
        <button class="logout-btn" onclick="document.location='logout.php'">LOGOUT</button>
    </div>

    <script>
        // Your existing JavaScript functions (startScanner, stopScanner, fetchProduct, etc.)
        // should be placed here, just like you had them.
        // I've removed them from this example for brevity.
        let scanner;
        let cart = [];
        // ... (rest of your JS) ...

        function startScanner() {
            scanner = new Html5Qrcode("reader");

            scanner.start(
                { facingMode: "environment" },
                {
                    fps: 30,
                    qrbox: {width: 100, height: 100} // Adjusted for better visibility in the new layout
                },
                qrCodeMessage => {
                    fetchProduct(qrCodeMessage);
                }
            );
        }

        function stopScanner() {
            if (scanner) scanner.stop();
        }

        function fetchProduct(productID) {
            fetch("fetch_product.php?id=" + productID)
                .then(res => res.json())
                .then(product => {
                    if (!product) return alert("Invalid QR!");
                    addToCart(product);
                });
        }

        function manualAdd() {
            let code = document.getElementById("manual_code").value.trim();
            if (code === "") return alert("Enter a code first.");
            fetchProduct(code);
            document.getElementById("manual_code").value = ""; // Clear input after adding
        }

        function addToCart(product) {
            let price = parseFloat(product.Price);
            let existing = cart.find(item => item.ID == product.ProductID);

            if (existing) {
                existing.qty++;
            } else {
                cart.push({
                    ID: product.ProductID,
                    name: product.ProductName,
                    price: price,
                    qty: 1,
                    subtotal: price
                });
            }
            updateTable();
        }

        function updateTable() {
            let table = document.getElementById("cartTable");
            // Clear existing rows, but keep the header
            while(table.rows.length > 1) {
                table.deleteRow(1);
            }

            cart.forEach((item, index) => {
                item.subtotal = item.qty * item.price;

                let row = table.insertRow(-1); // Insert at the end
                row.className = "cart-row";

                row.insertCell(0).textContent = item.name;
                row.insertCell(1).textContent = item.price;
                row.insertCell(2).textContent = item.qty;
                row.insertCell(3).textContent = item.subtotal;
                
                let actionsCell = row.insertCell(4);
                actionsCell.className = "cart-actions";
                actionsCell.innerHTML = `
                    <button class="btn-minus" onclick="decreaseQty(${index})">-</button>
                    <button class="btn-plus" onclick="increaseQty(${index})">+</button>
                    <button class="btn-delete" onclick="deleteItem(${index})">DELETE</button>
                `;
            });
            
            let subtotal = cart.reduce((s, item) => s + item.subtotal, 0);
            let vat = +(subtotal * 0.12); // Assuming 12% VAT
            let discount = 0;

            if (subtotal >= 5000) {
                discount = 160;
            } else if (subtotal >= 3000) {
                discount = 80;
            } else if (subtotal >= 1000) {
                discount = 40;
            } else {
                discount = 0;
            }

            let total = subtotal + vat - discount;

            document.getElementById("subtotal").innerText = subtotal.toFixed(2);
            document.getElementById("vat").innerText = vat.toFixed(2);
            document.getElementById("discount").innerText = discount.toFixed(2);
            document.getElementById("total").innerText = total.toFixed(2);
            document.getElementById("bigTotal").innerText = total.toFixed(2);
        }

        function increaseQty(index) {
            cart[index].qty++;
            updateTable();
        }

        function decreaseQty(index) {
            if (cart[index].qty > 1) {
                cart[index].qty--;
            } else {
                cart.splice(index, 1);
            }
            updateTable();
        }

        function deleteItem(index) {
            cart.splice(index, 1);
            updateTable(); 
        }

        function checkout() {
            if (cart.length === 0) {
                alert("Cart is empty. Please add items before checking out.");
                return;
            }
            fetch("checkout.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(cart)
            })
            .then(res => res.blob())
            .then(blob => {
                const url = URL.createObjectURL(blob);
                window.open(url, "_blank"); // Open PDF

                // Reset cart and display
                cart = [];
                updateTable(); // This will also update totals to 0.00
                document.getElementById('manual_code').value = ''; // Clear input
            })
            .catch(err => {
                console.error("Checkout error:", err);
                alert("Checkout failed. Please try again.");
            });
        }
    </script>
</body>
</html>
