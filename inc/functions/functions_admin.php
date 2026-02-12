<?php
function getAllMenu($db) {
    $stmt = $db->query("SELECT * FROM menu ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function tambahMenu($db, $nama_menu, $deskripsi, $harga, $status, $gambar=null) {
    $stmt = $db->prepare("INSERT INTO menu (nama_menu, deskripsi, harga, status, gambar) VALUES (?,?,?,?,?)");
    return $stmt->execute([$nama_menu, $deskripsi, $harga, $status, $gambar]);
}

function getMenuById($db, $id) {
    $stmt = $db->prepare("SELECT * FROM menu WHERE id=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateMenu($db, $id, $nama, $deskripsi, $harga, $status) {
    $stmt = $db->prepare("
        UPDATE menu 
        SET nama_menu=?, deskripsi=?, harga=?, status=?
        WHERE id=?
    ");
    return $stmt->execute([$nama, $deskripsi, $harga, $status, $id]);
}

function hapusMenu($db, $id) {
    $stmt = $db->prepare("DELETE FROM menu WHERE id = ?");
    return $stmt->execute([$id]);
}

function getAllUsers($db){
    $stmt = $db->query("SELECT id, nama, email, role FROM users ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteUser($db, $id){
    $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role = 'user'");
    return $stmt->execute([$id]);
}

function getAllReservations($db) {
    $stmt = $db->query("
        SELECT r.*, u.nama AS user_name, u.email, m.nama_meja, m.kapasitas
        FROM reservasi r
        JOIN users u ON r.user_id = u.id
        LEFT JOIN meja m ON r.meja_id = m.id
        ORDER BY r.tanggal DESC, r.jam DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateReservationStatus($db, $id, $status) {
    $stmt = $db->prepare("UPDATE reservasi SET status=? WHERE id=?");
    return $stmt->execute([$status, $id]);
}

function selesaikanReservasi($db, $id_res) {
    $stmt = $db->prepare("SELECT meja_id FROM reservasi WHERE id = ?");
    $stmt->execute([$id_res]);
    $res = $stmt->fetch();
    if (!$res) return false;
    
    $meja_id = $res['meja_id'];
    $stmt1 = $db->prepare("UPDATE reservasi SET status = 'selesai' WHERE id = ?");
    $stmt1->execute([$id_res]);
    $stmt2 = $db->prepare("UPDATE meja SET status = 'aktif' WHERE id = ?");
    return $stmt2->execute([$meja_id]);
}

function tambahMetodePembayaran($db, $nama, $keterangan) {
    $stmt = $db->prepare("
        INSERT INTO metode_pembayaran (nama_metode, keterangan, status)
        VALUES (?, ?, 'aktif')
    ");
    return $stmt->execute([$nama, $keterangan]);
}

function updateMetodePembayaran($db, $id, $nama, $keterangan, $status) {
    $stmt = $db->prepare("
        UPDATE metode_pembayaran
        SET nama_metode = ?, keterangan = ?, status = ?
        WHERE id = ?
    ");
    return $stmt->execute([$nama, $keterangan, $status, $id]);
}

function getMotodeById($db, $id) {
    $stmt = $db->prepare("SELECT * FROM metode_pembayaran WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);


}
function getAllMetode($db) {
    $stmt = $db->query("SELECT * FROM metode_pembayaran ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteMetodePembayaran($db, $id) {
    $stmt = $db->prepare("DELETE FROM metode_pembayaran WHERE id = ?");
    return $stmt->execute([$id]);
}



function handleReservasiAction($db, $aksi, $id) {
    switch ($aksi) {
        case 'konfirmasi':
            return updateReservationStatus($db, $id, 'dikonfirmasi');
        case 'batal':
            return updateReservationStatus($db, $id, 'dibatalkan');
        case 'selesai':
            return selesaikanReservasi($db, $id);
        default:
            return false;
    }
}

function getAllPayments($db) {
    $sql = "
        SELECT 
            p.*,
            m.nama_metode,
            t.status_pembayaran,
            t.total_harga,
            u.nama AS user_name
        FROM pembayaran p
        LEFT JOIN metode_pembayaran m ON p.metode_id = m.id
        LEFT JOIN transaksi t ON p.transaksi_id = t.id
        LEFT JOIN users u ON t.user_id = u.id
        ORDER BY p.created_at DESC
    ";

    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}



function konfirmasiPembayaran($db, $transaksi_id) {
    $stmt = $db->prepare("
        UPDATE transaksi 
        SET status_pembayaran = 'lunas'
        WHERE id = ?
    ");

    return $stmt->execute([$transaksi_id]);
}


function tolakPembayaran($db, $transaksi_id) {
    $stmt = $db->prepare("
        UPDATE transaksi 
        SET status_pembayaran = 'ditolak'
        WHERE id = ?
    ");

    return $stmt->execute([$transaksi_id]);
}


function countTodayReservations($db) {
    $stmt = $db->query("SELECT COUNT(*) FROM reservasi WHERE tanggal = CURDATE()");
    return $stmt->fetchColumn();
}

function countActiveMenu($db) {
    $stmt = $db->query("SELECT COUNT(*) FROM menu WHERE status = 'tersedia'");
    return $stmt->fetchColumn();
}

function countPendingPayments($db) {
    $stmt = $db->query("SELECT COUNT(*) FROM transaksi WHERE status_pembayaran = 'menunggu_konfirmasi'");
    return $stmt->fetchColumn();
}

function countCustomers($db) {
    $stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
    return $stmt->fetchColumn();
}

function getLatestReservations($db) {
    $stmt = $db->query("
        SELECT r.*, u.nama 
        FROM reservasi r
        JOIN users u ON r.user_id = u.id
        ORDER BY r.created_at DESC
        LIMIT 5
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSemuaMeja($db) {
    $stmt = $db->query("SELECT * FROM meja ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function tambahMeja($db, $nama_meja, $kapasitas) {
    $stmt = $db->prepare("INSERT INTO meja (nama_meja, kapasitas) VALUES (?,?)");
    return $stmt->execute([$nama_meja, $kapasitas]);
}

function hapusMeja($db, $id) {
    $stmt = $db->prepare("DELETE FROM meja WHERE id=?");
    return $stmt->execute([$id]);
}

function getMejaById($db, $id) {
    $stmt = $db->prepare("SELECT * FROM meja WHERE id =?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateMeja($db, $id, $nama_meja, $kapasitas) {
    $stmt = $db->prepare("UPDATE meja SET nama_meja = ?, kapasitas = ? WHERE id = ?");
    return $stmt->execute([$nama_meja, $kapasitas, $id]);
}


