<?php
function getActiveMenu($db) {
    $stmt = $db->query("SELECT * FROM menu WHERE status='tersedia' ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addToCart($db, $user_id, $menu_id, $qty) {
    $cek = $db->prepare("SELECT id, qty FROM cart WHERE user_id = ? AND menu_id = ?");
    $cek->execute([$user_id, $menu_id]);
    $existing = $cek->fetch();

    if ($existing) {
        $newQty = $existing['qty'] + $qty;
        $stmt = $db->prepare("UPDATE cart SET qty = ? WHERE id = ?");
        return $stmt->execute([$newQty, $existing['id']]);
    } else {
        $stmt = $db->prepare("INSERT INTO cart (user_id, menu_id, qty) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $menu_id, $qty]);
    }
}

function getCartItems($db, $user_id) {
    $stmt = $db->prepare("SELECT c.*, m.nama_menu, m.harga FROM cart c JOIN menu m ON c.menu_id = m.id WHERE c.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removeFromCart($db, $user_id, $menu_id) {
    $stmt = $db->prepare("DELETE FROM cart WHERE user_id = ? AND menu_id = ?");
    return $stmt->execute([$user_id, $menu_id]);
}

function getAllMeja($db) {
    return $db->query("SELECT * FROM meja WHERE status = 'aktif'")->fetchAll(PDO::FETCH_ASSOC);
}

function getBookedMeja($db, $tanggal, $jam) {
    $stmt = $db->prepare("SELECT meja_id FROM reservasi WHERE tanggal = ? AND jam = ? AND status IN ('pending', 'dikonfirmasi')");
    $stmt->execute([$tanggal, $jam]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function checkoutBooking($db, $user_id, $meja_id, $tanggal, $jam, $jumlah_orang, $cartItems) {
    try {
        $db->beginTransaction();
        $total_harga = 0;
        foreach ($cartItems as $item) { $total_harga += ($item['harga'] * $item['qty']); }

        $stmt = $db->prepare("INSERT INTO reservasi (user_id, meja_id, tanggal, jam, jumlah_orang, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $meja_id, $tanggal, $jam, $jumlah_orang]);
        $reservasi_id = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO transaksi (user_id, reservasi_id, total_harga, status_pembayaran) VALUES (?, ?, ?, 'belum_bayar')");
        $stmt->execute([$user_id, $reservasi_id, $total_harga]);
        $transaksi_id = $db->lastInsertId();

        foreach ($cartItems as $item) {
            $stmt = $db->prepare("INSERT INTO transaksi_detail (transaksi_id, menu_id, qty, harga) VALUES (?, ?, ?, ?)");
            $stmt->execute([$transaksi_id, $item['menu_id'], $item['qty'], $item['harga']]);
        }

        $db->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);
        $db->commit();
        return $transaksi_id;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}

function getTransactionDetail($db, $transaksi_id) {
    $sql = "SELECT t.*, r.tanggal, r.jam, m.nama_meja, u.nama as nama_user 
            FROM transaksi t 
            JOIN reservasi r ON t.reservasi_id = r.id 
            JOIN meja m ON r.meja_id = m.id
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$transaksi_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if($data) {
        $stmtItems = $db->prepare("SELECT td.*, mn.nama_menu FROM transaksi_detail td 
                                   JOIN menu mn ON td.menu_id = mn.id 
                                   WHERE td.transaksi_id = ?");
        $stmtItems->execute([$transaksi_id]);
        $data['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
}

function tambahPembayaran($db, $transaksi_id, $metode_id, $nominal, $bukti) {
    $stmt = $db->prepare("
        INSERT INTO pembayaran 
        (transaksi_id, metode_id, total_bayar, bukti_bayar) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$transaksi_id, $metode_id, $nominal, $bukti]);
    
    $stmt = $db->prepare("
        UPDATE transaksi 
        SET status_pembayaran = 'menunggu_konfirmasi' 
        WHERE id = ?
    ");
    return $stmt->execute([$transaksi_id]);
}

function getDashboardStats($db, $user_id) {
    $total = $db->prepare("SELECT COUNT(*) FROM reservasi WHERE user_id = ?");
    $total->execute([$user_id]);
    $aktif = $db->prepare("SELECT COUNT(*) FROM reservasi WHERE user_id = ? AND status IN ('pending', 'dikonfirmasi')");
    $aktif->execute([$user_id]);
    
    $stmtRecent = $db->prepare("SELECT r.*, m.nama_meja FROM reservasi r JOIN meja m ON r.meja_id = m.id 
                                WHERE r.user_id = ? ORDER BY r.created_at DESC LIMIT 3");
    $stmtRecent->execute([$user_id]);
    
    return [
        'total' => $total->fetchColumn(),
        'aktif' => $aktif->fetchColumn(),
        'recent' => $stmtRecent->fetchAll()
    ];
}

function getUserFullHistory($db, $user_id) {
    $sql = "SELECT t.id AS transaksi_id, t.total_harga, t.status_pembayaran, r.tanggal, r.jam, m.nama_meja 
            FROM transaksi t
            JOIN reservasi r ON t.reservasi_id = r.id
            JOIN meja m ON r.meja_id = m.id
            WHERE t.user_id = ? ORDER BY t.id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($db, $id) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getDetailReservasiUser($db, $id, $user_id) {
    $stmt = $db->prepare("
        SELECT r.*, m.nama_meja, m.kapasitas
        FROM reservasi r
        JOIN meja m ON r.meja_id = m.id
        WHERE r.id=? AND r.user_id=?
    ");
    $stmt->execute([$id, $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getActiveMetodePembayaran($db) {
    $stmt = $db->query("SELECT * FROM metode_pembayaran WHERE status='aktif' ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

