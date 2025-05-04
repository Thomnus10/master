<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Simple POS Layout</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      color: #333;
    }

    header, footer {
      background: #13213C;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    main {
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .products, .cart {
      background: #fff;
      padding: 15px;
      border-radius: 5px;
    }

    .products {
      flex: 2;
    }

    .cart {
      flex: 1;
    }

    .product, .cart-item {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 4px;
    }

    .product-name, .cart-item-name {
      font-weight: bold;
    }

    .actions {
      margin-top: 15px;
      display: flex;
      justify-content: space-between;
    }

    button {
      padding: 8px 12px;
      border: none;
      background: #FCA311;
      color: #000;
      cursor: pointer;
      border-radius: 4px;
    }

    input[type="text"] {
      padding: 8px;
      width: 100%;
      margin-bottom: 10px;
      box-sizing: border-box;
    }
  </style>
</head>
<body>
  <header>
    <div>Simple POS</div>
    <div>Cashier: John Doe</div>
  </header>

  <main>
    <div class="products">
      <input type="text" placeholder="Search products..." />
      <div class="product">
        <div class="product-name">Cappuccino</div>
        <div>$4.50</div>
      </div>
      <div class="product">
        <div class="product-name">Muffin</div>
        <div>$3.50</div>
      </div>
    </div>

    <div class="cart">
      <div class="cart-item">
        <div class="cart-item-name">Cappuccino x1</div>
        <div>$4.50</div>
      </div>
      <div class="cart-item">
        <div class="cart-item-name">Muffin x2</div>
        <div>$7.00</div>
      </div>
      <div class="actions">
        <div><strong>Total: $11.50</strong></div>
        <button>Checkout</button>
      </div>
    </div>
  </main>

  <footer>
    <div>Terminal #3</div>
    <div>Order #1052</div>
  </footer>
</body>
</html>
