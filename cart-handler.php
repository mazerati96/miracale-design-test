<?php
// cart-handler.php
// Session-based cart. Called via AJAX from shop.php and cart.php.
// Returns JSON for all actions.

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$action = trim($_POST['action'] ?? $_GET['action'] ?? '');

// ── Helper: cart total item count ─────────────────────────────────────────
function cartCount() {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += (int)($item['quantity'] ?? 1);
    }
    return $count;
}

// ── Helper: cart subtotal (in cents) ──────────────────────────────────────
function cartSubtotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += (int)($item['amount'] ?? 0) * (int)($item['quantity'] ?? 1);
    }
    return $total;
}

switch ($action) {

    // ── ADD ─────────────────────────────────────────────────────────────────
    case 'add':
        $priceId     = trim($_POST['price_id']     ?? '');
        $productName = trim($_POST['product_name'] ?? '');
        $amount      = (int)($_POST['amount']      ?? 0);  // in cents
        $imageUrl    = trim($_POST['image_url']    ?? '');
        $category    = trim($_POST['category']     ?? '');

        if (empty($priceId) || empty($productName)) {
            http_response_code(422);
            echo json_encode(array('success' => false, 'message' => 'Missing product data.'));
            exit;
        }

        // If already in cart, increment quantity
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['price_id'] === $priceId) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['cart'][] = array(
                'price_id'     => $priceId,
                'product_name' => $productName,
                'amount'       => $amount,
                'image_url'    => $imageUrl,
                'category'     => $category,
                'quantity'     => 1,
            );
        }

        echo json_encode(array(
            'success'   => true,
            'message'   => htmlspecialchars($productName) . ' added to cart!',
            'count'     => cartCount(),
            'subtotal'  => cartSubtotal(),
        ));
        break;

    // ── UPDATE QUANTITY ──────────────────────────────────────────────────────
    case 'update':
        $priceId  = trim($_POST['price_id'] ?? '');
        $quantity = max(0, (int)($_POST['quantity'] ?? 0));

        foreach ($_SESSION['cart'] as $key => &$item) {
            if ($item['price_id'] === $priceId) {
                if ($quantity === 0) {
                    unset($_SESSION['cart'][$key]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                } else {
                    $item['quantity'] = $quantity;
                }
                break;
            }
        }
        unset($item);

        echo json_encode(array(
            'success'  => true,
            'count'    => cartCount(),
            'subtotal' => cartSubtotal(),
        ));
        break;

    // ── REMOVE ──────────────────────────────────────────────────────────────
    case 'remove':
        $priceId = trim($_POST['price_id'] ?? '');
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['price_id'] === $priceId) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
        echo json_encode(array(
            'success'  => true,
            'count'    => cartCount(),
            'subtotal' => cartSubtotal(),
        ));
        break;

    // ── CLEAR ───────────────────────────────────────────────────────────────
    case 'clear':
        $_SESSION['cart'] = array();
        echo json_encode(array('success' => true, 'count' => 0, 'subtotal' => 0));
        break;

    // ── COUNT (for nav badge on page load) ───────────────────────────────────
    case 'count':
        echo json_encode(array(
            'count'    => cartCount(),
            'subtotal' => cartSubtotal(),
        ));
        break;

    default:
        http_response_code(400);
        echo json_encode(array('success' => false, 'message' => 'Unknown action.'));
        break;
}
exit;